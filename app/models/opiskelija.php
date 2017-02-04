<?php

class opiskelija extends BaseModel{

  public $id, $nimi, $syntymaaika, $salasana;

  public function __construct($attributes){
    parent::__construct($attributes);
  }
  
   public static function all(){

    $query = DB::connection()->prepare('SELECT * FROM opiskelija');
    $query->execute();
    $rows = $query->fetchAll();
    $opiskelijat = array();

    foreach($rows as $row){
      $opiskelijat[] = new opiskelija(array(
        'id' => $row['id'],
        'nimi' => $row['nimi'],
        'syntymaaika' => $row['syntymaaika'],
        'salasana' => $row['salasana'],
      ));
    }

    return $opiskelijat;
  }
  
    public static function find($id){
    $query = DB::connection()->prepare('SELECT * FROM opiskelija WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if($row){
      $hyypio = new opiskelija(array(
        'id' => $row['id'],
        'nimi' => $row['nimi'],
        'syntymaaika' => $row['syntymaaika'],
        'salasana' => $row['salasana']
      ));

      return $hyypio;
    }

    return null;
  }
}