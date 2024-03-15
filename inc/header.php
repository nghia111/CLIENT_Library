<?
  function logOut(){
    $access_token = "";
    $refresh_token = "";
    $role = "";

    if (isset($_COOKIE['access_token'])) {
      $access_token = $_COOKIE['access_token'];
    }
    if (isset($_COOKIE['refresh_token'])) {
      $refresh_token = $_COOKIE['refresh_token'];
    }
    if (isset($_COOKIE['role'])) {
      $role = $_COOKIE['role'];
    }
    $BASE_URL = "http://localhost/CT06/do_an/api/routes/auth";
    // Cấu hình URL và thông tin yêu cầu
    $url = $BASE_URL . '/logout.php'; // Thay thế bằng URL thực tế của bạn

    // Tạo dữ liệu yêu cầu
    $data = array(
      'refresh_token' => 'Bearer ' . $refresh_token
    );

    // Tạo header yêu cầu
    $headers = array(
      "Content-Type: application/x-www-form-urlencoded",
      "Authorization: Bearer " . $access_token // Thay thế bằng token thực tế của bạn
    );

    // Khởi tạo cURL
    $ch = curl_init($url);

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
      // Xử lý phản hồi thành công
      $object = json_decode($response);
      setcookie('access_token', '', 0, '/');
      setcookie('refresh_token', '', 0, '/');
      setcookie('role', '', 0, '/');
      header("Location: index.php");
    } else {
      // Xử lý lỗi
      $object = json_decode($response);
      echo $object->errors;
    }
  }

  if (isset($_GET['log_out'])) {
    logOut();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Books Store</title>
  <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
  <header class="header">
    <nav class="header__nav">
      <div class="header__logo">
        <img class="header__logo-img" src="./assets/img/logo-book.png" alt="logo">
        <a href="index.php" data-aos="fade-down">my library</a>
        <div class="header__logo-overlay"></div>
      </div>

      <ul class="header__menu" data-aos="fade-down">
        <li><a href="index.php">Home</a></li>
        <li><a href="product.php#product">Product</a></li>
        <li><a href="contact-us.php#contact">Contact</a></li>
        <? if (isset($_COOKIE['access_token'])) : ?>
          <li><a href="./?log_out=true">Logout</a></li>
          <? if ($_COOKIE['role'] == "AD") : ?>
            <li><a href="add-book.php#add_book">Add Book</a></li>
            <li><a href="admin-page.php"><img class="avatar" src="./assets/img/avatar.jpg" alt="avatar"></a></li>
          <? endif; ?>
          <? if ($_COOKIE['role'] == "UR") : ?>
            <li><a href="user-page.php"><img class="avatar" src="./assets/img/avatar.jpg" alt="avatar"></a></li>
          <? endif; ?>
        <? else : ?>
          <li><a href="login.php#login">Login</a></li>
        <? endif; ?>
      </ul>

      <!-- Menu mobile -->
      <div class="header__menu-mobile" data-aos="fade-down">
        <img src="./assets/img/menu.svg" alt="menu" class="menu-icon">
        <div class="mobile-menu">
          <ul class="mobile__menu-list">
            <li><a menu-link="Home" href="index.php">Home</a></li>
            <li><a menu-link="Product" href="product.php">Product</a></li>
            <li><a menu-link="Contact" href="index.php#contact">Contact</a></li>
            <? if (isset($_COOKIE['access_token'])) : ?>
              <li><a menu-link="Add Book" href="add-book.php#add_book">Add Book</a></li>
              <li><a href="./?log_out=true">Logout</a></li>
              <li><a href=""><img class="avatar" src="./assets/img/avatar.jpg" alt="avatar"></a></li>
            <? else : ?>
              <li><a href="login.php#login">Login</a></li>
            <? endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Banner củ -->
  <!-- <div class="banner">
    <div class="cover"></div>
    <img class="banner_img" src="./assets/img/banner-header.png" alt="banner">
  </div> -->

  <!-- Banner -->
  <div class="content">
    <div id="carouselExampleControls" class="banner carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-100" src="./assets/img/banner_1.png" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="./assets/img/banner_2.png" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="./assets/img/banner_3.png" alt="Third slide">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only"></span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only"></span>
      </a>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- cấu hình chuyển động -->
  <script>
    $('#carouselExampleControls').carousel({
      interval: 3000, // Thời gian hiển thị mỗi slide là 3 giây
    });
  </script>

  <!-- active header menu item -->
  <script>
    // Xử lý sự kiện khi nhấp vào nút danh mục sách
    document.querySelectorAll('.header__menu').forEach(item => {
        item.addEventListener('click', event => {
            const menu_link = event.target.getAttribute('menu-link');
            console.log(menu_link);
        });
    });
  </script>
</body>

</html>