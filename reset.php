<?php
    session_start();
    require 'connect.php';

    $fpwuser=$_POST['fpwuser'];

    $stmt = $mysqli->prepare("SELECT username, hashedp, securitya FROM users WHERE username=?");

    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('s', $fpwuser);

    $stmt->execute();

    $stmt->bind_result($username, $oldpw, $securitya);
    $stmt->fetch();
    $stmt->close();

    //Hash new password
    $securityguess=$_POST['fpwanswer'];
    $newpassword=$_POST['newpw'];
    $hashednewpw=password_hash($newpassword, PASSWORD_DEFAULT);

    //Check if security question answer is correct, then update to new hashed password
    if(password_verify($securityguess, $securitya)){
        $update=$mysqli->prepare("UPDATE users SET hashedp=? where username=?");
            if(!$update){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
        $update->bind_param('ss', $hashednewpw, $fpwuser);
        $update->execute();
        $update->close();
        echo "Reset Successful.";?><a href="loginpage.php">Login?</a><?php
    }
    else{
        session_destroy();
        header('Location: resetfail.php');
        exit;
    }
?>