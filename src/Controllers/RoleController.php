<?php

namespace MVC\Controllers;

use MVC\Connection;
use MVC\Controller;
use MVC\Enum\Response;

class RoleController extends Controller
{
    public $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    /**
     * The function `addRoles` inserts a new role into the database table "roles" and returns a JSON
     * response indicating success or failure.
     */
    public function addRoles()
    {
        $data = [
            'name' => $_POST['name'],
        ];
        $this->connection->beginTransaction();
        try {
            $this->connection->query("INSERT INTO roles (name) VALUES ('". $data['name'] ."')");
            $this->connection->commit();
            $this->responseJson([], 'Data created successfully', Response::HTTP_OK()->getValue(), true);
        } catch(\Exception $err) {
            $this->connection->rollBack();
            $this->responseJson([], $err->getMessage(), Response::HTTP_SERVER_ERROR()->getValue(), false);
        }
    }

    /**
     * The function updates the name of a role in the database using the provided ID.
     */
    public function updateRoles()
    {
        $data = [
            'id' => $_POST['id'],
            'name' => $_POST['name'],
        ];
        $this->connection->beginTransaction();
        try {
            $this->connection->query("UPDATE roles SET name = '" .$data['name']. "' WHERE id = '" . $data['id'] . "'");
            $this->connection->commit();
            $this->responseJson([], 'Data updated successfully', Response::HTTP_OK()->getValue(), true);
        } catch(\Exception $err) {
            $this->connection->rollBack();
            $this->responseJson([], $err->getMessage(), Response::HTTP_SERVER_ERROR()->getValue(), false);
        }
    }

    /**
     * The function `deleteRoles()` deletes a role from the database based on the provided ID and
     * returns a JSON response indicating the success or failure of the operation.
     */
    public function deleteRoles()
    {
        $this->connection->beginTransaction();
        try {
            if (!isset($_POST['id'])) {
                $this->responseJson([], 'Undefined ID', Response::HTTP_SERVER_ERROR()->getValue(), false);
            } else {
                $data = [
                    'id' => $_POST['id'],
                ];
                $this->connection->query("DELETE FROM roles WHERE id = '". $data['id'] ."'");
                $this->connection->commit();
                $this->responseJson([], 'Data deleted successfully', Response::HTTP_OK()->getValue(), true);
            }
        } catch(\Exception $err) {
            $this->connection->rollBack();
            $this->responseJson([], $err->getMessage(), Response::HTTP_SERVER_ERROR()->getValue(), false);
        }
    }
}