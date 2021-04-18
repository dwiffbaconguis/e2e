<?php

include_once '../config/database.php';
include_once '../objects/material.php';
include_once '../objects/category.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$recordsPerPage = 10;
$fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;

$database = new Database();
$db = $database->getConnection();

$material = new Material($db);
$category = new Category($db);

$statement = $material->readAll($fromRecordNum, $recordsPerPage);
$num = $statement->rowCount();

$page_title = "Materials";
include_once "../layouts/header.php";

echo
    "
        <div class='right-button-margin mb-3'>
            <a href='create.php' class='btn btn-primary float-end'>Create Material</a>
        </div>
    ";

if ($num>0) {

    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Material</th>";
            echo "<th>Barcode</th>";
            echo "<th>Description</th>";
            echo "<th>Category</th>";
            echo "<th>Created</th>";
            echo "<th>Updated</th>";
            echo "<th>Actions</th>";
        echo "</tr>";

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

            extract($row);

            echo "<tr>";
                echo "<td>{$name}</td>";
                echo "<td>{$barcode}</td>";
                echo "<td>{$description}</td>";
                echo "<td>";
                    $category->id = $category_id;
                    $category->readName();
                    echo $category->name;
                echo "</td>";
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
    $total_rows = $material->countAll();
    include_once '../layouts/paging.php';
}

else {
    echo "<div class='alert alert-info'>No products found.</div>";
}

include_once "../layouts/footer.php";
?>