<?php  
    require "./inc/init.php";
?>

<?php          
    $books_url = BOOK_URL . "/get_books.php";
    // Gửi yêu cầu GET đến API để lấy dữ liệu sách
    $response = file_get_contents($books_url . "?limit=99&page=1");
    $data = json_decode($response, true);

    // Dữ liệu trả về từ API
    $books = $data['data']; // Sửa key thành 'data' thay vì 'books'
?>

<?php 
  if(isset($_POST['offset'])){
      $offset = $_POST['offset'];
      $new_books = array_slice($books, $offset, 8); // Lấy 8 quyển sách tiếp theo từ offset
      foreach($new_books as $b):
?>
        <div class="card">
            <img src="<?php  echo $b['image'] ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php  echo $b['title'] ?></h5>
                <p class="card-text"><?php  echo $b['description'] ?></p>
                <a href="book-detail.php?id=<?php  echo htmlspecialchars($b['id']); ?>#book_detail" class="btn btn-primary">Book Detail</a>
            </div>
        </div>
<?php  endforeach; ?>
<?php  } ?>