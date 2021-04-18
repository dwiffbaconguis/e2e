<?php

class Category
{
    public $id;
    public $name;

    private $connection;
    private $tableName = "categories";

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function read()
    {
        $query = "SELECT id, name FROM {$this->tableName} ORDER BY name";

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

    public function readAll($fromRecordsNum, $recordsPerPage)
    {
        $query = "SELECT
                    id,
                    name
                FROM {$this->tableName}
                ORDER BY name ASC
                LIMIT {$fromRecordsNum}, {$recordsPerPage}";

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function readOne()
    {
        $query = "SELECT
                    id,
                    name
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
    }

    public function countAll()
    {
        $query = "SELECT id FROM {$this->tableName}";

        $statement = $this->connection->prepare( $query );
        $statement->execute();

        $num = $statement->rowCount();

        return $num;
    }

    public function create()
    {
        $this->name = htmlspecialchars(strip_tags($this->name));

        $query = "INSERT INTO
                    {$this->tableName}
                SET
                    name=:name";

        $statement = $this->connection->prepare($query);
        $statement->bindParam(":name", $this->name);

        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    public function update()
    {
        $query = "UPDATE
                    {$this->tableName}
                SET
                    name=:name
                WHERE
                    id = :id";

        $statement = $this->connection->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind parameters
        $statement->bindParam(":name", $this->name);
        $statement->bindParam(":id", $this->id);

        // execute the query
        if($statement->execute()){
            return true;
        }

        return false;
    }

    public function delete()
    {
        $query = "DELETE
                FROM
                    {$this->tableName}
                WHERE
                    id = ?";

        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $this->id);

        if ($statement->execute()) {
            return true;
        }

        return false;
    }
}