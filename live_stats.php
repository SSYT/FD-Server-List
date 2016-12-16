<?php
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	header("Access-Control-Allow-Origin: http://www.frannnta-design.com");
	header("Refresh: 1");
	
	if(isset($_GET['live']) && isset($_GET['server_ip']) !== "")
	{
		$i9p = isset($_GET['server_ip']) ? $_GET['server_ip'] : null;
		$server = simplexml_load_file("http://api.gametracker.rs/demo/xml/server_info/". $i9p .":27015/");
		$players = $server->xpath('//server_info');
		$onPlayers = $server->xpath('//server_info/players_list');
		
		$server_arrays;
		foreach($players as $server_info) {
			$server_arrays = array(
				'players' => $server_info->players,
				'playersmax' => $server_info->playersmax,
				'name' => $server_info->name,
				'ip' => $server_info->ip,
				'map' => $server_info->map,
				'players_day' => $server_info->players_day,
				'players_week' => $server_info->players_week,
				'status' => $server_info->status,
				'last_refresh' => $server_info->last_refresh,
				'last_online' => $server_info->last_online,
				'countryname' => $server_info->countryname,
				'gamename' => $server_info->gamename,
				'modname' => $server_info->modname,
				'modshort' => $server_info->modshort,
				'lastMap' => $server_info->lastMap,
				'players_list' => $server_info->players_list
			);
		}
	} else {
		echo "Nu am gasit serverul ...";
	}
	
	function time_elapsed_format($secs){
		$bit = array(
			' year'        => $secs / 31556926 % 12,
			' week'        => $secs / 604800 % 52,
			' day'        => $secs / 86400 % 7,
			' hour'        => $secs / 3600 % 24,
			' minute'    => $secs / 60 % 60,
			' second'    => $secs % 60
		);
			
		foreach($bit as $k => $v){
			if($v > 1)$ret[] = $v . $k . 's';
			if($v == 1)$ret[] = $v . $k;
		}
		
		array_splice($ret, count($ret)-1, 0, '');
		$ret[] = 'ago';
		
		return join(' ', $ret);
    }
	
	$nowtime = time(); $oldtime = $server_arrays['last_refresh'];
	$lastUpdate = "Last refresh " . time_elapsed_format($nowtime-$oldtime);
?>

<h2 class="sub-header"><?=$server_arrays['name'];?></h2>
<div class="row">Map: <?=$server_arrays['map'];?></div>
<div class="row">Players: <?=$server_arrays['players'];?>/<?=$server_arrays['playersmax'];?></div>
<br /><br />
<div class="row">
	<img src="http://forumotiondb.tk/FD%20Servers/banners.php?mode=style_1&server=<?=$_GET['server_ip'];?>" />
	<br /><br />
	Cod forum v1:<br />
	<textarea style="width: 500px;background: #fff;border: 1px solid #ddd;padding: 5px;height: 80;font-size: 12px;text-align: left;"><a href="http://forumotiondb.tk/FD%20Servers/banners.php?mode=1&server=<?=$_GET['server_ip'];?>" /></a></textarea>
	<br /><br />
	<img src="http://forumotiondb.tk/FD%20Servers/banners.php?mode=style_2&server=<?=$_GET['server_ip'];?>" />
	<br />
	Cod forum v2:<br />
	<textarea style="width: 500px;background: #fff;border: 1px solid #ddd;padding: 5px;height: 80;font-size: 12px;text-align: left;"><a href="http://www.frannnta-design.com/h18-servers-list/live_stats=<?=$server_arrays['ip'];?>"><img src="http://forumotiondb.tk/FD%20Servers/banners.php?mode=2&server=<?=$_GET['server_ip'];?>" /></a></textarea>
</div>
<br /><br />
<h2 class="sub-header">Online Players</h2>
<div class="table-responsive">
    <table class="table table-striped">
		<thead>
			<tr>
			  <th>Name</th>
			  <th>Score</th>
			  <th>Connected</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($onPlayers as $players_info) : foreach($players_info->player as $players_info) : ?>
			<tr>
				<td><?=$players_info->name?></td>
				<td><?=$players_info->score?></td>
				<td><?=$players_info->time?></td>
			</tr>
			<?php endforeach; endforeach; ?>
		</tbody>
	</table>
</div>
