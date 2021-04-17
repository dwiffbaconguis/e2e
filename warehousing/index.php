<?php

include_once '../config/database.php';
include_once '../objects/material.php';
include_once '../objects/location.php';
include_once '../objects/warehousing.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$recordsPerPage = 10;
$fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;

$database = new Database();
$db = $database->getConnection();

$material = new Material($db);
$location = new Location($db);
$warehousing = new Warehousing($db);

$statement = $warehousing->readAll($fromRecordNum, $recordsPerPage);
$num = $statement->rowCount();

$page_title = "Inventory Report";
include_once "../layouts/header.php";

echo
    "
        <div class='right-button-margin'>
            <a href='create.php' class='btn btn-primary float-end'>Add Inventory</a>
        </div>
    ";

if ($num>0) {

    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Material</th>";
            echo "<th>Location</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity</th>";
            echo "<th>Status</th>";
            echo "<th>Created At</th>";
            echo "<th>Actions</th>";
        echo "</tr>";

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

            extract($row);

            echo "<tr>";
                echo "<td>";
                    $material->id = $material_id;
                    $material->readName();
                    echo $material->name;
                echo "</td>";
                echo "<td>";
                    $location->id = $location_id;
                    $location->readName();
                    echo $location->name;
                echo "</td>";
                echo "<td>{$price}</td>";
                echo "<td>{$quantity}</td>";
                echo "<td>{$status}</td>";
                echo "<td>{$created_at}</td>";
                echo "<td>";
                    // read, edit and delete buttons
                    echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>
                    <span class='glyphicon glyphicon-list'></span> Read
                    </a>

                    <a href='update_product.php?id={$id}' class='btn btn-info left-margin'>
                    <span class='glyphicon glyphicon-edit'></span> Edit
                    </a>

                    <a delete-id='{$id}' class='btn btn-danger delete-object'>
                    <span class='glyphicon glyphicon-remove'></span> Delete
                    </a>";
                echo "</td>";
            echo "</tr>";
        }

    echo "</table>";

    // paging buttons will be here
}

else {
    echo "<div class='alert alert-info'>No products found.</div>";
}
include_once "../layouts/footer.php";
?>