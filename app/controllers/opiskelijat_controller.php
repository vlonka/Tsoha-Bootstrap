<?php

class Opiskelijat_Controller extends BaseController {

    public static function index() {
        $opiskelija = opiskelija::all();
        View::make('opiskelijat.html', array('opiskelijat' => $opiskelija));
    }

    public static function oppija($id) {
        self::check_logged_in();
        $opiskelija = opiskelija::find($id);
        $ilmoittautumiset = opiskelija::findIlmo($id);
        View::make
                ('opiskelija.html', array('opiskelija' => $opiskelija
            , 'ilmoittautumiset' => $ilmoittautumiset));
    }

    public static function store() {
        $params = $_POST;

        $validointi = self::validate($params);

        if ($validointi == '') {

            $opiskelija = new opiskelija(array(
                'opiskelijanro' => $params['opiskelijanro'],
                'nimi' => $params['nimi'],
                'syntymaaika' => $params['syntymaaika'],
                'salasana' => $params['salasana']
            ));

            $opiskelija->save();
            $_SESSION['opiskelija'] = $opiskelija->id;
            Redirect::to('/opiskelijat/' . $opiskelija->id, array('message' => 'Käyttäjä luotu'));
        } else {
            Redirect::to('/uusioppilas', array('message' => $validointi));
        }
    }

    public static function create() {
        View::make('uusioppilas.html');
    }

    public static function edit($id) {
        self::check_logged_in();
        if ($_SESSION['opiskelija'] == $id) {
            $opiskelija = opiskelija::find($id);
            View::make('muokkaaopiskelija.html', array('opiskelija' => $opiskelija));
        } else {
            View::make('login.html');
        }
    }

    public static function update($id) {
        $params = $_POST;

        $validointi = self::validate($params);


        if ($validointi == '') {

            $attributes = array(
                'id' => $id,
                'nimi' => $params['nimi'],
                'opiskelijanro' => $params['opiskelijanro'],
                'syntymaaika' => $params['syntymaaika'],
                'salasana' => $params['salasana']
            );

            $opiskelija = new opiskelija($attributes);
            $opiskelija->update($id);

            Redirect::to('/opiskelijat/' . $opiskelija->id, array('message' => 'Opiskelijan tietoja on muokattu onnistuneesti!'));
        } else {
            Redirect::to('/opiskelijat/' . $_SESSION['opiskelija'] . '/muokkaa', array('message' => $validointi));
        }
    }

    public static function destroy($id) {
        self::check_logged_in();
        if ($_SESSION['opiskelija'] == $id) {
            $opiskelija = new opiskelija(array('id' => $id));
            $opiskelija->destroy($id);
            Redirect::to('/opiskelijat', array('message' => 'opiskelijan tiedot on poistettu onnistuneesti!'));
        } else {
            View::make('login.html');
        }
    }

    public static function login() {
        View::make('/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        if (!ctype_digit($params['id'])) {
            View::make('/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'id' => $params['id']));
        }

        $opiskelija = opiskelija::authenticate($params['id'], $params['salasana']);

        if (!$opiskelija) {
            View::make('/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'id' => $params['id']));
        } else {
            $_SESSION['opiskelija'] = $opiskelija->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $opiskelija->nimi . '!'));
        }
    }

    public static function logout() {
        $_SESSION['opiskelija'] = null;
        Redirect::to('/', array('message' => 'Olet kirjautunut ulos!'));
    }

    public static function validate($params) {
        $errors = "";

        if ($params['nimi'] == '' || $params['nimi'] == null) {

            $errors .= 'Nimi oltava. ';
        }

        if ($params['opiskelijanro'] == '' || $params['opiskelijanro'] == null) {

            $errors .= 'Opiskelijanumero oltava. ';
        }

        if (!ctype_digit($params['opiskelijanro'])) {

            $errors .= 'Opiskelijanumeron oltava numero. ';
        }

        if (!ctype_digit(substr($params['syntymaaika'], 0, 4)) ||
                !ctype_digit(substr($params['syntymaaika'], 5, 2)) ||
                !ctype_digit(substr($params['syntymaaika'], 8, 2)) ||
                strlen($params['syntymaaika']) != 10 ||
                $params['syntymaaika']{4} != '-' ||
                $params['syntymaaika']{7} != '-' || 
                !checkdate(substr($params['syntymaaika'], 5, 2), substr($params['syntymaaika'], 8, 2), substr($params['syntymaaika'], 0, 4))) {

            $errors .= 'Syntymäajassa häikkää. ';
        }

        // yyyy-mm-dd

        if (strlen($params['salasana']) < 4 || $params['salasana'] == null) {

            $errors .= 'Salasanan pituuden oltava vähintään 4. ';
        }

        return $errors;
    }

}
