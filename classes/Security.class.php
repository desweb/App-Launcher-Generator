<?php

class Security
{
	private $weight		= 5242880;
	private $extensions	= array('png', 'PNG');
	private $size		= array('width' => 2048, 'height' => 2048);
	private $resolution	= 72;

	private $identifier;

	private $file;

	private $path_upload= '/homez.488/deswebcr/www/_code/app-launcher/uploads/';

	private $path_launcher_folder;
	private $path_launcher_file;

	public function checkFile($file)
	{
		$this->file = $file;

		return file_exists($this->file['tmp_name']) && is_uploaded_file($this->file['tmp_name']);
	}

	public function checkLauncherProperties()
	{
		if ($this->file['error'] > 0) return false;

		if ($this->file['size'] > $this->weight || $this->file['size'] <= 0) return false;

		list($launcher_width, $launcher_height) = getimagesize($this->file['tmp_name']);

		if ($launcher_width != $this->size['width'] || $launcher_height != $this->size['height']) return false;

		if(!in_array(explode('.', $this->file['name'])[1], $this->extensions)) return false;

		return true;
	}

	/**
	 * Getters
	 */

	public function getPathLauncherFolder()	{ return $this->path_launcher_folder; }
	public function getPathLauncherFile()	{ return $this->path_launcher_file; }

	/**
	 * Setters
	 */

	public function setIdentifier($identifier)
	{
		$this->identifier	= $identifier;

		$this->path_launcher_folder	= $this->path_upload . $identifier . '/';
		$this->path_launcher_file	= $this->path_launcher_folder . '/launcher.png';
	}
}