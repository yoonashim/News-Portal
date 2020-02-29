<?php
session_start();
require 'connect.php';

    $currentuser=$_SESSION['user_id'];
    $comment=$_POST['comment'];
    $news_id=$_POST['newsid'];

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }

    //Query
    $stmt=$mysqli->prepare("INSERT into comments (news_id, username, comment) values (?, ?, ?) ");

    if(!$stmt){
	    printf("Query Prep Failed: %s\n", $mysqli->error);
	    exit;
    }

    //Store/bind values to variables
    $stmt->bind_param('iss', $news_id, $currentuser, $comment);
    $stmt->execute();
    $stmt->close();

    header('Location: viewer.php?news_id='.$news_id);
    exit;
?>