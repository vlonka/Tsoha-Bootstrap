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



    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Ilmoittautuminen (opiskelijaid, kurssi_id) VALUES (:opiskelijaid, :kurssi_id) RETURNING id');
        $query->execute(array('opiskelijaid' => $this->opiskelijaid, 'kurssi_id' => $this->kurssi_id));
        $row = $query->fetch();
        $this->id = $row['id'];
        
        
    }

    public static function destroy($id) {
        $query = DB::connection()->prepare('DELETE FROM ilmoittautuminen WHERE id = :id');
        $query->execute(array('id' => $id));
   
    }
}