<?php
// SET TIME ZONE TO ASIA
date_default_timezone_set('Asia/Manila');

// DELETE FILE
unlink('uploads/'.$_GET['name']);

// CREATE DELETE LOGS
$fp = fopen('delete-log.txt', 'a');  
fwrite($fp, date("F d, Y -- H:i A") . " : File Deleted \u{21D2} {$_GET['name']}\r\n");
fclose($fp);

// GO BACK TO HOME PAGE
header("Location: http://test-grounds.rf.gd/backup/");