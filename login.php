<!DOCTYPE html>
<html lang="en">

  <?php include('./header.php'); ?>
   <?php 
   session_start();
   if(isset($_SESSION['login_id']))
   header("location:index.php?page=notary");
   ?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Notary Public</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon1.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>
<style>
  #login-right{
		position: absolute;
		right:0;
		width:30%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
  #login-left{
    position: absolute;
    left: 0;
    width: 70%;
    height: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    display: flex;
    align-items: center;
}
#login-right .card{
		margin: auto
	}
  .img .logo {
      width: 900px; 
    height: auto;
  }
  .login-bg {
    background-color: white;
    text-align: center;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 50px;
}
.new-login-wrapper {
    background-color: #FFFFFF;
    height: 500px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.new-input-label {
    color: #1D1F1F;
    margin-top: 9px;
    margin-bottom: 4px;
    display: flex;
    justify-content: flex-start;
    font: normal normal medium 16px/19px Roboto;
}

.form-spacer {
    margin-top: 2rem;
}
.new-title-2 {
    color: #041E80;
    margin: 0;
    padding: 0px;
    font: normal normal bold 34px/43px "Nunito", sans-serif;
}

.new-title-3 {
    color: #222;
    margin: 0;
    padding: 0px;
    font: normal normal bold 27px/43px "Nunito", sans-serif;
}

h1, h2, h3, h4, h5, h6 {
    margin-top: 1.6rem;
    margin-bottom: 1rem;
    font-weight: 500;
    line-height: 1.2;
}
</style>
<body>

<main>
  
  <div class="container">
      <div id="login-left" style="background-image: url('assets/img/background.png');">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="img">
                <img class="logo" src="assets/img/lol.png">
              </div>
            </div>
          </div>
        </div>
      </div>
    <div id="login-right">
      <div class="login-bg">
				<div class="new-login-wrapper">
                <div><h1 class="new-title-2">ATTYY. RAFUNZEL S. BERO </h1></div>
                <div><h5 class="new-title-3">NOTARY PUBLIC</h5></div>
                <div class='form-spacer'></div>
                <div><h2 class="new-title-3">Sign In</h2></div>
                <form class="row g-3" id="login-form">
                  <div class="col-12">
                    <label for="username" class="new-input-label">Username</label>
                    <input type="text" autofocus="" name="username" class="form-control" id="username" required>
                  </div>
                  
                  <div class="col-12">
                    <label for="password" class="new-input-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                  </div>
                  
                  <div class="col-12">
                    <div class="text-end mb-2">
                      <span id="login-error" class="text-danger small" style="display: none;">
                        Username or password is incorrect
                      </span>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                  </div>
                </form>
          </div>
        </div>
    </div>

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        
      </section>
    </div>
  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

<script>
  $(document).ready(function () {
    $('#login-form').submit(function (e) {
      e.preventDefault();
      $('#login-form button[type="submit"]').attr('disabled', true).html('Logging in...');
  
      // Remove any existing error messages and reset styles
      $('#login-form .is-invalid').removeClass('is-invalid');
      $('.invalid-feedback-log').hide();
      $('#login-error').hide(); // Hide the error message
  
      $.ajax({
        url: 'ajax.php?action=login',
        method: 'POST',
        data: $(this).serialize(),
        error: function (err) {
          console.log(err);
          $('#login-form button[type="submit"]').removeAttr('disabled').html('Login');
        },
        success: function (resp) {
            if (resp == 1) {
                // Redirect to the notary page
                window.location.href = 'index.php?page=notary';
            } else {
                // Show invalid feedback for username and password fields
                $('#username').addClass('is-invalid');
                $('#password').addClass('is-invalid');
                $('.invalid-feedback-log').show();

                // Show the error message
                $('#login-error').show();

                $('#login-form button[type="submit"]').removeAttr('disabled').html('Login');
            }
        }
      });
    });
  });
</script>



</html>