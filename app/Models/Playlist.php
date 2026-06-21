<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Playlist {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM playlists ORDER BY playlist_name ASC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM playlists WHERE playlist_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO playlists (playlist_name, description) VALUES (?, ?)");
        return $stmt->execute([
            $data['playlist_name'],
            $data['description'] ?? null
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE playlists SET playlist_name = ?, description = ? WHERE playlist_id = ?");
        return $stmt->execute([
            $data['playlist_name'],
            $data['description'] ?? null,
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM playlists WHERE playlist_id = ?");
        return $stmt->execute([$id]);
    }

    public function getVideos($id) {
        $sql = "SELECT pv.*, v.title, v.video_url, v.duration_seconds, v.episode_number,
                       t.title as tutorial_title
                FROM playlist_videos pv
                JOIN videos v ON pv.video_id = v.video_id
                JOIN tutorials t ON v.tutorial_id = t.tutorial_id
                WHERE pv.playlist_id = ?
                ORDER BY pv.sequence_number ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public function addVideo($playlistId, $videoId, $sequence = null) {
        if ($sequence === null) {
            $stmt = $this->db->prepare("SELECT COALESCE(MAX(sequence_number), 0) + 1 FROM playlist_videos WHERE playlist_id = ?");
            $stmt->execute([$playlistId]);
            $sequence = $stmt->fetchColumn();
        }
        $stmt = $this->db->prepare("INSERT IGNORE INTO playlist_videos (playlist_id, video_id, sequence_number) VALUES (?, ?, ?)");
        return $stmt->execute([$playlistId, $videoId, $sequence]);
    }

    public function removeVideo($playlistId, $videoId) {
        $stmt = $this->db->prepare("DELETE FROM playlist_videos WHERE playlist_id = ? AND video_id = ?");
        return $stmt->execute([$playlistId, $videoId]);
    }

    public function getAvailableVideos($playlistId) {
        $sql = "SELECT v.*, t.title as tutorial_title
                FROM videos v
                JOIN tutorials t ON v.tutorial_id = t.tutorial_id
                WHERE v.video_id NOT IN (
                    SELECT video_id FROM playlist_videos WHERE playlist_id = ?
                )
                ORDER BY v.title ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$playlistId]);
        return $stmt->fetchAll();
    }

    public function updateSequence($playlistId, $videoId, $sequence) {
        $stmt = $this->db->prepare("UPDATE playlist_videos SET sequence_number = ? WHERE playlist_id = ? AND video_id = ?");
        return $stmt->execute([$sequence, $playlistId, $videoId]);
    }
}
