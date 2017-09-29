<?php
require 'database.php';

function setup($dbh, $dbname)
{
	$sql = "CREATE DATABASE IF NOT EXISTS ".$dbname;
	$result = $dbh->exec($sql);

	$sql = "USE ".$dbname;
	$result = $dbh->exec($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `User` (
		`login` varchar(10) NOT NULL,
		`mail` varchar(255) NOT NULL,
		`passwd` varchar(255) NOT NULL,
		`profile` ENUM('USER', 'ADMIN') NOT NULL,
		`creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		`status` ENUM('NOT_ACTIVATED', 'ACTIVATED') NOT NULL,
		`cle` varchar(32),
		PRIMARY KEY (login),
		CONSTRAINT uc_mail UNIQUE (`mail`)
	)";
	$result = $dbh->exec($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `Image` (
		`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		`user_id` varchar(8) NOT NULL,
		`image_name` varchar(255) NOT NULL,
		`creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
	)";
	$result = $dbh->exec($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `Comment` (
		`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		`description` varchar(255),
		`image_id` INT NOT NULL,
		`liker_id` varchar(8) NOT NULL,
		`creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
	)";
	$result = $dbh->exec($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `Like_table` (
		`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		`image_id` INT NOT NULL,
		`liker_id` varchar(8) NOT NULL,
		`creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		CONSTRAINT uc_image_liker UNIQUE (`image_id`, `liker_id`)
	)";
	$result = $dbh->exec($sql);

	// creation du compte administrateur (login et passwd = 'admin')
	$sql = "INSERT INTO User (login, mail, passwd, profile, status) VALUES ('admin', 'l.mathou@laposte.net', '6a4e012bd9583858a5a6fa15f58bd86a25af266d3a4344f1ec2018b778f29ba83be86eb45e6dc204e11276f4a99eff4e2144fbe15e756c2c88e999649aae7d94', 'ADMIN', 'ACTIVATED')";
	$result = $dbh->exec($sql);

	// creation d'une image
	$sql="INSERT INTO Image (user_id, image_name) VALUES ('admin','chat1.jpg');";
	$result = $dbh->exec($sql);

	// creation d'un commentaire
	$sql = "INSERT INTO Comment (description, image_id, liker_id) VALUES ('Space cat', 1, 'admin')";
	$result = $dbh->exec($sql);

	// creation d'un like
	$sql = "INSERT INTO Like_table (image_id, liker_id) VALUES (1, 'admin')";
	$result = $dbh->exec($sql);
}

$dsn = "mysql:host=".$DB_HOST;
$db = new PDO($dsn, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
setup($db, $DB_NAME);
echo '<center><h2>Installation réussie</h2>'.PHP_EOL;
echo '<h2><a href="../index.php">Accéder à CAMAGRU</a></h2></center>';
?>
