<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	if (!isset($_SESSION['logged_on_user']))
	{
		echo "<div class=\"erreur\">ERREUR : acces interdit, veuillez vous connecter<br><br>".PHP_EOL;
		echo "==&gt; <a href=\"../index.php\">PAGE D'ACCUEIL</a> &lt;==</div>".PHP_EOL;
		exit;
	}
}

function list_users()
{
	require __DIR__ . '/../config/database.php';
	require __DIR__ . '/../model/User.class.php';
	require __DIR__ . '/../model/DBAccess.class.php';

	$data = array(
		'login' => $_SESSION['logged_on_user'],
	);
	$user = new User($data);
	$db = new DBAccess($DB_DSN, $DB_USER, $DB_PASSWORD);
	$result = $user->listAll($db->db);
?>
<table>
	<tr style="border-bottom: 2px solid gray">
		<th>Login</th>
		<th>Mail</th>
		<th>Profile</th>
		<th>Status</th>
	</tr>
<?php
	foreach ($result as $value) 
	{
		echo "<tr>";
		if ($value['profile'] == "USER")
			echo "<td class='deluser' onclick='delete_user(this)' title='Supprimer cet utilisateur'>".$value['login']."</td>";
		else
			echo "<td>".$value['login']."</td>";
		echo "<td>".$value['mail']."</td>";
		echo "<td>".$value['profile']."</td>";
		echo "<td>".$value['status']."</td>";
		echo "</tr>";
	}
?>
</table>
<script type="text/javascript">
function delete_user(elem) {
	if(elem) {
		if (confirm("Voulez vous vraiment supprimer cet utilisateur ?")) {
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '../control/delete_user.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.responseText);
					window.location.pathname = '<?php echo $_SERVER['PHP_SELF']; ?>';
				}
			};
			var params = 'user=' + elem.innerHTML;
			xhr.send(params);
		}
	}
}
</script>
<?php
}
?>
