<?php

require_once('csstidy/csstidy.class.php');

require_once('csstidy.config.php');

$config = parse_ini_file("./simpleconfig.ini", true);

$config['csstidy']['vendor_prefix'] = '-moz-';

$csstidy = new csstidy($csstidy_config, $config['csstidy']);
$csstidy->load_template('highest_compression');
$file = file_get_contents("./qutim.pure.css");
$csstidy->parse($file);

//var_dump($csstidy);

//echo $csstidy->return_plain_output_css();

//print_r($csstidy->get_log());

foreach($csstidy->get_log() as $l => $m)
{
	foreach($m as $me => $t)
	{
		echo $t['t'].": ".$t['m']."\n";
	}
}

//$csstidy->get_diff();
