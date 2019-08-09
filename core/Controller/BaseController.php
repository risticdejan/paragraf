<?php

namespace Core\Controller;

class BaseController {

    public function render($view, $data = null) {
        $path = $this->getViewPath($view);

        if(!$path) exit('Template not found');

        ob_start();

        if(is_array($data)) extract($data);

        require $path;

        return trim(ob_get_clean());
    }

    public function json($obj, $code = 200) {
        header('Content-type: application/json', true, $code);
        echo json_encode($obj);
        exit;
    }

    private function getViewPath($view) {
        $path = VIEW_PATH."/". $view;

        if(file_exists($path)) {
            return $path;
        }

        return false;
    }
}