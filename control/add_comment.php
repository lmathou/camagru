<?php
if(!isset($_SESSION))
{
	session_start();
}

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../model/Comment.class.php';
require __DIR__ . '/../model/User.class.php';
require __DIR__ . '/../model/DBAccess.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$image_id = $_POST['image_id'];
	$comment = $_POST['comment'];
	$login = $_SESSION['logged_on_user'];
	if (empty($image_id) || empty($comment))
	{
		echo "<script>alert('ERREUR : les champs image_id et comment doivent être remplis')</script>";
		return;
	}
	else if (empty($login))
	{
		echo "<script>alert('ERREUR : pas d\'utilisateur connecté')</script>";
	}
	else
	{
		$data = array(
					'liker_id' => $login,
					'image_id' => $image_id,
					'description' => $comment
		);
		$comm = new Comment($data);
		$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
		if (!$comm->persist($db->db))
			echo "<script>alert('ERREUR : problème d\'insertion en base')</script>";
		else 
		{
			echo "<script>alert('Commentaire enregistré')</script>";
			$user = new User();
			if ($user->findByImage($db->db, $image_id)) 
			{
				$message = "Bonjour ".$user->login.", l'utilisateur ".$login." a fait ce commentaire sur votre photo : ".utf8_decode($comment);
				mail($user->mail, 'Camagru : un utilisateur a fait un commentaire sur votre photo',$message);
			}
			else 
				echo "<script>alert('Oups, l\'utilisateur dont vous avez commenté la photo n\'est plus enregistré')</script>";
		}
		return;
	}
}
echo 'Erreur de PHP quelque part...';
return;
?>
