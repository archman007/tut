<?php

namespace App\Controllers;

class DashboardController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->requireLogin();
    }

    public function index() {
        $this->requirePermission('view_dashboard');
        $this->render('dashboard', [
            'title' => 'Tutorial Library Dashboard'
        ]);
    }
}
