<?php

class Location
{
    private $connection;
    private $tableName = 'locations';

    public $id;
    public $name;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function read()
    {
        $query = "SELECT id, name from locations";

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