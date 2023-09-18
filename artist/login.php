<?php ob_start(); ?>
<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php'); ?>

<style>
  body {
    background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
    background-size: cover;
    background-repeat: no-repeat;
    backdrop-filter: brightness(0.5);
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    /* background-color: #f3f4f6; */
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
  }

  #page-title {
    text-shadow: 6px 4px 7px black;
    font-size: 3.3em;
    color: #fff4f4 !important;
    background: #8080801c;
  }

  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .login-cards {
    width: 500px;
    height: auto;
  }

  .login-card {
    background-color: #f2f2f2;
    border-radius: 45px;
    padding: 5px;
    /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
    box-shadow: 0 3px 50px 0 rgba(0, 0, 0, 0.2), 0 1px 50px 0 rgba(0, 0, 0, 0.19);
  }

  .login-card-items {
    text-align: center;
    gap: 65px;
    margin: 20px 10px 10px;
  }

  .login-tag {
    font-size: 24px;
    margin-bottom: 20px;
  }

  .form-items input[type="email"],
  .form-items input[type="text"],
  .form-items input[type="password"] {
    width: 80%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 30px;
    border: 1px solid #ccc;
  }

  .password-item {
    position: relative;
  }

  .forgot-password-item {
    text-align: left;
    margin-top: 5px;
    margin-left: 39px;
  }

  .button-item {
    width: 80%;
    padding: 10px;
    margin-top: 10px;
    background-color: #3e7ef3;
    color: #fff;
    border: none;
    border-radius: 45px;
    cursor: pointer;
  }

  .create-account-item {
    margin-top: 20px;
  }

  .create-account-item a {
    color: #333;
    text-decoration: none;
  }

  .create-account-item a span {
    font-weight: bold;
  }

  /* Responsive Styles */
  @media screen and (max-width: 480px) {
    .login-cards {
      width: 100%;
      padding: 20px;
    }
  }

  #back-to-home {
    margin-bottom: 40rem;
    padding-left: 40px
  }
</style>

<body>
  <div id="back-to-home">
    <a href="../index.php?page=home" class="btn btn-outline btn-default"><i class="fas fa-home animated zoomIn"></i><span>
        <h5 class="back-to-home text-lightblue">Back to Home</h5>
      </span></a>

  </div>
  <div class="container">
    <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo $_settings->info('name') ?></b></h1>
    <div class="login-cards">
      <div class="login-card">
        <div class="login-card-items">
          <h1 class="login-tag">Please Login</h1>
          <form id="login-frm" action="" method="post" class="form-items">
            <input type="text" name="username" placeholder="Username">
            <div class="password-item">
              <input type="password" name="password" placeholder="Password">
              <div class="forgot-password-item">
                <a href="#">Forgot Password</a>
              </div>
            </div>
            <button class="button-item" type="submit" value="Login">Login</button>
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  </div>
  <script>
    $(document).ready(function() {
      end_loader();
    })
  </script>
</body>

</html>