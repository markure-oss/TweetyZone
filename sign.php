<?php 

require_once "backend/initialize.php";
require_once "backend/shared/register_handlers.php";
?>
<?php $pageTitle='SignUp | Twitter'; ?>
<?php require_once 'backend/shared/header.php'; ?>
<section class="sign-container">
  <?php require_once 'backend/shared/signNav.php'; ?>
  <div class="form-container">
    <div class="form-content">
      <div class="header-form-content">
        <h2>Create your account</h2>
      </div>
      <form action="sign.php" class="formField" method="POST">
        <div class="form-group">
          <?php echo $account->getErrorMessage(Constant::$firstNameCharacters);   ?>
          <label for="firstName">FirstName</label>
          <input type="text" name="firstName" id="firstName" value="<?php getInputValue("firstName"); ?>"
            autocomplete="off" required>
        </div>
        <div class="form-group">
          <?php echo $account->getErrorMessage(Constant::$lastNameCharacters);   ?>
          <label for="lastName">LastName</label>
          <input type="text" name="lastName" id="lastName" value="<?php getInputValue("lastName"); ?>"
            autocomplete="off" required>
        </div>
        <div class="form-group">
          <?php echo $account->getErrorMessage(Constant::$emailInUse);   ?>
          <?php echo $account->getErrorMessage(Constant::$emailInValid);   ?>
          <label for="email">Email</label>
          <input type="email" name="email" id="email" value="<?php getInputValue("email"); ?>" autocomplete="off"
            required>
        </div>
        <div class="form-group">
          <?php  echo $account->getErrorMessage(Constant::$passwordDoNotMatch);   ?>
          <?php  echo $account->getErrorMessage(Constant::$passwordNotAlphanumeric);   ?>
          <?php  echo $account->getErrorMessage(Constant::$passwordLength);   ?>
          <label for="pass">Password</label>
          <input type="password" name="pass" id="pass" autocomplete="off" required>
        </div>
        <div class="form-group">
          <label for="cpass">Confirm Password</label>
          <input type="password" name="pass2" id="cpass" autocomplete="off" required>
        </div>
        <div class="s-password">
          <input type="checkbox" class="form-checkbox" id="s-password" onclick="showPassword()">
          <label for="s-password">Show Password</label>
        </div>
        <div class="form-btn-wrapper">
          <button type="submit" class="btn-form">SignUp</button>
          <input type="checkbox" class="form-checkbox" id="check" name="remember">
          <label for="check">Remember me</label>
        </div>

      </form>
    </div>
    <footer class="form-footer">
      <p>Already have an account. <a href="login">Login Now</a></p>
    </footer>
  </div>
</section>
<script src="frontend/assets/js/showPassword.js"></script>
<script src="<?php echo url_for("frontend/assets/js/liveSearch.js"); ?>"></script>
<!-- <script src="<?php echo url_for("frontend/assets/js/notify.js"); ?>"></script> -->
<script src="<?php echo url_for("frontend/assets/js/follow.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/delete.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/hashtag.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/retweet.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/reply.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/likeTweet.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/fetchTweet.js"); ?>"></script>
<script src="<?php echo url_for("frontend/assets/js/common.js"); ?>"></script>