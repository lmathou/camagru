<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../model/User.class.php';
require __DIR__ . '/../model/DBAccess.class.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['change_pw_login'])
	&& isset($_SESSION['change_pw_mail']) && isset($_SESSION['change_pw_cle'])
	&& isset($_POST['new_passwd']) && isset($_POST['new_new_passwd']) && isset($_POST['submit'])
	&& $_POST['submit'] ==='OK') 
{
	$data = array(
		'login' => $_SESSION['change_pw_login'],
		'mail' => $_SESSION['change_pw_mail'],
	);
	$user = new User($data);
	$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
	if (!$user->getDb($db->db))
	{
		echo "<script>alert('ERREUR : utilisateur inconnu')</script>";
	}
	else
	{
		if ($user->cle !== $_SESSION['change_pw_cle'])
			echo "<script>alert('ERREUR : clé erronée')</script>";
		else
		{
			$new_passwd = $_POST['new_passwd'];
			$new_new_passwd = $_POST['new_new_passwd'];
			if (empty($new_passwd) || empty ($new_new_passwd) || $new_passwd !== $new_new_passwd)
			{
				echo "<script>alert('ERREUR : les deux mots de passe saisis sont différents ou vides')</script>";
			}
			else
			{
				$user->passwd = hash('whirlpool',$new_passwd);
				$user->setPasswdByLogin($db->db);
				echo "<script>alert('Mot de passe modifié')</script>";
				unset($_SESSION['change_pw_login']);
				unset($_SESSION['change_pw_mail']);
				unset($_SESSION['change_pw_cle']);
?>
<script>
window.location.pathname = '<?php echo dirname($_SERVER['PHP_SELF'], 2); ?>/index.php';
</script>
<?php
			}
		}
	}
}
