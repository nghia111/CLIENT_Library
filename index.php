<?php
    require "inc/init.php";
    $conn = require('inc/db.php');
    $books = Book::getAllBooks($conn);

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

<?
    // Đỗi từ category code thành category name
    foreach ($books as $book) {
        $book->category_code = Book::getCategoryFromCategoryCode($conn,$book->category_code);
    };
?>

<!-- API  tất cả sách rồi thực hiện phân trang -->
<?php

    // Kiểm tra nếu có yêu cầu tìm kiếm
    $search_title = isset($_GET['search']) ? $_GET['search'] : null;

    if($search_title){
        try {
            // API endpoint
            $api_url = "http://localhost/CT06/do_an/api/routes/book/get_books.php";
            
            // Số quyển sách trên mỗi trang
            $booksPerPage = 10;

            // Xác định trang hiện tại
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $search_title_code = urlencode($search_title);

            $offset = ($page - 1) * $booksPerPage;
            $api_params = "?title=$search_title_code&limit=$booksPerPage&page=$page";
            $response = file_get_contents($api_url . $api_params);
            $data = json_decode($response, true);

            // Dữ liệu trả về từ API
            $books = $data['data'] ?? []; // Sử dụng toán tử null coalescing để xác định giá trị mặc định là mảng rỗng nếu không có dữ liệu trả về
            $totalPages = $data['total_page'] ?? 0; // Sửa key thành 'total_page' thay vì 'total' 
              

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    } else {
        // API endpoint
        $api_url = "http://localhost/CT06/do_an/api/routes/book/get_books.php";
            
        // Số quyển sách trên mỗi trang
        $booksPerPage = 10;

        // Xác định trang hiện tại
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        // Gửi yêu cầu GET đến API để lấy dữ liệu sách
        $offset = ($page - 1) * $booksPerPage;
        $api_params = "?limit=$booksPerPage&page=$page";
        $response = file_get_contents($api_url . $api_params);
        $data = json_decode($response, true);

        // Dữ liệu trả về từ API
        $books = $data['data']; // Sửa key thành 'data' thay vì 'books'
        $totalPages = $data['total_page']; // Sửa key thành 'total_page' thay vì 'total'   
    }
?>

<? 
    require "./inc/header.php";
?>

<div class="content">
    <div class="row"> 
        <div class="filter col-md-3">
            <div class="filter-title mb-2">
                <h3 >Filter by Category</h3>
            </div>
            
            <div class="list-group">
                <button type="button" class="list-group-item list-group-item-action active" data-category="all">All</button>
                <? foreach($data_categories["categories"] as $categories): ?>
                    <div class="list-group">
                    <button type="button" class="list-group-item list-group-item-action " data-category=""><? echo $categories['value'] ?></button>
                </div>
                <? endforeach; ?> 
            </div>
             
        </div>
        <div class="table-search col-md-9">
            <div class="search row mb-3">
                <div class="col">
                    <form method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" id="search-input" placeholder="Search by title">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="search-button">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-bordered table-hover">
                <thead align="center">
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col" width="15%">Title</th>
                        <th class="col-mobile" scope="col" width="15%">Category</th>
                        <th class="col-mobile" scope="col" width="40%">Description</th>
                        <th scope="col" width="15%">Author</th>
                        <th scope="col" width="10%">Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = ($page - 1) * $booksPerPage + 1;
                        if(isset($books) && is_array($books)) { // Kiểm tra nếu có dữ liệu sách trả về và là một mảng
                            foreach ($books as $book) {
                                ?>
                                <tr>
                                    <td align="center"><?php echo $no++; ?></td>
                                    <td align="center"><?php echo $book['title']; ?></td>
                                    <td class="col-mobile" align="center"><?php echo $book['category_value']; ?></td>
                                    <td class="col-mobile"><?php echo $book['description']; ?></td>
                                    <td align="center"><?php echo $book['author']; ?></td>
                                    <td align="center">
                                        <img src="<?php echo $book['image']; ?>" alt="" width="100" height="100">
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='6'>No books found</td></tr>"; // Thông báo nếu không có sách nào được tìm thấy
                        }

                        if($books === []) {
                            echo "<tr><td colspan='6'>No books found</td></tr>"; // Thông báo nếu không có sách nào được tìm thấy
                        }
                    ?>
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="pagination justify-content-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php 
                        // Hiển thị nút Previous (Trang trước)
                        if($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page='.($page - 1).'">Previous</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
                        }
                        
                        // Hiển thị các trang xung quanh trang hiện tại
                        $startPage = max(1, $page - 2);
                        $endPage = min($totalPages, $page + 2);
                        
                        for ($i = $startPage; $i <= $endPage; $i++) {
                            if ($i == $page) {
                                echo '<li class="page-item active"><span class="page-link">'.$i.'</span></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
                            }
                        }
                        
                        // Hiển thị nút Next (Trang tiếp theo)
                        if($page < $totalPages) {
                            echo '<li class="page-item"><a class="page-link" href="?page='.($page + 1).'">Next</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><span class="page-link">Next</span></li>';
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php
    require "./inc/footer.php";
?>