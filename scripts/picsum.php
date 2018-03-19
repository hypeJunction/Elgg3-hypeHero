<?php

$root = dirname(dirname(__FILE__));
require_once $root . '/autoloader.php';

$parser = new \hypeJunction\Hero\PicsumParser();
$conf = $parser->parse();

$file = "$root/images.json";

$parser->save($file, $conf);

