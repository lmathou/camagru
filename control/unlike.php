<?php
if(!isset($_SESSION))
{
	session_start();
}
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../model/Like.class.php';
require __DIR__ . '/../model/DBAccess.class.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$image_id = $_POST['image_id'];
	$login = $_SESSION['logged_on_user'];
	if (empty($image_id))
	{
		echo "<script>alert('ERREUR : le champ image_id doit être rempli')</script>";
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
					'image_id' => $image_id
					);
		$like = new Like($data);
		$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
		if ($like->exists($db->db))
		{
			if (!$like->delete($db->db))
			{
				echo "<script>alert('ERREUR : problème de suppression en base')</script>";
				return;
			}
		}
		else
			echo "<script>alert('Unlike reussi')</script>";
		return;
	}
}
echo 'Erreur de PHP quelque part...';
return;
?>
