<?php

if ($_POST) {
    include_once '../config/database.php';
    include_once '../objects/materialLocation.php';

    $db = (new Database())->getConnection();
    $material = new MaterialLocation($db);
    $material->id = $_POST['object_id'];

    if ($material->delete()) {
        $response = "Material deleted";
    } else {
        $response = "Unable to delete Material";
    }

    echo $response;
}