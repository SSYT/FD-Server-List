
<?php
	include_once 'includes/class_connection.php';

	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	header("Access-Control-Allow-Origin: http://www.frannnta-design.com");
	// Activation Page
	$server_id = isset($_GET['server']) ? $_GET['server'] : "";
	$token_id  = isset($_GET['token']) ? $_GET['token'] : "";
	$msg = "";

	if($_GET['action'] == "activate_server")
	{
		$server_query = $PDO->query('SELECT * FROM server_stats WHERE server_name = "'. $server_id .'" AND server_active = "0"');
		$token_query  = $PDO->query('SELECT * FROM server_activations WHERE token = "'. $token_id .'" AND server_name = "'. $server_id .'"');
		if($token_query->rowCount() > 0 && $server_query->rowCount() > 0)
		{
			$PDO->query('UPDATE server_stats SET server_active = 1 WHERE server_name = "'. $server_id .'"');
			$PDO->query('DELETE FROM server_activations WHERE server_name = "'. $server_id .'" AND token = "'. $token_id .'"');
			$msg .= 'Serverul '. $server_id .' a fost activat cu succes, va multumim.';
			echo $msg;
		} else {
			$msg .= 'Acest token nu mai este disponibil, va rugam sa verificati cu atentie email-ul.';
			echo $msg;
		}
	}
?>
