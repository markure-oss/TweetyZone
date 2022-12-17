<?php
require_once "backend/initialize.php";
require_once "backend/shared/login_handlers.php";
$pageTitle='Login on Twitter | Twitter'; ?>
<?php require_once 'backend/shared/header.php'; ?>
<section class="sign-container">
  <?php require_once 'backend/shared/signNav.php'; ?>
  <div class="form-container">
    <div class="form-content">
      <div class="header-form-content">
        <h2>Login to Twitter</h2>
      </div>
      <form action="login.php" class="formField" method="POST">
        <div class="form-group">
          <?php echo $account->getErrorMessage(Constant::$loginPasswordFailed);   ?>
          <label for="un">Username or Email</label>
          <input type="text" name="un" id="un" value="<?php getInputValue("un"); ?>" autocomplete="off" required>
        </div>
        <div class="form-group">
          <label for="pass">Password</label>
          <input type="password" name="pass" id="pass" autocomplete="off" required>
        </div>

        <div class="s-password">
          <input type="checkbox" class="form-checkbox" id="s-password" onclick="showLoginPassword()">
          <label for="s-password">Show Password</label>
        </div>
        <div class="form-btn-wrapper">
          <button type="submit" class="btn-form" name="login">LogIn</button>
          <input type="checkbox" class="form-checkbox" id="check" name="rememberMe">
          <label for="check">Remember me</label>
        </div>

      </form>
    </div>
    <footer class="form-footer">
      <p>New to Twitter? <a href="sign">Signup for Twitter</a></p>
    </footer>
  </div>
</section>
<script src="frontend/assets/js/showPassword.js"></script>