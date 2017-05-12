<?php
session_start();

if (!isset($_SESSION['username'])) {  // Checks whether user has logged in
    header("Location: ../../final_project/index.php");
}

if ($_SESSION['user_type_id'] != 1) {   // Checks whether user is an admin
    header("Location: ../../final_project/index.php");
}

include '../../final_project/SQLFunctions.php'; 
$conn = getDatabaseConnection();

// Delete item from equipment DB
$sql = "DELETE FROM equipment WHERE equipment_id = :equipment_id";
$namedParameters = array();
$namedParameters[':equipment_id'] = $_GET['equipment_id'];
$statement = $conn->prepare($sql);    
$statement->execute($namedParameters);

// Return to management page
header("Location: manageEquipment.php");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Delete Equipment</title>

    <!-- Bootstrap core CSS -->
    <link href="../../final_project/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Include JQuery and JS functions -->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../../final_project/Javascript.js" ></script>
  </head>

<body>
  <div class="container">
    <header>
      <h1>Delete Equipment</h1>
    </header>
    
    <!-- Welcome user --->
    <div class="form-inline" id="welcomeDiv">
     <strong> Welcome, <?=$_SESSION['username']?>! </strong>
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="button" class="btn btn-warning" id="logoutButton">Logout</button>
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="button" class="btn btn-info" id="returnButton">Return to Management</button>
  </div id="deleteDiv">
    
    <br /><br />
    </div>
    </form>
  </div>

    <footer>

    </footer>
  </div>
  
  <script>
  // Define logout button behavior
  $("#logoutButton").click(function(){
   window.location.href = "../../final_project/Login/logout.php";
  });
  
  // Define return button behavior
  $("#returnButton").click(function(){
   window.location.href = "manageEquipment.php";
  });
  </script>  
</body>
</html>