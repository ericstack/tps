<?php 

$pages = $_GET['page'] ?? 'dashboard';

echo file_get_contents($pages.'.php');


?>