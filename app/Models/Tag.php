<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Tag {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM tags ORDER BY tag_name ASC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM tags WHERE tag_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO tags (tag_name) VALUES (?)");
        return $stmt->execute([$data['tag_name']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE tags SET tag_name = ? WHERE tag_id = ?");
        return $stmt->execute([$data['tag_name'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tags WHERE tag_id = ?");
        return $stmt->execute([$id]);
    }
}
