<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends BaseController {
    private $categoryModel;

    public function __construct() {
        parent::__construct();
        $this->requireLogin();
        $this->categoryModel = new Category();
    }

    public function index() {
        $this->requirePermission('view_dashboard');
        $categories = $this->categoryModel->all();
        $this->render('categories/index', [
            'title' => 'Categories',
            'categories' => $categories
        ]);
    }

    public function create() {
        $this->requirePermission('create_content');
        $this->render('categories/create', [
            'title' => 'Add Category'
        ]);
    }

    public function store() {
        $this->requirePermission('create_content');
        $this->categoryModel->create($_POST);
        $this->redirect('/categories');
    }

    public function edit($id = null) {
        $this->requirePermission('edit_content');
        if (!$id) $this->redirect('/categories');

        $category = $this->categoryModel->find($id);
        if (!$category) $this->redirect('/categories');

        $this->render('categories/edit', [
            'title' => 'Edit Category',
            'category' => $category
        ]);
    }

    public function update() {
        $this->requirePermission('edit_content');
        $id = $_POST['category_id'] ?? null;
        if ($id) {
            $this->categoryModel->update($id, $_POST);
        }
        $this->redirect('/categories');
    }

    public function delete($id = null) {
        $this->requirePermission('delete_content');
        if ($id) {
            $category = $this->categoryModel->find($id);
            $this->render('categories/delete', [
                'title' => 'Delete Category',
                'category' => $category
            ]);
        } else {
            $this->redirect('/categories');
        }
    }

    public function destroy() {
        $this->requirePermission('delete_content');
        $id = $_POST['category_id'] ?? null;
        if ($id) {
            $this->categoryModel->delete($id);
        }
        $this->redirect('/categories');
    }
}
