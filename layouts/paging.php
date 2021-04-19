<?php
echo "<ul class=\"pagination\">";

// button for first page
if ($page > 1) {
    echo "<li><a href='{$page_url}' title='Go to the first page.'>";
        echo "First Page";
    echo "</a></li>";
}

// count all products in the database to calculate total pages
$total_pages = ceil($total_rows / $recordsPerPage);

// range of links to show
$range = 2;

// display links to 'range of pages' around 'current page'
$initial_num = $page - $range;
$condition_limit_num = ($page + $range)  + 1;

for ($num = $initial_num; $num < $condition_limit_num; $num++) {

    // be sure '$num is greater than 0' AND 'less than or equal to the $total_pages'
    if (($num > 0) && ($num <= $total_pages)) {

        // current page
        if ($num == $page) {
            echo "<li class='active'><a href=\"#\">$num <span class=\"sr-only\">(current)</span></a></li>";
        }

        // not current page
        else {
            echo "<li><a href='{$page_url}page=$num'>$num</a></li>";
        }
    }
}

// button for last page
if ($page < $total_pages) {
    echo "<li><a href='" .$page_url . "page={$total_pages}' title='Last page is {$total_pages}.'>";
        echo "Last Page";
    echo "</a></li>";
}

echo "</ul>";
?>