<?
    require "inc/init.php";
    ini_set('display_errors', 'off');
?>
    <!-- LOGIN  -->
    <!-- Cấu hình URL và thông tin yêu cầu -->
<?
    $url = AUTH_URL . '/login.php'; // Thay thế bằng URL thực tế của bạn

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = require "inc/db.php";

        $email = $_POST['email'];
        $password = $_POST['password'];

        $loginData = array(
            'email' => $email,
            'password' => $password
        );

        $ch = curl_init($url);
    
        $headers = array(
            "Content-Type: application/x-www-form-urlencoded",
        );

        // Cấu hình cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($loginData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Gửi yêu cầu và nhận phản hồi
        $response = curl_exec($ch);
    
        // Kiểm tra mã phản hồi HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        // Đóng kết nối cURL
        curl_close($ch);
    
        if ($httpCode === 200) {
            // Xử lý phản hồi thành công
            $object = json_decode($response);
            $accessToken =  $object->access_token;
            $refreshToken =  $object->refresh_token;
            $role = $object->role;

            echo $response;

            //add to local storage
            $expirationTime = time() + (5 * 24 * 60 * 60);
            setcookie("access_token", $accessToken, $expirationTime, "/");
            setcookie("refresh_token", $refreshToken, $expirationTime, "/");
            setcookie("role", $role, $expirationTime, "/");
            header("Location: index.php");
        } else {
            // Xử lý lỗi
            echo 
            '
            <div class="container p-5">
                <div class="row no-gutters">
                    <div class="col-lg-6 col-md-12">
                        <div class="alert-danger shadow my-3" role="alert" style="border-radius: 0px">
                            <div class="row">
                                <div class="col-2">
                                    <div class="text-center" style="background:#721C24">
                                        <svg width="3em" height="3em" style="color:#F8D7DA" viewBox="0 0 16 16" class="m-1 bi bi-exclamation-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="alert col-10 my-auto">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="True" style="color:#721C24">&times;</span>
                                    </button>
                                    <div class="row">
                                        <p style="font-size:18px" class="mb-0 font-weight-light"><b class="mr-1">Danger!</b>' . json_encode($ProfileResponse) . '</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            
        }
    }
?>

<?php
    require "./inc/header.php";
?>

<div id="login" class="content">
    <section>
        <div class="form-login container-fluid">
            <div class="row">
                <div class="form-login__info col-sm-6 text-black">

                    <div class="login-header__logo px-5 ms-xl-4">
                        <div class="header__logo">
                            <img class="header__logo-img" src="./assets/img/logo-book.png" alt="logo">
                            <a href="index.php" data-aos="fade-down">my library</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

                    <form style="width: 23rem" method="POST">

                        <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Login System</h3>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="form2Example18">Email address</label>
                            <input type="email" id="form2Example18" name="email" class="form-control form-control-lg" />
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="form2Example28">Password</label>
                            <input type="password" id="form2Example28" name="password" class="form-control form-control-lg" />
                        </div>

                        <div class="pt-1 mb-4">
                            <button class="btn btn-info btn-lg btn-block" type="submit">Login</button>
                        </div>

                        <p>Don't have an account? <a href="register.php#register" class="link-info">Register here</a></p>

                    </form>

                    </div>

                </div>
                <div class="form-login__img col-sm-6 px-0 d-none d-sm-block">
                    <!-- <img src="https://i.pinimg.com/564x/6d/52/60/6d5260b4e265aad38be8f8b8931776f0.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;"> -->

                    <img src="https://i.pinimg.com/564x/b4/d4/2e/b4d42eee67bd0f7b8b178679dc447e44.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
            </div>
        </div>
    </section>
</div>

<?php require "inc/footer.php";?>