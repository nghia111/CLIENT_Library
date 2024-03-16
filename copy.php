<?php
require "inc/init.php";


if (isset($_COOKIE['role'])) {
    $role = $_COOKIE['role'];
}

require "./inc/header.php";

// Lấy thông tin sách theo ID
$id = $_GET['id'];
try {
    $url = BOOK_URL . "/get_book_by_id.php";
    $api_params = "?id=$id";
    $response = file_get_contents($url . $api_params);
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

// Xử lý xóa sách
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Thu thập id của sách cần xóa
    $idToDelete = $_GET["id"];
    $access_token = $_COOKIE['access_token'];

    // Chuẩn bị dữ liệu để gửi đến API
    $deleteBookUrl = BOOK_URL . "/delete_book.php?id=" . $idToDelete;

    // Khởi tạo cURL handle
    $ch = curl_init($deleteBookUrl);

    // Thiết lập các tùy chọn cURL
    $headers = array(
        "Content-Type: application/x-www-form-urlencoded",
        "Authorization: Bearer " . $access_token,
        
    );

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('id' => $idToDelete))); // Dữ liệu cần xóa

    // Thực thi cURL và lưu kết quả
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Đóng cURL handle
    curl_close($ch);

    // Xử lý kết quả từ API
    if ($httpCode === 200) {
        // Xóa thành công, có thể redirect hoặc hiển thị thông báo tùy ý
        echo "<script>
        var cmm = JSON.stringify($response); 
        alert(cmm) 
        window.location.href = 'index.php'; 
            </script>";
        exit();
    } else {
        // Xóa không thành công, hiển thị thông báo lỗi
        echo "Xóa sách không thành công";
    }
}
?>

<!-- Hàm mượn sách -->
<?
    function borrowBook ($id) {

        $Borrow_url = BRB_URL . "/create_borrow_book.php";
        $headers = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Bearer " . $_COOKIE['access_token'] ,
        );

        $data = array(
            'book_id' => $id,
        );
        $ch = curl_init($Borrow_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            $ProfileResponse = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        if ($httpCode === 200) {
            echo "<script> 
                var cmm = JSON.stringify($ProfileResponse); 
                alert(cmm)
                window.location.href = 'book-detail.php?id=$id';     
            </script>";
        } else {  
            echo "<script> 
                var cmm = JSON.stringify($ProfileResponse); 
                alert(cmm)      
            </script>";
        }
    }
    if(isset($_GET['borrow'])){
        $bookId = $_GET['id'];
        borrowBook($bookId);
    };
?>

<?
    $AllBRB_url = BRB_URL . "/get_my_borrow_return_books.php";

    $ch = curl_init($AllBRB_url);
    $headers = array(
        "Content-Type: application/x-www-form-urlencoded",
        "Authorization: Bearer " . $_COOKIE['access_token'] ,
    );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $BRBresponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    if ($httpCode === 200) {
        $BRBobject = json_decode($BRBresponse);

    } else {
    
        
    }
?>

                    <? if(!isset($BRBobject->data)) {
                        echo "";
                        return;
                    } else { 
                    ?>
                    <? foreach ($BRBobject->data as $key ) :
                        if($key->book_id == $book['id'] && $key->status == 0){
                    ?>

                    <?        
                        }    
                        
                    ?>
                        
                    <tr>
                        <td><? echo $key->id  ?></td>
                        <td><? echo $key->book_title  ?></td>
                        <td><? echo $key->borrowed_day ?></td>
                        <td><? echo $key->returned_day  ?></td>
                    
                        <? if($key->status == 0) : 

                     ?>
                        <td>
                            <a href="#" class="btn px-0 py-1 btn-accept" style="width: 100px;">Chờ duyệt</a>
                            <a href="index.php" class="btn btn-cancel">Cancel</a>
                        </td>
                    <? elseif($key->status == 1 ): ?>
                        <td>
                            <a href="?borrow_id=<? echo $key->id?>" class="btn px-0 py-1 btn-accept" style="width: 100px;">Trả sách</a>
                        </td>
                    <? elseif($key->status == 2) : ?>
                        <td>
                            <div class="btn px-0 py-1 btn-cancel" style="width: 100px;">Đã từ chối</div>
                        </td>
                    <? elseif($key->status == 3 ) : ?>
                        <td>
                            <div href="#" class="btn px-0 py-1 btn-cancel" style="width: 100px; background-color:green; ">Đã trả</div>
                        </td>
                    <? endif ?>
                    <??> 
                    </tr>
                    <? endforeach; } ?>



<div class="content" id="book_detail">
    <div class="book-detail row mb-5">
        <div class="book-detail_cover col-md-4">
            <div class="book-detail_img row">
                <img src="<?php echo ($book['image'] == "") ? "./uploads/no_image.jpg" : $book['image']; ?>" alt="image book" >
            </div>
            <div class="book-detail_category row">
                <h4>Category: <?php echo $book['category_value']; ?></h4>
            </div>
        </div>
        <div class="book-detail_info col-md-8">
            <div class="book-detail_title row">
               <h3><?php echo $book['title']; ?></h3>
            </div>
            <hr>
            <div class="book-detail_desc row">
                <p>Description: <?php echo $book['description']; ?></p>
                <h5>Author: <?php echo $book['author']; ?></h5>    
            </div>
            <hr>
            <div class="button-group">
                <div class="book-detail_btn col">
                    <?if($role == "AD") : ?>
                        <button class="btn"><a href="update-book.php?id=<?=htmlspecialchars($book['id'])?>#update_book">Update</a></button>
                        <form id="deleteForm" method="post">
                            <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                            <button type="submit" class="btn" name="delete">Delete</button>
                        </form>
                    <? elseif($role == "UR") : ?>
                        <button class="btn"><a href="./book-detail.php?id=<?=htmlspecialchars($book['id'])?>&borrow=true">Borrow</a></button>
                        <a href="index.php" class="btn btn-cancel">Cancel</a>
                    <? else: ?>

                    <? endif; ?>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="book-suggest">
        <h2>Books in the Same Category</h2>
        <div class="book-suggest_list">
            <?php
                if(isset($books) && is_array($books)){
                    shuffle($books);
                    foreach ($books as $b){
                        if($b['id'] != $book['id']){
            ?>                
                            <div class="book-suggest_item">
                                <a href="book-detail.php?id=<?php echo htmlspecialchars($b['id']); ?>#book_detail"><img src="<?php echo $b['image']; ?>" alt="image book" width="200"></a>
                            </div>
            <?php
                        }
                    }
                } else {
                    echo "<h5>No books in the same category.</h5>";
                }
            ?>
        </div>
    </div>
</div>

<?php
require "./inc/footer.php";
?>
