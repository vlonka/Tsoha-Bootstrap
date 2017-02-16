<?php

class opiskelija extends BaseModel {

    public $id, $opiskelijanro, $nimi, $syntymaaika, $salasana;

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
                'id' => $row['id'],
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
        $query->execute(array('opiskelijanro' => $this->opiskelijanro, 'nimi' => $this->nimi, 'syntymaaika' => $this->syntymaaika, 'salasana' => $this->salasana));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public static function destroy($id) {
        $query = DB::connection()->prepare('DELETE FROM opiskelija WHERE id = :id');
        $query->execute(array('id' => $id));
    }

    public function update($id) {
        $query = DB::connection()->prepare('UPDATE Opiskelija SET (opiskelijanro, nimi, syntymaaika, salasana) = (:opiskelijanro, :nimi, :syntymaaika, :salasana) WHERE id = :id');
        $query->execute(array('id' => $this->id, 'opiskelijanro' => $this->opiskelijanro, 'nimi' => $this->nimi, 'syntymaaika' => $this->syntymaaika, 'salasana' => $this->salasana));
    }

    public function authenticate($nimi, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Opiskelija WHERE nimi = :nimi AND salasana = :salasana LIMIT 1');
        $query->execute(array('nimi' => $nimi, 'salasana' => $salasana));
        $row = $query->fetch();
        if ($row) {
            $hyypio = new opiskelija(array(
                'opiskelijanro' => $row['opiskelijanro'],
                'nimi' => $row['nimi'],
                'syntymaaika' => $row['syntymaaika'],
                'salasana' => $row['salasana']
            ));
            return $hyypio;
        } else {
            return null;
        }
    }

}
