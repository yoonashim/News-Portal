<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Post</title>
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

    <br><br>
    <?php
            //Check if logged in
            session_start();
            $username=$_SESSION['user_id'];
            if(!(isset($username))){
                echo "<div id='content'><h2>You are not logged in. Please log in.</h2></div>";
                ?><div id='content'><a href="loginpage.php">Login</a></div><?php
            }
            else{
    ?>
    <!-- Form for article upload -->
    <div id="content">
        <form name="uploadarticle" method="post" action="uploader.php">
            <h3>TITLE</h3>
            <textarea name="articletitle" cols="190" rows="2" placeholder="Enter title"></textarea><br><br>
            <h3>LINK</h3>
            <textarea name="articlelink" cols="190" rows="2" placeholder="Enter link"></textarea><br><br>
            <h3>BODY</h3>
            <textarea name="articlebody" cols="190" rows="20" placeholder="Enter text"></textarea><br>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
            <input type="submit" value="Post">
        </form>
     </div>
    <?php }?>

</body>
</html>