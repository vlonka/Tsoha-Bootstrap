<?php

class Kurssi_Controller extends BaseController {

    public static function index() {
        $kurssi = kurssi::all();
        View::make('kurssit.html', array('kurssit' => $kurssi));
    }

    public static function opetus($id) {
        $kurssi = kurssi::find($id);
        View::make('kurssi.html', array('kurssi' => $kurssi));
    }

    public static function store() {
        $params = $_POST;
        $kurssi = new kurssi(array(
            'id' => $row['id'],
            'opeid' => $row['opeid'],
            'aihe' => $row['aihe'],
            'kurssimaksu' => $row['kurssimaksu'],
            'kuvaus' => $row['kuvaus'],
            'aloituspvm' => $row['aloituspvm'],
            'aloitusaika' => $row['aloitusaika']
        ));

        $kurssi->save();

        Redirect::to('/kurssit' . $kurssi->id, array('message' => 'Kurssi luotu'));
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

        $attributes = array(
            'id' => $row['id'],
            'opeid' => $row['opeid'],
            'aihe' => $row['aihe'],
            'kurssimaksu' => $row['kurssimaksu'],
            'kuvaus' => $row['kuvaus'],
            'aloituspvm' => $row['aloituspvm'],
            'aloitusaika' => $row['aloitusaika']
        );

        $kurssi = new kurssi($attributes);
        $kurssi->update($id);

        Redirect::to('/kurssit/' . $kurssi->id, array('message' => 'Kurssin tietoja on muokattu onnistuneesti!'));
    }

    public static function destroy($id) {
        $kurssi = new kurssi(array('id' => $id));
        $kurssi->destroy($id);
        Redirect::to('/kurssit', array('message' => 'Kurssin tiedot on poistettu onnistuneesti!'));
    }

}