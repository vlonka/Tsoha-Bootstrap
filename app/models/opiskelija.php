<?php

class opiskelija extends BaseModel {

    public $id, $nimi, $syntymaaika, $salasana;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM opiskelija');
        $query->execute();
        $rows = $query->fetchAll();
        $opiskelijat = array();

        foreach ($rows as $row) {
            $opiskelijat[] = new opiskelija(array(
                'id' => $row['id'],
                'opiskelijanro' => $row['opiskelijanro'],
                'nimi' => $row['nimi'],
                'syntymaaika' => $row['syntymaaika'],
                'salasana' => $row['salasana']
            ));
        }

        return $opiskelijat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM opiskelija WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $hyypio = new opiskelija(array(
                'opiskelijanro' => $row['opiskelijanro'],
                'nimi' => $row['nimi'],
                'syntymaaika' => $row['syntymaaika'],
                'salasana' => $row['salasana']
            ));

            return $hyypio;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Opiskelija (opiskelijanro, nimi, syntymaaika, salasana) VALUES (:opiskelijanro, :nimi, :syntymaaika, :salasana) RETURNING id');
        $query->execute(array('id' => $this->id, 'opiskelijanro' => $this->opiskelijanro, 'nimi' => $this->nimi, 'syntymaaika' => $this->syntymaaika, 'salasana' => $this->salasana));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public static function destroy($id) {
        $query = DB::connection()->prepare('DELETE * FROM opiskelija WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Opiskelija (opiskelijanro, nimi, syntymaaika, salasana) VALUES (:opiskelijanro, :nimi, :syntymaaika, :salasana)');
        $query->execute(array('opiskelijanro' => $this->opiskelijanro, 'nimi' => $this->nimi, 'syntymaaika' => $this->syntymaaika, 'salasana' => $this->salasana));
    }

}
