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
            session_start();
            $user_id = $_SESSION['user_id'];
            if(!(isset($user_id))){
                echo "<br><br><h2>You are not logged in. Please log in.</h2>";
                ?><a href="loginpage.php">Login</a><?php
            }
            else{?>

            <h1>My Profile</h1><br><br><br><br><br>
            <?php
                session_start();

                require 'connect.php';

                //Query for profile info
                $stmt1 = $mysqli->prepare("SELECT bio, tagline FROM users WHERE username =?");
                if(!$stmt1){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }

                $stmt1->bind_param('s', $user_id);
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

                //Query for articles
                $stmt = $mysqli->prepare("SELECT title, body, news_id FROM news WHERE username =?");
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }

                $stmt->bind_param('s', $user_id);
                $stmt->execute();
                $stmt->bind_result($title, $body, $news_id);

                echo "<ul>\n";

                echo "<h2>";
                echo "My Articles: ";
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

        <?php if(isset($user_id)){
            ?>
            <form name="editbytitle" method="post" action="editprofile.php">
                <input type="hidden" name="currenttag" value="<?php echo $tagline;?>">
                <input type="hidden" name="currentbio" value="<?php echo $bio;?>">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <input type="submit" name="submitedit" value="Edit Profile">
            </form>          
    <?php }?>
        <a href="homepage.php">Return to homepage</a>

        <?php
        }
        ?>
    </div>
</body>
</html>