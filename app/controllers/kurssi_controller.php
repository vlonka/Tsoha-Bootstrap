<?php

class Kurssi_Controller extends BaseController {

    public static function index() {
        $kurssi = kurssi::all();
        View::make('kurssit.html', array('kurssit' => $kurssi));
    }

    public static function opetus($id) {
        $kurssi = kurssi::find($id);
        $ilmoittautumiset = kurssi::findIlmo($id);
        View::make('kurssi.html', array('kurssi' => $kurssi, 'ilmoittautumiset' => $ilmoittautumiset));
    }

    public static function store() {
        $params = $_POST;
        $kurssi = new kurssi(array(
            'opeid' => $params['opeid'],
            'aihe' => $params['aihe'],
            'kurssimaksu' => $params['kurssimaksu'],
            'kuvaus' => $params['kuvaus'],
            'aloituspvm' => $params['aloituspvm'],
            'aloitusaika' => $params['aloitusaika']
        ));

        $kurssi->save();

        Redirect::to('/kurssit/' . $kurssi->id, array('message' => 'Kurssi luotu'));
    }

    public static function create() {
        View::make('uusikurssi.html');
    }

    public static function edit($id) {
        $kurssi = kurssi::find($id);
        View::make('muokkaakurssi.html', array('kurssi' => $kurssi));
    }

    public static function update($id) {
        $params = $_POST;

        $validointi = self::validate($params);

        if ($validointi == "") {

            $attributes = array(
                'opeid' => $params['opeid'],
                'aihe' => $params['aihe'],
                'kurssimaksu' => $params['kurssimaksu'],
                'kuvaus' => $params['kuvaus'],
                'aloituspvm' => $params['aloituspvm'],
                'aloitusaika' => $params['aloitusaika']
            );

            $kurssi = new kurssi($attributes);
            $kurssi->update($id);

            Redirect::to('/kurssit/' . $id, array('message' => 'Kurssin tietoja on muokattu onnistuneesti!'));
        } else {
            Redirect::to('/kurssit/' . $id . '/muokkaa', array('message' => $validointi));
        }
    }

    public static function destroy($id) {
        $kurssi = new kurssi(array('id' => $id));
        $kurssi->destroy($id);
        Redirect::to('/kurssit', array('message' => 'Kurssin tiedot on poistettu onnistuneesti!'));
    }

    public static function validate($params) {
        $errors = '';

        if ($params['aihe'] == '' || $params['aihe'] == null) {

            $errors .= 'Kurssilla oltava aihe. ';
        }

        if (strlen($params['aihe']) > 50) {

            $errors .= 'Aihe liian pitkä. ';
        }

        if ($params['opeid'] == '' || $params['opeid'] == null) {

            $errors .= 'Opettaja-ID oltava. ';
        }

        if (!ctype_digit($params['opeid'])) {

            $errors .= 'Opettaja-ID:n oltava numero. ';
        }

        if (ctype_digit($params['opeid'])) {
            $query = DB::connection()->prepare('SELECT * FROM opettaja WHERE id = :id LIMIT 1');
            $query->execute(array('id' => $params['opeid']));
            $row = $query->fetch();

            if ($row == null) {

                $errors .= 'Opettaja-ID:n vastattava olemassa olevaa opettajaa. ';
            }
        }

        if (!ctype_digit(substr($params['aloituspvm'], 0, 4)) ||
                !ctype_digit(substr($params['aloituspvm'], 5, 2)) ||
                !ctype_digit(substr($params['aloituspvm'], 8, 2)) ||
                strlen($params['aloituspvm']) != 10 ||
                $params['aloituspvm']{4} != '-' ||
                $params['aloituspvm']{7} != '-' ||
                !checkdate(substr($params['aloituspvm'], 5, 2), substr($params['aloituspvm'], 8, 2), substr($params['aloituspvm'], 0, 4))) {

            $errors .= 'Aloituspäivämäärässä häikkää. ';
        }

// yyyy-mm-dd

        if (!ctype_digit(substr($params['aloitusaika'], 0, 2)) ||
                !ctype_digit(substr($params['aloitusaika'], 3, 2)) ||
                !ctype_digit(substr($params['aloitusaika'], 6, 2)) ||
                strlen($params['aloitusaika']) != 8 ||
                $params['aloitusaika']{2} != ':' ||
                $params['aloitusaika']{5} != ':' ||
                ($params['aloitusaika']{0} . $params['aloitusaika']{1}) <= 0 ||
                ($params['aloitusaika']{0} . $params['aloitusaika']{1}) >= 23 ||
                ($params['aloitusaika']{3} . $params['aloitusaika']{4}) <= 0 ||
                ($params['aloitusaika']{3} . $params['aloitusaika']{4}) >= 59 ||
                ($params['aloitusaika']{6} . $params['aloitusaika']{7}) <= 0 ||
                ($params['aloitusaika']{6} . $params['aloitusaika']{7}) >= 59) {

            $errors .= 'Aloitusajassa häikkää. ';
        }

        if ($params['kurssimaksu'] == '' || $params['kurssimaksu'] == null) {

            $errors .= 'Kurssimaksu oltava. ';
        }

        if (!ctype_digit($params['kurssimaksu'])) {

            $errors .= 'Kurssimaksun oltava numero. ';
        }

        if ($params['kurssimaksu'] < 0) {

            $errors .= 'Laitos ei maksa oppilaille. ';
        }

        if ($params['kurssimaksu'] >= 10000) {

            $errors .= 'Liian kallis. ';
        }

        if (strlen($params['kuvaus']) != '' || $params['kuvaus'] == null) {

            $errors .= 'Kuvaus oltava. ';
        }

        if (strlen($params['kuvaus']) > 10000) {

            $errors .= 'Kuvaus liian pitkä. ';
        }

        return $errors;
    }

}
