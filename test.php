<? 
    require "./inc/init.php";
    $conn = require('inc/db.php');
    require "./inc/header.php";
    
?>
<div class="content">
    <div class="admin-page row"> 
        <div class="col-lg-4">
            <div class="user-information">
                <h5 class="text-center mt-3">Thông tin quản trị viên</h5>
                <div class="m-3">
                    <p>Tên: Nguyễn Văn B</p>
                    <p>Email: nguyenvanB@gmail.com</p>
                    <p>SĐT: 0123456789</p>
                    <p>Ngày sinh: 01/01/2001</p>
                    <p>Địa chỉ: Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="mb-3 d-flex justify-content-end">
                <div class="col-sm-4">
                    <select id="admin-option" class="form-select" aria-label="Default select example">
                        <option value="1">Quản lí người dùng</option>
                        <option value="2">Các lệnh mượn và trả</option>
                    </select>
                </div>
            </div>
            

            <div id="user-manager" style="display: block;">
            <table class="table">
                <thead align="center">
                    <tr>
                        <th scope="col" align="center">ID</th>
                        <th scope="col" align="center">Tên người dùng</th>
                        <th scope="col" align="center">Số sách đã mượn</th>
                        <th scope="col" align="center">Số sách đã trả</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody align="center">
                    <tr>
                        <td>1</td>
                        <td>Nguyễn Văn A</td>
                        <td>3</td>
                        <td>3</td>
                        <td>
                            <a href="user-profile.php" class="btn px-4 py-1">Chi tiết</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Nguyễn Văn C</td>
                        <td>3</td>
                        <td>3</td>
                        <td>
                            <a href="user-profile.php" class="btn px-4 py-1">Chi tiết</a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Nguyễn Văn D</td>
                        <td>3</td>
                        <td>3</td>
                        <td>
                            <a href="user-profile.php" class="btn px-4 py-1">Chi tiết</a>
                        </td>
                    </tr>

                </tbody>
            </table>
            </div>
            
            <div id="borrow-return" style="display: none;">
            <table class="table">
                <thead align="center">
                    <tr>
                        <th scope="col">ID Sách</th>
                        <th scope="col">Tên sách</th>
                        <th scope="col">ID người dùng</th>
                        <th scope="col">Tên người dùng</th>
                        <th scope="col" style="width: 222px;">Trạng thái</th>
                    </tr>
                </thead>
                <tbody align="center">
                    <tr>
                        <td>1</td>
                        <td>To Kill a Mockingbird - Harper Lee</td>
                        <td>1</td>
                        <td>Nguyễn Văn A</td>
                        <td>
                            <a href="#" class="btn px-0 py-1 btn-accept" style="width: 100px;">Chấp nhận</a>
                            <a href="#" class="btn px-0 py-1 btn-cancel" style="width: 100px;">Từ chối</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>To Kill a Mockingbird - Harper Lee</td>
                        <td>1</td>
                        <td>Nguyễn Văn D</td>
                        <td>
                            <a href="#" class="btn px-0 py-1 btn-accept" style="width: 100px;">Chấp nhận</a>
                            <a href="#" class="btn px-0 py-1 btn-cancel" style="width: 100px;">Từ chối</a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>To Kill a Mockingbird - Harper Lee</td>
                        <td>1</td>
                        <td >Nguyễn Văn C</td>
                        <td>
                            <a href="#" class="btn px-0 py-1 btn-accept" style="width: 100px;">Chấp nhận</a>
                            <a href="#" class="btn px-0 py-1 btn-cancel" style="width: 100px;">Từ chối</a>
                        </td>
                    </tr>

                </tbody>
            </table>
            </div>
            
        </div>
    </div>
</div>

<script>
    document.getElementById("admin-option").onchange = function () {
        var e = parseInt(document.getElementById("admin-option").value);
        // alert(e);
        switch(e){
            case 1 : {
                document.getElementById("user-manager").style.display = 'block';
                document.getElementById("borrow-return").style.display = 'none';
                break;
            }
            case 2 : {
                document.getElementById("user-manager").style.display = 'none';
                document.getElementById("borrow-return").style.display = 'block';
                break;
            }
            default : {
                alert('Có gì đó không đúng xảy ra!!!');
            }
        }
    };
    
</script>

<? require "./inc/footer.php";?>