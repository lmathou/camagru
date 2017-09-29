<?php
if (basename($_SERVER['SCRIPT_NAME']) == "footer.php")
{
	echo "<link rel=\"stylesheet\" href=\"../css/style.css\">".PHP_EOL;
	echo "<div class=\"erreur\">ERREUR : accès direct interdit<br><br>".PHP_EOL;
	echo "==&gt; <a href=\"../index.php\">PAGE D'ACCUEIL</a> &lt;==</div>".PHP_EOL;
	exit;
}
?>
<footer>
	<span class="left"><?php
	if ($_SESSION['total'])
		echo "Nombre d'utilisateurs&nbsp;: ".$_SESSION['total'];
?></span>
	<span class="right">&copy;&nbsp;lmathou@42 &ndash; 2017</span>
</footer>
</body>