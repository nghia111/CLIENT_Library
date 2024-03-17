<?php 
require "./inc/init.php";
require "./inc/header.php";

?>
<?php 
        $ProfileUrl = USER_URL . "/get_my_profile.php";
        $ch = curl_init($ProfileUrl);
        $headers = array(
        "Content-Type: application/x-www-form-urlencoded",
        "Authorization: Bearer " . $_COOKIE['access_token'] ,
    );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $ProfileResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    if ($httpCode === 200) {
        $ProfileObject = json_decode($ProfileResponse);
    } else {
    
        echo "<script> 
            var cmm = JSON.stringify($ProfileResponse); 
            alert(cmm)      
        </script>";
    }
?>


<?php 
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

<?php 
    function ReturnBRB($id){
        
        $processUrl =  BRB_URL . "/create_return_book.php" ;
        $headers = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Bearer " . $_COOKIE['access_token'] ,
        );

        $data = array(
            'borrow_id' => $id,
        );
        $ch = curl_init($processUrl);
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
                window.location.href = 'user-page.php'; 
            </script>";
        } else {  
            echo "<script> 
                var cmm = JSON.stringify($ProfileResponse); 
                alert(cmm)      
            </script>";
        }
    }
    if (isset($_GET['borrow_id'])) {
        $borrow_id = $_GET['borrow_id'];
        ReturnBRB($borrow_id);
      }
?>
<div class="content" id="user">
    <div class="user-page row">
        <div class="col-lg-4">
            <div class="user-information">
            <h5 class="text-center mt-3">Thông tin cá nhân</h5>
                <div class="m-3">
                    <p>Tên : <?php  echo $ProfileObject->data->name?></p>
                    <p>Email : <?php  echo $ProfileObject->data->email?></p>
                    <p>Role : <?php  echo $ProfileObject->data->role?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-8 table-mobile">
            <table class="table table-brb">
                <thead align="center">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tên sách</th>
                        <th scope="col">Ngày mượn</th>
                        <th scope="col">Ngày trả</th>
                        <th scope="col">Trạng thái</th>
                    </tr>
                </thead>
                <tbody align="center">
                    <?php  if(!isset($BRBobject->data)) {
                        echo " <h5> Không có lệnh đang mượn.</h5>";
                        return;
                    } else { ?>
                     <?php  foreach ($BRBobject->data as $key ) :?>
                        
                    <tr>
                        <td><?php  echo $key->id  ?></td>
                        <td><?php  echo $key->book_title  ?></td>
                        <td><?php  echo $key->borrowed_day ?></td>
                        <td><?php  echo $key->returned_day  ?></td>
                    
                        <?php  if($key->status == 0) : 

                     ?>
                        <td>
                            <a href="#" class="btn px-0 py-1 btn-accept" style="width: 100px;">Chờ duyệt</a>
                            
                        </td>
                    <?php  elseif($key->status == 1 ): ?>
                        <td>
                            <a href="?borrow_id=<?php  echo $key->id?>" class="btn px-0 py-1 btn-accept" style="width: 100px;">Trả sách</a>
                        </td>
                    <?php  elseif($key->status == 2) : ?>
                        <td>
                            <div class="btn px-0 py-1 btn-cancel" style="width: 100px;">Bị từ chối</div>
                        </td>
                    <?php  elseif($key->status == 3 ) : ?>
                        <td>
                            <div href="#" class="btn px-0 py-1 btn-cancel" style="width: 100px; background-color:green; ">Đã trả</div>
                        </td>
                    <?php  endif ?>
                    <?php ?> 
                    </tr>
                    <?php  endforeach; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php  require "./inc/footer.php"; ?>