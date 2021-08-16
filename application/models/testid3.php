<?php
require_once('getid3/getid3.php');
$getID3 = new getID3;
$fileinfo = $getID3->analyze('/mnt/mammoth/music/Buck 65/Synesthesia/15 - Grumpy.mp3');
print_r($fileinfo);
?>
