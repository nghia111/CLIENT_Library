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
          <li><a href="product.php">Product</a></li>
          <li><a href="index.php">Services</a></li>
          <li><a href="index.php">Contact</a></li>
          <? if(Auth::isLoggedIn()): ?>
              <li><a href="adduser.php">Add User</a></li>
              <li><a href="addbook.php">Add Book</a></li>
              <li><a href="logout.php">Logout</a></li>
          <? else: ?>
              <li><a href="login.php">Login</a></li>
          <? endif; ?>
        </ul>

        <div class="header__menu-mobile" data-aos="fade-down">
          <img src="./assets/img/menu.svg" alt="menu" class="menu-icon">
          <div class="mobile-menu">
            <ul class="mobile__menu-list">
              <li><a href="index.php">Home</a></li>
              <li><a href="product.php">Product</a></li>
              <li><a href="index.php">Services</a></li>
              <li><a href="index.php">Contact</a></li>
              <? if(Auth::isLoggedIn()): ?>
                <li><a href="adduser.php">Add User</a></li>
                <li><a href="addbook.php">Add Book</a></li>
                <li><a href="logout.php">Logout</a></li>
              <? else: ?>
                <li><a href="login.php">Login</a></li>
              <? endif; ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    
    <div class="banner">
      <div class="cover"></div>
      <img class="banner_img" src="./assets/img/banner-header.png" alt="banner">
    </div>
  </body>
</html>

