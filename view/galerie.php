<?php
if(!isset($_SESSION))
{
	session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Camagru : galerie</title>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1" name="viewport" />
<link rel="stylesheet" href="../css/style.css" />
</head>
<?php
require __DIR__ . '/../control/app_galerie.php';
include('../view/header.php');
?>
<div class="page_content">
	<h2>Galerie</h2>
	<?php affiche_galerie(); ?>
</div>
<!-- <div id="fb-root"></div>
 -->
<script type="text/javascript">

// (function(d, s, id) {
//   var js, fjs = d.getElementsByTagName(s)[0];
//   if (d.getElementById(id)) return;
//   js = d.createElement(s); js.id = id;
//   js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.9";
//   fjs.parentNode.insertBefore(js, fjs);
// }(document, 'script', 'facebook-jssdk'));

function like(elem, image_id) {
	if (elem) {
		console.log('like');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '../control/like.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.responseText);
				window.location.pathname = '<?php echo $_SERVER['PHP_SELF']; ?>';
			}
		};
		var params = 'image_id='+image_id;
		xhr.send(params);
	}
}

function unlike(elem, image_id) {
	if (elem) {
		console.log('unlike');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '../control/unlike.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.responseText);
				window.location.pathname = '<?php echo $_SERVER['PHP_SELF']; ?>';
			}
		};
		var params = 'image_id='+image_id;
		xhr.send(params);
	}
}

function add_comment(elem, image_id) {
	if (elem) {
		console.log('add_comment');
		var comment = prompt("Veuillez saisir un commentaire");
		if (comment != null)
		{
			console.log("Vous avez saisi : " + comment);
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '../control/add_comment.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.responseText);
					window.location.pathname = '<?php echo $_SERVER['PHP_SELF']; ?>';
				}
			};
			var params = 'image_id='+image_id+'&comment='+comment;
			xhr.send(params);
		}
	}
}
</script>
<?php
include('../view/footer.php');
?>
</html>