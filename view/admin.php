<?php
if(!isset($_SESSION))
{
	session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Camagru : administration du site</title>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1" name="viewport">
<link rel="stylesheet" href="../css/style.css">
</head>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	if (!isset($_SESSION['logged_on_user']))
	{
		echo "<body>".PHP_EOL."<div class=\"erreur\">ERREUR : acces interdit, veuillez vous connecter<br><br>".PHP_EOL;
		echo "==&gt; <a href=\"../index.php\">PAGE D'ACCUEIL</a> &lt;==</div>".PHP_EOL."</body>".PHP_EOL."</html>";
		exit;
	}
}
include('../view/header.php');
?>
<div class="page_content">
	<h2>Page d'administration du site</h2>
	<a href="../../../phpMyAdmin/" target="_blank" title="Ouvrir phpMyAdmin (dans une nouvelle fenêtre)"><img class="phpbtn" src="../img/phpmyadmin.png"></a>
	<p><b><u>Liste de tous les utilisateurs (cliquez sur un login pour le supprimer)&nbsp;:</u></b></p>
<?php
require __DIR__ . '/../control/app_admin.php';
list_users();
?>
</div>
<?php include('../view/footer.php'); ?>
</html>	