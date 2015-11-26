<?
	header("Content-type: image/jpeg");
	putenv('GDFONTPATH=' . realpath('.')); 
	require_once("ts3admin.class.php");
	$config = array 
	(
		'ip' => '127.0.0.1',
		'port' => '9987',
		'query_port' => '10011'
	);
	
	$tsServer = new ts3admin($config['ip'], $config['query_port']);
	if( $tsServer->getElement('success', $tsServer->connect()) ) 
	{
		$tsServer->selectServer($config['port']);
		
		$player = $tsServer->hostInfo();
		$clients = $tsServer->clientList(); 
		$name = $tsServer->serverList();
		$hostname = preg_replace("/[^a-zA-Z0-9_ %\[\]\.\(\)%@#$!\/:|,-]/s", "", $name['data']['0']['virtualserver_name']);
		
		$plr_count = $player['data']['virtualservers_total_clients_online'];
		$max_plrs = $player['data']['virtualservers_total_maxclients'];
	}
	else
	{
		$max_plrs = "0";
		$hostname = "Serwer jest OFFLINE!!!";
		$plr_count = "0";
	}		
	$image = imagecreatefromjpeg("ts.jpg");
	$color = ImageColorAllocate($image, 255,255,255);
	$colorobr = ImageColorAllocate($image, 0, 0, 0);
	imagettftext($image, 10, 0, -10, 8, $color, "visitor.ttf", $hostname);
	imagettftext($image, 10, 0, 225, 17, $color, "visitor.ttf", $config['ip'].$config['port']);
	imagettftext($image, 10, 0, 310, 8, $color, "visitor.ttf", $plr_count."/".$max_plrs);

	imagealphablending($image, false);
	imagesavealpha($image, true);
	imagepng($image);
	ImageDestroy($image);
?>