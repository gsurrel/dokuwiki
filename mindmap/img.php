<?php

ini_set('memory_limit','128M');

if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/../../../');
define('NOSESSION',true);
require_once(DOKU_INC.'inc/init.php');

session_write_close();

// Get the syntax parameters
$data = $_REQUEST;

// Get the plugin
$plugin = plugin_load('syntax','mindmap');

$image = $plugin->get_graphviz_image( $data );

if (!$image) _fail();

header('Content-Type: image/png;');
header('Expires: '.gmdate("D, d M Y H:i:s", time()+max($conf['cachetime'], 3600)).' GMT');
header('Cache-Control: public, proxy-revalidate, no-transform, max-age='.max($conf['cachetime'], 3600));
header('Pragma: public');
http_conditionalRequest($time);
echo $image;


function _fail() {
    header("HTTP/1.0 404 Not Found");
    header('Content-Type: image/png');
    echo io_readFile('broken.png',false);
    exit;
}

?>