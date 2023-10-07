<?php

namespace MVC\Models;

use MVC\Connection;

class Role extends Connection
{
    public $id, $name, $created_at, $updated_at;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllData()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function setName($name)
    {
        return $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}