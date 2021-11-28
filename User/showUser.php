<?php

require_once '../dbConfig.php';

$id = $_POST['id'];

$user->showUser($id);

?>