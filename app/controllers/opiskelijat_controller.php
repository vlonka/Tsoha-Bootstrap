<?php

class Opiskelijat_Controller extends BaseController {

    public static function index() {
        $opiskelija = opiskelija::all();
        View::make('opiskelijat.html', array('opiskelijat' => $opiskelija));
    }

    public static function hyypio($id) {
        self::check_logged_in();
        $opiskelija = opiskelija::find($id);
        View::make('opiskelija.html', array('opiskelija' => $opiskelija));
    }

    public static function store() {
        $params = $_POST;
        $opiskelija = new opiskelija(array(
            'opiskelijanro' => $params['opiskelijanro'],
            'nimi' => $params['nimi'],
            'syntymaaika' => $params['syntymaaika'],
            'salasana' => $params['salasana']
        ));

        $opiskelija->save();

        Redirect::to('/opiskelijat' . $opiskelija->id, array('message' => 'Käyttäjä luotu'));
    }

    public static function create() {
        View::make('uusioppilas.html');
    }

    public static function edit($id) {
        self::check_logged_in();
        $opiskelija = opiskelija::find($id);
        View::make('muokkaaopiskelija.html', array('opiskelija' => $opiskelija));
    }

    public static function update($id) {
        $params = $_POST;

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
    }

    public static function destroy($id) {
        self::check_logged_in();
        $opiskelija = new opiskelija(array('id' => $id));
        $opiskelija->destroy($id);
        Redirect::to('/opiskelijat', array('message' => 'opiskelijan tiedot on poistettu onnistuneesti!'));
    }

    public static function logout() {
        $_SESSION['opiskelija'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

}
