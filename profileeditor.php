<?php
    require 'connect.php';
    session_start();

    $username=$_SESSION['user_id'];
    $editedtag=$_POST['edittag'];
    $editedbio=$_POST['editbio'];


    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }

    if(!isset($username)){
        header('Location: loginpage.php');
        exit;
    }

    if(isset($editedtag)){
        //Update profile data in database
        $stmt=$mysqli->prepare("UPDATE users SET tagline=?, bio=? where username=?");
        
        
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('sss', $editedtag, $editedbio, $username);
        $stmt->execute();
        $stmt->close();
        header('Location: mystories.php');  
        exit;

    }
?>