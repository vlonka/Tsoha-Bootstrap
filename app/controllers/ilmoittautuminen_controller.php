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

    public static function ilmo($id) {
        opiskelija::check_logged_in();
        $oppilas = session_id();
        
        $query = DB::connection()->prepare('INSERT INTO Ilmoittautuminen (opiskelijaid, kurssi_id) VALUES (:opiskelijaid, :kurssi_id) RETURNING id');
        $query->execute(array('opiskelijaid' => $oppilas, 'kurssi_id' => $id));

        Redirect::to('/kurssit' . $opiskelija->id, array('message' => 'Ilmoittautuminen lisätty'));
    }

//    public static function edit($id) {
//        self::check_logged_in();
//        $opettaja = opettaja::find($id);
//        View::make('muokkaaopettaja.html', array('opettaja' => $opettaja));
//    }

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
        $ilmoittautuminen->destroy($id);
        Redirect::to('/oppilaat/', array('message' => 'Ilmoittautuminen on poistettu onnistuneesti!'));
    }

}
