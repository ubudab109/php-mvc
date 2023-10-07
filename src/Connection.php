<?php

namespace MVC;

use mysqli;

class Connection
{
    protected $host, $user, $pass, $name, $port, $con;

    public function __construct()
    {
        $this->host = DBHOST;
        $this->user = DBUSER;
        $this->pass = DBPASS;
        $this->name = DBNAME;
        $this->port = DBPORT;
        $this->con = new mysqli($this->host, $this->user, $this->pass, $this->name, $this->port);
    }
    
    public function getConnectionInstance()
    {
        return $this->con;
    }
    
    /**
     * The query function executes a given SQL query and returns the result.
     * 
     * @param mixed $query The query parameter is a string that represents the SQL query that you want
     * to execute. It can be any valid SQL statement such as SELECT, INSERT, UPDATE, DELETE, etc.
     * 
     */
    public function query(mixed $query)
    {
        return $this->con->query($query);
    }

    public function beginTransaction()
    {
        return $this->con->begin_transaction();
    }

    public function commit()
    {
        return $this->con->commit();
    }

    public function rollBack()
    {
        return $this->con->rollback();
    }
}