<?php
$mail = select 'mail' from user where name = $_['name'];
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // Filtrage des serveurs bogués.
{
	$saut_ligne = "\r\n";
}
else
{
	$saut_ligne = "\n";
}
$message_txt = "Bonjour, nous vous remercions de votre inscription sur Camagru. Merci de confirmer votre inscription en cliquant sur le lien suivant : <a href="http://www.commentcamarche.net"> Comment ça marche? </a>";
$message_html = "<html><head></head><body><b>Bonjour,</b> voici un e-mail envoyé par un <i>script PHP</i>.</body></html>";

$boundary = "-----=".hash.whirlpool(rand());

$sujet = "Inscription a Camagru";

$header = "From: \"Camagru\"<l.mathou@laposte.net>".$saut_ligne;
$header.= "Reply-to: \"Camagru\" <l.mathou@laposte.net>".$saut_ligne;
$header.= "MIME-Version: 1.0".$saut_ligne;
$header.= "Content-Type: multipart/alternative;".$saut_ligne." boundary=\"$boundary\"".$saut_ligne;

$message = $saut_ligne."--".$boundary.$saut_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$saut_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$saut_ligne;
$message.= $saut_ligne.$message_txt.$saut_ligne;
//==========
$message.= $saut_ligne."--".$boundary.$saut_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$saut_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$saut_ligne;
$message.= $saut_ligne.$message_html.$saut_ligne;
//==========
$message.= $saut_ligne."--".$boundary."--".$saut_ligne;
$message.= $saut_ligne."--".$boundary."--".$saut_ligne;
 //=====Envoi de l'e-mail.
mail($mail,$sujet,$message,$header);
?>
