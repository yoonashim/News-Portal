<?php
    require 'connect.php';
    session_start();

    $currentuser=$_SESSION['user_id'];
    $title=$_POST['articletitle'];
    $link=$_POST['articlelink'];
    $body=$_POST['articlebody'];


    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }

    //Insert article data to database
    $stmt=$mysqli->prepare("INSERT into news (username, title, body, link) values (?, ?, ?, ?) ");

    if(!$stmt){
	    printf("Query Prep Failed: %s\n", $mysqli->error);
	    exit;
    }

    $stmt->bind_param('ssss', $currentuser, $title, $body, $link);
    $stmt->execute();
    $stmt->close();

    header('Location: homepage.php');
    exit;
?>