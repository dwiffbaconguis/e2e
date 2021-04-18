<?php

$page_title = "Update material";
include_once "../layouts/header.php";

echo "
        <div class='right-button-margin'>
            <a href='index.php' class='btn btn-info float-end'>Read Materials</a>
        </div>
     ";

$id = isset($_GET['id']) ? $_GET['id'] : die("Material ID: Not Found");
include_once '../config/database.php';
include_once '../objects/material.php';
include_once '../objects/category.php';

$db = (new Database())->getConnection();

$material = new Material($db);
$category = new Category($db);

$material->id = $id;
$material->readOne();

if ($_POST) {
    // set material property values
    $material->name = $_POST['name'];
    $material->barcode = $_POST['barcode'];
    $material->description = $_POST['description'];
    $material->category_id = $_POST['category_id'];

    // update the material
    if($material->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Material was updated.";
        echo "</div>";
    }

    // if unable to update the material, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update material.";
        echo "</div>";
    }
}
?>

<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" >
    <div class="form-group">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="<?= $material->name?>" required>
    </div>
    <div class="form-group">
        <label for="barcode" class="form-label">Barcode</label>
        <input type="text" class="form-control" name="barcode" id="barcode" value="<?= $material->barcode?>" required>
    </div>
    <div class="form-group">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" name="description" id="description" value="<?= $material->description?>" required>
    </div>
    <div class="form-group">
        <label for="category" class="form-label">Category</label>
        <?php
            $statement = $category->read();

            echo "<select class='form-control' name='category_id'>";
                echo "<option>Select category...</option>";

                while ($row_category = $statement->fetch(PDO::FETCH_ASSOC)){
                    extract($row_category);
                    $categoryId = $id;
                    $categoryName = $name;

                    if ($material->category_id == $categoryId) {
                        echo "<option value={$categoryId} selected>";
                    } else {
                        echo "<option value={$categoryId}>";
                    }

                    echo "$categoryName</option>";
                }
            echo "</select>";
        ?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="index.php" class="btn btn-danger">Back</a>
</form>

<?php include_once "../layouts/footer.php"; ?>