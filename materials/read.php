<?php

$page_title = "Read Material";
include_once '../layouts/header.php';
include_once '../config/database.php';
include_once '../objects/material.php';
include_once '../objects/category.php';

$db = (new Database())->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : die ("Missing: Material ID");

$material = new Material($db);
$material->id = $id;
$material->readOne();

$category = new Category($db);
$category->id = $material->category_id;
$category->readName();

?>

<div class="container">
    <div class="col-md-12">
        <table class="table table-striped table-responsive">
            <tr>
                <td>Name</td>
                <td><?= $material->name ?></td>
            </tr>
            <tr>
                <td>Barcode</td>
                <td><?= $material->barcode ?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><?= $material->description ?></td>
            </tr>
            <tr>
                <td>Category</td>
                <td><?= $category->name ?></td>
            </tr>
            <tr>
                <td>Created</td>
                <td><?= $material->created_at ?></td>
            </tr>
            <tr>
                <td>Updated</td>
                <td><?= $material->updated_at ?></td>
            </tr>
        </table>
    </div>
    <a href="index.php" class="btn btn-secondary">Back</a>
</div>

<? include_once '../layouts/footer.php'; ?>