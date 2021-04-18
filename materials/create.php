<?php

$page_title = "Create Material";
include_once "../layouts/header.php";
// include database and object files
include_once '../config/database.php';
include_once '../objects/material.php';
include_once '../objects/category.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// pass connection to objects
$material = new Material($db);
$category = new Category($db);

if ($_POST) {
    // set material property values
    $material->name = $_POST['name'];
    $material->barcode = $_POST['barcode'];
    $material->description = $_POST['description'];
    $material->category_id = $_POST['category_id'];

    // create the material
    if ($material->create()) {
        echo "<div class='alert alert-success'>Successfully Added.</div>";
    }

    else {
        echo "<div class='alert alert-danger'>Material already exists.</div>";
    }
}
?>
<div class="container">
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >
        <div class="form-group">
            <div class="col-md-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" required>
                <div id="nameHelp" class="form-text">Please be precise as much as possible.</div>
            </div>
        </div>
        <div class="form-group">
            <label for="barcode" class="form-label">Barcode</label>
            <input type="text" class="form-control" name="barcode" id="barcode" required>
        </div>
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" name="description" id="description" required>
        </div>
        <div class="form-group">
            <label for="category" class="form-label">Category</label>
            <?php
                $statement = $category->read();

                echo "<select class='form-control' name='category_id'>";
                    echo "<option>Select category...</option>";

                    while ($row_category = $statement->fetch(PDO::FETCH_ASSOC)){
                        extract($row_category);
                        echo "<option value='{$id}'>{$name}</option>";
                    }

                echo "</select>";
            ?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="index.php" class="btn btn-danger">Back</a>
    </form>
</div>

<?php include_once "../layouts/footer.php"; ?>