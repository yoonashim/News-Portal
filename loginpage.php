<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sign In.</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        
        <div id="login">
            <h5>Already have an account?</h5>
            <h1>Sign In</h1>
            <form name="input" method="post" action="login.php">
                <p><input type="text" name="username" placeholder="Username" autocomplete="off"></p>
                <p><input type="password" name="password" placeholder="Password"></p>
                <p><input type="submit" name="login" id="button1" value="Sign In"></p>
            </form>
            <br><br><br>
            <a href="forgotpw.php">Forgot my password</a>
        </div>

        <div id="register">
            <h5>Are you a new user?</h5>
            <h1>Register</h1>
            <form name="input" method="post" action="register.php">
                <p><input type="text" name="new_username" placeholder="Enter new username" autocomplete="off"></p>
                <p><input type="password" name="new_password" placeholder="Enter new password"></p>
                <select id="listofq" name="listofq">
                    <option value="B">What is the first name of your best friend?</option>
                    <option value="P">What is the name of your first pet?</option>
                    <option value="T">What is the last name of your favorite teacher?</option>
                </select>
                <input type="text" name="answertoq" placeholder="Enter answer to security question" autocomplete="off">
                <p><input type="submit" name="register" id="button2" value="Register"></p>
            </form>
            <a href="homepage.php">Return to Homepage</a>
        </div>
    </body>
</html>