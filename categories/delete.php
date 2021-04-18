<?php

if ($_POST) {
    include_once '../config/database.php';
    include_once '../objects/category.php';

    $db = (new Database())->getConnection();
    $category = new Category($db);
    $category->id = $_POST['object_id'];

    if ($category->delete()) {
        $response = "Category deleted";
    } else {
        $response = "Unable to delete Category";
    }

    echo $response;
}