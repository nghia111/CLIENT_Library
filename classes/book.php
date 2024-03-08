<?php
class Book
{
  public $id;
  public $title;
  public $description;
  public $author;
  public $imagefile;

  private static $instance;
  private $conn;

  // use singleton pattern
  public function __construct(
    $title = null,
    $description = null,
    $author = null,
    $imagefile = null,
    $db
  ) {
    // Hide the constructor
    $this->title = $title;
    $this->description = $description;
    $this->author = $author;
    $this->imagefile = $imagefile;
    $this->conn = $db;
  }

  public static function getInstance(
    $title,
    $description,
    $author,
    $imagefile
  ): Book {
    if (!self::$instance) {
      self::$instance = new self(
        $title,
        $description,
        $author,
        $imagefile
      );
    }

    return self::$instance;
  }

  private function validate()
  {
    return $this->title
      && $this->description
      && $this->author;
  }

  public function addBook($conn)
  {
    if ($this->validate()) {
      // Write sql querry
      $sql = "insert into books (title, description, author, imagefile) 
                  values (:title,:description,:author,:imagefile);";

      // Prepare connection
      $stmt = $conn->prepare($sql);

      // Refence to each value
      $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
      $stmt->bindValue(':description', $this->description, PDO::PARAM_STR);
      $stmt->bindValue(':author', $this->author, PDO::PARAM_STR);
      $stmt->bindValue(':imagefile', $this->imagefile, PDO::PARAM_STR);

      return $stmt->execute();
    } else {
      return false;
    }
  }

  public static function getAllBooks($conn)
  {
    try {
      $sql = "select * from books";
      $stmt = $conn->prepare($sql);
      $stmt->setFetchMode(PDO::FETCH_OBJ);
      if ($stmt->execute()) {
        $books = $stmt->fetchAll();
        return $books;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
      return null;
    }
  }

  public static function getBookById($conn, $id)
  {
    try {
      $sql = "select * from books where id=:id;";
      $stmt = $conn->prepare($sql);
      $stmt->setFetchMode(PDO::FETCH_INTO, new Book());
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $books = $stmt->fetch();
      return $books;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
  }

  public static function getDistinctCategories($conn) {
    try {
      $sql = "select DISTINCT category FROM books";
      $result = $conn->query($sql);

      $categories = array();
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $categories[] = $row['category'];
          }
      }
      return $categories;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return null;
    }
    
  }

  public static function getPagingBooks($conn, $limit, $offset)
  {
    try {
      $sql = "select * from books order by title asc
                limit :limit
                offset :offset";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->setFetchMode(PDO::FETCH_CLASS, 'Book');
      if ($stmt->execute()) {
        $books = $stmt->fetchAll();
        return $books;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
      return null;
    }
  }

  public function update($conn)
  { if($this->validate()){
      try {
        $sql = "update books
                  set title=:title, description=:description,
                  author=:author
                  where id=:id;";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindValue(':author', $this->author, PDO::PARAM_STR);
        // $stmt->bindValue(':imagefile', $this->imagefile, PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
      } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
      }
    }
    
  }

  public function delete()
  {
  }

  public function deleteBookByID($conn, $id)
  {
    try {
      $sql = "delete from books where id =:id";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      if ($stmt->execute()) {
        return true;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function deleteByID($conn)
  {
    try {
      $sql = "delete from books where id =:id";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function updateImageBook($conn, $id, $imagefile)
  {
    try {
      $sql = "update books
                set imagefile=:imagefile
                where id=:id;";
      $stmt = $conn->prepare($sql);
      // $imagefile may be null
      $stmt->bindValue(
        ':imagefile',
        $imagefile,
        $imagefile == null ? PDO::PARAM_NULL : PDO::PARAM_STR
      );
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      if ($stmt->execute()) {
        return true;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public function updateImage ($conn){
    try {
        $sql = "update books
                set imagefile=:imagefile where id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':imagefile', $this->imagefile, $this->imagefile == null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        return $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }   
   }

  public static function count($conn)
  {
    try {
      $sql = "select count(id) from books";
      return $conn->query($sql)->fetchColumn();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return -1;
    }
  }
}
