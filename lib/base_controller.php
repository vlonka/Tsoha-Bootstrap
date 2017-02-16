<?php

class BaseController {

    public static function get_user_logged_in() {
        if (isset($_SESSION['opiskelija'])) {
            $opiskelija_id = $_SESSION['opiskelija'];
            $opiskelija = opiskelija::find($opiskelija_id);

            return $opiskelija;
        }
        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['opiskelija'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }

}
