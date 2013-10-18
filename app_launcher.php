<?php

define('identifier', $_GET['time']);

$path				= '/homez.488/deswebcr/www/_code/app-launcher/';
$path_dl			= 'http://code.desweb-creation.fr/app-launcher/zip/';
$path_upload		= $path . 'uploads/';
$path_zip			= $path . 'zip/';
$path_upload_file	= $path_upload . identifier . '/';

if (!is_dir($path_upload_file) && !file_exists($path_upload_file . 'launcher.png')) die('{ "is_error" : 1 }');

folders($path_upload_file);

launchers(array(
	'path_upload'		=> $path_upload_file,
	'path_upload_file'	=> $path_upload_file . 'launcher.png'));

$id_convert = base_convert(identifier, 16, 10);

zip($path_upload_file, $path_zip . 'app-launcher-' . $id_convert . '.zip');

$zip_link = $path_dl . 'app-launcher-' . $id_convert . '.zip';

remove($path_upload_file);

die('{
	"is_success" : 1,
	"path_dl" : "' . $zip_link . '"
}');

/**
 * Functions
 */

/**
 * Folders & files system
 * 
 * App
 *  launcher.png
 *  iOS
 *   Default-568h@2x.png		(640*1136)
 *   Default.png				(320*480)
 *   Default@2x.png				(640*960)
 *   Default-Portrait.png		(768*1024)
 *   Default-Portrait@2x.png	(1536*2048)
 *   Default-Landscape.png		(1024*768)
 *   Default-Landscape@2x.png	(2048*1536)
 *  Android
 *   res-notlong-port-ldpi
 *    default.png (240*320)
 *   res-notlong-land-ldpi
 *    default.png (320*240)
 *   res-long-port-ldpi
 *    default.png (240*400)
 *   res-long-land-ldpi
 *    default.png (400*240)
 *   res-notlong-port-mdpi
 *    default.png (320*480)
 *   res-notlong-land-mdpi
 *    default.png (480*320)
 *   res-notlong-port-hdpi
 *    default.png (480*800)
 *   res-notlong-land-hdpi
 *    default.png (800*480)
 *   res-long-port-hdpi
 *    default.png (480*800)
 *   res-long-land-hdpi
 *    default.png (800*480)
 */

function folders($path_upload_launcher)
{
	$folders = array(
		'iOS/',
		'Android/',
		'Android/res-notlong-port-ldpi/',
		'Android/res-notlong-land-ldpi/',
		'Android/res-long-port-ldpi/',
		'Android/res-long-land-ldpi/',
		'Android/res-notlong-port-mdpi/',
		'Android/res-notlong-land-mdpi/',
		'Android/res-notlong-port-hdpi/',
		'Android/res-notlong-land-hdpi/',
		'Android/res-long-port-hdpi/',
		'Android/res-long-land-hdpi/');

	foreach ($folders as $value)
		mkdir($path_upload_launcher . $value, 0777, true);
}

function launchers($datas)
{
	$launchers = array(
		array('path' => 'iOS/Default-568h@2x.png',		'size' => array('width' => 640,	'height' => 1136)),
		array('path' => 'iOS/Default.png',				'size' => array('width' => 320,	'height' => 480)),
		array('path' => 'iOS/Default@2x.png',			'size' => array('width' => 640,	'height' => 960)),
		array('path' => 'iOS/Default-Portrait.png',		'size' => array('width' => 768,	'height' => 1024)),
		array('path' => 'iOS/Default-Portrait@2x.png',	'size' => array('width' => 1536,'height' => 2048)),
		array('path' => 'iOS/Default-Landscape.png',	'size' => array('width' => 1024,'height' => 768)),
		array('path' => 'iOS/Default-Landscape@2x.png',	'size' => array('width' => 2048,'height' => 1536)),
		array('path' => 'Android/res-notlong-port-ldpi/default.png','size' => array('width' => 240,	'height' => 320)),
		array('path' => 'Android/res-notlong-land-ldpi/default.png','size' => array('width' => 320,	'height' => 240)),
		array('path' => 'Android/res-long-port-ldpi/default.png',	'size' => array('width' => 240,	'height' => 400)),
		array('path' => 'Android/res-long-land-ldpi/default.png',	'size' => array('width' => 400,	'height' => 240)),
		array('path' => 'Android/res-notlong-port-mdpi/default.png','size' => array('width' => 320,	'height' => 480)),
		array('path' => 'Android/res-notlong-land-mdpi/default.png','size' => array('width' => 480,	'height' => 320)),
		array('path' => 'Android/res-notlong-port-hdpi/default.png','size' => array('width' => 480,	'height' => 800)),
		array('path' => 'Android/res-notlong-land-hdpi/default.png','size' => array('width' => 800,	'height' => 480)),
		array('path' => 'Android/res-long-port-hdpi/default.png',	'size' => array('width' => 480,	'height' => 800)),
		array('path' => 'Android/res-long-land-hdpi/default.png',	'size' => array('width' => 800,	'height' => 480)));

	$src = imagecreatefrompng($datas['path_upload_file']);

	foreach ($launchers as $value)
	{
		$path = $datas['path_upload'] . $value['path'];

		if ($value['size']['width'] < $value['size']['height'])
		{
			$resize		= $value['size']['height'] . 'x' . $value['size']['height'];
			$crop_margin= '+' . ($value['size']['height'] - $value['size']['width']) / 2 . '+0';
		}
		else
		{
			$resize		= $value['size']['width'] . 'x' . $value['size']['width'];
			$crop_margin= '+0+' . ($value['size']['width'] - $value['size']['height']) / 2;
		}

		exec('/usr/bin/convert ' . $datas['path_upload_file'] . ' -quality 72 -resize ' . $resize . ' ' . $path);
		exec('/usr/bin/convert ' . $path . ' -crop ' . $value['size']['width'] . 'x' . $value['size']['height'] . $crop_margin . ' ' . $path);
	}
}

function zip($source, $destination)
{
    if (!extension_loaded('zip') || !file_exists($source)) return false;

    $zip = new ZipArchive();

    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) return false;

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            $file = str_replace('\\', '/', $file);

            if(in_array(substr($file, strrpos($file, '/') + 1), array('.', '..'))) continue;

            $file = realpath($file);

            if		(is_dir($file)	=== true)	$zip->addEmptyDir	(str_replace($source . '/', '', $file . '/'));
            else if	(is_file($file)	=== true)	$zip->addFromString	(str_replace($source . '/', '', $file), file_get_contents($file));
        }
    }
    else if (is_file($source) === true) $zip->addFromString(basename($source), file_get_contents($source));

    return $zip->close();
}

function remove($path_upload_file)
{
	$it		= new RecursiveDirectoryIterator($path_upload_file);
	$files	= new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);

	foreach($files as $file)
	{
		if ($file->getFilename() === '.' || $file->getFilename() === '..') continue;
		
		if ($file->isDir())	rmdir	($file->getRealPath());
		else				unlink	($file->getRealPath());
	}
	rmdir($path_upload_file);
}

?>