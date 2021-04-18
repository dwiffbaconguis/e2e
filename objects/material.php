<?php

class Material
{
    public $id;
    public $name;
    public $barcode;
    public $description;
    public $category_id;
    public $created_at;
    public $updated_at;

    private $connection;
    private $tableName = "materials";

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function create()
    {
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->barcode = htmlspecialchars(strip_tags($this->barcode));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->created_at = date('Y-m-d H:i:s');

        $query = "INSERT INTO {$this->tableName}
                SET
                    name=:name,
                    barcode=:barcode,
                    description=:description,
                    category_id=:category_id,
                    created_at=:created_at";

        $statement = $this->connection->prepare($query);

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
                    created_at,
                    updated_at
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
                    created_at,
                    updated_at
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
                    name,
                    barcode,
                    description,
                    category_id,
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

        $this->name = $row['name'];
        $this->barcode = $row['barcode'];
        $this->description = $row['description'];
        $this->category_id = $row['category_id'];
        $this->created_at = $row['created_at'];
        $this->updated_at = $row['updated_at'];
    }

    public function update()
    {
        $query = "UPDATE
                    {$this->tableName}
                SET
                    name=:name,
                    barcode=:barcode,
                    description=:description,
                    category_id=:category_id,
                    updated_at=:updated_at
                WHERE
                    id = :id";

        $statement = $this->connection->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->barcode = htmlspecialchars(strip_tags($this->barcode));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->updated_at = $this->created_at = date('Y-m-d H:i:s');
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind parameters
        $statement->bindParam(":name", $this->name);
        $statement->bindParam(":barcode", $this->barcode);
        $statement->bindParam(":description", $this->description);
        $statement->bindParam(":category_id", $this->category_id);
        $statement->bindParam(":updated_at", $this->updated_at);
        $statement->bindParam(":id", $this->id);

        // execute the query
        if($statement->execute()){
            return true;
        }

        return false;
    }
}