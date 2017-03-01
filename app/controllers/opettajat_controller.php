<?php

class Opettajat_Controller extends BaseController {

    public static function index() {
        $opettaja = opettaja::all();
        View::make('opettajat.html', array('opettajat' => $opettaja));
    }

    public static function ope($id) {
        $opettaja = opettaja::find($id);
        View::make('opettaja.html', array('opettaja' => $opettaja));
    }

    public static function store() {
        $params = $_POST;
        $opettaja = new opettaja(array(
            'openro' => $params['openro'],
            'nimi' => $params['nimi'],
            'syntymaaika' => $params['syntymaaika'],
            'kuvaus' => $params['kuvaus'],
            'salasana' => $params['salasana']
        ));

        $opettaja->save();

        Redirect::to('/opettajat' . $opettaja->id, array('message' => 'Opettaja lisätty'));
    }

    public static function create() {
        View::make('uusiopettaja.html');
    }

    public static function edit($id) {
        self::check_logged_in();
        $opettaja = opettaja::find($id);
        View::make('muokkaaopettaja.html', array('opettaja' => $opettaja));
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'openro' => $params['openro'],
            'syntymaaika' => $params['syntymaaika'],
            'kuvaus' => $params['kuvaus'],
            'salasana' => $params['salasana']
        );

        $opettaja = new opettaja($attributes);
        $opettaja->update($id);

        Redirect::to('/opettajat/' . $opettaja->id, array('message' => 'Opettajan tietoja on muokattu onnistuneesti!'));
    }

    public static function destroy($id) {
        self::check_logged_in();
        $opettaja = new opettaja(array('id' => $id));
        $opettaja->destroy($id);
        Redirect::to('/opettajat', array('message' => 'opettajan tiedot on poistettu onnistuneesti!'));
    }

    public static function login() {
        View::make('/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $opettaja = opettaja::authenticate($params['nimi'], $params['salasana']);

        if (!$opettaja) {
            View::make('/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'nimi' => $params['nimi']));
        } else {
            $_SESSION['opettaja'] = $opettaja->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $opettaja->nimi . '!'));
        }
    }

    public static function logout() {
        $_SESSION['opettaja'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

}
