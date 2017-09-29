<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
?>
<!DOCTYPE html>
<html>
<head>
<title>Camagru</title>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1" name="viewport">
<link rel="stylesheet" href="css/style.css">
</head>

<?php
require __DIR__ . '/control/app_index.php';
include('view/header.php');
?>
<div class="page_content">
<h1>Bienvenue sur Camagru&nbsp;!</h1>
<?php list_best_photos(); ?>
</div>
<?php include('view/footer.php'); ?>
</html>
