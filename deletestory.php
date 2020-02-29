<?php
    require 'connect.php';
    session_start();

    $username=$_SESSION['user_id'];
    $news_id=$_POST['deletetitle'];
    

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }
    //Checks if logged in
    if(!isset($username)){
        header('Location: loginpage.php');
        exit;
    }
    //Checks if delete button pressed
    if(isset($_POST['submitdelete'])){
        $stmt2=$mysqli->prepare("DELETE FROM comments WHERE news_id=?");

        if(!$stmt2){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt2->bind_param('i', $news_id);
        $stmt2->execute();
        $stmt2->close();

        $stmt=$mysqli->prepare("DELETE FROM news WHERE news_id=?");

        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('i', $news_id);
        $stmt->execute();
        $stmt->close();
        header('Location: mystories.php');
        exit;
        
    }
?>