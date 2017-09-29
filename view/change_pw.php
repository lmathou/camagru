<?php
if(!isset($_SESSION))
{
	session_start();
}
require __DIR__ . '/../control/app_change_pw.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Camagru - changement de mot de passe</title>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1" name="viewport">
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	if (!isset($_SESSION['logged_on_user']) && !isset($_GET['login']))
	{
		echo "<div class=\"erreur\">ERREUR : acces interdit, veuillez vous connecter<br><br>".PHP_EOL;
		echo "==&gt; <a href=\"../index.php\">PAGE D'ACCUEIL</a> &lt;==</div>".PHP_EOL;
		exit;
	}
}
?>
<header style="height: auto;">
	<div style="margin: 2em;">
		<a href="../index.php" title="Camagru : accueil"><img class="logo_img" src="../img/logo.gif"></a>
		<h1>Changement de mot de passe</h1>
	</div>
</header>
<div class="page_content">
	<form class="form" action="" method="post">
		<p>Saisissez 2 fois votre nouveau mot de passe</p>
		<div class="form-group">
			<label for="new_passwd">Mot de passe :</label>
			<input type="password" class="form-control" name="new_passwd" placeholder="mdp" 
				pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
				title="Doit contenir au moins 8 caractères dont 1 chiffre, une majuscule et une minuscule" 
				required>
		</div>
		<div class="form-group">
			<label for="new_new_passwd">Confirmation :</label>
			<input type="password" class="form-control" name="new_new_passwd" placeholder="mdp" 
				pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
				title="Doit contenir au moins 8 caractères dont 1 chiffre, une majuscule et une minuscule" 
				required>
		</div>
		<button type="submit" name="submit" value="OK" class="btn">Valider</button>
	</form>
</div>

<?php include('../view/footer.php'); ?>
</html>