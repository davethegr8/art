#!/usr/bin/env php
<?php

chdir(__DIR__);

date_default_timezone_set('America/Los_Angeles');

$src = 'flower.jpg';
$outputs = [
	'png', 'svg'
]; //= 'output-'.((new DateTime)->format('YmdHis')).'';

$basename = substr($src, 0, strpos($src, '.')).'/'.(new DateTime)->format('Y/m/d');
if(!is_dir($basename)) {
	mkdir($basename, 0777, true);
}

// $dest = (new DateTime)->format('Y/m/d');
// mkdir($dest, true);

$modes = [
	'combo',
	'triangle',
	'rect',
	'ellipse',
	'circle',
	'rotatedrect',
	'beziers',
	'rotatedellipse',
	'polygon',
	'vline',
	'hline'
];
$keys = array_flip($modes);

$vline = array_search('vline', $modes, true);
$hline = array_search('hline', $modes, true);

$params = [
	// '-m 5 -n 32',
	// '-m 2 -n 4096',
	// "-m {$mode} -n 1024 -rep 3",
	"-m {$hline} -n 16",
	"-m {$vline} -n 16",
	// '-m 5 -n 128',
	// '-m 6 -n 4096'
	// '-m 0 -n 64 -rep 256'
	// '-m 6 -n 512'
];

$args = implode(' ', $params);
// echo $args, PHP_EOL;
$path = preg_replace('/([a-z]+)\s(\d+)\s?/', '$1$2', $args);

$outputs = array_map(function ($output) use ($basename, $path) {
	$date = (new DateTime)->format('His');
	return '-o "'.$basename.'/'.$date.$path.'.'.$output.'"';
}, $outputs);

$outputs = implode(' ', $outputs);

// print_r($outputs); die;

// $cmd = 'docker-compose run app primitive -v -i '.$src.' '.$outputs.' '.$args;
$cmd = 'GOPATH='.getcwd().' go run src/github.com/fogleman/primitive/main.go -v -i '.$src.' -r 1024 -s 4096 '.$outputs.' '.$args;
echo '> '.$cmd, PHP_EOL;
passthru('time '.$cmd);

// docker-compose run app primitive -i flower.jpg -o output.png -m 4 -n 100 -m 6 -n 128 -rep 4