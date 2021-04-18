<?php

$page_title = "Update Category";
include_once "../layouts/header.php";

$id = isset($_GET['id']) ? $_GET['id'] : die("Material ID: Not Found");
include_once '../config/database.php';
include_once '../objects/category.php';

$db = (new Database())->getConnection();

$category = new Category($db);

$category->id = $id;
$category->readOne();

if ($_POST) {
    $category->name = $_POST['name'];

    if($category->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "category was updated.";
        echo "</div>";
    }

    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update category.";
        echo "</div>";
    }
}
?>

<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" >
    <div class="form-group">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="<?= $category->name?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="index.php" class="btn btn-danger">Back</a>
</form>

<?php include_once "../layouts/footer.php"; ?>