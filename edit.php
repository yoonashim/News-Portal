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
            $news_id = $_POST['edittitle'];
            $currenttitle = $_POST['currenttitle'];
            $currentbody = $_POST['currentbody'];
            $currentlink = $_POST['currentlink'];
        ?>

        <!--Edit article form-->
        <div id="content">
            <form name="editarticle" method="post" action="editor.php">
                <h3>TITLE</h3>
                <textarea name="edittitle" cols="190" rows="2" placeholder="Edit title">
                        <?php echo $currenttitle; ?>
                </textarea><br><br>
                <h3>LINK</h3>
                <textarea name="editlink" cols="190" rows="2" placeholder="Edit link">
                <?php echo $currentlink; ?>
                </textarea><br><br>
                <h3>BODY</h3>
                <textarea name="editbody" cols="190" rows="20" placeholder="Edit text">
                <?php echo $currentbody; ?>
                </textarea><br>
                <input type="hidden" name="articleedits" value="<?php echo $news_id;?>">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <input type="submit" name="editarticle" value="Edit">
            </form>
        </div>
</body>
</html>