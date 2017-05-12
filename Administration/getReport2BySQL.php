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
            
        // 2. Create SQL statement
        $sql = "SELECT equipment.equipment_slot_id AS slot, ROUND(AVG(equipment_attribute.value), 2) AS value
                FROM equipment, equipment_attribute 
                WHERE (equipment.equipment_id = equipment_attribute.equipment_id)
                AND (equipment_attribute.attribute_id = 1)
                GROUP BY slot
                ORDER BY value DESC";
        
        // 3. Prepare SQL
        $stmt = $dbConn->prepare($sql);
        
        // 4. Execute the statement
        $stmt->execute();
        
        // 5. Create and return array with data
        $records = [];
        $record = [];
        
        $i = 0;
        while($row = $stmt->fetch()) 
        {
                $record['slot'] = $row['slot'];
                $record['value'] = $row['value'];
                $records[$i] = $record;
                $i++;
        }
        
        echo json_encode($records);
?>