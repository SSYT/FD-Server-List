
<?php
	include_once 'includes/class_connection.php';

	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	header("Access-Control-Allow-Origin: http://www.frannnta-design.com");
	
	$server_list = $PDO->query('SELECT * FROM `server_stats`');
	$server_data = '';
	
	
	if($server_list->rowCount() > 0)
	{
		while($row = $server_list->fetch(PDO::FETCH_ASSOC)) {
			$myfile = fopen("scripfile/". $row['server_name'] .".cfg", "w") or die("Unable to open file!");
			if($myfile)
			{
				$txt = "[server]\n\nServer: ". strtoupper($row['server_name']) ."\nIP: ".$row['server_ip']."\nPort: ".$row['server_port']."\nSlots: ".$row['server_slots']."\nServer Mode: ".$row['server_mode']."\nEmail: ".$row['server_contact']."";
				fwrite($myfile, $txt);
				fclose($myfile);
				$server_data = "All servers data created !";
			}
		}
	}
?>

document.write('<?=$server_data;?>');
