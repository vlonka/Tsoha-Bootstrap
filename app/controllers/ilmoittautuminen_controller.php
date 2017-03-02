<?php

class Imoittautuminen_Controller extends BaseController {

//    public static function index() {
//        $opettaja = opettaja::all();
//        View::make('opettajat.html', array('opettajat' => $opettaja));
//    }
//    public static function ope($id) {
//        $opettaja = opettaja::find($id);
//        View::make('opettaja.html', array('opettaja' => $opettaja));
//    }

    public static function store() {
        $params = $_POST;
        $ilmoittautuminen = new ilmoittautuminen(array(
            'opiskelijaid' => $params['opiskelijaid'],
            'kurssi_id' => $params['kurssi_id'],
        ));

        $ilmoittautuminen->save();

        Redirect::to('/kurssit' . $opiskelija->id, array('message' => 'Ilmoittautuminen lisätty'));
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
            'opiskelijaid' => $params['opiskelijaid'],
            'kurssi_id' => $params['kurssi_id'],
            'salasana' => $params['salasana']
        );

        $opettaja = new opettaja($attributes);
        $opettaja->update($id);

        Redirect::to('/opettajat/' . $opettaja->id, array('message' => 'Opettajan tietoja on muokattu onnistuneesti!'));
    }

    public static function destroy($id) {
        opiskelija::check_logged_in();
        $opettaja = new opettaja(array('id' => $id));
        $opettaja->destroy($id);
        Redirect::to('/opettajat', array('message' => 'opettajan tiedot on poistettu onnistuneesti!'));
    }

}
