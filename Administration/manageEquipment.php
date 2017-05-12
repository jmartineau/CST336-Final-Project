<?php
session_start();

if (!isset($_SESSION['username'])) {  // Checks whether user has logged in
    header("Location: ../../final_project/index.php");
}

if ($_SESSION['user_type_id'] != 1) {   // Checks whether user is an admin
    header("Location: ../../final_project/index.php");
}

include '../../final_project/SQLFunctions.php'; 

// Displays all items from equipment table
function displayAllEquipment() {
    $conn = getDatabaseConnection();
    $sql = "SELECT name, equipment_id FROM equipment ORDER BY equipment_id";
    $records = getDataBySQL($conn, $sql);

    // Echo table data using form buttons
     echo "<table class='table table-sm table-hover table-striped'>";
     echo "<tr>";
     echo "<th><legend>Equipment Name</legend></th>";
     echo "<th><legend>&nbspUpdate</legend></th>";
     echo "<th><legend>&nbspDelete</legend></th>";
     echo "</tr>";
     
    foreach ($records as $record) 
    {
      echo "<tr>"; 
      echo "<td>" . $record['name'] . "</td>"; 
      echo "<td> <form action=updateEquipment.php>";
      echo "<input type='hidden' name='equipment_id' value='". $record['equipment_id'] . "'/>";
      echo "<input type='submit' class='btn btn-primary' value='Update'/></form> </td>";
      echo '<td> <form action="deleteEquipment.php" onsubmit="return confirmDelete()">';
      echo "<input type='hidden' name='equipment_id' value='". $record['equipment_id'] . "'/>";
      echo "<input type='submit' class='btn btn-danger' value='Delete'/></form> </td>";
      echo "</tr>";
    } //endForeach
    echo "</table>";
     
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>RPG Database Management</title>

    <!-- Bootstrap core CSS -->
    <link href="../../final_project/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Include JQuery and JS functions -->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../../final_project/Javascript.js" ></script>
  </head>

<body>
  <div class="container">
    <header>
      <h1>RPG Database Management</h1>
    </header>
    
    <!-- Welcome user --->
    <div class="form-inline" id="welcomeDiv">
     <strong> Welcome, <?=$_SESSION['username']?>! </strong>
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="button" class="btn btn-warning" id="logoutButton">Logout</button>
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="button" class="btn btn-info" id="returnButton">Return to Simulator</button>
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="submit" class="btn btn-success" id="generateButton">Generate Reports</button>
  </div>
    
    <br /><br />
    <?=displayAllEquipment()?>
    
    <form action="addEquipment.php">
        <button type="submit" class="btn btn-primary" id="addButton">Add New Equipment</button>
        <br><br>
    </form>
  </div>

    <footer>

    </footer>
  </div>
  
  <script>
    // Adds confirmation when deleting a record
    function confirmDelete() {
        return confirm("Do you really want to delete this record?");
    }

    // Define logout button behavior
    $("#logoutButton").click(function(){
        window.location.href = "../../final_project/Login/logout.php";
    });
    
    // Define return button behavior
    $("#returnButton").click(function(){
        window.location.href = "../../final_project/Simulator/simulator.php";
    });
    
    // Define generate report button behavior
    $("#generateButton").click(function(){
        window.location.href = "generateReports.php";
    });
  </script>  
</body>
</html>