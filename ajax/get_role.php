<?php
require_once __DIR__ . "/../app.php";

$utils = new Utils();
$info = $utils->get_role();
echo json_encode($info->data);
