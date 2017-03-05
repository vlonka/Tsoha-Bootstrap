<?php

class Ilmoittautuminen_Controller extends BaseController {


    public static function ilmo($id) {
        self::check_logged_in();
        $oppilas = $_SESSION['opiskelija'];
        
        $query = DB::connection()->prepare('INSERT INTO Ilmoittautuminen (opiskelijaid, kurssi_id) VALUES (:opiskelijaid, :kurssi_id) RETURNING id');
        $query->execute(array('opiskelijaid' => $oppilas, 'kurssi_id' => $id));

        Redirect::to('/kurssit');
    }


    public static function destroy($id) {
        self::check_logged_in();
        $nro = $_SESSION['opiskelija'];
        $ilmoittautuminen = new Ilmoittautuminen(array('id' => $id));
        $ilmoittautuminen->destroy($id);
        Redirect::to('/opiskelijat', array('message' => 'Ilmoittautuminen on poistettu onnistuneesti!'));
    }

}
