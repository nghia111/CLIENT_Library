<?php 
require "./inc/init.php";
$conn = require('inc/db.php');
$books = Book::getAllBooks($conn);
require "./inc/header.php";

if(isset($_POST['offset'])){
    $offset = $_POST['offset'];
    $new_books = array_slice($books, $offset, 8); // Lấy 8 quyển sách tiếp theo từ offset
    ob_start(); // Bắt đầu bộ đệm đầu ra
    foreach($new_books as $b):
?>
    <div class="card" style="width: 16rem;">
        <img src="<?php echo $b->image ?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?php echo $b->title ?></h5>
            <p class="card-text"><?php echo $b->description ?></p>
            <a href="#" class="btn btn-primary">Book Detail</a>
        </div>
    </div>
<?php endforeach; ?>
<?php 
    $html = ob_get_clean(); // Lấy HTML được lưu trong bộ đệm đầu ra và xóa bộ đệm
    echo $html; // Trả về HTML của sách mới
    exit(); // Dừng script để ngăn chạy tiếp phần còn lại của trang
} 
?>

<div class="content" id="product">
    <div class="title_product">
        <h2>My book card</h2>
    </div>
    
    <!-- Hiển thị sản phẩm theo dạng card -->
    <div class="product_cards" id="book-container">
    <?php foreach($books as $key => $b): ?>
        <div class="card" style="width: 16rem;">
            <img src="<?php echo $b->image ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $b->title ?></h5>
                <p class="card-text"><?php echo $b->description ?></p>
                <a href="#" class="btn btn-primary">Book Detail</a>
            </div>
        </div>
        <?php if ($key == 7) break; ?> <!-- Stop after showing 8 books -->
    <?php endforeach; ?>
</div>
<button id="load-more-btn" class="btn btn-primary">Read more</button>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
      var offset = 8; // Starting offset to load more books

      $('#load-more-btn').click(function(){
          $.ajax({
              url: '', // Trống để gửi yêu cầu đến cùng URL hiện tại
              type: 'POST',
              data: {offset: offset},
              success: function(response){
                  $('.product_cards').append(response); // Append loaded books
                  offset += 8; // Increment offset for next request
              }
          });
      });
  });
</script>

<?php require "./inc/footer.php";?>
