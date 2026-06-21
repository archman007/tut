<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Rbac;

class AdminController extends BaseController {
    private $userModel;
    private $rbacModel;

    public function __construct() {
        parent::__construct();
        $this->requirePermission('manage_users');
        $this->userModel = new User();
        $this->rbacModel = new Rbac();
    }

    public function index() {
        $usersCount = count($this->userModel->all());
        $rolesCount = count($this->rbacModel->getAllRoles());
        
        $this->render('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'usersCount' => $usersCount,
            'rolesCount' => $rolesCount
        ]);
    }

    public function users() {
        $users = $this->userModel->all();
        $this->render('admin/users/index', [
            'title' => 'User Management',
            'users' => $users
        ]);
    }

    public function userCreate() {
        $roles = $this->rbacModel->getAllRoles();
        $this->render('admin/users/create', [
            'title' => 'Add User',
            'roles' => $roles
        ]);
    }

    public function userStore() {
        $this->userModel->create($_POST);
        $this->redirect('/admin/users');
    }

    public function userEdit($id = null) {
        if (!$id) $this->redirect('/admin/users');

        $user = $this->userModel->find($id);
        $roles = $this->rbacModel->getAllRoles();

        $this->render('admin/users/edit', [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function userUpdate() {
        $id = $_POST['user_id'] ?? null;
        if ($id) {
            $this->userModel->update($id, $_POST);
        }
        $this->redirect('/admin/users');
    }

    public function userDelete($id = null) {
        if ($id) {
            $user = $this->userModel->find($id);
            $this->render('admin/users/delete', [
                'title' => 'Delete User',
                'user' => $user
            ]);
        } else {
            $this->redirect('/admin/users');
        }
    }

    public function userDestroy() {
        $id = $_POST['user_id'] ?? null;
        if ($id) {
            $this->userModel->delete($id);
        }
        $this->redirect('/admin/users');
    }

    public function roles() {
        $roles = $this->rbacModel->getAllRoles();
        $permissions = $this->rbacModel->getAllPermissions();
        
        $rolePermissions = [];
        foreach ($roles as $role) {
            $rolePermissions[$role['role_id']] = $this->rbacModel->getRolePermissions($role['role_id']);
        }

        $this->render('admin/roles/index', [
            'title' => 'Role & Permission Management',
            'roles' => $roles,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function rolesUpdate() {
        $rolesData = $_POST['roles'] ?? [];
        foreach ($rolesData as $roleId => $permissionIds) {
            $this->rbacModel->updateRolePermissions($roleId, $permissionIds);
        }
        $_SESSION['success'] = "Permissions updated successfully.";
        $this->redirect('/admin/roles');
    }
}
