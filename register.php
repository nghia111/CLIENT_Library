<?php
  require "inc/init.php";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usernameError = "";
    $passwordError = "";

    
    if (!preg_match("/^[A-Za-z]*$/", $username)) {
      $usernameError = "Only contains [A-Za-z]";
    }

    $password = $_POST["password"];
    if (!preg_match("/^(?=.*\d)(?=.*[a-zA-Z])[0-9a-zA-Z!@#$%^&*()_+]{8,}$/", $password)) {
      $passwordError = "Password is invalid";
    }

    if ($usernameError == "" && $passwordError == "") {
      $conn = require "inc/db.php";
      $user = new User($username, $password);
      try {
        if ($user->addUser($conn)) {
          Dialog::show("Add user successfully!");
        } else {
          Dialog::show("Cannot add user");
        }
      } catch (PDOException $e) {
        // Solution added: header to error.php
        Dialog::show($e->getMessage());
      }
    } else {
      Dialog::show('Error...');
    }
  }

  if (isset($_SESSION['logged_in'])) {
    header("Location: index.php");
  }
?>

<?php
    require "inc/header.php";
?>

<div class="content">
    <section>
        <div class="form-register container-fluid">
            <div class="row">
                <div class="form-register__img col-sm-6 px-0 d-none d-sm-block">
                    <img src="https://i.pinimg.com/564x/6d/52/60/6d5260b4e265aad38be8f8b8931776f0.jpg"
                    alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">

                    <!-- <img src="https://i.pinimg.com/564x/b4/d4/2e/b4d42eee67bd0f7b8b178679dc447e44.jpg"
                    alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;"> -->
                </div>
                <div class="form-register__info col-sm-6 text-black">

                    <div class="register-header__logo px-5 ms-xl-4">
                        <div class="header__logo">
                            <img class="header__logo-img" src="./assets/img/logo-book.png" alt="logo">
                            <a href="index.php" data-aos="fade-down">my library</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

                    <form style="width: 23rem;">

                        <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Register System</h3>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="form2Example18">Email address</label>
                            <input type="email" id="form2Example18" class="form-control form-control-lg" />
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="form2Example28">Password</label>
                            <input type="password" id="form2Example28" class="form-control form-control-lg" />
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="form2Example28">Repeat your password</label>
                            <input type="password" id="form2Example28" class="form-control form-control-lg" />
                        </div>

                        <div class="pt-1 mb-4">
                            <button class="btn btn-info btn-lg btn-block" type="button">Register</button>
                        </div>

                        <p>Do you have an account? <a href="login.php" class="link-info">Login here</a></p>

                    </form>

                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<?php require "inc/footer.php";?>