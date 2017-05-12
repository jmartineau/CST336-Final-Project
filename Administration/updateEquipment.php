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
 
 // Gets equipment information
 function getEquipmentById(){
    global $conn;
    $sql = "SELECT * FROM equipment WHERE equipment_id = :equipment_id";
    $namedParameters = array();
    $namedParameters[':equipment_id'] = $_GET['equipment_id'];
    $statement = $conn->prepare($sql);    
    $statement->execute($namedParameters);
    $record = $statement->fetch();
    return $record;
 }
 
 // Sets the select form data to match the equipment_slot_id
 function selectedCat($num)
 {
   $equipment = getEquipmentById();
   if ($num == $equipment['equipment_slot_id'])
   {
     return "selected";
   }
 }

if (isset($_GET['updateForm'])) {  // Admin submitted the Update Form
    
    $sql = "UPDATE equipment
            SET name = :name,
            equipment_slot_id = :equipment_slot_id
            WHERE equipment_id = :equipment_id";
    $namedParameters = array();
    $namedParameters[':name'] = $_GET['name'];
    $namedParameters[':equipment_slot_id'] = $_GET['equipment_slot_id'];
    $namedParameters[':equipment_id'] = $_GET['equipment_id'];

    $conn = getDatabaseConnection();    
    $statement = $conn->prepare($sql);
    $statement->execute($namedParameters);
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

    <title>Update Equipment</title>

    <!-- Bootstrap core CSS -->
    <link href="../../final_project/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Include JQuery and JS functions -->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../../final_project/Javascript.js" ></script>
  </head>

<body>
  <div class="container">
    <header>
      <h1>Update Equipment</h1>
    </header>
    
    <!-- Welcome user --->
    <div class="form-inline" id="welcomeDiv">
     <strong> Welcome, <?=$_SESSION['username']?>! </strong>
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="button" class="btn btn-warning" id="logoutButton">Logout</button>
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="button" class="btn btn-info" id="returnButton">Return to Management</button>
  </div id="updateDiv">
    
    <br /><br />
        <?php 
        $equipment = getEquipmentById();
        ?>

      <form>
          <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label">Name:</label>
              <div class="col-sm-10">
                  <input type="text" name="name" class="form-control" value="<?=$equipment['name']?>" id="name"/> <br />
              </div>
          </div>
          <div class="form-group row">
              <label for="equipment_slot_id" class="col-sm-2 col-form-label">Equipment Slot:</label>
              <div class="col-sm-10">
          <select name="equipment_slot_id" class="form-control" id="equipment_slot_id">
               <option value="1" <?=selectedCat(1)?> >Main Hand</option>
               <option value="2" <?=selectedCat(2)?> >Helm</option>
               <option value="3" <?=selectedCat(3)?> >Armor</option>
               <option value="4" <?=selectedCat(4)?> >Leggings</option>
                    </select>
                </div>
            </div>
          <br />          
          <input type="hidden" name="equipment_id" value="<?=$equipment['equipment_id']?>" />
          <input type="submit" id="updateButton" class="btn btn-success" value="Update Equipment" name="updateForm" />
          
          <!-- Echo update message -->
          <?php
          if (isset($_GET['updateForm'])) { echo "<br><br><h4>Record has been updated!</h4>";}
          ?>
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