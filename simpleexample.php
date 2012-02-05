<?php

require_once('csstidy/csstidy.class.php');

require_once('csstidy.config.php');

$config = array();

$csstidy = new csstidy($csstidy_config);
$csstidy->load_template('highest_compression');

$csstidy->parse(".lol { color: #ffffff; border-radius: 5px 5px 5px 5px; } @media print {
    p {
     widows: 3;
     orphans: 3;
    }
   }");

//var_dump($csstidy);

echo $csstidy->return_plain_output_css();
