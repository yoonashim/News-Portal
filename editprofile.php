<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Post</title>
    <link rel="stylesheet" type="text/css" href="homepagestyle.css">
</head>
<body>
<?php 
    session_start();
    $username=$_SESSION['user_id'];
    $currenttag = $_POST['currenttag'];
    $currentbio = $_POST['currentbio'];
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

    <div id="content">
        <form name="editprofile" method="post" action="profileeditor.php">
            <h3>TAGLINE</h3>
            <textarea name="edittag" cols="190" rows="2" placeholder="Edit tagline">
            <?php echo $currenttag;?>
            </textarea><br><br>
            <h3>BIO</h3>
            <textarea name="editbio" cols="190" rows="20" placeholder="Edit bio">
            <?php echo $currentbio;?>
            </textarea><br>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
            <input type="submit" name="editprof" value="Edit">
        </form>
    </div>
</body>
</html>