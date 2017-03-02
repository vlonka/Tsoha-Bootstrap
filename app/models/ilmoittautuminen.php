<?php

class Ilmoittautuminen extends BaseModel {

    public $id, $opiskelijaid, $kurssi_id, $kurssimaksu;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM ilmoittautuminen');
        $query->execute();
        $rows = $query->fetchAll();
        $ilmoittautumiset = array();

        foreach ($rows as $row) {
            $ilmoittautumiset[] = new ilmoittautuminen(array(
                'id' => $row['id'],
                'opiskelijaid' => $row['opiskelijaid'],
                'kurssi_id' => $row['kurssi_id'],
                'kurssimaksu' => $row['kurssimaksu'],
            ));
        }

        return $ilmoittautumiset;
    }

//    public static function find($id) {
//        $query = DB::connection()->prepare('SELECT * FROM opiskelija WHERE id = :id LIMIT 1');
//        $query->execute(array('id' => $id));
//        $row = $query->fetch();
//
//        $query = DB::connection()->prepare('SELECT * FROM ilmoittautuminen WHERE opiskelijaid = :id');
//        $query->execute(array('opiskelijaid' => $opiskelijaid));
//        $rows = $query->fetchAll();
//        $ilmoittautumiset = array();
//
//        foreach ($rows as $row) {
//            $ilmoittautumiset[] = new ilmoittautuminen(array(
//                'id' => $row['id'],
//                'opiskelijaid' => $row['opiskelijaid'],
//                'kurssi_id' => $row['kurssi_id'],
//                'kurssimaksu' => $row['kurssimaksu'],
//                'salasana' => $row['salasana']
//            ));
//        }
//
//        if ($row) {
//            $opiskelija = new opiskelija(array(
//                'id' => $row['id'],
//                'opiskelijanro' => $row['opiskelijanro'],
//                'nimi' => $row['nimi'],
//                'syntymaaika' => $row['syntymaaika'],
//                'salasana' => $row['salasana']
//            ));
//
//            return $opiskelija && $ilmoittautumiset;
//        }
//
//        return null;
//    }

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

}
