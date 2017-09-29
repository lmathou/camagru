<?php
if(!isset($_SESSION))
{
	session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Camagru - création de compte</title>
<meta content="width=device-width, initial-scale=1" name="viewport">
<link rel="stylesheet" href="../css/style.css">
</head>

<?php
	require __DIR__ . '/../control/app_create_account.php';
	require __DIR__ . '/../control/captcha.php';
?>
<body>
	<header>
		<div class="header">
			<div class="logo">
				<a href="../index.php">
					<img class="logo_img" src="../img/logo.gif" alt="Camagru : retour à la page d'accueil" title="Camagru : retour à la page d'accueil">
				</a>
			</div>
			<h1>Création d'un compte</h1>
		</div>
	</header>

<div class="page_content">
<form class="form" action="" method="post">
<p>Saisissez les informations de votre compte</p>
	<div class="form-group">
		<label for="login">Login&nbsp;:</label>
		<input type="text" class="form-control" name="login" placeholder="Login" value="<?php if(isset($_POST['login'])) { echo htmlentities($_POST['login']);} ?>" size="20" maxlength="10">
	</div>

	<div class="form-group">
		<label for="mail">Email&nbsp;:</label>
		<input type="email" class="form-control" name="mail" placeholder="Email" value="<?php if(isset($_POST['mail'])) { echo htmlentities($_POST['mail']);} ?>" size="30">
	</div>

	<div class="form-group">
		<label for="passwd">Mot de passe&nbsp;:</label>
		<input type="password" class="form-control" name="passwd" 
	pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
	title="Doit contenir au moins 8 caractères dont 1 chiffre, une majuscule et une minuscule" 
	placeholder="Mot de passe" size="20">
	</div>
	<div class="form-group">
	<label for="captcha">Recopiez le mot&nbsp;: "<?php echo captcha(); ?>"</label>
	<input type="text" name="captcha" id="captcha">
	</div>			
	<button type="submit" value="submit" class="btn">Valider</button>
</form>
<!-- <?php echo "Nombre actuel d'utilisateurs&nbsp;: " . $db->countAllUsers(); ?> -->
 </div>

<?php include('../view/footer.php'); ?>

</html>
