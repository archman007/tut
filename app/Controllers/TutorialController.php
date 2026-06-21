<?php

namespace App\Controllers;

use App\Models\Tutorial;
use App\Models\Instructor;
use App\Models\Category;

class TutorialController extends BaseController {
    private $tutorialModel;
    private $instructorModel;
    private $categoryModel;

    public function __construct() {
        parent::__construct();
        $this->requireLogin();
        $this->tutorialModel = new Tutorial();
        $this->instructorModel = new Instructor();
        $this->categoryModel = new Category();
    }

    public function index() {
        $this->requirePermission('view_dashboard');
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
        $offset = ($page - 1) * $limit;
        
        $orderBy = $_GET['sort'] ?? 'publish_date';
        $orderDir = $_GET['dir'] ?? 'ASC';
        $search = $_GET['search'] ?? '';

        $tutorials = $this->tutorialModel->all($limit, $offset, $orderBy, $orderDir, $search);
        $totalTutorials = $this->tutorialModel->count($search);
        $totalPages = ceil($totalTutorials / $limit);

        $this->render('tutorials/index', [
            'title' => 'Tutorials',
            'tutorials' => $tutorials,
            'page' => $page,
            'limit' => $limit,
            'totalPages' => $totalPages,
            'sort' => $orderBy,
            'dir' => $orderDir,
            'search' => $search
        ]);
    }

    public function create() {
        $this->requirePermission('create_content');
        $instructors = $this->instructorModel->all();
        $categories = $this->categoryModel->all();
        $this->render('tutorials/create', [
            'title' => 'Add Tutorial',
            'instructors' => $instructors,
            'categories' => $categories
        ]);
    }

    public function store() {
        $this->requirePermission('create_content');
        $this->tutorialModel->create($_POST);
        $this->redirect('/tutorials');
    }

    public function edit($id = null) {
        $this->requirePermission('edit_content');
        if (!$id) $this->redirect('/tutorials');

        $tutorial = $this->tutorialModel->find($id);
        if (!$tutorial) $this->redirect('/tutorials');

        $instructors = $this->instructorModel->all();
        $categories = $this->categoryModel->all();

        $this->render('tutorials/edit', [
            'title' => 'Edit Tutorial',
            'tutorial' => $tutorial,
            'instructors' => $instructors,
            'categories' => $categories
        ]);
    }

    public function update() {
        $this->requirePermission('edit_content');
        $id = $_POST['tutorial_id'] ?? null;
        if ($id) {
            $this->tutorialModel->update($id, $_POST);
        }
        $this->redirect('/tutorials');
    }

    public function delete($id = null) {
        $this->requirePermission('delete_content');
        if ($id) {
            $tutorial = $this->tutorialModel->find($id);
            $this->render('tutorials/delete', [
                'title' => 'Delete Tutorial',
                'tutorial' => $tutorial
            ]);
        } else {
            $this->redirect('/tutorials');
        }
    }

    public function destroy() {
        $this->requirePermission('delete_content');
        $id = $_POST['tutorial_id'] ?? null;
        if ($id) {
            $this->tutorialModel->delete($id);
        }
        $this->redirect('/tutorials');
    }

    private function findAuthorInJson($data) {
        if (!is_array($data)) return null;
        if (isset($data['author'])) {
            $author = $data['author'];
            if (is_string($author)) return $author;
            if (is_array($author)) {
                if (isset($author['name'])) return $author['name'];
                if (isset($author[0]['name'])) return $author[0]['name'];
            }
        }
        foreach ($data as $value) {
            if (is_array($value)) {
                $res = $this->findAuthorInJson($value);
                if ($res) return $res;
            }
        }
        return null;
    }

    public function fetchMetadata() {
        header('Content-Type: application/json');
        $url = $_GET['url'] ?? '';

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            echo json_encode(['error' => 'Invalid URL: ' . $url]);
            exit;
        }

        if (!ini_get('allow_url_fopen')) {
            echo json_encode(['error' => 'allow_url_fopen is disabled on this server.']);
            exit;
        }

