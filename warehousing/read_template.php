<?php
    echo "";
    echo "<form role='search' action='search.php'>";
        echo "<div class='input-group'>";
            $search_value = isset($search_term) ? "value='{$search_term}'" : "";
            echo "<input type='text' class='form-control col-md-3' placeholder='Type location name or status...' name='s' id='srch-term' {$search_value}>";
            echo "<button type='submit' class='btn btn-outline-info'>Search</button>";
            echo "
                <div class='float-end'>
                    <a href='create.php' class='btn btn-primary'>
                        Add Inventory
                    </a>
                </div>";
        echo "</div>";
    echo "</form>";

if ($total_rows > 0) {

    echo "<table class='table table-hover table-responsive table-bordered table-compact' style='margin-top:25px;'>";
        echo "<tr>";
            echo "<th>Material</th>";
            echo "<th>Category</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity</th>";
            echo "<th>Status</th>";
            echo "<th>Location</th>";
            echo "<th>Created At</th>";
            echo "<th>Updated At</th>";
            echo "<th>Actions</th>";
        echo "</tr>";

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

            extract($row);
            $check = ($status == 'Available') ? "table-success" : 'table-dark';

            echo "<tr>";
                echo "<td>{$material}</td>";
                echo "<td>{$category}</td>";
                echo "<td>{$price}</td>";
                echo "<td>{$quantity}</td>";
                echo "<td class={$check}>{$status}</td>";
                echo "<td>{$location}</td>";
                echo "<td>{$created_at}</td>";
                echo "<td>{$updated_at}</td>";
                echo "<td>";
                    // read, edit and delete buttons
                    echo "<a href='read.php?id={$id}' class='btn btn-primary left-margin'>
                    <span class='glyphicon glyphicon-list'></span> Read
                    </a>

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

    include_once '../layouts/paging.php';
}

else {
    echo "<div class='alert alert-info'>No products found.</div>";
}