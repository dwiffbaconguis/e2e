<?php

if ($_POST) {
    include_once '../config/database.php';
    include_once '../objects/material.php';

    $db = (new Database())->getConnection();
    $material = new Material($db);
    $material->id = $_POST['object_id'];

    if ($material->delete()) {
        $response = "Material deleted";
    } else {
        $response = "Unable to delete Material";
    }

    echo $response;
}