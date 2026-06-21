<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Rbac {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getPermissionsByRoleId($roleId) {
        $stmt = $this->db->prepare("
            SELECT p.permission_name 
            FROM permissions p 
            JOIN role_permissions rp ON p.permission_id = rp.permission_id 
            WHERE rp.role_id = ?
        ");
        $stmt->execute([$roleId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAllRoles() {
        $stmt = $this->db->query("SELECT * FROM roles");
        return $stmt->fetchAll();
    }

    public function getAllPermissions() {
        $stmt = $this->db->query("SELECT * FROM permissions");
        return $stmt->fetchAll();
    }

    public function getRolePermissions($roleId) {
        $stmt = $this->db->prepare("SELECT permission_id FROM role_permissions WHERE role_id = ?");
        $stmt->execute([$roleId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function updateRolePermissions($roleId, $permissionIds) {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("DELETE FROM role_permissions WHERE role_id = ?");
            $stmt->execute([$roleId]);

            if (!empty($permissionIds)) {
                $stmt = $this->db->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)");
                foreach ($permissionIds as $permId) {
                    $stmt->execute([$roleId, $permId]);
                }
            }
            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
