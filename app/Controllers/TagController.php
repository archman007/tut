<?php

namespace App\Controllers;

use App\Models\Tag;

class TagController extends BaseController {
    private $tagModel;

    public function __construct() {
        parent::__construct();
        $this->requireLogin();
        $this->tagModel = new Tag();
    }

    public function index() {
        $this->requirePermission('view_dashboard');
        $tags = $this->tagModel->all();
        $this->render('tags/index', [
            'title' => 'Tags',
            'tags' => $tags
        ]);
    }

    public function create() {
        $this->requirePermission('create_content');
        $this->render('tags/create', [
            'title' => 'Add Tag'
        ]);
    }

    public function store() {
        $this->requirePermission('create_content');
        $this->tagModel->create($_POST);
        $this->redirect('/tags');
    }

    public function edit($id = null) {
        $this->requirePermission('edit_content');
        if (!$id) $this->redirect('/tags');

        $tag = $this->tagModel->find($id);
        if (!$tag) $this->redirect('/tags');

        $this->render('tags/edit', [
            'title' => 'Edit Tag',
            'tag' => $tag
        ]);
    }

    public function update() {
        $this->requirePermission('edit_content');
        $id = $_POST['tag_id'] ?? null;
        if ($id) {
            $this->tagModel->update($id, $_POST);
        }
        $this->redirect('/tags');
    }

    public function delete($id = null) {
        $this->requirePermission('delete_content');
        if ($id) {
            $tag = $this->tagModel->find($id);
            $this->render('tags/delete', [
                'title' => 'Delete Tag',
                'tag' => $tag
            ]);
        } else {
            $this->redirect('/tags');
        }
    }

    public function destroy() {
        $this->requirePermission('delete_content');
        $id = $_POST['tag_id'] ?? null;
        if ($id) {
            $this->tagModel->delete($id);
        }
        $this->redirect('/tags');
    }
}
