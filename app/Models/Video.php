<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Video {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all() {
        $sql = "SELECT v.*, t.title as tutorial_title 
                FROM videos v 
                JOIN tutorials t ON v.tutorial_id = t.tutorial_id 
                ORDER BY v.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM videos WHERE video_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO videos (tutorial_id, episode_number, title, duration_seconds, video_url, transcript) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['tutorial_id'],
            $data['episode_number'] ?: null,
            $data['title'],
            $data['duration_seconds'] ?: null,
            $data['video_url'],
            $data['transcript'] ?? null
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE videos SET tutorial_id = ?, episode_number = ?, title = ?, duration_seconds = ?, video_url = ?, transcript = ? 
                WHERE video_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['tutorial_id'],
            $data['episode_number'] ?: null,
            $data['title'],
            $data['duration_seconds'] ?: null,
            $data['video_url'],
            $data['transcript'] ?? null,
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM videos WHERE video_id = ?");
        return $stmt->execute([$id]);
    }
}
