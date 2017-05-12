<?php
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
        
        // Reports all items in the equipment table
        function getDataBySQL($dbConn, $sql)
        {
            // 2. Create SQL statement (if not passed in)
            if ($sql == "DEFAULT")
            {
                $sql = "SELECT name, equipment_id FROM equipment ORDER BY equipment_id";
            }
            
            // 3. Prepare SQL
            $stmt = $dbConn->prepare($sql);
            
            // 4. Execute the statement
            $stmt->execute();
            
            // 5. Create and return associative array with data
            $records = [];
            $record = [];
            $i = 0;
            while($row = $stmt->fetch()) 
            {
                $record["name"] = $row["name"];
                $record["equipment_id"] = $row["equipment_id"];
                $records[$i] = $record;
                $i++;
            }
            
            return $records;
        }
        
        // Retrieves data from equipment table
        function populateDropdown($equipment_slot_id, $equipmentType)
        {
            $dbConn = getDatabaseConnection(); 
            
            // 2. Create SQL statement
            $sql = "SELECT * FROM equipment WHERE equipment_slot_id = '$equipment_slot_id'";
            
            // 3. Prepare SQL
            $stmt = $dbConn->prepare($sql);
            
            // 4. Execute the statement
            $stmt->execute();
            
            // 5. Create and return array with data
            echo '<select id="' . $equipmentType . '">';
            while ($row = $stmt->fetch())
            {
              // To-do: If session equipped item, set as selected, else echo normally
              echo '<option value="' . $row["equipment_id"] . '">' . $row["name"] . '</option>';
            }
            echo '</select>';
        }
        
        // Retrieves data from boss table
        function populateBosses()
        {
            $dbConn = getDatabaseConnection(); 
            
            // 2. Create SQL statement
            $sql = "SELECT * FROM boss";
            
            // 3. Prepare SQL
            $stmt = $dbConn->prepare($sql);
            
            // 4. Execute the statement
            $stmt->execute();
            
            // 5. Create and return array with data
            echo '<select id="boss">';
            while ($row = $stmt->fetch())
            {
              echo '<option value="' . $row["level"] . '">' . $row["name"] . ', Level: ' . $row["level"] . '</option>';
            }
            echo '</select>';
        }
?>