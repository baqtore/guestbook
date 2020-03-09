<?php
require_once ("db.php");

$errors = [];
$isRegistered =0;
if (!empty($_GET['registration'])) {
    $isRegistered =1;
}
if (!empty($_POST)){
    if (empty($_POST['user_name'])) {
        $errors[] = "Please enter email or User Name";
    }
    if (empty($_POST['password'])) {
        $errors[] = "Please enter password";
    }
    if(empty($errors)){
        $username = $_POST['user_name'];
        $password = sha1($_POST['password']);
        $db = new Database();
        $id = $db->query("SELECT id FROM users WHERE (`username` = '$username' or `email` = '$username') and `password` = '$password'");
        $col = $id[0];
        if (!empty($id)) {
            $SESSION_id = $col; 
            if (!empty($SESSION_id)) {
                $id=$SESSION_id['id'];
                $_SESSION['loged_user'] = $id;
                header("location: /index.php?sesid=$id");
            }
        }
        else {
            $errors[] = "Please enter valid credential";
        }
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

<?php if (!empty($isRegistered)): ?>
<h2>Сіз сәтті түрде тіркелдіңіз, сайтқа кіру үшін тіркелген мәліметтеріңізді енгізіңіз!</h2>
<?php endif ?>
    
<div id="app">
    <input type="text" v-on:input="changeName">
    <h1> Log in {{ name }}</h1>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>

    new Vue({
        el: '#app' ,
        data: {
            name: 'Vue!'
        },
        methods:  {
          changeName: function(event){
            this.name = event.target.value
          }
        }
    })

</script>
<div>
    <form method="POST" style="display: inline;">
        <div style="color: red;">
            <?php foreach ($errors as $error) :?>
                <p><?php echo $error;?></p>
            <?php endforeach; ?>
        </div>
        <div>
            <label>User Name / Email:</label>
            <div>
                <input type="text" name="user_name" required="" value="<?php echo (!empty($_POST['user_name']) ? $_POST['user_name'] : '');?>"/>
            </div>
        </div>
        <div>
            <label>Password:</label>
            <div>
                <input type="password" name="password" required="" value=""/>
            </div>
        </div>
        <div style="display: inline;">
            <br/>
            <input type="submit" name="submit" value="Log In">         
    </form>
            </div>   
        <a href="registration.php"><div style="display: inline;">
            <button>Registration</button>
        </div></a>
</div>

</body>
</html>