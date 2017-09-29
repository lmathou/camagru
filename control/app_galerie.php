<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../model/User.class.php';
require __DIR__ . '/../model/Image.class.php';
require __DIR__ . '/../model/Like.class.php';
require __DIR__ . '/../model/Comment.class.php';
require __DIR__ . '/../model/DBAccess.class.php';

function affiche_galerie()
{
	require __DIR__ . '/../config/database.php';

	$login = trim($_SESSION['logged_on_user']);
	$data = array('user_id' => $login);
	$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
	$image = new Image($data);
	$images_par_page=3;
	$nombre_images=$image->countPhotos($db->db);
	$nombre_pages=ceil($nombre_images/$images_par_page);

	if (!isset($_GET['page']) || $page === 0)
	{
		$page = 1;
	}
	else
	{
		$page = intval($_GET['page']);
	}

	echo 'Page : ';
	for ($i=1;$i<= $nombre_pages;$i++)
	{
		if ($i == $page)
		{
			echo $i." ";
		}
		else
		{
			echo '<a href="galerie.php?page=' . $i . '">' . $i . '</a> ';
		}
	}
	if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']>0 && $_GET['page']<= $nombre_pages)
	{
		$page=intval($_GET['page']);
	}
	else
	{
		$page=1;
	}
	$position = $page * $images_par_page-$images_par_page;
	$result = $image->listBlockOfPhotos($db->db, $images_par_page, $position);

	echo PHP_EOL."<table>".PHP_EOL."<tr><th class=\"center\">Montage</th><th>Créateur</th><th>Commentaires</th></tr>".PHP_EOL;

	foreach ($result as $value) 
	{
		echo "<tr>".PHP_EOL;
		echo "<td><a href='../pics/".$value['image_name']."' title='Cliquez pour agrandir'><img class='image_galerie' src='../pics/".$value['image_name']."'></a></td>".PHP_EOL;
		echo "<td>".$value['user_id']."</td>".PHP_EOL;
		echo "<td>";
		$data = array(
			'image_id' => $value['id']
		);
		$comment = new Comment($data);
		$resultComment = $comment->listByimage($db->db);
		foreach ($resultComment as $val) {
			echo "<b><span style=\"color:#FFB\">".$val['liker_id']."&nbsp;:</span></b> ".$val['description']."<br>";
		}
		echo "</td>".PHP_EOL;
		echo "</tr>".PHP_EOL;
		echo "<tr><td style='text-align:center;margin:0;padding:0;'>";
		$data = array(
			'image_id' => $value['id'],
			'liker_id' => $login
		);
		$like = new Like($data);
		if ($like->exists($db->db))
		{
			echo "<img onmouseover=\"style.cursor='pointer'\" onmouseout=\"style.cursor='default'\" src='../img/dislike.png' onclick='unlike(this,".$value['id'].")' title='J&rsquo;aime plus' alt='J&rsquo;aime plus'>";
		}
		else
			echo "<img onmouseover=\"style.cursor='pointer'\" onmouseout=\"style.cursor='default'\" src='../img/like.png' onclick='like(this,".$value['id'].")' title='J&rsquo;aime' alt='J&rsquo;aime'>";
		
		$image->id = $value['id'];
		$nbre_likes = $image->likesPerPhoto($db->db);
		echo "<span class=\"likes\" title=\"Nombre de Likes\">(".$nbre_likes.")</span>";
		echo "<img onmouseover=\"style.cursor='pointer'\" onmouseout=\"style.cursor='default'\" src='../img/comment.png' onclick='add_comment(this,".$value['id'].")' title='Commenter' alt='Commenter'>";

		// echo "<span class=\"fb-like\" data-href=\"../pics/".$value['image_name']."\" data-layout=\"button\" data-action=\"like\" data-size=\"small\" data-show-faces=\"false\" data-share=\"true\" style=\"margin-top: 2px;\"></div>";

		echo "</td></tr>".PHP_EOL;
	}
	echo "</table>".PHP_EOL;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	if (!isset($_SESSION['logged_on_user']))
	{
		echo "<div class=\"erreur\">ERREUR : acces interdit, veuillez vous connecter<br><br>".PHP_EOL;
		echo "==&gt; <a href=\"../index.php\">PAGE D'ACCUEIL</a> &lt;==</div>".PHP_EOL;
		exit;
	}
}
