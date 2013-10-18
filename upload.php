<?php

if (!file_exists($_FILES['launcher']['tmp_name']) || !is_uploaded_file($_FILES['launcher']['tmp_name'])) return;

define('identifier', $_GET['time']);

$weight		= 1024 * 1024 * 5;
$extensions	= array('png', 'PNG');
$size		= array('width' => 2048, 'height' => 2048);
$resolution	= 72;

$path		= '/homez.488/deswebcr/www/_code/app-launcher/uploads/';
$path_folder= $path . identifier . '/';

if (!check(array(
	'file'			=> $_FILES['launcher'],
	'weight'		=> $weight,
	'extensions'	=> $extensions,
	'size'			=> $size,
	'resolution'	=> $resolution))) exit;

mkdir($path_folder, 0777, true);

move_uploaded_file($_FILES['launcher']['tmp_name'], $path_folder . 'launcher.png');

/**
 * Functions
 */

function check($datas)
{
	$file = $datas['file'];

	if ($file['error'] > 0) return false;

	if ($file['size'] > $datas['weight'] || $file['size'] <= 0) return false;

	list($launcher_width, $launcher_height) = getimagesize($file['tmp_name']);

	if ($launcher_width != $datas['size']['width'] || $launcher_height != $datas['size']['height']) return false;

	list($launcher_name, $launcher_ext) = explode('.', $file['name']);

	if(!in_array($launcher_ext, $datas['extensions'])) return false;

	// Bug : dpi return 0
	//if (getPngDpi($file['tmp_name']) != $datas['resolution']) return false;

	return true;
}

function getPngDpi($source)
{
	$fh = fopen($source, 'rb');
	
	if (!$fh) return false;

	$dpi = false;

	$buf = array();

	$x		= 0;
	$y		= 0;
	$units	= 0;

	while(!feof($fh))
	{
		array_push($buf, ord(fread($fh, 1)));
		
		if		(count($buf) > 13) array_shift($buf);
		else if	(count($buf) < 13) continue;

		if ($buf[0] == ord('p') && $buf[1] == ord('H') && $buf[2] == ord('Y') && $buf[3] == ord('s'))
		{
			$x = ($buf[4] << 24) + ($buf[5] << 16) + ($buf[6] << 8) + $buf[7];
			$y = ($buf[8] << 24) + ($buf[9] << 16) + ($buf[10] << 8) + $buf[11];

			$units = $buf[12];

			break;
		}
	}

	fclose($fh);

	if ($x == $y)						$dpi = $x;
	if ($dpi != false && $units == 1)	$dpi = round($dpi * 0.0254);

	return $dpi;
}

?>