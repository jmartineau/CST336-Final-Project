<?php
session_start();

if (!isset($_SESSION['username'])) {  // Checks whether user has logged in
    
    header("Location: ../../final_project/index.php");
}

include '../../final_project/SQLFunctions.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>RPG Simulator</title>

    <!-- Bootstrap core CSS -->
    <link href="../../final_project/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Include JQuery and JS functions -->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../../final_project/Javascript.js" ></script>
  </head>

<body>
  <div class="container">
    <header>
      <h1>RPG Simulator</h1>
    </header>
    
    <!-- Welcome user --->
    <div class="form-inline" id="welcomeDiv">
     <strong> Welcome, <?=$_SESSION['username']?>! </strong>
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="button" class="btn btn-warning" id="logoutButton">Logout</button>
  </div>
  
  <!-- Create table to display equipment --->
  <div id="dataDisplay"><br>
    <table class="table table-border" id="rpgTable">
      <thead>
        <tr>
          <form action="#" id="rpgForm">
          <th>Select Weapon: <?php populateDropdown(1, "weapon"); ?></th>
          <th>Select Helm: <?php populateDropdown(2, "helm"); ?></th>
          <th>Select Armor:<?php populateDropdown(3, "armor"); ?></th>
          <th>Select Leggings: <?php populateDropdown(4, "leggings"); ?></th>
          </form>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td id="weaponImageTD">Weapon Image</td>
          <td id="helmImageTD">Helm Image</td>
          <td id="armorImageTD">Armor Image</td>
          <td id="leggingsImageTD">Leggings Image</td>
        </tr>
        <tr>
          <td id="weaponPrimaryTD">Weapon Primary Stat</td>
          <td id="helmPrimaryTD">Helm Primary Stat</td>
          <td id="armorPrimaryTD">Armor Primary Stat</td>
          <td id="leggingsPrimaryTD">Leggings Primary Stat</td>
        </tr>
        <tr>
          <td id="weaponStaminaTD">Weapon Stamina</td>
          <td id="helmStaminaTD">Helm Stamina</td>
          <td id="armorStaminaTD">Armor Stamina</td>
          <td id="leggingsStaminaTD">Leggings Stamina</td>
        </tr>
      </tbody>
    </table>
    
    <!-- Create UI buttons-->
    <br><button type="button" class="btn btn-success" id="statsButton">Update Stats</button>
    &nbsp&nbsp&nbsp<a href="#" id="showHide"> Show/Hide Stats </a>
    <div class="stats" style="display:none;"></div>
    <br><br><br><div id="bossSelect">
      Select Boss: <?php populateBosses(); ?>
      &nbsp&nbsp&nbsp&nbsp<button type="button" class="btn btn-danger" id="bossButton">Simulate Battle</button>
      <div id="bossMessage"></div>
      <br><br><div id="blizzardDiv">
        <button type="button" class="btn btn-primary" id="blizzardButton">Find More from Blizzard</button>
        &nbsp&nbsp&nbsp<a href="#" id="blizzardClear"> Clear</a>
        </div>
        <div id="blizzardReport"></div>
    </div>
    
  </div>

    <footer>

    </footer>
  </div>
  
  <script>
  // Initialize stat variables
  var strength = 0;
  var agility = 0;
  var intelligence = 0;
  var stamina = 0;
  
  // Workaround variables
  var savedStrength = 0;
  var savedAgility = 0;
  var savedIntelligence = 0;
  var savedStamina = 0;
  
  // Load initial info on page load
  window.onload = function() 
  {
    // Get user type and append a manage button if user is an admin
    var userTypeId = "<?php echo $_SESSION['user_type_id']; ?>";
    if (userTypeId == 1)
    {
      var manageAppend = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="button" class="btn btn-info" id="manageButton" onclick="manageRedirect()">Manage Database</button>';
      $("#welcomeDiv").append(manageAppend);  // Use this syntax to append; welcomeDiv.append(manageAppend) appends String literally
    }
    
    populateEquipment();
  }
  
  // Update equipment information on button click
  $("#statsButton").click(function(){
    $('#bossMessage').empty(); // Clear previous data
    $('#blizzardReport').empty(); // Clear previous data
    $(".stats").hide(); // Hide stats
    populateEquipment();
    savedStrength = strength;
    savedAgility = agility;
    savedIntelligence = intelligence;
    savedStamina = stamina;
    strength = 0;
    agility = 0;
    intelligence = 0;
    stamina = 0;
  });
  
  // Show or hide stats
  $("#showHide").click( function(){ 
    $(".stats").slideToggle(); 
  });
  
  // Define boss button behavior
  $("#bossButton").click(function(){
    // Get maximum stat
    var maxStat = Math.max(savedStrength, savedAgility, savedIntelligence);
    $('#bossMessage').empty(); // Clear previous data
    
    // Get boss level
    var bossLevel = document.getElementById("boss").value;
    
    // Determine if boss can be beaten with current gear
    // Simplistic algorithm: Require maxStat > (bossLevel * 6)
    if (maxStat >= (bossLevel * 7))
    {
      $("#bossMessage").append("<h4>Victory! The boss can be beaten with your current equipment.</h4>");
    }
    else
    {
      $("#bossMessage").append("<h4>Defeat! Try upgrading your equipment.</h4>");
    }
  });
  
  // Define Blizzard button behavior
  // Wait between AJAX calls to prevent errors
  $("#blizzardButton").click(function(){
    $('#blizzardReport').empty(); // Clear previous data
    
    // Use AJAX to retrieve Ragnaros
    setTimeout(function(){
      jQuery.ajax({
      type: "GET",
      url: "https://us.api.battle.net/wow/boss/11502?locale=en_US&apikey=fuj2mhhvwajk78t924yb344zrmrhqtam",
      dataType: 'json',
      success: function(data)
      {
        // Append data received as JSON to table
        $('#blizzardReport').append("<br><table class='table table-sm table-hover' id='myTable'><tr><th><legend>Name</legend></th><th><legend>Level</legend></th><th><legend>Health</legend></th></tr>");
        var name = data["name"];
        var level = data['level'];
        var health = data['health'];
        $('#myTable').append("<tr><td>" + name + "</td><td>" + level + "</td><td>" + health + "</td></tr>");
      }
    });
    }, 100);
    
    // Use AJAX to retrieve Illidan
    setTimeout(function(){
      jQuery.ajax({
      type: "GET",
      url: "https://us.api.battle.net/wow/boss/22917?locale=en_US&apikey=fuj2mhhvwajk78t924yb344zrmrhqtam",
      dataType: 'json',
      success: function(data)
      {
        // Append data received as JSON to table
        var name = data["name"];
        var level = data['level'];
        var health = data['health'];
        $('#myTable').append("<tr><td>" + name + "</td><td>" + level + "</td><td>" + health + "</td></tr>");
      }
    });
    }, 200);
    
    // Use AJAX to retrieve the Lich King
    setTimeout(function(){
    jQuery.ajax({
    type: "GET",
    url: "https://us.api.battle.net/wow/boss/36597?locale=en_US&apikey=fuj2mhhvwajk78t924yb344zrmrhqtam",
    dataType: 'json',
    success: function(data)
    {
      // Append data received as JSON to table
      var name = data["name"];
      var level = data['level'];
      var health = data['health'];
      $('#myTable').append("<tr><td>" + name + "</td><td>" + level + "</td><td>" + health + "</td></tr>");
      $('#blizzardReport').append("</table><br>");
    }
  });
    }, 300);
  });
  
  // Clear blizzard table and boss message
  $("#blizzardClear").click( function(){ 
    $('#blizzardReport').empty(); // Clear previous data
    $('#bossMessage').empty(); // Clear previous data
  });
  
  // Define logout button behavior
  $("#logoutButton").click(function(){
   window.location.href = "../../final_project/Login/logout.php";
  });
  
  // Define manage button behavior
  function manageRedirect()
  {
    window.location.href = "../../final_project/Administration/manageEquipment.php";
  }
  </script>  
</body>
</html>