<?php

namespace app;

class Router {

  public $getRoutes = array();
  public $postRoutes = array();
  public Database $db;

  public function __construct()
  {
    $this->db = new Database();
  }


  public function get($url, $fn) {
    $this->getRoutes[$url] = $fn;
  }

  public function post($url, $fn) {
    $this->postRoutes[$url] = $fn;
  }

  public function resolve() {
    // Store the PATH inside a variable
    $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
    // Store the method
    $method = $_SERVER['REQUEST_METHOD'];
    // Get the function from get or post routes arrays
    if($method === 'GET') {
      $fn = $this->getRoutes[$currentUrl] ?? null;
    } else {
      $fn = $this->postRoutes[$currentUrl] ?? null;
    }

    if ($fn) {
      call_user_func($fn, $this);
    } else {
      // if route will not exists: page not found
      echo '404 - PAGE NOT FOUND';
    }
  }

  public function renderView($view, $params = []) {
    foreach ($params as $key => $value) {
      $$key = $value;
    }
    ob_start();
    include_once __DIR__ . "/views/{$view}.php";
    $content = ob_get_clean();
    include_once __DIR__ . "/views/_layout.php";
  }
}