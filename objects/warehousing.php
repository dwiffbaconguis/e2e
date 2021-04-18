<?php

class Warehousing
{

    public $material_id;
    public $location_id;
    public $price;
    public $quantity;
    public $status;
    public $created_at;

    private $connection;
    private $tableName = "material_location";

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function create()
    {
        $query = "INSERT INTO {$this->tableName}
                SET
                    material_id=:material_id,
                    location_id=:location_id,
                    price=:price,
                    quantity=:quantity,
                    status=:status,
                    created_at=:created_at";

        $statement = $this->connection->prepare($query);

        $this->material_id = htmlspecialchars(strip_tags($this->material_id));
        $this->location_id = htmlspecialchars(strip_tags($this->location_id));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->status = ($this->quantity != 0) ? "Available" : "Not Available";
        $this->created_at = date('Y-m-d H:i:s');

        $statement->bindParam('material_id', $this->material_id);
        $statement->bindParam('location_id', $this->location_id);
        $statement->bindParam('price', $this->price);
        $statement->bindParam('quantity', $this->quantity);
        $statement->bindParam('status', $this->status);
        $statement->bindParam('created_at', $this->created_at);

        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    public function readAll($fromRecordsNum, $recordsPerPage)
    {
        $query = "SELECT
                    id,
                    material_id,
                    location_id,
                    price,
                    quantity,
                    status,
                    created_at
                FROM {$this->tableName}
                ORDER BY created_at ASC
                LIMIT {$fromRecordsNum}, {$recordsPerPage}";

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function countAll()
    {
        $query = "SELECT id FROM {$this->tableName}";

        $statement = $this->connection->prepare( $query );
        $statement->execute();

        $num = $statement->rowCount();

        return $num;
    }

    public function readOne()
    {
        $query = "SELECT
                    id,
                    material_id,
                    location_id,
                    price,
                    quantity,
                    status,
                    created_at,
                    updated_at
                FROM
                    {$this->tableName}
                WHERE
                    id = ?
                LIMIT
                    0, 1";

        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $this->id);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->material_id = $row['material_id'];
        $this->location_id = $row['location_id'];
        $this->price = $row['price'];
        $this->quantity = $row['quantity'];
        $this->status = $row['status'];
    }
}