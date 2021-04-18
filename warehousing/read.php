<?php

$page_title = "Read Material";
include_once '../layouts/header.php';
include_once '../config/database.php';
include_once '../objects/material.php';
include_once '../objects/location.php';
include_once '../objects/materialLocation.php';

$db = (new Database())->getConnection();

$id = isset($_GET['id']) ? $_GET['id'] : die ("Missing: Material ID");

$materialLocation = new MaterialLocation($db);
$materialLocation->id = $id;
$materialLocation->readOne();


$material = new Material($db);
$material->id = $materialLocation->material_id;
$material->readName();

$location = new location($db);
$location->id = $materialLocation->location_id;
$location->readName();

?>

<div class="container">
    <div class="col-md-12">
        <table class="table table-striped table-responsive">
            <tr>
                <td>Name</td>
                <td><?= $material->name ?></td>
            </tr>
            <tr>
                <td>Location</td>
                <td><?= $location->name ?></td>
            </tr>
            <tr>
                <td>Price</td>
                <td><?= $materialLocation->price ?></td>
            </tr>
            <tr>
                <td>Quantity</td>
                <td><?= $materialLocation->quantity ?></td>
            </tr>
            <tr>
                <td>Created</td>
                <td><?= $materialLocation->created_at ?></td>
            </tr>
            <tr>
                <td>Updated</td>
                <td><?= $materialLocation->updated_at ?></td>
            </tr>
        </table>
    </div>
    <a href="index.php" class="btn btn-secondary">Back</a>
</div>

<? include_once '../layouts/footer.php'; ?>