<?php 
    session_start(); // Start or resume an existing session 

    include '../../final_project/SQLFunctions.php'; 
    
    $connection = getDatabaseConnection(); 
    
    if (isset($_POST['createAccountForm'])) { // Checks whether user submitted the form 
         
        $username = $_POST['username']; 
    
        // Create, prepare, and execute SQL statement
        $sql = "SELECT *  
                FROM user
                WHERE username = :username";  //Preventing SQL Injection 
                 
        $namedParameters = array(); 
        $namedParameters[':username'] = $username; 
         
        $statement = $connection->prepare($sql);  
        $statement->execute($namedParameters); 
        $record = $statement->fetch(PDO::FETCH_ASSOC); 
         
        if (!empty($record)) // Username already in use
        { 
            // Sends user back to login screen with error message 
            $_SESSION['errorMessage'] = "Username already in use!";
            header("Location: createAccount.php"); 
        } 
        else    // Create account
        { 
            // Help hashing and salting from: 
            // https://www.sitepoint.com/hashing-passwords-php-5-5-password-hashing-api/
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            // Create user and send to simulator
            $sql = "INSERT INTO user (username, password, user_type_id) VALUES (:username, :password, 2)";   //Preventing SQL Injection 
                     
            $namedParameters = array(); 
            $namedParameters[':username'] = $username;                 
            $namedParameters[':password'] = $hash;             
             
            $statement = $connection->prepare($sql);  
            $statement->execute($namedParameters); 
            $record = $statement->fetch(PDO::FETCH_ASSOC); 
            
            $_SESSION['username'] = $record['username'];
            header("Location: ../../final_project/Simulator/simulator.php"); 
        }
    }
    else 
    {
        header("Location: ../../final_project/index.php"); 
    }

?>