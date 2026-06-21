<?php

namespace App\Controllers;

use App\Models\Playlist;

class PlaylistController extends BaseController {
    private $playlistModel;

    public function __construct() {
        parent::__construct();
        $this->requireLogin();
        $this->playlistModel = new Playlist();
    }

    public function index() {
        $this->requirePermission('view_dashboard');
        $playlists = $this->playlistModel->all();
        $this->render('playlists/index', [
            'title' => 'Playlists',
            'playlists' => $playlists
        ]);
    }

    public function create() {
        $this->requirePermission('create_content');
        $this->render('playlists/create', [
            'title' => 'Add Playlist'
        ]);
    }

    public function store() {
        $this->requirePermission('create_content');
        $this->playlistModel->create($_POST);
        $this->redirect('/playlists');
    }

    public function edit($id = null) {
        $this->requirePermission('edit_content');
        if (!$id) $this->redirect('/playlists');

        $playlist = $this->playlistModel->find($id);
        if (!$playlist) $this->redirect('/playlists');

        $this->render('playlists/edit', [
            'title' => 'Edit Playlist',
            'playlist' => $playlist
        ]);
    }

    public function update() {
        $this->requirePermission('edit_content');
        $id = $_POST['playlist_id'] ?? null;
        if ($id) {
            $this->playlistModel->update($id, $_POST);
        }
        $this->redirect('/playlists');
    }

    public function delete($id = null) {
        $this->requirePermission('delete_content');
        if ($id) {
            $playlist = $this->playlistModel->find($id);
            $this->render('playlists/delete', [
                'title' => 'Delete Playlist',
                'playlist' => $playlist
            ]);
        } else {
            $this->redirect('/playlists');
        }
    }

    public function destroy() {
        $this->requirePermission('delete_content');
        $id = $_POST['playlist_id'] ?? null;
        if ($id) {
            $this->playlistModel->delete($id);
        }
        $this->redirect('/playlists');
    }

    public function show($id = null) {
        $this->requirePermission('view_dashboard');
        if (!$id) $this->redirect('/playlists');

        $playlist = $this->playlistModel->find($id);
        if (!$playlist) $this->redirect('/playlists');

        $videos = $this->playlistModel->getVideos($id);
        $availableVideos = $this->playlistModel->getAvailableVideos($id);

        $this->render('playlists/show', [
            'title' => 'Playlist: ' . $playlist['playlist_name'],
            'playlist' => $playlist,
            'videos' => $videos,
            'availableVideos' => $availableVideos
        ]);
    }

    public function addVideo() {
        $this->requirePermission('edit_content');
        $playlistId = $_POST['playlist_id'] ?? null;
        $videoId = $_POST['video_id'] ?? null;
        if ($playlistId && $videoId) {
            $this->playlistModel->addVideo($playlistId, $videoId);
        }
        $this->redirect('/playlists/show/' . $playlistId);
    }

    public function removeVideo() {
        $this->requirePermission('edit_content');
        $playlistId = $_POST['playlist_id'] ?? null;
        $videoId = $_POST['video_id'] ?? null;
        if ($playlistId && $videoId) {
            $this->playlistModel->removeVideo($playlistId, $videoId);
        }
        $this->redirect('/playlists/show/' . $playlistId);
    }
}
