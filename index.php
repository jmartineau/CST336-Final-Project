<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>RPG Simulator Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">
      <!-- Creates login form -->
      <form class="form-signin" method="post" action="/final_project/Login/loginProcess.php">
        <h2 class="form-signin-heading">RPG Sim Login</h2>
        
        <?php
        session_start();
        
        // Prints error message if there was an incorrect login
        if(isset($_SESSION['errorMessage']))
        {
          echo $_SESSION['errorMessage'];
          $_SESSION['errorMessage'] = null;
        }
        ?>
        
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" value="login" name="loginForm">Sign in</button>
        <p><a href="/final_project/Login/createAccount.php">Create Account<br></a>
        <a href="/final_project/Login/guestLogin.php">Continue as Guest</a></p>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
