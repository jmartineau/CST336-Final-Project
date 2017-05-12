<?php 
    session_start(); // Start or resume an existing session 
    
    include '../../final_project/SQLFunctions.php'; 
    
    $connection = getDatabaseConnection(); 
    
    if (isset($_POST['loginForm'])) { // Checks whether user submitted the form 
         
        $username = $_POST['username']; 
        
        // Create, prepare, and execute SQL statement
        $sql = "SELECT *  
                FROM user
                WHERE username = :username"; //Preventing SQL Injection 
                 
        $namedParameters = array(); 
        $namedParameters[':username'] = $username;                 
         
        $statement = $connection->prepare($sql);  
        $statement->execute($namedParameters); 
        $record = $statement->fetch(PDO::FETCH_ASSOC);
        
        // Get password hash from DB for password_verify
        $hash = $record['password'];
        
        if (empty($record))  // User doesn't exist
        { 
            // Sends user back to login screen with error message 
            $_SESSION['errorMessage'] = "Wrong username or password!";
            header("Location: ../../final_project/index.php"); 
        } 
        else if (password_verify($_POST['password'], $hash))   // Password correct
        { 
            // Set session username and send to simulator
            $_SESSION['username'] = $record['username'];
            $_SESSION['user_type_id'] = $record['user_type_id'];
            header("Location: ../../final_project/Simulator/simulator.php"); 
        }
        else   // Password incorrect
        {
            // Sends user back to login screen with error message 
            $_SESSION['errorMessage'] = "Wrong username or password!";
            header("Location: ../../final_project/index.php"); 
        }
    }
    else 
    {
        header("Location: ../../final_project/index.php"); 
    }
?>