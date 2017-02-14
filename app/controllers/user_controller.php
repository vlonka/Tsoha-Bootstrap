<?php

class UserController extends BaseController {

    public static function login() {
        View::make('/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $opiskelija = opiskelija::authenticate($params['nimi'], $params['salasana']);

        if (!$opiskelija) {
            View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        } else {
            $_SESSION['opiskelija'] = $opiskelija->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->name . '!'));
        }
    }

}
