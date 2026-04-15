<?php
if(!session_id()) session_start();
date_default_timezone_set('Asia/Jakarta');
define('BASEURL', 'http://localhost/project_1_pebri');
require_once 'app/persiapan.php';

// Pastikan Database juga menggunakan zona waktu yang sama agar TIMESTAMPDIFF akurat
$db = new Database();
$db->query("SET time_zone = '+07:00'");
$db->execute();
?>
