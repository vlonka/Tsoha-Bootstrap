<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('etusivu.html');
    }

    public static function sandbox() {
        $opiskelijat = opiskelija::all();
        $hyypio = opiskelija::find(1243);
        Kint::dump($opiskelijat);
        Kint::dump($hyypio);
        View::make('helloworld.html');
    }

    public static function listaussivu() {
        View::make('listaus.html');
    }

    public static function muokkaus_ja_esittely() {
        View::make('muokkausesittely.html');
    }
    
    

}
