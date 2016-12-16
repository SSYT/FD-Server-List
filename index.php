
<?php
	include_once 'includes/class_connection.php';
	include_once 'includes/class_functions.php';
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	header("Access-Control-Allow-Origin: http://www.frannnta-design.com");
	
	$servers_data = $PDO->query('SELECT * FROM server_stats');
	$active_servers = $PDO->query('SELECT * FROM server_stats WHERE server_active = 1 ORDER BY server_votes DESC');
	$padding_servers = $PDO->query('SELECT * FROM server_stats WHERE server_active = 0');
	
	if($_GET['mode'] == "get_servers")
	{
		$getservers = 'Active Servers: ' . $active_servers->rowCount() . ' | ';
		$getservers .= 'Pending Servers: ' . $padding_servers->rowCount() . '';
		echo "document.write('". $getservers ."')";
	}
	
	# Get active servers of database
	# active_servers
	if($_GET['mode'] == "active_servers")
	{
		if($active_servers->rowCount() > 0)
		{
			$i = 0;
			while($server_info = $active_servers->fetch(PDO::FETCH_ASSOC))
			{
				$server = simplexml_load_file("http://api.gametracker.rs/demo/xml/server_info/". $server_info['server_ip'] .":27015/");
				$players = $server->xpath('//server_info');
				if($server_info['server_active'] == 1) $status = '<b><font style="color: green;">Activat</font></b>';
				foreach($players as $server_data)
				{
					$sv_data_active .= '<tr id="server_row">';
					$sv_data_active .= '<td colspan="2">'. $server_data->rank .'</td>';
					$sv_data_active .= '<td colspan="2"><img src="http://forumotiondb.tk/FD%20Servers/images/game-cs.png"  style="align-content: center;text-align: center;position: relative;top: 5px;left: 30%;" alt="'. $server_data->gamename .'" /></td>';
					$sv_data_active .= '<td colspan="2" class="hostname"><a href="/h18-servers-list/live_stats='. $server_data->ip .'">'. $server_data->name .'</a></td>';
					$sv_data_active .= '<td colspan="2">'. $server_data->players .'/'. $server_data->playersmax .'</td>';
					$sv_data_active .= '<td colspan="2" class="ip_row">'. $server_data->ip .'</td>';
					$sv_data_active .= '<td colspan="2">'. strtoupper ($server_data->modshort) .'</td>';
					$sv_data_active .= '<td colspan="2" class="map"><img src="http://forumotiondb.tk/FD%20Servers/images/'. $server_data->iso2 .'.png" alt="'. $server_data->countryname .'" /></td>';
					$sv_data_active .= '<td colspan="2">'.$server_data->map.'</td>';
					$sv_data_active .= '<td colspan="2">'. $status .'</td>';
					$sv_data_active .= '</tr>';
				}
			}
		} else $sv_data_active = "Nu au fost gasite server active !";
	}
	
	# Get no active servers of database
	# inactive_servers
	if($_GET['mode'] == "inactive_servers")
	{
		if($padding_servers->rowCount() > 0)
		{
			while($server_data = $padding_servers->fetch(PDO::FETCH_ASSOC))
			{
				if($server_data['activate'] == 0) $status = '<b><font style="color: #FFC107;">In Asteptare</font></b>';
				$sv_data_inactive .= '<tr id="server_row"><td colspan="2">'. $server_info['id'] .'</td><td colspan="2" class="hostname">'. strtoupper($server_info['server_name']) .' <a class="btn-stats" href="?mode=live_stats">Live Stats</a></td><td colspan="2">'. $server_info['server_slots'] .'</td><td colspan="2" class="ip_row">'. $server_info['server_ip'] .':'. $server_info['server_port'] .'</td><td colspan="2" class="map">'. $server_info['server_votes'] .'</td><td colspan="2">'. $status .'</td></tr>';
			}
		} else $sv_data_inactive = "Nu au fost gasite server inactive !";
	}
	
	# Add server to datebase from post
	# add_servers
	if($_GET['mode'] == "add_servers")
	{	
		if(isset($_POST['server_name']))
		{
			$post_sv_name = $_POST['server_name'];
			$post_sv_ip = $_POST['server_ip'];
			$post_sv_port = (isset($_POST['server_port'])) ? $_POST['server_port'] : '27015';
			$post_sv_mode = $_POST['server_mode'];
			$post_sv_slots = $_POST['server_slots'];
			$post_sv_email = $_POST['server_email'];
			
			$token_key = tokenKeys(32);

			$PDO->query('INSERT INTO `server_stats`(`server_name`, `server_ip`, `server_port`, `server_slots`, `server_mode`, `server_active`, `server_contact`) VALUES ("'. $post_sv_name .'", "'. $post_sv_ip .'", "'. $post_sv_port .'", "'. $post_sv_slots .'", "'. $post_sv_mode .'", "0", "'. $post_sv_email .'")');
			$PDO->query('INSERT INTO `server_activations`(`server_name`, `token`, `expire_time`) VALUES ("'. $post_sv_name .'","'. $token_key .'",CURDATE())');

			$to = $post_sv_email;
			$subject = 'FraNNNta-Design.com | Server activation';
			$message = '<h1>Server activation</h1>';
			$message .= '<br />Buna ziua,<br />Ati primit aces email de oare ce ai adaugat un server in lista noastra de servere publice.';
			$message .= '<br />Pentru activarea acestui server va rugam sa apasati pe butonul Activeaza sau accesati acest link';
			$message .= '<br /><a href="http://www.frannnta-design.com/h18-servers-list/mode=activate&server='.$post_sv_name.'&token='.$token_key.'">http://www.frannnta-design.com/h18-servers-list/mode=activate&server='.$post_sv_name.'&token='.$token_key.'</a>';
			$message .= '<br />';
			$message .= '<a style="padding: 5px; margin-top: 10px; display: block; background: #8BC34A; width: 10%; color: white; text-align: center; text-decoration: none;font-weight: 600;" href="http://www.frannnta-design.com/h18-servers-list/mode=activate&server='.$post_sv_name.'&token='.$token_key.'">Activeaza</a>';
			$message .= '<br />';
			$message .= '(!) Acest email expira in mod automat dupa 1 ore, daca aveti probleme va rugam sa ne contactati pe forum sau la adresa de email: server@frannnta-design.com';
			$message .= '<br />';
			$message .= '<br />';
			$message .= '<br />';
			$message .= 'Cu stima,<br />Echipa FraNNNta-Design.com';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From: server@frannnta-design.com";
			mail($to, $subject, $message, $headers);
		}
	}
?>

<?php
if($_GET['mode'] == "active_servers")
{
?>
	document.write('<?=$sv_data_active;?>');
<?
} else if($_GET['mode'] == "inactive_servers")
{
?>
	document.write('<?=$sv_data_inactive;?>');
<?
}
?>			
