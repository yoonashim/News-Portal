<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Stories</title>
    <link rel="stylesheet" type="text/css" href="homepagestyle.css">
</head>
<body>
<?php 
    session_start();
    $username=$_GET['username'];
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
            session_start();    
        ?>

            <h2><?php echo strtoupper($username);?>'s Profile</h2>
            <?php
                session_start();

                require 'connect.php';
                
                //Query for Profile
                $stmt1 = $mysqli->prepare("SELECT bio, tagline FROM users WHERE username =?");
                if(!$stmt1){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }

                $stmt1->bind_param('s', $username);
                $stmt1->execute();
                $stmt1->bind_result($bio, $tagline);

                echo "<ul>\n";

                while($stmt1->fetch()){
                    echo "<h3>";
                    echo $tagline;
                    echo "<br><br><br>";
                    echo "BIO: ";
                    echo "\n";
                    echo "</h3>";
                    echo $bio;
                }
                echo "</ul>\n";

                $stmt1->close();

                //Query for Articles
                $stmt = $mysqli->prepare("SELECT title, body, news_id FROM news WHERE username =?");
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }

                $stmt->bind_param('s', $username);
                $stmt->execute();
                $stmt->bind_result($title, $body, $news_id);

                echo "<ul>\n";
                
                echo "<h2>";
                echo "Articles: ";
                echo "</h2>";
                
                while($stmt->fetch()){ ?>
                <div id="story">
                    <a href="viewer.php?news_id= <?php echo htmlspecialchars($news_id);?>"><?php echo htmlspecialchars($title);?></a>
                </div>
                    <?php
                    echo "<br>";
                    echo "<hr>";
                }   
                echo "</ul>\n";

                $stmt->close();
        ?>


        <a href="homepage.php">Return to homepage</a>
    </div>
</body>
</html>