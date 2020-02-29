<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Register</title>
    </head>
    <body>
        <?php
            session_start();
            
            require 'connect.php';
            
            $new_user=$_POST['new_username'];
            $new_pass=$_POST['new_password'];
            $securityq=$_POST['listofq'];
            $securitya=$_POST['answertoq'];
            
            //Error case
            if(strlen($new_pass) < 8){
                echo "Invalid password. Password must be at least 8 characters.";?>
                <a href="loginpage.php">Register Again?</a><?php
            }
            else{
                //Insert hashed password and security question answer
                $hashed=password_hash($new_pass, PASSWORD_DEFAULT);
                $hasheds=password_hash($securitya, PASSWORD_DEFAULT);

                $insert=$mysqli->prepare("INSERT into users (username, hashedp, securityq, securitya) values (?, ?, ?, ?)");

                if(!$insert){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
	                exit;
                }

                $insert->bind_param('ssss', $new_user, $hashed, $securityq, $hasheds);
                $insert->execute();
                $insert->close();
                echo "Registration Successful.";?><a href="loginpage.php">Login?</a><?php
            }
        ?>
    </body>
</html>