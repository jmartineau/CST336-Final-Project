<?php
        session_start();
        // Creates connection with DB
        function getDatabaseConnection()
        {
            $dbHost = getenv("IP");
            $dbPort = 3306;
            $dbName = "rpg_equipment_simulator";
            $dbUsername = getenv("C9_USER");
            $dbPassword = "";
            
            // 1. Connect to database
            $dbConn = new PDO("mysql:host=$dbHost;dbname=$dbName;port=$dbPort", $dbUsername, $dbPassword);
            
            // Error checking
            //$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            
            return $dbConn;
        }
        
        // Retrieves equipment stats from DB
        $dbConn = getDatabaseConnection(); 
        
        $equipment_id = @$_POST['equipment_id'];
        
        // First, get the name of the equipment to determine main attribute
        $sql = "SELECT * FROM equipment WHERE equipment_id = '$equipment_id'";
        $stmt = $dbConn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
        $name = $row['name'];
            
        // 2. Create SQL statement
        $sql = "SELECT equipment_attribute.value AS value, equipment.image_url AS image_url
                FROM equipment, equipment_attribute 
                WHERE (equipment.equipment_id = '$equipment_id') AND (equipment_attribute.equipment_id = '$equipment_id')";
        
        // 3. Prepare SQL
        $stmt = $dbConn->prepare($sql);
        
        // 4. Execute the statement
        $stmt->execute();
        
        // 5. Create and return array with data
        $record = [];
        $row = $stmt->fetch();
        $primaryValue = $row['value'];
        $imageUrl = $row['image_url'];
        $return_arr[] = array("name" => $name, "primaryValue" => $primaryValue, "imageUrl" => $imageUrl);
        echo json_encode($return_arr);
?>