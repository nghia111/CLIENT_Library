<?
    require "inc/init.php";
    $conn = require("inc/db.php");
?>

<?php
    require "./inc/header.php";
?>


<!-- Get book by id -->
<?
    $id = $_GET['id'];
    try {
        $url = "http://localhost/CT06/do_an/api/routes/book/get_book_by_id.php";

        $api_params = "?id=$id";


        $response = file_get_contents($url . $api_params);

        if ($response === false) {
            echo "Lỗi khi gọi API";
        } else {
            // Xử lý dữ liệu nhận được từ API
            $data = json_decode($response, true);
            if ($data) {
                $book = $data['data'];
            } else {
                // Xử lý lỗi nếu dữ liệu không hợp lệ
                echo "Dữ liệu API không hợp lệ";
            }
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
?>

<!-- Get book same category -->
<?
    $categoryFilter = $book['category_code'];
    try {
        $url = "http://localhost/CT06/do_an/api/routes/book/get_books.php";

        $api_params = "?limit=99&page=1&category_code=$categoryFilter";


        $response = file_get_contents($url . $api_params);

        if ($response === false) {
            echo "Lỗi khi gọi API";
        } else {
            // Xử lý dữ liệu nhận được từ API
            $data_book_same_category = json_decode($response, true);
            if ($data_book_same_category) {
                $books = $data_book_same_category['data'];
            } else {
                // Xử lý lỗi nếu dữ liệu không hợp lệ
                echo "Dữ liệu API không hợp lệ";
            }
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
?>



<div class="content" id="book_detail">
    <div class="book-detail row mb-5">
        <div class="book-detail_cover col-md-4">
            <div class="book-detail_img row">
                <img src="<? echo $book['image'] ?>" alt="image book">
            </div>
            <div class="book-detail_category row">
                <h4>Category: <? echo $book['category_value'] ?></h4>
            </div>
        </div>
        <div class="book-detail_info col-md-8">
            <div class="book-detail_title row">
               <h3><? echo $book['title'] ?></h3>
            </div>
            <hr>
            <div class="book-detail_desc row">
                <p>Description: <? echo $book['description'] ?></p>
                <h5>Author: <? echo $book['author']?>Crist Topfer</h5>    
            </div>
            <hr>
            <div class="button-group">
                <div class="book-detail_btn col">
                    <button  class="btn"><a href="update-book.php#update_book">Update</a></button>
                    <button class="btn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="book-suggest">
        <h2>Book have same category</h2>
        <div class="book-suggest_list">
            <?
                if(isset($books) && is_array($books)){
                    shuffle($books);
                    foreach ($books as $b){
                        if($b['id'] != $book['id']){
            ?>                
                        
                            <div class="book-suggest_item">
                                <a href="book-detail.php?id=<?=htmlspecialchars($b['id'])?>#book_detail"><img src="<? echo $b['image'] ?>" alt="image book" width="200"></a>
                            </div>
                        
            <?          }else {
                            echo "<h5>Không có sách nào cùng thể loại với sách trên.</h5>";
                        }
                }
                }else {
                    echo "<h5>Không có sách nào cùng thể loại với sách trên.</h5>";
                }
            ?>
            
        </div>
    </div>
    
</div>

<?php
    require "./inc/footer.php";
?>