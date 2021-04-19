<?php

include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/material.php';
include_once '../objects/location.php';
include_once '../objects/category.php';
include_once '../objects/materialLocation.php';

$db = (new Database())->getConnection();

$material = new Material($db);
$location = new Location($db);
$materialLocation = new MaterialLocation($db);
$category = new Category($db);

$page_title = "Inventory Report";
include_once "../layouts/header.php";

$statement = $materialLocation->readAllV2($fromRecordNum, $recordsPerPage);

$pageUrl = "index.php?";

$total_rows = $materialLocation->countAll();

include_once "read_template.php";

include_once "../layouts/footer.php";
?>