<?php
  class User {
    public $id;
    public $username;
    public $password;

    // Constructor
    public function __construct($username, $password) {
      $this->username = $username;
      $this->password = $password;
    }

    // Method to authenticate user
    public static function authenticate($conn, $username, $password) {
      //Write code querry
      $sql = "select * from users where username=:username";

      //Prepare
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':username', $username, PDO::PARAM_STR);

      //Return object correspond to User Class
      $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
      $stmt->execute();
      $user = $stmt->fetchObject();
      if ($user) {
        $hash = $user->password;
        return password_verify($password, $hash);
      }
    }

    private function validate(): bool {
      $rs = $this->username != '' && $this->password != '';
      return $rs;
    }

    public function addUser($conn) {
      if ($this->validate()) {
        // Write sql querry
        $sql = "insert into users(username, password)
                value(:username, :password);";
        
        // Prepare connection
        $stmt = $conn->prepare($sql);
        $hash = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hash, PDO::PARAM_STR);
        return $stmt->execute();
      } else {
        return false;
      }
    }
  }
?>