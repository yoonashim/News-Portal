<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Results</title>
    <link rel="stylesheet" type="text/css" href="homepagestyle.css">
</head>
<body>
<?php 
    session_start();
    $username=$_GET['username'];
    if(isset($_POST['searchtitle'])){
        $_SESSION['search'] = "%".$_POST['searchtitle']."%";
    }
    $search = $_SESSION['search'];
    $username1=$_SESSION['user_id'];
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
                    if(!isset($username1)){?>
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

            <h1>Search Results</h1><br><br><br><br><br>
            <?php
                session_start();

                require 'connect.php';
                
                //Get and bind
                $stmt = $mysqli->prepare("SELECT username, title, body, news_id FROM news WHERE title LIKE ?");

                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                $stmt->bind_param('s', $search);
                $stmt->execute();
                $stmt->bind_result($user, $title, $body, $news_id);

                echo "<ul>\n";
                
                //Show search results
                while($stmt->fetch()){ ?>
                <div id="story">
                <a href="viewer.php?news_id= <?php echo htmlspecialchars($news_id);?>&search=yes"><?php echo htmlspecialchars($title);?></a>
                <p>Published by <a href="userstory.php?username=<?php echo $user;?>"><?php echo $user?></a></p>
                <?php } ?>
                </div>
                <?php 
                echo "<br>";
                echo "<hr>";

                echo "</ul>\n";

                $stmt->close();
        ?>
    </div>
</body>
</html>