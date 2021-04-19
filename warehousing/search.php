<?php
// core.php holds pagination variables
include_once '../config/core.php';

// include database and object files
include_once '../config/database.php';
include_once '../objects/materialLocation.php';

// instantiate database and product object
$db = (new Database())->getConnection();

$materialLocation = new MaterialLocation($db);

// get search term
$search_term=isset($_GET['s']) ? $_GET['s'] : '';

$page_title = "You searched for \"{$search_term}\"";
include_once "../layouts/header.php";

// query materialLocations
$statement = $materialLocation->search($search_term, $fromRecordNum, $recordsPerPage);

// specify the page where paging is used
$page_url = "search.php?s={$search_term}&";

// count total rows - used for pagination
$total_rows = $materialLocation->countAll_BySearch($search_term);

// read_template.php controls how the materialLocation list will be rendered
include_once "read_template.php";

// layout_footer.php holds our javascript and closing html tags
include_once "../layouts/footer.php";
?>