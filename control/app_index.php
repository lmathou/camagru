<?php

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../model/User.class.php';
require __DIR__ . '/../model/Image.class.php';
require __DIR__ . '/../model/Comment.class.php';
require __DIR__ . '/../model/DBAccess.class.php';

function list_best_photos()
{
	require __DIR__ . '/../config/database.php';

	echo "<h2>Les montages les plus likés du moment&nbsp;:</h2>".PHP_EOL;
	$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
	$image = new Image();

	$result = $image->listBestPhotos($db->db);

	echo "<table>".PHP_EOL."<tr>".PHP_EOL."<th class='center'>Image</th>".PHP_EOL."<th>Créée par</th>".PHP_EOL."<th>Likes</th>".PHP_EOL."<th>Commentaires</th>".PHP_EOL."</tr>".PHP_EOL;

	foreach ($result as $value) 
	{
		$data = array(
			'image_id' => $value['id']
		);
		$comment = new Comment($data);
		$resultComment = $comment->listByimage($db->db);

		echo "<tr>".PHP_EOL;
		echo "<td><a href='pics/".$value['image_name']."' title='Cliquez pour aggrandir l&rsquo;image ".$value['image_name']."'><img class='image_galerie' src='pics/".$value['image_name']."'></a></td>".PHP_EOL;
		echo "<td>".$value['user_id']."</td>".PHP_EOL;
		echo "<td>".$value['likes']."</td>".PHP_EOL;
		echo "<td>".PHP_EOL;

		foreach ($resultComment as $val) {
			echo "<b><span style=\"color:#FFB\">".$val['liker_id']."&nbsp;:</span></b> ".$val['description']."<br>".PHP_EOL;
		}
		echo "</td>".PHP_EOL;
		echo "</tr>".PHP_EOL;
	}
	echo "</table>".PHP_EOL;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['submit']))
	{
		$login = trim($_POST['login']);
		$passwd = trim($_POST['passwd']);

		if (empty($login) || empty ($passwd))
		{
			echo "<script>alert('ERREUR : tous les champs doivent être remplis')</script>";
		}
		else
		{
			try 
			{
				$data = array(
					'login' => $login,
					'passwd' => hash('whirlpool',$passwd)
				);
				$user = new User($data);
				$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
				if (!$user->checkCredentials($db->db))
				{
					echo "<script>alert('ERREUR : login ou mot de passe erroné')</script>";
				}
				else
				{	
					if ($user->status !== 'ACTIVATED')
					{
						echo "<script>alert('ERREUR : veuillez vous enregistrer avant de vous connecter')</script>";
					}
					else
					{
						echo "<script>alert('Utilisateur ".$login." connecté')</script>".PHP_EOL;
						$_SESSION['logged_on_user'] = $login;
						$_SESSION['status'] = "";
						$_SESSION['profile'] = $user->profile;
						$_SESSION['total'] = $db->countAllUsers();
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
	else if (isset($_POST['submitFp']))
	{
		$mail = trim($_POST['mail']);
		if (empty($mail))
		{
			echo "<script>alert('ERREUR : le champ Email doit être rempli')</script>";
		}
		else
		{
			$data = array('mail' => $mail);
			$user = new User($data);
			$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
			if (!$user->getUserByMail($db->db))
			{
				echo "<script>alert('Erreur : Email inconnu')</script>";
			}
			else
			{
				$login = $user->login;
				$cle = $user->cle;
				$url="http://$_SERVER[HTTP_HOST]/camagru/control/app_forgot_pw.php".'?login='.urlencode($login).'&mail='.urlencode($mail).'&cle='.urlencode($cle);
				$message = "Veuillez cliquer sur le lien suivant pour modifier votre mot de passe : ".$url;
				mail($mail, 'Camagru : changement de mot de passe',$message);
				echo "<script>alert('Demande de changement de mot de passe prise en compte, consultez votre messagerie.')</script>";
			}
		}
	}
}

$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
