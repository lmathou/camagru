<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../model/User.class.php';
require __DIR__ . '/../model/DBAccess.class.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$login = trim($_POST['login']);
	$mail = trim($_POST['mail']);
	$passwd = trim($_POST['passwd']);
	$captcha = trim($_POST['captcha']);
	if (empty($login) || empty($mail) || empty ($passwd) || empty($captcha))
	{
		echo "<script>alert('ERREUR : tous les champs doivent être remplis')</script>";
	}
	else
	{
		try 
		{
			if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
			{
				echo "<script>alert('ERREUR : Format de mail incorrect')</script>";
			}
			else if ($captcha !== $_SESSION['captcha'])
			{
				echo "<script>alert('ERREUR : captcha erroné')</script>";
			}
			else
			{
				$cle = md5(microtime(TRUE)*100000);
				$data = array(
					'login' => $login,
					'mail' => $mail,
					'passwd' => hash('whirlpool',$passwd),
					'cle' => $cle
				);
				$user = new User($data);
				$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
				if (!$user->persist($db->db))
				{
					echo "<script>alert('ERREUR : login ou mail déjà utilisé')</script>";
				}
				else
				{
					$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?login='.urlencode($login).'&mail='.urlencode($mail).'&cle='.urlencode($cle);
					$message = "Veuillez cliquer sur le lien suivant pour confirmer votre inscription : ".$url;
					mail($mail, 'Votre inscription sur Camagru',$message);
?>
<script>
alert('Compte utilisateur créé avec succès ! Un lien de validation vous est envoyé par email.');
window.location.pathname = '<?php echo dirname($_SERVER['PHP_SELF'], 2); ?>/index.php';
</script>
<?php
				}
			}
		} catch (NestedValidationException $e) {
			echo "<ul>";
			foreach ($e->getMessages() as $message) {
				echo "<li>$message</li>";
			}
			echo "</ul>";
		}
	}
}

else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	// 2 cas :
	// 1) création du compte depuis la page index.php (dans ce cas il n'y a pas de parametres)
	// 2) depuis le lien de validation du mail (dans ce cas il y a les parametres login, cle et mail)
	if (empty($_GET['login']) || empty($_GET['mail']) || empty ($_GET['cle']))
	{
		// echo "DEBUG : les champs login, mail et cle doivent etre remplis !";
	}
	else
	{
		$login = trim($_GET['login']);
		$mail = trim($_GET['mail']);
		$cle = trim($_GET['cle']);
		$data = array('login' => $login, 'mail' => $mail);
		$user = new User($data);
		$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
		if (!$user->getDb($db->db))
			echo "<script>alert('ERREUR : utilisateur introuvable')</script>";
		else
		{
			if ($user->cle !== $cle)
			{
				echo "<script>alert('Erreur de clé')</script>";
			}
			else
			{
				if ($user->status === 'ACTIVATED')
					echo "<script>alert('ERREUR : utilisateur déjà enregistré')</script>";
				else
				{
					$user->status='ACTIVATED';
					$user->setStatus($db->db);
					?>
<script>
alert('Utilisateur enregistré avec succès !');
window.location.pathname = '<?php echo dirname($_SERVER['PHP_SELF'], 2); ?>/index.php';
</script>
<?php
				}
			}
		}
	}
}

$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
