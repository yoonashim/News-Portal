<!DOCTYPE html>
<html lang="en">
<head>
    <title>Simple News Portal</title>
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
        <br>
        <h1>WELCOME <?php echo strtoupper($username)?></h1><br><br><br><br><br>
        <form name="searcharticle" method="post" action="results.php">
            <input type="text" name="searchtitle" placeholder="Search for an Article">
            <input type="hidden" name="articlesearch" value="<?php echo $news_id;?>">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
            <input type="submit" name="submitsearch" value="Search">
        </form>
        <hr>
        <h2>All Articles</h2>
    <?php
        require 'connect.php';
        
        $stmt = $mysqli->prepare("SELECT news_id, username, title, body FROM news");
        if(!$stmt){
	        printf("Query Prep Failed: %s\n", $mysqli->error);
	        exit;
        }

        $stmt->execute();
        $stmt->bind_result($news_id, $user, $title, $body);
        
        echo "<ul>\n";

        //Show articles
        while($stmt->fetch()){ ?>
            <a href="viewer.php?news_id= <?php echo htmlspecialchars($news_id);?>"><?php echo htmlspecialchars($title);?></a>
            <br>Published by <a href="userstory.php?username=<?php echo $user;?>"><?php echo $user?></a><br>

    <?php
        echo "<br>";
        echo "<hr>";
        }   
        echo "</ul>\n";
        $stmt->close();
    ?> 
        </div>
</body>
</html>