<?
  require 'inc/init.php';
?>

<?
  require 'inc/header.php';
?>

<div class="content mt-5" id="contact">
  <div class="container_contact row justify-content-center">
    <div class="col-md-8">
      <div class="contact-form">
        <h2>Contact Us</h2>
        <form class="form_contact">
          <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter your name">
          </div>
          <div class="form-group">
            <label for="email">Your Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter your email">
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" id="message" rows="4" placeholder="Enter your message"></textarea>
          </div>
          <div class="button-group">
            <button type="submit" class="btn">Submit</button>
            <a href="index.php" class="btn btn-cancel">Cancel</a>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>

<?
    require 'inc/footer.php';
?>