<?php

namespace App\Controllers;

use App\Models\Video;
use App\Models\Tutorial;

class VideoController extends BaseController {
    private $videoModel;
    private $tutorialModel;

    public function __construct() {
        parent::__construct();
        $this->requireLogin();
        $this->videoModel = new Video();
        $this->tutorialModel = new Tutorial();
    }

    public function index() {
        $this->requirePermission('view_dashboard');
        $videos = $this->videoModel->all();
        $this->render('videos/index', [
            'title' => 'Videos',
            'videos' => $videos
        ]);
    }

    public function create() {
        $this->requirePermission('create_content');
        $tutorials = $this->tutorialModel->all();
        $this->render('videos/create', [
            'title' => 'Add Video',
            'tutorials' => $tutorials
        ]);
    }

    public function store() {
        $this->requirePermission('create_content');
        $this->videoModel->create($_POST);
        $this->redirect('/videos');
    }

    public function edit($id = null) {
        $this->requirePermission('edit_content');
        if (!$id) $this->redirect('/videos');

        $video = $this->videoModel->find($id);
        if (!$video) $this->redirect('/videos');

        $tutorials = $this->tutorialModel->all();

        $this->render('videos/edit', [
            'title' => 'Edit Video',
            'video' => $video,
            'tutorials' => $tutorials
        ]);
    }

    public function update() {
        $this->requirePermission('edit_content');
        $id = $_POST['video_id'] ?? null;
        if ($id) {
            $this->videoModel->update($id, $_POST);
        }
        $this->redirect('/videos');
    }

    public function delete($id = null) {
        $this->requirePermission('delete_content');
        if ($id) {
            $video = $this->videoModel->find($id);
            $this->render('videos/delete', [
                'title' => 'Delete Video',
                'video' => $video
            ]);
        } else {
            $this->redirect('/videos');
        }
    }

    public function destroy() {
        $this->requirePermission('delete_content');
        $id = $_POST['video_id'] ?? null;
        if ($id) {
            $this->videoModel->delete($id);
        }
        $this->redirect('/videos');
    }
}
