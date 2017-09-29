<?php
function user_logged()
{
	echo "<div class=\"user_logged\">Bonjour <b>".$_SESSION['logged_on_user']."</b></div>";
	if (basename($_SERVER['SCRIPT_NAME']) == "index.php")
	{
		echo '<a href="control/logout.php" class="button">Se déconnecter</a>'.PHP_EOL;
		echo '<a href="view/admin_user.php" class="button">Administrer son compte</a>'.PHP_EOL;
		echo '<a href="view/montage.php" class="button">Accéder au montage</a>'.PHP_EOL;
		echo '<a href="view/galerie.php" class="button">Accéder à la galerie</a>'.PHP_EOL;
	}
	else
	{
		echo '<a href="../control/logout.php" class="button">Se déconnecter</a>'.PHP_EOL;
		if (basename($_SERVER['SCRIPT_NAME']) !== "admin_user.php")
			echo '<a href="admin_user.php" class="button">Administrer son compte</a>'.PHP_EOL;
		if (basename($_SERVER['SCRIPT_NAME']) !== "montage.php")
			echo '<a href="montage.php" class="button">Accéder au montage</a>'.PHP_EOL;
		if (basename($_SERVER['SCRIPT_NAME']) !== "galerie.php")
			echo '<a href="galerie.php" class="button">Accéder à la galerie</a>'.PHP_EOL;
	}
}

function user_notlogged()
{
	require('login.php');
}

function admin_page()
{ 
	if (basename($_SERVER['SCRIPT_NAME']) == "index.php")
		echo '<a href="view/admin.php" id="connect_button" class="button">Administrer le site</a>'.PHP_EOL;
	elseif (basename($_SERVER['SCRIPT_NAME']) !== "admin.php")
		echo '<a href="admin.php" id="connect_button" class="button">Administrer le site</a>'.PHP_EOL;
}
	
function print_user_auth()
{
	if (!isset($_SESSION['logged_on_user']) || $_SESSION['logged_on_user'] === "")
		user_notlogged();
	else
		user_logged();
	if (isset($_SESSION['profile']) && $_SESSION['profile'] === "ADMIN")
		admin_page();
}

function print_status()
{
	if (!empty($_SESSION['status']))
		echo $_SESSION['status'];
}
?>

<body>
<?php
if (basename($_SERVER['SCRIPT_NAME']) == "header.php")
{
	echo "<link rel=\"stylesheet\" href=\"../css/style.css\">".PHP_EOL;
	echo "<div class=\"erreur\">ERREUR : acces direct interdit<br><br>".PHP_EOL;
	echo "==&gt; <a href=\"../index.php\">PAGE D'ACCUEIL</a> &lt;==</div>".PHP_EOL;
	exit;
}
?>
<header>
	<div class="header">
<?php
if (basename($_SERVER['SCRIPT_NAME']) == "index.php")
{
?>
		<a href="index.php" title="Camagru : accueil"><img class="logo_img" src="img/logo.gif"></a>
<?php 
}
else
{
?>
		<a href="../index.php" title="Camagru : accueil"><img class="logo_img" src="../img/logo.gif"></a>
<?php
}
?>
		<div class="header_right">
			<?php print_user_auth(); ?>
		</div>
	</div>
</header>
