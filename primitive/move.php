<?php

date_default_timezone_set('America/Los_Angeles');

$files = array_merge(glob('*/*.png'), glob('*/*.svg'));

foreach($files as $src) {
	$path = explode('/', $src);
	$parts = explode('-', $path[1]);

	$date = DateTime::createFromFormat('YmdHis', $parts[0]);
	$parts[0] = $date->format('Y/m/d/His');
	$parts = implode('-', $parts);
	$dest = $path[0].'/'.$parts;

	if(!is_dir(dirname($dest))) {
		mkdir(dirname($dest), 0777, true);
	}

	rename($src, $dest);
}