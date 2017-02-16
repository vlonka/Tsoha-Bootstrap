<?php

class kurssi extends BaseModel {

    public $id, $opeid, $aihe, $kurssimaksu, $kuvaus, $aloituspvm, $aloitusaika;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM kurssi');
        $query->execute();
        $rows = $query->fetchAll();
        $kurssit = array();

        foreach ($rows as $row) {
            $kurssit[] = new kurssi(array(
                'id' => $row['id'],
                'opeid' => $row['opeid'],
                'aihe' => $row['aihe'],
                'kurssimaksu' => $row['kurssimaksu'],
                'kuvaus' => $row['kuvaus'],
                'aloituspvm' => $row['aloituspvm'],
                'aloitusaika' => $row['aloitusaika']
            ));
        }

        return $kurssit;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM kurssi WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $opetus = new kurssi(array(
                'id' => $row['id'],
                'opeid' => $row['opeid'],
                'aihe' => $row['aihe'],
                'kurssimaksu' => $row['kurssimaksu'],
                'kuvaus' => $row['kuvaus'],
                'aloituspvm' => $row['aloituspvm'],
                'aloitusaika' => $row['aloitusaika']
            ));

            return $opetus;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kurssi (opeid, aihe, kurssimaksu, kuvaus, aloituspvm, aloitusaika) VALUES (:opeid, :aihe, :kurssimaksu, :kuvaus, :aloituspvm, :aloitusaika) RETURNING id');
        $query->execute(array('opeid' => $this->opeid, 'aihe' => $this->aihe, 'kurssimaksu' => $this->kurssimaksu, 'kuvaus' => $this->kuvaus, 'aloituspvm' => $this->aloituspvm, 'aloitusaika' => $this->aloitusaika));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public static function destroy($id) {
        $query = DB::connection()->prepare('DELETE FROM kurssi WHERE id = :id');
        $query->execute(array('id' => $id));
    }

    public function update($id) {
        $query = DB::connection()->prepare('UPDATE Kurssi SET (opeid, aihe, kurssimaksu, kuvaus, aloituspvm, aloitusaika) = (:opeid, :aihe, :kurssimaksu, :kuvaus, :aloituspvm, :aloitusaika) WHERE id = :id');
        $query->execute(array('id' => $this->id, 'opeid' => $this->opeid, 'aihe' => $this->aihe, 'kurssimaksu' => $this->kurssimaksu, 'kuvaus' => $this->kuvaus, 'aloituspvm' => $this->aloituspvm, 'aloitusaika' => $this->aloitusaika));
    }

}