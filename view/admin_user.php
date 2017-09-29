<?php
if(!isset($_SESSION))
{
	session_start();
}
require __DIR__ . '/../control/app_admin_user.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Camagru : administration utilisateur</title>
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
	<h2>Page d'administration utilisateur</h2>

	<button id="change_mail_button">Changer son adresse email</button>
	<button id="change_pw_button">Changer son mot de passe</button>
	<button id="suppress_account_button">Supprimer son compte</button>

	<div id="change_mail_modal" class="modal">
		<div class="modal-content">
			<span id="change_mail_close" class="close">&times;</span>
			<form class="form" action="" method="post">
				<p>Changement d'adresse email</p>
				<div class="form-group">
					<label for="current_mail">Email actuel&nbsp;:</label>
					<input name="current_mail" placeholder="Email actuel" required>
				</div>
				<div class="form-group">
					<label for="new_mail">Nouvel email&nbsp;:</label>
					<input name="new_mail" placeholder="Nouveau email" required>
				</div>
				<div class="form-group">
					<label for="new_new_mail">Confirmez&nbsp;:</label>
					<input name="new_new_mail" placeholder="Nouveau email" required>
				</div>
  				<button type="submit" name="newmail" value="newmail" class="btn">Valider</button>
			</form>
		</div>
	</div>

	<div id="change_pw_modal" class="modal">
		<div class="modal-content">
			<span id="change_pw_close" class="close">&times;</span>
			<form class="form" action="" method="post">
				<p>Changement de mot de passe</p>
				<div class="form-group">
					<label for="current_pw">Mot de passe actuel&nbsp;:</label>
					<input type="password" class="form-control" name="current_pw" placeholder="Ancien" required>
				</div>
				<div class="form-group">
					<label for="new_passwd">Nouveau mdp&nbsp;:</label>
					<input type="password" class="form-control" name="new_passwd" placeholder="Nouveau" 
					pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
					title="Doit contenir au moins 8 caractères dont 1 chiffre, une majuscule et une minuscule" 
					required>
				</div>
				<div class="form-group">
					<label for="new_new_passwd">Confirmez&nbsp;:</label>
					<input type="password" class="form-control" name="new_new_passwd" placeholder="Nouveau" 
					pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
					title="Doit contenir au moins 8 caractères dont 1 chiffre, une majuscule et une minuscule" 
					required>
				</div>
  				<button type="submit" name="submit" value="submit" class="btn">Valider</button>
			</form>
		</div>
	</div>

	<div id="suppress_user_modal" class="modal">
		<div class="modal-content">
			<span id="suppress_user_close" class="close">&times;</span>
			<form class="form" action="" method="post">
				<p>Suppression <b>définitive</b> du compte de l'utilisateur</p>
  				<button type="submit" name="suppress" value="suppress" class="btn">Cliquez ici pour valider la suppression de votre compte</button>
			</form>
		</div>
	</div>

	<script type="text/javascript">
	var modalmail = document.getElementById('change_mail_modal');
	var btnmail = document.getElementById("change_mail_button");
	var closemail = document.getElementById("change_mail_close");
	var modalpw = document.getElementById('change_pw_modal');
	var btnpw = document.getElementById("change_pw_button");
	var closepw = document.getElementById("change_pw_close");
	var closesup = document.getElementById("suppress_user_close");
	var btnsup = document.getElementById("suppress_account_button");
	var modalsup = document.getElementById('suppress_user_modal');

	btnmail.onclick = function() {
		modalmail.style.display = "block";
	}

	closemail.onclick = function() {
		modalmail.style.display = "none";
	}

	btnpw.onclick = function() {
		modalpw.style.display = "block";
	}

	btnsup.onclick = function() {
		modalsup.style.display = "block";
	}

	closepw.onclick = function() {
		modalpw.style.display = "none";
	}

	closesup.onclick = function() {
		modalsup.style.display = "none";
	}

	window.onclick = function(event) {
		if (event.target == modalmail)
			modalmail.style.display = "none";
		if (event.target == modalpw)
			modalpw.style.display = "none";
		if (event.target == modalsup)
			modalsup.style.display = "none";
	}
	</script>
</div>

<?php include('../view/footer.php'); ?>
</html>
