
<?php
header("Content-Type: image/png");
date_default_timezone_set('Europe');
header("Refresh: 5");

if(isset($_GET['mode']) && isset($_GET['server']))
{
	if($_GET['mode'] == "style_1")
	{
		$sip = isset($_GET['server']) ? $_GET['server'] : null;
		$xml = simplexml_load_file("http://api.gametracker.rs/demo/xml/server_info/". $sip .":27015");
		$players = $xml->xpath('//server_info');
		
		$stamp = imagecreatefrompng('images/cs_430x73.png');
		
		$colorOrange = ImageColorAllocate($stamp, 128,255,0);
		foreach($players as $sv_rows)
		{
			// Server Name
			$string1 = "Server:";
			$string2 = $sv_rows->name;
			
			// Server Map
			$string3 = "Map:";
			$string4 = $sv_rows->map;
			
			// Server Players
			$string5 = "Players:";
			$string6 = $sv_rows->players . "/" . $sv_rows->playersmax;
			
			// Server IP
			$string7 = "IP:";
			$string8 = $sv_rows->ip;

			ImageString($stamp, 2, 20, 1,   $string1, $colorOrange);
			ImageString($stamp, 2, 20, 13,  $string2, $colorOrange);
			
			ImageString($stamp, 2, 20, 30,  $string3, $colorOrange);
			ImageString($stamp, 2, 20, 43,  $string4, $colorOrange);
			
			ImageString($stamp, 2, 240, 1,   $string5, $colorOrange);
			ImageString($stamp, 2, 240, 13,  $string6, $colorOrange);
			
			ImageString($stamp, 2, 240, 30,  $string7, $colorOrange);
			ImageString($stamp, 2, 240, 44,  $string8, $colorOrange);
		}
		ImagePNG($stamp);
		ImageDestroy($stamp);
	}
}

if(isset($_GET['mode']) && isset($_GET['server']))
{
	if($_GET['mode'] == "style_2")
	{
		$sip = isset($_GET['server']) ? $_GET['server'] : null;
		$xml = simplexml_load_file("http://api.gametracker.rs/demo/xml/server_info/". $sip .":27015");
		$players = $xml->xpath('//server_info');
		
		// Images
		$stamp = imagecreatefrompng('images/cs_350x20.png');
		$im_tmp = imagecreatefrompng("images/game-cs.png");
		
		// Colors
		$colorOrange = ImageColorAllocate($stamp, 220, 210, 60);
		$colorWhite = ImageColorAllocate($stamp, 255, 255, 255);
		
		foreach($players as $sv_rows)
		{
			$string1 = $sv_rows->name;
			$string2 = $sv_rows->map;
			$string3 = $sv_rows->players . "/" . $sv_rows->playersmax;
			$string4 = $sv_rows->ip;

			$px2 = (imagesx($stamp) + 10.0 * strlen($string2)) / 2;
			
			ImageString($stamp, 1.2, 25, 1,  $string1, $colorWhite);
			ImageString($stamp, 2, 220, 7, $string2, $colorWhite);
			ImageString($stamp, 2, 25, 7, $string4, $colorWhite);
			ImageString($stamp, 2, 160, 7, $string3, $colorWhite);
			imagecopymerge($stamp, $im_tmp, 3, 2.5, 0, 0, 16, 16, 100);
		}
		ImagePNG($stamp);
		ImageDestroy($stamp);
		ImageDestroy($im_tmp);
	}
}

if(isset($_GET['mode']) && isset($_GET['server']))
{
	if($_GET['mode'] == "style_3")
	{
		$sip = isset($_GET['server']) ? $_GET['server'] : null;
		$xml = simplexml_load_file("http://api.gametracker.rs/demo/xml/server_info/". $sip .":27015");
		$players = $xml->xpath('//server_info');
	}
}
?>
