<?php

include_once '../config/database.php';
include_once '../objects/material.php';
include_once '../objects/location.php';
include_once '../objects/category.php';
include_once '../objects/materialLocation.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$recordsPerPage = 10;
$fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;

$db = (new Database())->getConnection();

$material = new Material($db);
$location = new Location($db);
$warehousing = new MaterialLocation($db);
$category = new Category($db);

$statement = $warehousing->readAllV2($fromRecordNum, $recordsPerPage);
$num = $statement->rowCount();

$page_title = "Inventory Report";
include_once "../layouts/header.php";

echo
    "
        <div class='right-button-margin'>
            <a href='create.php' class='btn btn-primary float-end'>
                Add Inventory
            </a>
        </div>
    ";

if ($num>0) {

    echo "<table class='table table-hover table-responsive table-bordered table-compact'>";
        echo "<tr>";
            echo "<th>Material</th>";
            echo "<th>Category</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity</th>";
            echo "<th>Status</th>";
            echo "<th>Location</th>";
            echo "<th>Created At</th>";
            echo "<th>Updated At</th>";
            echo "<th>Actions</th>";
        echo "</tr>";

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

            extract($row);
            echo "<tr>";
                echo "<td>{$material}</td>";
                echo "<td>{$category}</td>";
                echo "<td>{$price}</td>";
                echo "<td>{$quantity}</td>";
                echo "<td>{$status}</td>";
                echo "<td>{$location}</td>";
                echo "<td>{$created_at}</td>";
                echo "<td>{$updated_at}</td>";
                echo "<td>";
                    // read, edit and delete buttons
                    echo "<a href='read.php?id={$id}' class='btn btn-primary left-margin'>
                    <span class='glyphicon glyphicon-list'></span> Read
                    </a>

                    <a href='update.php?id={$id}' class='btn btn-info left-margin'>
                    <span class='glyphicon glyphicon-edit'></span> Edit
                    </a>

                    <a delete-id='{$id}' class='btn btn-danger delete'>
                    <span class='glyphicon glyphicon-remove'></span> Delete
                    </a>";
                echo "</td>";
            echo "</tr>";
        }

    echo "</table>";

    $page_url = "index.php?";
    $total_rows = $warehousing->countAll();
    include_once '../layouts/paging.php';
}

else {
    echo "<div class='alert alert-info'>No products found.</div>";
}
include_once "../layouts/footer.php";
?>