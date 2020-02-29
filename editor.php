<?php
    require 'connect.php';
    session_start();

    $username=$_SESSION['user_id'];
    $news_id=$_POST['articleedits'];
    $editedtitle=$_POST['edittitle'];
    $editedlink=$_POST['editlink'];
    $editedbody=$_POST['editbody'];


    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }

    if(!isset($username)){
        header('Location: loginpage.php');
        exit;
    }

    if(isset($_POST['editarticle'])){
        $stmt=$mysqli->prepare("UPDATE news SET title=?, link=?, body=? where news_id=?");
        
        
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('sssi', $editedtitle, $editedlink, $editedbody, $news_id);
        $stmt->execute();
        $stmt->close();
        header('Location: mystories.php');  
        exit;

    }
?>