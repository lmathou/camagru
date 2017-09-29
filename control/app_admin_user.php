<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../model/User.class.php';
require __DIR__ . '/../model/DBAccess.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['submit']))
	{
		$current_pw = trim($_POST['current_pw']);
		$new_passwd = trim($_POST['new_passwd']);
		$new_new_passwd = trim($_POST['new_new_passwd']);
		$login = $_SESSION['logged_on_user'];

		if (empty($current_pw) || empty ($new_passwd) || empty ($new_new_passwd))
		{
			echo "<script>alert('ERREUR : tous les champs doivent être remplis')</script>";
		}
		else if ($new_passwd !== $new_new_passwd)
			echo "<script>alert('ERREUR : les deux valeurs du nouveau mot de passe sont différentes')</script>";
		else if (empty($login))
			echo "<script>alert('ERREUR : pas d\'utilisateur loggué')</script>";
		else
		{
			try 
			{
				$data = array(
					'login' => $login,
					'passwd' => hash('whirlpool',$current_pw)
				);
				$user = new User($data);
				$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
				if (!$user->checkCredentials($db->db))
				{
					echo "<script>alert('ERREUR : mot de passe erroné')</script>";
				}
				else
				{	
					$user->passwd = hash('whirlpool',$new_passwd);
					$user->setPasswdByLogin($db->db);
					echo "<script>alert('Mot de passe mis à jour')</script>";
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
	else if (isset($_POST['suppress']))
	{
		$login = $_SESSION['logged_on_user'];
		$profile = $_SESSION['profile'];
		if (!empty($profile) && $profile === "ADMIN")
		{
			echo "<script>alert('ERREUR : un administrateur ne peux pas supprimer son propre compte')</script>";
		}
		else if (empty($login))
		{
			echo "<script>alert('ERREUR : pas d\'utilisateur loggué')</script>";
		}
		else
		{
			$data = array('login' => $login);
			$user = new User($data);
			$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
			if (!$user->deleteUser($db->db))
			{
				echo "<script>alert('Erreur lors de la suppression')</script>";
			}
			else
			{
				header('location:../control/logout.php');
				echo "<script>alert('Suppression du compte confirmée')</script>";
			}
		}
	}
	else if (isset($_POST['newmail']))
	{
		$current_mail = trim($_POST['current_mail']);
		$new_mail = trim($_POST['new_mail']);
		$new_new_mail = trim($_POST['new_new_mail']);
		$login = $_SESSION['logged_on_user'];

		if (empty($current_mail) || empty ($new_mail) || empty ($new_new_mail))
			echo "<script>alert('ERREUR : tous les champs doivent être remplis')</script>";
		else if ($new_mail !== $new_new_mail)
			echo "<script>alert('ERREUR : les deux valeurs du nouvel email sont différentes')</script>";
		else if (empty($login))
			echo "<script>alert('ERREUR : pas d\'utilisateur loggué')</script>";
		else if (!filter_var($new_mail, FILTER_VALIDATE_EMAIL))
			echo "<script>alert('ERREUR : Format de mail incorrect')</script>";
		else
		{
			try 
			{
				$data = array('login' => $login);
				$user = new User($data);
				$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
				$user->mail = $new_mail;
				$user->setMailByLogin($db->db);
				echo "<script>alert('Email mis à jour')</script>";
			} catch (NestedValidationException $e) {
				echo "<ul>";
				foreach ($e->getMessages() as $message) {
					echo "<li>$message</li>";
				}
				echo "</ul>";
			}
		}
	}





}
