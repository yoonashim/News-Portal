<?php
    session_start();
    require 'connect.php';

    $stmt = $mysqli->prepare("SELECT COUNT(*), username, hashedp FROM users WHERE username=?");

    if(!$stmt){
	    printf("Query Prep Failed: %s\n", $mysqli->error);
	    exit;
    }

    // Bind the parameter
    $stmt->bind_param('s', $user_id);
    $user_id = $_POST['username'];
    $stmt->execute();

    // Bind the results
    $stmt->bind_result($cnt, $user_id, $hashed);
    $stmt->fetch();

    $pwd_guess = $_POST['password'];
    // Compare the submitted password to the actual password hash

    if($cnt == 1 && password_verify($pwd_guess, $hashed)){
    	// Login succeeded!
        $_SESSION['user_id'] = $user_id;
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
        // Redirect to your target page
        header('Location: homepage.php');
    }
    else{
        // Login failed; redirect back to the login screen
        session_destroy();
        header('Location: loginfail.php');
        exit;
    }
?>