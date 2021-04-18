<?php

include_once '../config/database.php';
include_once '../objects/category.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$recordsPerPage = 10;
$fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

$statement = $category->readAll($fromRecordNum, $recordsPerPage);
$num = $statement->rowCount();

$page_title = "Category";
include_once "../layouts/header.php";

echo
    "
        <div class='right-button-margin mb-3'>
            <a href='create.php' class='btn btn-primary float-end'>Add Category</a>
        </div>
    ";

if ($num>0) {

    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Actions</th>";
        echo "</tr>";

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

            extract($row);

            echo "<tr>";
                echo "<td>{$name}</td>";
                echo "<td>";
                    // read, edit and delete buttons
                    echo "
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
    $total_rows = $category->countAll();
    include_once '../layouts/paging.php';
}

else {
    echo "<div class='alert alert-info'>No category found.</div>";
}

include_once "../layouts/footer.php";
?>