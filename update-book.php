<?php 
    require "inc/init.php";
?>

<?php 
    require "inc/header.php";
?>

<!-- API lấy tất cả tên thể loại của sách -->
<?php 
    $url = BOOK_URL . "/get_all_categories.php";
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

 <!-- Lấy thông tin sách theo ID -->
<?php 
    $id = $_GET['id'];
    try {
        $api_params = BOOK_URL . "/get_book_by_id.php?id=$id";
        $response = file_get_contents($api_params);
        if ($response === false) {
            echo "Lỗi khi gọi API";
        } else {
            $data = json_decode($response, true);
            if ($data) {
                $book = $data['data'];
            } else {
                echo "Dữ liệu API không hợp lệ";
            }
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
?>

<!-- API update sách -->
<?php 
    // Kiểm tra nếu có dữ liệu được gửi đi từ form POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Thu thập dữ liệu từ form
        $id = $_GET["id"] ;
        $title = $_POST["title"];
        $available = $_POST["available"];
        $description = $_POST["description"];
        $category = $_POST["category"];
        $author = $_POST["author"];
        $image = $_POST["image"];
        $access_token = $_COOKIE['access_token'];

        // Chuẩn bị dữ liệu để gửi đến API
        $data = [
            'title' => $title,
            'available' => $available,
            'description' => $description,
            'category_code' => $category,
            'author' => $author,
            'image' => $image
        ];


        $updateBookUrl = BOOK_URL . "/update_book.php?id=" . urlencode($id);;
        $ch = curl_init($updateBookUrl);
        
        $headers = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Bearer " . $access_token,
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);


        // Xử lý kết quả từ API
        if ($httpCode === 200) {
            $object = json_decode($response);
            echo "<script> 
                    window.location.href = 'index.php';     
                 </script>";
        } else {
            echo "<script> 
            var cmm = JSON.stringify($response); 
                    alert(cmm)      
            </script>";
        }
    }
    
?>

<div class="content" id="update_book">
    <div class="addBook justify-content-center">
      <div class="addBook">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0 text-center">Update Book</h3>
          </div>
          <div class="card-body">
            <form class="row" action="update-book.php?id=<?php echo  $id ?>" method="POST">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Image URL</label>
                        <input type="url" class="form-control" id="image" name="image" value="<?php echo htmlspecialchars($book['image'])?>" oninput="displayImage(this.value)">
                    </div>
                    <div class="img_upload form-group">
                        <img id="book-image" src="<?php  echo ($book['image'] == "") ? "./uploads/no_image.jpg" : $book['image']; ?>" alt="Book Image" style="max-width: 80%; height: auto;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($book['title'])?>" required>
                    </div>
                    <div class="form-group">
                        <label for="available">Available</label>
                        <input type="number" class="form-control" id="available" name="available" value="<?php echo htmlspecialchars($book['available'])?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea va class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($book['description'])?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category" required>
                        <?php  foreach ($data_categories["categories"] as $category): ?>
                            <option value="<?php  echo $category['code']; ?>"><?php  echo $category['value']; ?></option>
                        <?php  endforeach; ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($book['author'])?>" required>
                    </div>
                </div>
              <div class="button-group">
                <button type="submit" class="btn mr-2">Update Book</button>
                <a href="index.php" class="btn btn-cancel">Cancel</a>
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

<?php 
    require "inc/footer.php";
?>