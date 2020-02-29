<?php
    require 'connect.php';
    session_start();

    $username=$_SESSION['user_id'];
    $news_id=$_POST['getnewsid'];
    $comment_id=$_POST['commentid'];
    $editedcomment=$_POST['ecomment'];

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }

    if(!isset($username)){
        header('Location: loginpage.php');
        exit;
    }

    $stmt=$mysqli->prepare("UPDATE comments SET comment=? where comment_id=?");    
    
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('si', $editedcomment, $comment_id);
    $stmt->execute();
    $stmt->close();
    
    header('Location: viewer.php?news_id='.$news_id);
    exit;
?>