<?php

$page_title = "Create Material";
include_once "../layouts/header.php";
include_once '../config/database.php';
include_once '../objects/category.php';

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

if ($_POST) {
    $category->name = $_POST['name'];

    if ($category->create()) {
        echo "<div class='alert alert-success'>Successfully Added.</div>";
    }

    else {
        echo "<div class='alert alert-danger'>Category already exists.</div>";
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
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="index.php" class="btn btn-danger">Back</a>
    </form>
</div>

<?php include_once "../layouts/footer.php"; ?>