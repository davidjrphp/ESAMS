
<?php ob_start(); ?>
<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">

<?php
  require_once('inc/sess_auth.php');
  
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<title><?php echo $_settings->info('title') != false ? $_settings->info('title').' | ' : '' ?><?php echo $_settings->info('name') ?></title>
    <link rel="icon" href="<?php echo validate_image($_settings->info('logo')) ?>" />
    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
      <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
   <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.css">
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/custom.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.css">
     <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <style type="text/css">/* Chart.js */
      @keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}
    </style>

     <!-- jQuery -->
     <script src="<?php echo base_url ?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?php echo base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <!-- <script src="<?php echo base_url ?>plugins/toastr/toastr.min.js"></script> -->
    <script>
        var _base_url_ = '<?php echo base_url ?>';
    </script>
    <script src="<?php echo base_url ?>dist/js/script.js"></script>
  </head>

  <style>
    body{
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size:cover;
      background-repeat:no-repeat;
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
    #page-title{
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
    margin: 40px 15px 15px;
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
    border-radius: 45px;
    border: 1px solid #ccc;
  }
  
  .password-item {
    position: relative;
  }
  
  .forgot-password-item {
    text-align: left;
    margin-top: 5px;
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
  </style>
  <body>
	<div class="container">
	<h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo $_settings->info('name') ?></b></h1>
		<div class="login-cards">
			<div class="login-card">
				<div class="login-card-items">
					<h1 class="login-tag">Please Enter Your Details</h1>
					<form action="sign_up.php" class="form-items" method="POST">
                    <div class="email">
						<input type="email" name="email" id="email" placeholder="Email Address">
                        <div class="username">
							<input type="text" name="username" id="username" placeholder="Username">
						<div class="password-item">
							<input type="password" name="password" id="pass" placeholder="Password" maxlength="8">
                            <div class="password-item">
							<input type="password" name="password2" id="pass2" placeholder="Retype your Password" maxlength="8">
							
						</div><br>
						<button class="button-item" type="submit" id="btn" value="Submit">Sign-Up</button>
					</form>
                    <?php
      if(isset($_POST['submit'])){
        $username = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
        $email = $_POST['email'];

        require_once('Administrator/PHP/connect.php');

      $query = "INSERT INTO tblusers VALUES ('','$username','$password','$password2','$email')";

                    $result = mysqli_query($con, $query) or die(mysqli_error($con));
                    ?>
        <script type="text/javascript">
            alert("Account Created Successfully.");
            window.location = "loginpage.php";
        </script>
         <?php
             }               
        ?>   
			</div>
		</div>
	</div>
    <script>

var mail = document.getElementById("email").value;
    var username = document.getElementById("username").value;
    var pass = document.getElementById("pass").value;
    var pass2 = document.getElementById("pass2").value;
    if(mail == ""){
        alert('You must enter your Email Address');
    }
    else if(username == ""){
        alert('you must enter your password');
    }
    else if(pass == ""){
        alert('you must enter your Username');
    }else{
        if(pass != pass2){
            alert('type a matching password');
        }else{
            alert('Your account has been created successfully');
        }
    }
    </script>
</body>
</html>


