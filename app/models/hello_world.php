<?php

class HelloWorld extends BaseModel {

    public static function say_hi() {
        return 'Hello World!';
    }

    public static function sandbox() {
        $kurssit = Kurssi::all();
        Kint::dump($kurssit);
    }

}
