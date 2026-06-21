<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Tutorial {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all($limit = 10, $offset = 0, $orderBy = 'publish_date', $orderDir = 'ASC', $search = '') {
        $allowedColumns = ['tutorial_id', 'title', 'difficulty', 'publish_date'];
        $orderBy = in_array($orderBy, $allowedColumns) ? $orderBy : 'publish_date';
        $orderDir = strtoupper($orderDir) === 'ASC' ? 'ASC' : 'DESC';

        $where = $search ? "WHERE t.title LIKE :search" : "";
        $sql = "SELECT t.*, i.first_name, i.last_name, c.category_name 
                FROM tutorials t 
                LEFT JOIN instructors i ON t.instructor_id = i.instructor_id 
                LEFT JOIN categories c ON t.category_id = c.category_id 
                $where
                ORDER BY $orderBy $orderDir 
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        if ($search) $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function count($search = '') {
        $sql = "SELECT COUNT(*) FROM tutorials t";
        if ($search) $sql .= " WHERE t.title LIKE :search";
        $stmt = $this->db->prepare($sql);
        if ($search) $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM tutorials WHERE tutorial_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO tutorials (title, description, instructor_id, category_id, difficulty, language, duration_minutes, publish_date, thumbnail_url, source_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['title'],
            $data['description'] ?? null,
            $data['instructor_id'] ?: null,
            $data['category_id'] ?: null,
            $data['difficulty'] ?? 'Beginner',
            $data['language'] ?? 'English',
            $data['duration_minutes'] ?: null,
            $data['publish_date'] ?: null,
            $data['thumbnail_url'] ?? null,
            $data['source_url'] ?? null
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE tutorials SET title = ?, description = ?, instructor_id = ?, category_id = ?, difficulty = ?, language = ?, duration_minutes = ?, publish_date = ?, thumbnail_url = ?, source_url = ? 
                WHERE tutorial_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['title'],
            $data['description'] ?? null,
            $data['instructor_id'] ?: null,
            $data['category_id'] ?: null,
            $data['difficulty'] ?? 'Beginner',
            $data['language'] ?? 'English',
            $data['duration_minutes'] ?: null,
            $data['publish_date'] ?: null,
            $data['thumbnail_url'] ?? null,
            $data['source_url'] ?? null,
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tutorials WHERE tutorial_id = ?");
        return $stmt->execute([$id]);
    }
}
