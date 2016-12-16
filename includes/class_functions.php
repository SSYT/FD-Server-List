<?php
	function tokenKeys($length) {
		$keys = array_merge(range(0,9), range('a', 'z'));
		$key = "";
		for($i=0; $i < $length; $i++) {
			$key .= $keys[mt_rand(0, count($keys) - 1)];
		}
		return $key;
	}

	function server_source_query($ip)
	{
		$cut = explode(":", $ip);
		$HL2_address = $cut[0];
		$HL2_port = $cut[1];
		$HL2_stats = "";

		$HL2_command = "\xFF\xFF\xFF\xFFinfo\x00Source Engine Query\x00";
		$HL2_socket = @fsockopen("udp://".$HL2_address, $HL2_port, $errno, $errstr, 3);
		fwrite($HL2_socket, $HL2_command); $JunkHead = fread($HL2_socket, 4);
		$CheckStatus = socket_get_status($HL2_socket);

		if($CheckStatus["unread_bytes"] == 0)
		{
			return 0;
		}

		$do = 1;
		while($do)
		{
			$str = fread($HL2_socket, 1);
			$HL2_stats .= $str;
			$status = socket_get_status($HL2_socket);
			if($status["unread_bytes"] == 0)
			{
				$do = 0;
			}
		}
		fclose($HL2_socket);

		$x = 0; $result = "";
		while ($x <= strlen($HL2_stats))
		{
			$x++;
			$result .= substr($HL2_stats, $x, 1);
		}
		$result = urlencode($result); // the output
		return $result;
	}

	function server_read_query($string)
	{
		$string = str_replace('%07','',$string);
		$string = str_replace("%00","|||",$string);
		$sinfo = urldecode($string);
		$sinfo = explode('|||', $sinfo);
		$info['hostname'] = $sinfo[0];
		$info['map'] = $sinfo[1];
		$info['game'] = $sinfo[3];
		return $info;
	}
?>
