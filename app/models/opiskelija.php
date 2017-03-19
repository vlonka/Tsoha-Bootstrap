<?php

class opiskelija extends BaseModel {

    public $id, $opiskelijanro, $nimi, $syntymaaika, $salasana, $opiskelijaid, $kurssi_id;

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
            $opiskelija = new opiskelija(array(
                'id' => $row['id'],
                'opiskelijanro' => $row['opiskelijanro'],
                'nimi' => $row['nimi'],
                'syntymaaika' => $row['syntymaaika'],
                'salasana' => $row['salasana']
            ));

            return $opiskelija;
        }

        return null;
    }

    public static function findIlmo($id) {
        $query = DB::connection()->prepare('SELECT * FROM ilmoittautuminen WHERE opiskelijaid = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $ilmoittautumiset = array();

        foreach ($rows as $row2) {
            $ilmoittautumiset[] = new Ilmoittautuminen(array(
                'id' => $row2['id'],
                'opiskelijaid' => $row2['opiskelijaid'],
                'kurssi_id' => $row2['kurssi_id'],
                'kurssimaksu' => $row2['kurssimaksu'],
            ));

            return $ilmoittautumiset;
        }
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Opiskelija (opiskelijanro, nimi, syntymaaika, salasana) VALUES (:opiskelijanro, :nimi, :syntymaaika, :salasana) RETURNING id');
        $query->execute(array('opiskelijanro' => $this->opiskelijanro, 'nimi' => $this->nimi, 'syntymaaika' => $this->syntymaaika, 'salasana' => $this->salasana));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public static function destroy($id) {
        $query = DB::connection()->prepare('DELETE FROM ilmoittautuminen WHERE opiskelijaid = :id');
        $query->execute(array('id' => $id));

        $query = DB::connection()->prepare('DELETE FROM opiskelija WHERE id = :id');
        $query->execute(array('id' => $id));
    }

    public function update($id) {
        $query = DB::connection()->prepare('UPDATE Opiskelija SET (opiskelijanro, nimi, syntymaaika, salasana) = (:opiskelijanro, :nimi, :syntymaaika, :salasana) WHERE id = :id');
        $query->execute(array('id' => $this->id, 'opiskelijanro' => $this->opiskelijanro, 'nimi' => $this->nimi, 'syntymaaika' => $this->syntymaaika, 'salasana' => $this->salasana));
    }

    public function authenticate($id, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Opiskelija WHERE id = :id AND salasana = :salasana LIMIT 1');
        $query->execute(array('id' => $id, 'salasana' => $salasana));
        $row = $query->fetch();
        if ($row) {
            $opiskelija = new opiskelija(array(
                'id' => $row['id'],
                'opiskelijanro' => $row['opiskelijanro'],
                'nimi' => $row['nimi'],
                'syntymaaika' => $row['syntymaaika'],
                'salasana' => $row['salasana']
            ));
            return $opiskelija;
        } else {
            return null;
        }
    }

}
