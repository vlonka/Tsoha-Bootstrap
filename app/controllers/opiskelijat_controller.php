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
        $opiskelija = new opiskelija(array(
            'opiskelijanro' => $params['opiskelijanro'],
            'nimi' => $params['nimi'],
            'syntymaaika' => $params['syntymaaika'],
            'salasana' => $params['salasana']
        ));

        $query1 = DB::connection()->prepare('SELECT * FROM Opiskelija WHERE nimi = :nimi AND salasana = :salasana LIMIT 1');
        $query1->execute(array('nimi' => $params['nimi'], 'salasana' => $params['salasana']));
        $haku = $query1->fetch();

        if ($haku == NULL) {
            $opiskelija->save();
        }

        Redirect::to('/opiskelijat/' . $opiskelija->id, array('message' => 'Käyttäjä luotu'));
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

        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'opiskelijanro' => $params['opiskelijanro'],
            'syntymaaika' => $params['syntymaaika'],
            'salasana' => $params['salasana']
        );

        $query1 = DB::connection()->prepare('SELECT * FROM Opiskelija WHERE nimi = :nimi AND salasana = :salasana LIMIT 1');
        $query1->execute(array('nimi' => $params['nimi'], 'salasana' => $params['salasana']));
        $haku = $query1->fetch();

        if ($haku == NULL) {
            $opiskelija = new opiskelija($attributes);
            $opiskelija->update($id);
        }

        Redirect::to('/opiskelijat/' . $opiskelija->id, array('message' => 'Opiskelijan tietoja on muokattu onnistuneesti!'));
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

        $opiskelija = opiskelija::authenticate($params['nimi'], $params['salasana']);

        if (!$opiskelija) {
            View::make('/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'nimi' => $params['nimi']));
        } else {
            $_SESSION['opiskelija'] = $opiskelija->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $opiskelija->nimi . '!'));
        }
    }

    public static function logout() {
        $_SESSION['opiskelija'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

}
