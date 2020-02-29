<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="homepagestyle.css">
</head>
<body>
    <?php 
    //Start session
    session_start();
    $username=$_SESSION['user_id'];
    ?>
    <header>
        <div id="navbar">
            <h1>Simple News Portal</h1>
            <nav>
                <ul>
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="uploadpost.php">Upload Story</a></li>
                    <li><a href="mystories.php">My Profile</a></li>
                    <?php
                    if(!isset($username)){?>
                    <li><a href="loginpage.php">Login</a></li>
                    <?php }
                    else{?>
                    <li><a href="logout.php">Logout</a></li>
                    <?php }?>
                    
                </ul>
            </nav>
        </div>
    </header>

    <div id="content">
    <?php
        require 'connect.php';
        
        $news_id = $_GET['news_id'];
        $search = $_GET['search'];
        
        //Get and print title, link, and body by news id
        $stmt = $mysqli->prepare("SELECT username, title, body, link FROM news WHERE news_id=?");

        if(!$stmt){
	        printf("Query Prep Failed: %s\n", $mysqli->error);
	        exit;
        }
        $stmt->bind_param('i', $news_id);
        $stmt->execute();
        $stmt->bind_result($articleusername, $title, $body, $link);

        echo "<ul>\n";
        
        while($stmt->fetch()){
            ?><?php
            echo "<h3>";
            echo strtoupper($title);?><?php
            echo "</h3>";
            echo "<br>";
            echo "Link: ";
            echo htmlspecialchars($link);
            echo "<br>";
            echo "<hr>";
            echo htmlspecialchars($body);?><br><br><br><?php
            echo "<br>";
        }

        //Check if current session user is user who posted
        if(isset($username) && (strcmp($username, $articleusername)==0)){
            ?>
            <form name="editbytitle" method="post" action="edit.php">
                <input type="hidden" name="edittitle" value="<?php echo $news_id;?>">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <input type="submit" name="submitedit" value="Edit Article">
                <input type="hidden" name="currenttitle" value="<?php echo $title;?>">
                <input type="hidden" name="currentbody" value="<?php echo $body;?>">
                <input type="hidden" name="currentlink" value="<?php echo $link;?>">
            </form>
            <form name="deletebytitle" method="post" action="deletestory.php">
                <input type="hidden" name="deletetitle" value="<?php echo $news_id;?>">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <input type="submit" name="submitdelete" value="Delete Article">
            </form>
            
    <?php }?>
        <h2>Comments</h2>
    <?php

        $stmt->close();
            
        //Comments
        $stmt2 = $mysqli->prepare("SELECT comment_id, username, comment FROM comments WHERE news_id=?");
        if(!$stmt2){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        
        $stmt2->bind_param('i', $news_id);
        $stmt2->execute();
        $stmt2->bind_result($comment_id, $commentusername, $comment);

        //Print comments
        while($stmt2->fetch()){
            echo "<b>";
            echo htmlspecialchars($commentusername);
            echo "</b>";
            echo ": ";
    
            if(!(isset($_POST['submiteditc']) && $_POST['editc'] == $comment_id)){
                if(!(isset($username) && (strcmp($username, $commentusername)==0))){
                    echo htmlspecialchars($comment);
                    echo "<br>";
                    //echo "<hr>";
                }
            }
            //Check if session user is person who uploaded the commment to delete/edit
            if(isset($username) && (strcmp($username, $commentusername)==0)){
                if(isset($_POST['submiteditc']) && $_POST['editc'] == $comment_id){
            ?>
                    <form name="editcommenttext" method="post" action="editcomment.php">
                        <textarea name="ecomment" cols="190" rows="1">
                        <?php echo htmlspecialchars($comment);?>
                        </textarea><br><br>
                        <input type="hidden" name="commentid" value="<?php echo $comment_id;?>"/>
                        <input type="hidden" name="getnewsid" value="<?php echo $news_id;?>">
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                        <input type="submit" value="Edit">
                    </form>
            <?php }
                else{
                    echo htmlspecialchars($comment);
                    echo "<br>";
            ?>
                    <form name="editcomment" method="post" >
                        <input type="hidden" name="editc" value="<?php echo $comment_id;?>">
                        <input type="hidden" name="getnewsid" value="<?php echo $news_id;?>">
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                        <input type="submit" name="submiteditc" value="Edit Comment">
                    </form><?php
                        
                    } ?>
    
                    <form name="deletecomment" method="post" action="deletecomment.php">
                        <input type="hidden" name="deletec" value="<?php echo $comment_id;?>">
                        <input type="hidden" name="getnewsid" value="<?php echo $news_id;?>">
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                        <input type="submit" name="submitdeletec" value="Delete Comment">
                    </form>

            <?php }
            
            echo "<hr>";}
            echo "</ul>\n";

            $stmt2->close();
            ?> 
            <?php
            //If logged in, be able to upload comment
            if(isset($username)){
            ?>
            <form name="uploadarticle" method="post" action="commentupload.php">
                <h3>COMMENT</h3>
                <textarea name="comment" cols="190" rows="5" placeholder="Enter comment"></textarea><br><br>
                <input type="hidden" name="newsid" value="<?php echo $news_id;?>"/>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <input type="submit" value="Comment">
            </form>
            <?php } ?>
    </div>
    
    
    <div id=content><?php
    //If search was pressed, be able to return to search results
    if(isset($search)){ ?>
    <form name="searcharticlew" method="post" action="results.php">
                <input type="hidden" name="searchtitlew" value="<?php echo ($search);?>">
                <input type="hidden" name="articlesearchw" value="<?php echo $news_id;?>">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <input type="submit" name="submitsearchw" value="Back to Search Results">
            </form>
    <?php } ?>

    <a href="homepage.php">Return to homepage</a>
    </div>
</body>
</html>