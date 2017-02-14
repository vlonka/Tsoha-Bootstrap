<?php

class UserController extends BaseController {

    public static function login() {
        View::make('/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $opiskelija = opiskelija::authenticate($params['username'], $params['password']);

        if (!$opiskelija) {
            View::make('/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        } else {
            $_SESSION['opiskelija'] = $opiskelija->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $opiskelija->nimi . '!'));
        }
    }

}
