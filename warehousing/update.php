<?php

$page_title = "Update Inventory";
include_once "../layouts/header.php";

$id = isset($_GET['id']) ? $_GET['id'] : die("Material ID: Not Found");

include_once '../config/database.php';
include_once '../objects/material.php';
include_once '../objects/location.php';
include_once '../objects/warehousing.php';

$db = (new Database())->getConnection();

$material = new Material($db);
$location = new Location($db);
$materialLocation = new Warehousing($db);

$materialLocation->id = $id;
$materialLocation->readOne();

if ($_POST) {
    // set material location property values
    $materialLocation->material_id = $_POST['material_id'];
    $materialLocation->location_id = $_POST['location_id'];
    $materialLocation->price = $_POST['price'];
    $materialLocation->quantity = $_POST['quantity'];

    // update inventory
    if($materialLocation->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Inventory updated.";
        echo "</div>";
    }

    // if unable to update the material, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update inventory.";
        echo "</div>";
    }
}
?>

<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . "?id=:id"); ?>" method="post" >
    <div class="form-group">
        <label for="material_id" class="form-label">Material</label>
        <?php
            $statement = $material->read();
            echo "<select class='form-control' name='material_id'>";
                echo "<option>Select material...</option>";
                while ($row_material = $statement->fetch(PDO::FETCH_ASSOC)) {
                    extract($row_material);
                    $materialId = $id;
                    $materialName = $name;

                    if ($materialLocation->material_id == $materialId) {
                        echo "<option value={$materialId} selected>";
                    } else {
                        echo "<option value={$materialId}>";
                    }

                    echo "$materialName</option>";
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

                while ($row_location = $statement->fetch(PDO::FETCH_ASSOC)) {
                    extract($row_location);
                    $locationId = $id;
                    $locationName = $name;

                    if ($materialLocation->location_id == $locationId) {
                        echo "<option value={$locationId} selected>";
                    } else {
                        echo "<option value={$locationId}>";
                    }
                    echo "{$locationName} </option>";
                }

            echo "</select>";
        ?>
    </div>
    <div class="form-group">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" name="price" id="price" value=<?= $materialLocation->price ?> required>
    </div>
    <div class="form-group">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="text" class="form-control" name="quantity" id="quantity" value=<?= $materialLocation->quantity ?> required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="index.php" class="btn btn-danger">Back</a>
</form>

<?php include_once "../layouts/footer.php"; ?>