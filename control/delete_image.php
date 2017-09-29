<?php
if(!isset($_SESSION))
{
	session_start();
}

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../model/Image.class.php';
require __DIR__ . '/../model/DBAccess.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$image_name = $_POST['image_name'];
	$login = $_SESSION['logged_on_user'];
	if (empty($image_name))
	{
		echo "<script>alert('ERREUR : le champ image_name doit être rempli')</script>";
		return;
	}
	else if (empty($login))
	{
		echo "<script>alert('ERREUR : pas d\'utilisateur connecté')</script>";
	}
	else
	{
		$dir = dirname($_SERVER['SCRIPT_FILENAME'], 2).'/pics/';
		$file = basename($image_name);
		$filename = $dir.$file;
		$data = array(
			'user_id' => $login,
			'image_name' => $file
		);
		$image = new Image($data);
		$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
		if (!$image->delete($db->db))
			echo "<script>alert('ERREUR : problème de suppression en base')</script>";
		if (!unlink($filename))
			echo "<script>alert('ERREUR : problème de suppression de fichier')</script>";
		return;
	}
}
echo 'Erreur de PHP quelque part...';
return;
?>
