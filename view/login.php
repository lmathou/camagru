<?php
if (basename($_SERVER['SCRIPT_NAME']) == "login.php")
{
	echo "<link rel=\"stylesheet\" href=\"../css/style.css\">".PHP_EOL;
	echo "<div class=\"erreur\">ERREUR : acces direct interdit<br><br>".PHP_EOL;
	echo "==&gt; <a href=\"../index.php\">PAGE D'ACCUEIL</a> &lt;==</div>".PHP_EOL;
	exit;
}
?>
<div class='login'>
	<div>&nbsp;</div>
	<a href="#" id="connect_button" class="button">Se connecter</a>
	<div id="loginModal" class="modal">
		<div class="modal-content">
		<span id="login_close" class="close">&times;</span>
		<button id="create_user_button" class="btn">Nouvel utilisateur&nbsp;: créer un compte</button>
		<form class="form" action="" method="post">
			<p>Entrez un nom d'utilisateur et un mot de passe</p>
  			<div class="form-group">
				<label for="login">Login&nbsp;:&nbsp;</label>
				<input type="text" class="form-control" name="login" maxlength="10">
  			</div>
			<div class="form-group">
				<label for="passwd">Password&nbsp;:&nbsp;</label>
				<input type="password" class="form-control" name="passwd">
  			</div>
  			<button type="submit" name="submit" value="submit" class="btn">Valider</button>
		</form>  
		<button id="forgotten_passwd_button" class="btn">Mot de passe oublié&nbsp;?</button>
	</div>
</div>

<div id="forgotPasswdModal" class="modal">
	<div class="modal-content">
		<span id="fpw_close" class="close">&times;</span>
		<form class="form" action="" method="post">
			<p>Entrez votre email pour renouveller votre mot de passe</p>
			<div class="form-group">
				<label for="mail">Mail&nbsp;:</label>
				<input type="email" class="form-control" name="mail" placeholder="Email">
  			</div>
  			<button type="submit" name="submitFp" value="submitFp" class="btn">Valider</button>
		</form>  
	</div>
</div>

<script>
var modal = document.getElementById('loginModal');
var btn = document.getElementById("connect_button");
var span = document.getElementById("login_close");
var span1 = document.getElementById("fpw_close");
var create_button = document.getElementById("create_user_button");
var forgotten_passwd_button = document.getElementById("forgotten_passwd_button");
var forgotPasswdModal = document.getElementById('forgotPasswdModal');

btn.onclick = function() {
	btn.style.display = "none";
	modal.style.display = "block";
}

span.onclick = function() {
	btn.style.display = "initial";
	modal.style.display = "none";
}

span1.onclick = function() {
	btn.style.display = "initial";
	modal.style.display = "none";
	forgotPasswdModal.style.display = "none";
}

create_button.onclick = function() {
	modal.style.display = "none";
	window.location.pathname = '<?php echo dirname($_SERVER['PHP_SELF'], 1); ?>/view/create_account.php';
}

forgotten_passwd_button.onclick = function() {
	btn.style.display = "none";
	modal.style.display = "none";
	forgotPasswdModal.style.display = "block";
}

window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
		btn.style.display = "initial";
	}
	
	if (event.target == forgotPasswdModal) {
		forgotPasswdModal.style.display = "none";
		btn.style.display = "initial";
	} 
}
</script>
</div>