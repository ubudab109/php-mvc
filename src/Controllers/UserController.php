<?php

namespace MVC\Controllers;

use MVC\Connection;
use MVC\Controller;
use MVC\Enum\Response;
use MVC\Models\Role;
use MVC\Models\User;

class UserController extends Controller
{
    public $connection;

    /**
     * The function creates a new instance of the Connection class and assigns it to the 
     * property.
     */
    public function __construct()
    {
        $this->connection = new Connection();
    }

    /**
     * The index function retrieves data from the users and roles tables, creates User and Role
     * objects, and returns the data to be rendered in the user/index view.
     */
    public function index()
    {
        $query = $this->connection->query("SELECT * FROM users");
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $user = new User();
            $user->id = $row['id'];
            $user->name = $row['name'];
            $userRole = [];
            $queryRoleUser = $this->connection->query("SELECT users.name, role.name AS role_name, role.id AS role_id FROM user_has_roles AS uhr
            LEFT JOIN users ON users.id = uhr.user_id
            LEFT JOIN roles AS role ON role.id = uhr.role_id WHERE uhr.user_id = " . $row['id'] . "");
            while ($rowUserRole = mysqli_fetch_assoc($queryRoleUser)) {
                $userRole[] = [
                    'id' => $rowUserRole['role_id'],
                    'name' => $rowUserRole['role_name']
                ];
            }
            $user->roles = $userRole;
            $data[] = $user->getAllData();
        }

        $queryRole = $this->connection->query("SELECT * FROM roles");
        $roleData = [];
        while ($rowRole = mysqli_fetch_assoc($queryRole)) {
            $role = new Role();
            $role->id = $rowRole['id'];
            $role->name = $rowRole['name'];
            $roleData[] = $role->getAllData();
        }
        // $this->responseJson($data, 'true', 200, true);
        $this->render('user/index', ['users' => $data, 'roles' => $roleData]);
    }

    /**
     * The `detailUser()` function retrieves user details and their associated roles from the database
     * and renders them in a view.
     */
    public function detailUser()
    {
        $query = $this->connection->query("SELECT * FROM users WHERE id = '" . $_GET['id'] . "'");
        $data = [];
        $row = mysqli_fetch_assoc($query);
        $user = new User();
        $user->id = $row['id'];
        $user->name = $row['name'];
        $userRole = [];
        $queryRoleUser = $this->connection->query("SELECT users.name, role.name AS role_name, role.id AS role_id FROM user_has_roles AS uhr
            LEFT JOIN users ON users.id = uhr.user_id
            LEFT JOIN roles AS role ON role.id = uhr.role_id WHERE uhr.user_id = " . $row['id'] . "");
        while ($rowUserRole = mysqli_fetch_assoc($queryRoleUser)) {
            $userRole[] = [
                'id' => $rowUserRole['role_id'],
                'name' => $rowUserRole['role_name']
            ];
        }
        $user->roles = $userRole;
        $data[] = $user->getAllData();
        $roles = $this->getRoleDataset($_GET['id']);

        $this->render('user/detail-users', ['users' => $data[0], 'roles' => $roles]);
    }

    /**
     * The function "createUser" renders a view for creating users and passes an array of roles to the
     * view.
     */
    public function createUser()
    {
        $roles = $this->getRoleDataset();
        $this->render('user/create-users', ['roles' => $roles]);
    }

    /**
     * The function `getRoleDataset` retrieves role data from the database based on the provided user
     * ID, or returns all roles if no user ID is provided.
     * 
     * @param int $userId The `userId` parameter is an optional parameter that represents the ID of a user.
     * If a `userId` is provided, the function will retrieve the roles associated with that specific
     * user. If no `userId` is provided, the function will retrieve all roles from the database.
     * 
     * @return aray array of role data.
     */
    private function getRoleDataset($userId = null)
    {
        $roles = [];
        if (!is_null($userId)) {
            $roleData = $this->connection->query(
                "SELECT roles.id, roles.name, uhr.user_id as user_id 
                FROM roles LEFT OUTER JOIN user_has_roles as uhr ON uhr.role_id = roles.id"
            );
            while ($rowRole = mysqli_fetch_assoc($roleData)) {
                if (is_null($rowRole['user_id']) || $rowRole['user_id'] == $userId) {
                    $roles[] = $rowRole;
                }
            }
        } else {
            $roleData = $this->connection->query("SELECT * FROM roles");
            while($rowRole = mysqli_fetch_assoc($roleData)) {
                $roles[] = $rowRole;
            }
        }
        return $roles;
    }

    /**
     * The deleteUser function deletes a user from the database based on the provided ID and returns a
     * JSON response indicating the success or failure of the operation.
     */
    public function deleteUser()
    {
        $this->connection->beginTransaction();
        try {
            if (!isset($_POST['id'])) {
                $this->responseJson([], 'Undefined ID', Response::HTTP_SERVER_ERROR()->getValue(), false);
            } else {
                $data = [
                    'id' => $_POST['id'],
                ];
                $this->connection->query("DELETE FROM users WHERE id = '" . $data['id'] . "'");
                $this->connection->commit();
                $this->responseJson([], 'Data deleted successfully', Response::HTTP_OK()->getValue(), true);
            }
        } catch (\Exception $err) {
            $this->connection->rollBack();
            $this->responseJson([], $err->getMessage(), Response::HTTP_SERVER_ERROR()->getValue(), false);
        }
    }

    /**
     * The function `updateUser()` updates a user's name and roles in a database transaction, removing
     * all existing roles and inserting new ones.
     */
    public function updateUser()
    {
        $this->connection->beginTransaction();
        try {
            $data = [
                'id'    => $_POST['id'],
                'name'  => $_POST['name'],
                'roles' => $_POST['roles'],
            ];

            // We need to remove all roles first
            $this->connection->query("DELETE FROM user_has_roles WHERE user_id = '" . $data['id'] . "'");

            // Update user
            $this->connection->query("UPDATE users SET name = '". $data['name'] ."' WHERE id=". $data['id']. "");

            // insert roles user
            foreach($data['roles'] as $role) {
                $this->connection->query("INSERT INTO user_has_roles (user_id, role_id) VALUES('" . $data['id'] . "', '" . $role . "')");
            }
            $this->connection->commit();
            $this->responseJson([], 'Data updated successfully', Response::HTTP_OK()->getValue(), false);
        } catch (\Exception $err) {
            $this->connection->rollBack();
            $this->responseJson([], $err->getMessage(), Response::HTTP_SERVER_ERROR()->getValue(), false);
        }
    }

    /**
     * The function `addUser` inserts a new user into the database along with their assigned roles, and
     * handles any errors that may occur during the process.
     */
    public function addUser()
    {
        $this->connection->beginTransaction();
        try {
            $data = [
                'name'  => $_POST['name'],
                'roles' => $_POST['roles'],
            ];

            // INSERT USER
            $this->connection->query("INSERT INTO users SET name = '". $data['name'] ."'");
            $userId = mysqli_insert_id($this->connection->getConnectionInstance());
            // insert roles user
            foreach($data['roles'] as $role) {
                $this->connection->query("INSERT INTO user_has_roles (user_id, role_id) VALUES('" . $userId . "', '" . $role . "')");
            }
            $this->connection->commit();
            $this->responseJson([], 'Data created successfully', Response::HTTP_OK()->getValue(), false);
        } catch (\Exception $err) {
            $this->connection->rollBack();
            $this->responseJson([], $err->getMessage(), Response::HTTP_SERVER_ERROR()->getValue(), false);
        }
    }
}
