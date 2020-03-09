<?php
require_once 'db.php';
if (!empty($_SESSION['loged_user'])) {
    header("location: /index.php");
}
$db = new Database();
$username = $_POST['user_name'];
$email = $_POST['email'];
$password = sha1($_POST['password']);
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$errors = [];
$x=$db->count("SELECT COUNT(*) FROM `users` WHERE `username`='$username'");
$y=$db->count("SELECT COUNT(*) FROM `users` WHERE `email`='$email'");
$countid=$x[0];
$countem=$y[0];
if (!empty($_POST)){
    if ($countid['COUNT(*)']>0) {
        $errors[] = "Мұндай атпен уже аккаунт бар!";
    }
    if ($countem['COUNT(*)']>0) {
        $errors[] = "Мұндай почтамен уже аккаунт  бар!";
    }    
    if (empty($_POST['user_name'])) {
        $errors[] = "Please enter User Name";
    }
    if (empty($_POST['email'])) {
        $errors[] = "Please enter email";
    }
    if (empty($_POST['password'])) {
        $errors[] = "Please enter password";
    }
    if (empty($_POST['confirm_password'])) {
        $errors[] = "Please confirm password";
    }
    if (empty($_POST['first_name'])) {
        $errors[] = "Please enter first_name";
    }
    if (empty($_POST['last_name'])) {
        $errors[] = "Please enter last_name";
    }
    if (strlen($_POST['user_name'])>100) {
        $errors[] = "User name is too long. Max length is 100 characters";
    }
    if (strlen($_POST['first_name'])>80) {
        $errors[] = "First name is too long. Max length is 80 characters";  
    }
    if (strlen($_POST['last_name'])>80) {
        $errors[] = "Last name is too long. Max length is 80 characters";
    }
    if (strlen($_POST['password'])<6) {
        $errors[] = "Password should conteins at least 6 characters";
    }
    if (($_POST['confirm_password'])!=($_POST['password'])) {
        $errors[] = "Siz engizgen parolder saikes kelmeidi";
    }

    if(empty($errors)) {
    	$db->execute("INSERT INTO `users`(username, email, password, first_name, last_name) VALUES ('$username','$email','$password','$first_name','$last_name')");
    	header("location: /login.php?registration=1");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Guest Book</title>
    <meta charset="UTF-8">
</head>
<body>
<h1>Тіркелу парағы</h1>
<div>
    <form method="POST">
        <div style="color: red;">
            <?php foreach ($errors as $error) :?>
                <p><?php echo $error;?></p>
            <?php endforeach; ?>
        </div>
        <div>
            <label>Login:</label>
            <div>
                <input type="text" name="user_name" id="user_name" required="" value="<?php echo (!empty($_POST['user_name']) ? $_POST['user_name'] : '');?>"/>
                <span id="username_error" style="color: red;"></span>
            </div>
        </div>
        <div>
            <label>Email:</label>
            <div>
                <input type="email" name="email" id="email" required="" value="<?php echo (!empty($_POST['email']) ? $_POST['email'] : '');?>"/>
                <span id="email_error" style="color: red;"></span>
            </div>
        </div>
        <div>
            <label>Атыңыз:</label>
            <div>
                <input type="text" name="first_name" required="" value="<?php echo (!empty($_POST['first_name']) ? $_POST['first_name'] : '');?>"/>
            </div>
        </div>
        <div>
            <label>Фамилияңыз:</label>
            <div>
                <input type="text" name="last_name" required="" value="<?php echo (!empty($_POST['last_name']) ? $_POST['last_name'] : '');?>"/>
            </div>
        </div>
        <div>
            <label>Password:</label>
            <div>
                <input type="password" name="password" required="" value=""/>
            </div>
        </div>
        <div>
            <label>Confirm Password:</label>
            <div>
                <input type="password" name="confirm_password" required="" value=""/>
            </div>
        </div>
        <div>
            <br/>
            <input type="submit" name="submit" id="submit" value="Тіркелу">
        </div>      
    </form>
</div>
</body>
</html>
