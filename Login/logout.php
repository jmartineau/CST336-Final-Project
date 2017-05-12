<?php 
session_start();  // Starting or resuming existing session 
session_destroy();  // Kills session 

header("Location: ../../final_project/index.php"); 


?>