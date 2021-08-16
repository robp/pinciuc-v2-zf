<?php

// Use Zend_Loader from here on in
require_once ('application/global.php');
Zend_Loader::loadClass('ItunesTrack');

$table = new ItunesTrack();
//$tracks = $table->fetchAll($table->select()->where('albumArtist = ?', 'The Arcade Fire'));
$table->delete('1 = 1');

print_r($tracks);
