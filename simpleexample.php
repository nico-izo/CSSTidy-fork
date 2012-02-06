<?php

require_once('csstidy/csstidy.class.php');

require_once('csstidy.config.php');

$config = array();

$csstidy = new csstidy($csstidy_config);
$csstidy->load_template('highest_compression');
$file = file_get_contents("./test.css");
$csstidy->parse($file);

//var_dump($csstidy);

echo $csstidy->return_plain_output_css();
