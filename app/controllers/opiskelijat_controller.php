<?php

class Opiskelijat_Controller extends BaseController {

    public static function index() {
        $opiskelija = opiskelija::all();
        View::make('opiskelijat.html', array('opiskelijat' => $opiskelija));
    }

    public static function hyypio($id) {
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
        $game = Game::find($id);
        View::make('game/edit.html', array('attributes' => $game));
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

        $game = new Game($attributes);
        $game->update();

        Redirect::to('/opiskelijat' . $game->id, array('message' => 'Opiskelijan tietoja on muokattu onnistuneesti!'));
    }

    public static function destroy($id) {
        $opiskelija = new opiskelija(array('id' => $id));
        $opiskelija->destroy();
        Redirect::to('/opiskelijat', array('message' => 'opiskelijan tiedot on poistettu onnistuneesti!'));
    }

}
