<?php

$page_title = "Material Location";
include_once "../layouts/header.php";
// include database and object files
include_once '../config/database.php';
include_once '../objects/material.php';
include_once '../objects/location.php';
include_once '../objects/materialLocation.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// pass connection to objects
$material = new Material($db);
$location = new Location($db);
$materialLocation = new MaterialLocation($db);
?>

<?php
if ($_POST) {

    $materialLocation->material_id = $_POST['material_id'];
    $materialLocation->location_id = $_POST['location_id'];
    $materialLocation->price = $_POST['price'];
    $materialLocation->quantity = $_POST['quantity'];

    // create the material
    if ($materialLocation->create()) {
        echo "<div class='alert alert-success'>Successfully added to the selected Location.</div>";
    }

    else {
        echo "<div class='alert alert-danger'>Something went wrong.</div>";
    }
}
?>
<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >
    <div class="form-group">
        <label for="material_id" class="form-label">Material</label>
        <?php
            $statement = $material->read();

            echo "<select class='form-control' name='material_id'>";
                echo "<option>Select location...</option>";

                while ($row_material = $statement->fetch(PDO::FETCH_ASSOC)){
                    extract($row_material);
                    echo "<option value='{$id}'>{$name}</option>";
                }

            echo "</select>";
        ?>
    </div>
    <div class="form-group">
        <label for="location_id" class="form-label">Location</label>
        <?php
            $statement = $location->read();

            echo "<select class='form-control' name='location_id'>";
                echo "<option>Select location...</option>";

                while ($row_location = $statement->fetch(PDO::FETCH_ASSOC)){
                    extract($row_location);
                    echo "<option value='{$id}'>{$name}</option>";
                }

            echo "</select>";
        ?>
    </div>
    <div class="form-group">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" name="price" id="price" required>
    </div>
    <div class="form-group">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="text" class="form-control" name="quantity" id="quantity" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="index.php" class="btn btn-danger">Back</a>
</form>
<?php include_once "../layouts/footer.php"; ?>