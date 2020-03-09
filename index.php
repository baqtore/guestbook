<?php
require_once 'db.php';

if (empty($_SESSION['loged_user'])) {
    header("location: /login.php");
}
$db = new Database();
$comment = $_POST['comment'];
$id = $_SESSION['loged_user'];
if (!empty($_POST['comment'])){
    $db->execute("INSERT INTO `comments`(user_id, comment) VALUES ('$id','$comment')");
}
$comments=$db->query("SELECT * FROM `comments` ORDER BY `id` DESC");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ұсыныс парақшасы</title>
	<style></style>
</head>
<body>
<div id="app">
    <h> Hello Vue </h1>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script></script>

    new Vue({
        el: '#app'
    })
	<div id="comments-header">
		<h1>Арыз-шағым парақшасы</h1>
	</div>
	<div id="comments-form">
		<h3>Өтінеміз өз пікіріңізді қалдырыңыз</h3>
		<form method="POST">
			<div>
				<label>Ұсыныс</label>
				<div>
					<textarea name="comment"></textarea>
				</div>
			</div>
			<div>
				<br>
				<input type="submit" name="submit" value="Пікір қалдыру">
				<a href="/logout.php">Шығу</a>   
			</div>
		</form>
	</div>
	<div id="comment-panel">
		<h3>Ұсыныстар</h3>
		<?php foreach ($comments as $comment): ?>
		<p <?php if($comment['user_id'] == $_SESSION['loged_user']) echo 'style="font-weight:bold;"';?>><?php echo $comment['comment'];?>; <span class="comment-date">(<?php echo $comment['created_at'];  ?>)</span> </p>
	<?php endforeach; ?>
	</div>
</body>
</html>