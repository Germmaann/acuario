<?php
class LangController {
    private function setAndRedirect($code) {
        if (!in_array($code, ['es','en'])) {
            $code = 'es';
        }
        if (class_exists('Session')) {
            Session::set('lang', $code);
        } else {
            $_SESSION['lang'] = $code;
        }
        $back = $_SERVER['HTTP_REFERER'] ?? APP_URL;
        if (class_exists('Response')) {
            Response::redirect($back);
            return;
        }
        header('Location: ' . $back);
        exit;
    }

    public function es() { $this->setAndRedirect('es'); }
    public function en() { $this->setAndRedirect('en'); }
}
