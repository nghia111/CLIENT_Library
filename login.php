<?php
    require "inc/init.php";
    ini_set('display_errors', 'off');

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $conn = require "inc/db.php";
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(User::authenticate($conn, $username, $password)){
            Auth::login();
            header("Location: index.php");
        }else{
            Dialog::show("Invalid username or password");
        }
    }
?>

<?php
    require "inc/header.php";
?>

<div class="content">
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

                    <form style="width: 23rem;">

                        <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Login System</h3>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="form2Example18">Email address</label>
                            <input type="email" id="form2Example18" class="form-control form-control-lg" />
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="form2Example28">Password</label>
                            <input type="password" id="form2Example28" class="form-control form-control-lg" />
                        </div>

                        <div class="pt-1 mb-4">
                            <button class="btn btn-info btn-lg btn-block" type="button">Login</button>
                        </div>

                        <p>Don't have an account? <a href="register.php" class="link-info">Register here</a></p>

                    </form>

                    </div>

                </div>
                <div class="form-login__img col-sm-6 px-0 d-none d-sm-block">
                    <!-- <img src="https://i.pinimg.com/564x/6d/52/60/6d5260b4e265aad38be8f8b8931776f0.jpg"
                    alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;"> -->

                    <img src="https://i.pinimg.com/564x/b4/d4/2e/b4d42eee67bd0f7b8b178679dc447e44.jpg"
                    alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
            </div>
        </div>
    </section>
</div>

<?php require "inc/footer.php";?>