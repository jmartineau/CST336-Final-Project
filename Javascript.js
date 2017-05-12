// Fill equipment table with data
function populateEquipment()
{
  // Display equipment table
  $("#dataDisplay").hide();
  populateWeapon();
  populateHelm();
  populateArmor();
  populateLeggings();
  $("#dataDisplay").fadeIn(900);
  
  // Display stats to user
  $('.stats').empty(); // Clear previous data
   $( ".stats" ).append("Note: Two clicks required to update." +
                            "<br>Strength: " + strength + 
                            "<br>Agility: " + agility + 
                            "<br>Intelligence: " + intelligence + 
                            "<br>Stamina: " + stamina);
}

// Populate weapon portion of equipment table
function populateWeapon()
{
    // Clear out previous data
    var equipment_id = document.getElementById("weapon").value;
    $('#weaponImageTD').empty(); // Clear previous data
    $('#weaponPrimaryTD').empty(); // Clear previous data
    $('#weaponStaminaTD').empty(); // Clear previous data
    
    // Use AJAX to retrieve data from server
    jQuery.ajax({
    type: "POST",
    url: "../../final_project/Simulator/getStatsBySQL.php",
    dataType: 'json',
    data: {equipment_id: equipment_id},
    cache: false,
    success: function(data)
    {
      // Find primary attribute based on name and update counter
      var name = data[0].name;
      var attributeName;
      if (name.includes("Plate") || name.includes("Sword"))
      {
        attributeName = "Strength: ";
        strength += Number(data[0].primaryValue);
      }
      else if (name.includes("Leather") || name.includes("Bow"))
      {
        attributeName = "Agility: ";
        agility += Number(data[0].primaryValue);
      }
      else if (name.includes("Cloth") || name.includes("Staff"))
      {
        attributeName = "Intelligence: ";
        intelligence += Number(data[0].primaryValue);
      }
      
      // Append data received as JSON to table  
      var primaryValue = data[0].primaryValue;
      var image = new Image();
      image.src = data[0].imageUrl;
      weaponImageTD.append(image);
      weaponPrimaryTD.append(attributeName + primaryValue);
      weaponStaminaTD.append("Stamina: 0");
    }
  });
}

// Populate helm portion of equipment table
function populateHelm()
{
    // Clear out previous data
    var equipment_id = document.getElementById("helm").value;
    $('#helmImageTD').empty(); // Clear previous data
    $('#helmPrimaryTD').empty(); // Clear previous data
    $('#helmStaminaTD').empty(); // Clear previous data
    
    // Use AJAX to retrieve data from server
    jQuery.ajax({
    type: "POST",
    url: "../../final_project/Simulator/getStatsBySQL.php",
    dataType: 'json',
    data: {equipment_id: equipment_id},
    cache: false,
    success: function(data)
    {
      // Find primary attribute based on name and update counter
      var name = data[0].name;
      var attributeName;
      if (name.includes("Plate") || name.includes("Sword"))
      {
        attributeName = "Strength: ";
        strength += Number(data[0].primaryValue);
      }
      else if (name.includes("Leather") || name.includes("Bow"))
      {
        attributeName = "Agility: ";
        agility += Number(data[0].primaryValue);
      }
      else if (name.includes("Cloth") || name.includes("Staff"))
      {
        attributeName = "Intelligence: ";
        intelligence += Number(data[0].primaryValue);
      }
      stamina += Number(data[0].primaryValue);
      
      // Append data received as JSON to table    
      var primaryValue = data[0].primaryValue;
      var image = new Image();
      image.src = data[0].imageUrl;
      helmImageTD.append(image);
      helmPrimaryTD.append(attributeName + primaryValue);
      helmStaminaTD.append("Stamina: " + primaryValue);
    }
  });
}

// Populate armor portion of equipment table
function populateArmor()
{
    // Clear out previous data
    var equipment_id = document.getElementById("armor").value;
    $('#armorImageTD').empty(); // Clear previous data
    $('#armorPrimaryTD').empty(); // Clear previous data
    $('#armorStaminaTD').empty(); // Clear previous data
    
    // Use AJAX to retrieve data from server
    jQuery.ajax({
    type: "POST",
    url: "../../final_project/Simulator/getStatsBySQL.php",
    dataType: 'json',
    data: {equipment_id: equipment_id},
    cache: false,
    success: function(data)
    {
      // Find primary attribute based on name and update counter
      var name = data[0].name;
      var attributeName;
      if (name.includes("Plate") || name.includes("Sword"))
      {
        attributeName = "Strength: ";
        strength += Number(data[0].primaryValue);
      }
      else if (name.includes("Leather") || name.includes("Bow"))
      {
        attributeName = "Agility: ";
        agility += Number(data[0].primaryValue);
      }
      else if (name.includes("Cloth") || name.includes("Staff"))
      {
        attributeName = "Intelligence: ";
        intelligence += Number(data[0].primaryValue);
      }
      stamina += Number(data[0].primaryValue);
      
      // Append data received as JSON to table   
      var primaryValue = data[0].primaryValue;
      var image = new Image();
      image.src = data[0].imageUrl;
      armorImageTD.append(image);
      armorPrimaryTD.append(attributeName + primaryValue);
      armorStaminaTD.append("Stamina: " + primaryValue);
    }
  });
}

// Populate leggings portion of equipment table
function populateLeggings()
{
    // Clear out previous data
    var equipment_id = document.getElementById("leggings").value;
    $('#leggingsImageTD').empty(); // Clear previous data
    $('#leggingsPrimaryTD').empty(); // Clear previous data
    $('#leggingsStaminaTD').empty(); // Clear previous data
    
    // Use AJAX to retrieve data from server
    jQuery.ajax({
    type: "POST",
    url: "../../final_project/Simulator/getStatsBySQL.php",
    dataType: 'json',
    data: {equipment_id: equipment_id},
    cache: false,
    success: function(data)
    {
      // Find primary attribute based on name and update counter
      var name = data[0].name;
      var attributeName;
      if (name.includes("Plate") || name.includes("Sword"))
      {
        attributeName = "Strength: ";
        strength += Number(data[0].primaryValue);
      }
      else if (name.includes("Leather") || name.includes("Bow"))
      {
        attributeName = "Agility: ";
        agility += Number(data[0].primaryValue);
      }
      else if (name.includes("Cloth") || name.includes("Staff"))
      {
        attributeName = "Intelligence: ";
        intelligence += Number(data[0].primaryValue);
      }
      stamina += Number(data[0].primaryValue);
      
      // Append data received as JSON to table
      var primaryValue = data[0].primaryValue;
      var image = new Image();
      image.src = data[0].imageUrl;
      leggingsImageTD.append(image);
      leggingsPrimaryTD.append(attributeName + primaryValue);
      leggingsStaminaTD.append("Stamina: " + primaryValue);
    }
  });
}