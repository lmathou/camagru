<?php
if(!isset($_SESSION))
{
	session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Camagru : montage</title>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1" name="viewport">
<link rel="stylesheet" href="../css/style.css">
</head>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	if (!isset($_SESSION['logged_on_user']))
	{
		echo "<body>".PHP_EOL."<div class=\"erreur\">ERREUR : acces interdit, veuillez vous connecter<br><br>".PHP_EOL;
		echo "==&gt; <a href=\"../index.php\">PAGE D'ACCUEIL</a> &lt;==</div>".PHP_EOL."</body>".PHP_EOL."</html>";
		exit;
	}
}
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../model/Image.class.php';
require __DIR__ . '/../model/DBAccess.class.php';

function listPhotos()
{
	require __DIR__ . '/../config/database.php';
	
	$login = $_SESSION['logged_on_user'];
	$data = array('user_id' => $login);
	$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
	$image = new Image($data);
	$result = $image->listPhotos($db->db);

	foreach ($result as $value) 
	{
		echo "<img class='vignette' onclick='delete_image(this)' src='../pics/".$value['image_name']."' title='Cliquez pour supprimer' alt='Cliquez pour supprimer'>".PHP_EOL;
	}
}

include('../view/header.php');
?>
<div class="montage_content">
	<h2>Montage</h2>
	<div class="main">
		<div class="images">
			<div class="incrust_image"/>
				<img id="incrust" src="" width="500" height="375">
			</div>
			<div class="video">
				<video autoplay id="videoElement" width="500" height="375"></video>
			</div>
			<div class="selected_image">
				<img id="imgtag" src="" width="500" height="375">
			</div>
			<div class="resulting_image">
				<canvas id="canvas" width="500" height="375"></canvas>
			</div>
		</div>
		<div class="boutons_montage">
			<input id="snap" type="button" value="Prendre une photo" onmouseover="style.cursor='pointer'" onmouseout="style.cursor='default'">
			<input id="fileselect" type="file" accept=".png" capture="camera" style="display: none;">
			<label for="fileselect" class="getfile">Choisir un fichier</label>
			<input id="save_to_server" type="submit" value="Enregistrer votre montage" onmouseover="style.cursor='pointer'" onmouseout="style.cursor='default'">
		</div>
		<div class="effects">
<?php
$dir = '../effects/*.{jpg,jpeg,gif,png}';
$files = glob($dir,GLOB_BRACE);
echo "<p>Choisissez un effet dans cette liste&nbsp;:<p>".PHP_EOL;
foreach($files as $image)
{
	echo "<img class='vignette' src='$image' onclick='select_image(this)' title=\"Cliquez pour appliquer l'effet\">";
}
?>
		</div>
		<div class="boutons_montage">
			<input id="reset" type="button" value="Annuler" onmouseover="style.cursor='pointer'" onmouseout="style.cursor='default'">
		</div>

	</div>
	<div class="side">
		Liste de vos montages<br>
		(cliquez sur une image pour la supprimer)<br><br>
		<?php listPhotos(); ?>
	</div>
</div>

<script type="text/javascript">
var video = document.querySelector("#videoElement");


navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

if (navigator.getUserMedia) {
	navigator.getUserMedia({video: true}, handleVideo, videoError);
}

function handleVideo(stream) {
	video.src = window.URL.createObjectURL(stream);
}

function videoError(e) {
	alert("ERREUR : la caméra n\'est pas opérationnelle");
}

var v,canvas,context,w,h;
var imgtag = document.getElementById('imgtag');
var imgtagsrc_initial = imgtag.src;
var sel = document.getElementById('fileselect');
var incrust = document.getElementById('incrust');

document.addEventListener('DOMContentLoaded', function() {
	v = document.getElementById('videoElement');
	canvas = document.getElementById('canvas');
	context = canvas.getContext('2d');
	w = canvas.width;
	h = canvas.height;
	context.translate(w, 0);
	context.scale(-1, 1);
},false);

function draw(v,c,w,h) {
	if(v.paused || v.ended) return false;
	context.drawImage(v,0,0,w,h);
	var uri = canvas.toDataURL("image/png");
	imgtag.src = uri;
}

var snap=document.getElementById('snap');
snap.addEventListener('click',function(e){
	draw(v,context,w,h);
	imgtag.style.display='initial';
});

var reset=document.getElementById('reset');
reset.addEventListener('click',function(e){
	window.location.pathname = '<?php echo $_SERVER['PHP_SELF']; ?>';
});

var save_to_server=document.getElementById('save_to_server');
save_to_server.addEventListener('click',function(e){
	if (imgtag.src !== imgtagsrc_initial)
	{
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '../control/generate_image.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.responseText);
				window.location.pathname = '<?php echo $_SERVER['PHP_SELF']; ?>';
			}
		};

		var params = 'image='+imgtag.src+'&image_incrustee='+incrust.src;
		console.log(params);
		xhr.send(params);
	}
	else
		alert("Veuillez prendre une photo ou selectionner un fichier");
});

var fr;

sel.addEventListener('change',function(e) {
	var f = sel.files[0];
	var extensions_ok = 'png';
	var file_name = f.name.toLowerCase();
	if(file_name!='') {
		var file_array = file_name.split('.');
		var file_extension = file_array[file_array.length-1];
		if(extensions_ok.indexOf(file_extension)===-1) { 
			alert('Type de fichier incorrect');
		}
		else {
			fr = new FileReader();
			fr.onload = receivedData;
			fr.readAsDataURL(f);
			video.style.display='none';
			imgtag.style.display='initial';
		}
	}
});

function receivedData() {
	imgtag.src = fr.result;
}

function select_image(elem){
	console.log("selection d'une image");
	incrust.style.display='initial';
	incrust.src=elem.src;
	save_to_server.style.display='initial';
}

function delete_image(elem) {
	if (elem) {
		if (confirm("Voulez vous vraiment supprimer cette image ?")){
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '../control/delete_image.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.responseText);
					window.location.pathname = '<?php echo $_SERVER['PHP_SELF']; ?>';
				}
			};
			var params = 'image_name='+elem.src;
			xhr.send(params);
		}
	}
}	
</script>

<?php
include('../view/footer.php');
?>
</html>