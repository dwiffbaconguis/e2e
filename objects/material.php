<?php

class Material
{
    public $id;
    public $name;
    public $barcode;
    public $description;
    public $category_id;
    public $created_at;

    private $connection;
    private $tableName = "materials";

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function create()
    {
        $query = "INSERT INTO {$this->tableName}
                SET
                    name=:name,
                    barcode=:barcode,
                    description=:description,
                    category_id=:category_id,
                    created_at=:created_at";

        $statement = $this->connection->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->barcode = htmlspecialchars(strip_tags($this->barcode));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->created_at = date('Y-m-d H:i:s');

        $statement->bindParam(":name", $this->name);
        $statement->bindParam(":barcode", $this->barcode);
        $statement->bindParam(":description", $this->description);
        $statement->bindParam(":category_id", $this->category_id);
        $statement->bindParam(":created_at", $this->created_at);

        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    public function read()
    {
        $query = "SELECT
                    id,
                    name,
                    barcode,
                    description,
                    category_id,
                    created_at
                FROM {$this->tableName}
                ORDER BY name ASC";

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function readAll($fromRecordsNum, $recordsPerPage)
    {
        $query = "SELECT
                    id,
                    name,
                    barcode,
                    description,
                    category_id,
                    created_at
                FROM {$this->tableName}
                ORDER BY name ASC
                LIMIT {$fromRecordsNum}, {$recordsPerPage}";

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function readName()
    {
        $query = "SELECT name FROM {$this->tableName} WHERE id = ? limit 0,1";

        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $this->id);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->name = $row["name"];
    }
}