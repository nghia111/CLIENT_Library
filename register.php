<?php
  require "inc/init.php";
?>

<?
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usernameError = "";
    $passwordError = "";


    if ($usernameError == "" && $passwordError == "") {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $username = $_POST['name'];
      $confirm_password = $_POST['confirm_password'];
      $data = array(
        'email' => $email,
        'password' => $password,
        'name' => $username,
        'confirm_password' => $confirm_password
      );
      $url = AUTH_URL . "/register.php";
      $ch = curl_init($url);

      $headers = array(
        "Content-Type: application/x-www-form-urlencoded",
      );
      // Cấu hình cURL
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      // Gửi yêu cầu và nhận phản hồi
      $response = curl_exec($ch);

      // Kiểm tra mã phản hồi HTTP
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      // Đóng kết nối cURL
      curl_close($ch);

      if ($httpCode === 200) {
        echo $response;
        // Xử lý phản hồi thành công
        $object = json_decode($response);
        header('Location: login.php');
      } else {
        // Xử lý lỗi
        $object = json_decode($response);

        echo $response;
      }
    }
  }

  if (isset($_SESSION['logged_in'])) {
    header("Location: index.php");
  }
?>

<?php
  require "inc/header.php";
?>

<div id="register" class="content">
  <section>
    <div class="form-register container-fluid">
      <div class="row">
        <div class="form-register__img col-sm-6 px-0 d-none d-sm-block">
          <img src="https://i.pinimg.com/564x/6d/52/60/6d5260b4e265aad38be8f8b8931776f0.jpg" alt="Login image" class="w-100 vh-110" style="object-fit: cover; object-position: left;">

          <!-- <img src="https://i.pinimg.com/564x/c4/9f/0f/c49f0f23df88100dd72d21d4d2d0f035.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;"> -->
        </div>
        <div class="form-register__info col-sm-6 text-black">

          <div class="register-header__logo px-5 ms-xl-4">
            <div class="header__logo">
              <img class="header__logo-img" src="./assets/img/logo-book.png" alt="logo">
              <a href="index.php" data-aos="fade-down">my library</a>
            </div>
          </div>

          <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

            <form style="width: 23rem;" method="POST">

              <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Register System</h3>


              <div class="form-outline mb-4">
                <label class="form-label" for="form2Example18">Email address</label>
                <input type="email" id="form2Example18" name="email" class="form-control form-control-lg" />
              </div>
              <div class="form-outline mb-4">
                <label class="form-label" for="form2Example18">Username</label>
                <input type="text" id="form2Example18" name="name" class="form-control form-control-lg" />
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="form2Example28">Password</label>
                <input type="password" id="form2Example28" name="password" class="form-control form-control-lg" />
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="form2Example28">Repeat your password</label>
                <input type="password" id="form2Example28" name="confirm_password" class="form-control form-control-lg" />
              </div>

              <div class="pt-1 mb-4">
                <button class="btn btn-info btn-lg btn-block" type="submit">Register</button>
              </div>

              <p>Do you have an account? <a href="login.php#login" class="link-info">Login here</a></p>

            </form>

          </div>

        </div>
      </div>
    </div>
  </section>
</div>

<?php require "inc/footer.php"; ?>