<?
    require "inc/init.php";
    $conn = require("inc/db.php");
?>

<?
    require "inc/header.php";
?>

<!-- API lấy tất cả tên thể loại của sách -->
<?
    $url = "http://localhost/CT06/do_an/api/routes/book/get_all_categories.php";
    $response = file_get_contents($url);
    if ($response === false) {
        echo "Lỗi khi gọi API";
    } else {
        // Xử lý dữ liệu nhận được từ API
        $data_categories = json_decode($response, true);
        if ($data_categories) {
        } else {
            // Xử lý lỗi nếu dữ liệu không hợp lệ
            echo "Dữ liệu API không hợp lệ";
        }
    }
?>


<div class="content">
    <div class="addBook justify-content-center">
      <div class="addBook">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0 text-center">Add Book</h3>
          </div>
          <div class="card-body">
            <form class="row" action="add_book.php" method="POST">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="available">Available</label>
                        <input type="number" class="form-control" id="available" name="available" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category" required>
                        <?php foreach ($data_categories["categories"] as $category): ?>
                            <option value="<?php echo $category['code']; ?>"><?php echo $category['value']; ?></option>
                        <?php endforeach; ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" id="author" name="author" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Image URL</label>
                        <input type="url" class="form-control" id="image" name="image" oninput="displayImage(this.value)" required>
                    </div>
                    <div class="img_upload form-group">
                        <img id="book-image" src="./uploads/no_image.jpg" alt="Book Image" style="max-width: 80%; height: auto;">
                    </div>
                </div>
              <div class="button-group">
                <button type="submit" class="btn mr-2">Add Book</button>
                <a href="#" class="btn btn-cancel">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>

<script>
    function displayImage(url) {
      var img = document.getElementById('book-image');
      img.src = url || "./uploads/no_image.jpg";
    }
</script>

<?
    require "inc/footer.php";
?>