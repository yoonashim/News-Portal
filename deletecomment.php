<?php
    require 'connect.php';
    session_start();

    $username=$_SESSION['user_id'];
    $comment_id=$_POST['deletec'];
    $news_id=$_POST['getnewsid'];    

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }

    //Checks if logged in
    if(!isset($username)){
        header('Location: loginpage.php');
        exit;
    }

    //Checks if delete comment button pressed
    if(isset($_POST['submitdeletec'])){
        $stmt=$mysqli->prepare("DELETE FROM comments WHERE comment_id=?");

        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('i', $comment_id);
        $stmt->execute();
        $stmt->close();
        header('Location: viewer.php?news_id='.$news_id);
        exit;
    }
    

    

    

?>