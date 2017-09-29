<?php
if(!isset($_SESSION))
{
	session_start();
}
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../model/User.class.php';
require __DIR__ . '/../model/DBAccess.class.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$login = trim($_GET['login']);
	$mail = trim($_GET['mail']);
	$cle = trim($_GET['cle']);
	if (empty($login) || empty($mail) || empty ($cle))
	{
		echo "<script>alert('ERREUR : les champs login, mail et cle doivent etre remplis')</script>";
	}
	else
	{
		$data = array('login' => $login, 'mail' => $mail);
		$user = new User($data);
		$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
		if (!$user->getDb($db->db))
			echo "<script>alert('ERREUR : utilisateur non enregistré')</script>";
		else
		{
			$_SESSION['change_pw_login']=$login;
			$_SESSION['change_pw_mail']=$mail;
			$_SESSION['change_pw_cle']=$cle;
?>
<script>
window.location.pathname = '<?php echo dirname($_SERVER['PHP_SELF'], 2); ?>/view/change_pw.php';
</script>
<?php
		}
	}
}

$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
