<? 
    require "./inc/init.php";
    $conn = require('inc/db.php');
    $BASE_URL = "http://localhost/CT06/do_an/api/routes/book/get_books.php";
    require "./inc/header.php";
?>

<?         

    // Gửi yêu cầu GET đến API để lấy dữ liệu sách
    $response = file_get_contents($BASE_URL . "?limit=99&page=1");
    $data = json_decode($response, true);

    // Dữ liệu trả về từ API
    $books = $data['data']; // Sửa key thành 'data' thay vì 'books'
?>

<div class="content" id="product">
    <div class="title_product">
        <h2>My book card</h2>
    </div>
    
    <!-- Hiển thị sản phẩm theo dạng card -->
    <div class="product_cards" id="book-container">
      <?php foreach($books as $key => $b): ?>
          <div class="card" style="width: 16rem;">
              <img src="<?php echo $b['image'] ?>" class="card-img-top" alt="...">
              <div class="card-body">
                  <h5 class="card-title"><?php echo $b['title'] ?></h5>
                  <p class="card-text"><?php echo $b['description'] ?></p>
                  <a href="#" class="btn btn-read">Book Detail</a>
              </div>
          </div>
          <?php if ($key == 7) break; ?> <!-- Stop after showing 8 books -->
      <?php endforeach; ?>
  </div>
  <button id="load-more-btn" class="btn btn-read-more">Read more</button>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
      var offset = 8; // Starting offset to load more books

      $('#load-more-btn').click(function(){
          $.ajax({
              url: 'load_more_card-books.php',
              type: 'POST',
              data: {offset: offset},
              success: function(response){
                  $('#book-container').append(response); // Append loaded books
                  offset += 8; // Increment offset for next request
              }
          });
      });
  });
</script>


<? require "./inc/footer.php";?>