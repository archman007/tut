<?php

namespace App\Controllers;

use App\Models\Instructor;

class InstructorController extends BaseController {
    private $instructorModel;

    public function __construct() {
        parent::__construct();
        $this->requireLogin();
        $this->instructorModel = new Instructor();
    }

    public function index() {
        $this->requirePermission('view_dashboard');
        $instructors = $this->instructorModel->all();
        $this->render('instructors/index', [
            'title' => 'Instructors',
            'instructors' => $instructors
        ]);
    }

    public function create() {
        $this->requirePermission('create_content');
        $this->render('instructors/create', [
            'title' => 'Add Instructor'
        ]);
    }

    public function store() {
        $this->requirePermission('create_content');
        $this->instructorModel->create($_POST);
        $this->redirect('/instructors');
    }

    public function edit($id = null) {
        $this->requirePermission('edit_content');
        if (!$id) $this->redirect('/instructors');

        $instructor = $this->instructorModel->find($id);
        if (!$instructor) $this->redirect('/instructors');

        $this->render('instructors/edit', [
            'title' => 'Edit Instructor',
            'instructor' => $instructor
        ]);
    }

    public function update() {
        $this->requirePermission('edit_content');
        $id = $_POST['instructor_id'] ?? null;
        if ($id) {
            $this->instructorModel->update($id, $_POST);
        }
        $this->redirect('/instructors');
    }

    public function delete($id = null) {
        $this->requirePermission('delete_content');
        if ($id) {
            $instructor = $this->instructorModel->find($id);
            $this->render('instructors/delete', [
                'title' => 'Delete Instructor',
                'instructor' => $instructor
            ]);
        } else {
            $this->redirect('/instructors');
        }
    }

    public function destroy() {
        $this->requirePermission('delete_content');
        $id = $_POST['instructor_id'] ?? null;
        if ($id) {
            $this->instructorModel->delete($id);
        }
        $this->redirect('/instructors');
    }
}
