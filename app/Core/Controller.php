<?php
class Controller {
    public function view($view, $data = []) {
        $base = dirname(dirname(__DIR__));
        if (file_exists($base . '/views/' . $view . '.php')) {
            require_once $base . '/views/' . $view . '.php';
        } else {
            die("View $view not found in " . $base . '/views/' . $view . '.php');
        }
    }

    public function model($model) {
        $base = dirname(dirname(__DIR__));
        if (file_exists($base . '/app/Models/' . $model . '.php')) {
            require_once $base . '/app/Models/' . $model . '.php';
            return new $model();
        } else {
            die("Model $model not found in " . $base . '/app/Models/' . $model . '.php');
        }
    }
}
?>
