<?php

class opettaja extends BaseModel {

    public $id, $openro, $nimi, $syntymaaika, $kuvaus, $salasana, $opiskelijaid;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM opettaja');
        $query->execute();
        $rows = $query->fetchAll();
        $opettajat = array();

        foreach ($rows as $row) {
            $opettajat[] = new opettaja(array(
                'id' => $row['id'],
                'openro' => $row['openro'],
                'nimi' => $row['nimi'],
                'syntymaaika' => $row['syntymaaika'],
                'kuvaus' => $row['kuvaus'],
                'salasana' => $row['salasana']
            ));
        }

        return $opettajat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM opettaja WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $opettaja = new opettaja(array(
                'id' => $row['id'],
                'openro' => $row['openro'],
                'nimi' => $row['nimi'],
                'syntymaaika' => $row['syntymaaika'],
                'salasana' => $row['salasana']
            ));

            return $opettaja;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO opettaja (openro, nimi, syntymaaika, kuvaus, salasana) VALUES (:openro, :nimi, :syntymaaika, :kuvaus, :salasana) RETURNING id');
        $query->execute(array('openro' => $this->openro, 'nimi' => $this->nimi, 'syntymaaika' => $this->syntymaaika, 'kuvaus' => $this->kuvaus, 'salasana' => $this->salasana));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public static function destroy($id) {
        $query = DB::connection()->prepare('UPDATE Kurssi SET opeid = NULL WHERE opeid = :id');
        $query->execute(array('id' => $id));
        
        $query = DB::connection()->prepare('DELETE FROM Opettaja WHERE id = :id');
        $query->execute(array('id' => $id));
    }

    public function update($id) {
        $query = DB::connection()->prepare('UPDATE Opettaja SET (openro, nimi, syntymaaika, kuvaus, salasana) = (:openro, :nimi, :syntymaaika, :kuvaus, :salasana) WHERE id = :id');
        $query->execute(array('id' => $this->id, 'openro' => $this->openro, 'nimi' => $this->nimi, 'syntymaaika' => $this->syntymaaika, 'kuvaus' => $this->kuvaus, 'salasana' => $this->salasana));
    }

    public function authenticate($nimi, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Opettaja WHERE nimi = :nimi AND salasana = :salasana LIMIT 1');
        $query->execute(array('nimi' => $nimi, 'salasana' => $salasana));
        $row = $query->fetch();
        if ($row) {
            $opettaja = new opettaja(array(
                'id' => $row['id'],
                'openro' => $row['openro'],
                'nimi' => $row['nimi'],
                'syntymaaika' => $row['syntymaaika'],
                'kuvaus' => $row['kuvaus'],
                'salasana' => $row['salasana']
            ));
            return $opettaja;
        } else {
            return null;
        }
    }

}