        try {
            $context = stream_context_create([
                'http' => [
                    'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n",
                    'timeout' => 15,
                    'follow_location' => 1
                ]
            ]);

            $html = @file_get_contents($url, false, $context);
            if ($html === false) {
                $error = error_get_last();
                echo json_encode(['error' => 'Could not fetch content. ' . ($error['message'] ?? '')]);
                exit;
            }

            $doc = new \DOMDocument();
            @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
            $xpath = new \DOMXPath($doc);

            $data = [
                'title' => '',
                'description' => '',
                'source_url' => $url,
                'thumbnail_url' => '',
                'publish_date' => '',
                'duration_minutes' => '',
                'instructor_id' => null,
                'author_name' => ''
            ];

            // 1. Get Title
            $titleNode = $xpath->query('//title');
            if ($titleNode->length > 0) {
                $data['title'] = trim($titleNode->item(0)->nodeValue);
            }

            // 2. Get Description
            $descNode = $xpath->query('//meta[@name="description"]/@content | //meta[@property="og:description"]/@content');
            if ($descNode->length > 0) {
                $data['description'] = trim($descNode->item(0)->nodeValue);
            }

            // 3. Get Thumbnail
            $thumbNode = $xpath->query('//meta[@property="og:image"]/@content | //meta[@name="twitter:image"]/@content');
            if ($thumbNode->length > 0) {
                $data['thumbnail_url'] = trim($thumbNode->item(0)->nodeValue);
            }

            // 4. Get Author (The complex part)
            $authorName = '';
            
            // A. Try JSON-LD (Modern standard)
            $jsonLdNodes = $xpath->query('//script[@type="application/ld+json"]');
            foreach ($jsonLdNodes as $node) {
                $json = json_decode($node->nodeValue, true);
                $found = $this->findAuthorInJson($json);
                if ($found) {
                    $authorName = $found;
                    break;
                }
            }

            // B. Try Meta Tags & Microdata
            if (empty($authorName)) {
                $authorNodes = $xpath->query('
                    //meta[@name="author"]/@content | 
                    //meta[@property="article:author"]/@content | 
                    //meta[@name="twitter:creator"]/@content | 
                    //meta[@property="og:author"]/@content |
                    //*[@itemprop="author"]/@content |
                    //*[@itemprop="author"]//text() |
                    //*[@rel="author"]//text() |
                    //*[contains(@class, "author")]//text()
                ');
                foreach ($authorNodes as $node) {
                    $potential = trim($node->nodeValue);
                    $potential = preg_replace('/^(By|Written by|Posted by|Author:)\s+/i', '', $potential);
                    if (!empty($potential) && strlen($potential) < 80 && !filter_var($potential, FILTER_VALIDATE_URL)) {
                        $authorName = $potential;
                        break;
                    }
                }
            }

            // C. Regex Fallback (Last resort)
            if (empty($authorName)) {
                if (preg_match('/"author":\s*\{[^\}]*"name":\s*"([^"]+)"/', $html, $matches)) {
                    $authorName = $matches[1];
                }
            }

            if (!empty($authorName)) {
                $authorName = preg_replace('/^@/', '', $authorName); // Clean twitter handles
                $data['author_name'] = $authorName;
                
                // Attempt matching
                $instructors = $this->instructorModel->all();
                $foundInst = false;
                $searchName = mb_strtolower($authorName);
                
                foreach ($instructors as $inst) {
                    $fName = mb_strtolower($inst['first_name']);
                    $lName = mb_strtolower($inst['last_name']);
                    if (strpos($searchName, $fName) !== false && strpos($searchName, $lName) !== false) {
                        $data['instructor_id'] = $inst['instructor_id'];
                        $foundInst = true;
                        break;
                    }
                }

                if (!$foundInst) {
                    $parts = explode(' ', $authorName);
                    $lastName = count($parts) > 1 ? array_pop($parts) : ' (Extracted)';
                    $firstName = !empty($parts) ? implode(' ', $parts) : $authorName;
                    
                    $this->instructorModel->create([
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'email' => null,
                        'website' => null
                    ]);
                    $data['instructor_id'] = \App\Config\Database::getInstance()->getConnection()->lastInsertId();
                }
            }

            // 5. Get Publish Date
            $dateNode = $xpath->query('//meta[@property="article:published_time"]/@content | //meta[@name="publish_date"]/@content | //meta[@itemprop="datePublished"]/@content');
            if ($dateNode->length > 0) {
                $rawDate = trim($dateNode->item(0)->nodeValue);
                $data['publish_date'] = date('Y-m-d', strtotime($rawDate));
            }

            // 6. Get Duration
            $durationNode = $xpath->query('//meta[@property="video:duration"]/@content | //meta[@itemprop="duration"]/@content');
            if ($durationNode->length > 0) {
                $rawDuration = trim($durationNode->item(0)->nodeValue);
                if (is_numeric($rawDuration)) {
                    $data['duration_minutes'] = ceil($rawDuration / 60);
                } elseif (strpos($rawDuration, 'PT') === 0) {
                    try {
                        $interval = new \DateInterval($rawDuration);
                        $data['duration_minutes'] = ($interval->h * 60) + $interval->i + ceil($interval->s / 60);
                    } catch (\Exception $e) {}
                }
            }

            echo json_encode($data);
        } catch (\Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }
}
