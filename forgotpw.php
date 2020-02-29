<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Reset</title>
    <style>
        body{
            background: lightblue;
        }
        #incorrect{
            width: 20%;
            border-radius: 5px;
            margin: 100px auto;
            background: white;
            padding: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="incorrect">
        <h1>Forgot my password</h1>

        <form name="fpw" method="post" action="reset.php">
            <p><input type="text" name="fpwuser" placeholder="Username" autocomplete="off"></p>
            <p><input type="password" name="newpw" placeholder="New password"></p>
            <p><input type="text" name="fpwanswer" placeholder="Answer to security" autocomplete="off"></p>
            <p><input type="submit" name="reset" id="button" value="Reset"></p>
        </form>
    </div>
</body>
</html>