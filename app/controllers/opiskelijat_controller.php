<?php

class Opiskelijat_Controller extends BaseController{
  public static function index(){
    $opiskelija = opiskelija::all();
    View::make('opiskelijat.html', array('opiskelijat' => $opiskelija));
  }
  
  public static function hyypio($id){
    $opiskelija = opiskelija::find($id);
    View::make('opiskelija.html', array('hyypio' => $opiskelija));
  }
  
   public static function store(){
    $params = $_POST;
    $opiskelija = new opiskelija(array(
        'id' => $row['id'],
        'nimi' => $row['nimi'],
        'syntymaaika' => $row['syntymaaika'],
        'salasana' => $row['salasana']
    ));

    $opiskelija->save();

    Redirect::to('/opiskelijat/' . $game->id, array('message' => 'Käyttäjä luotu'));
  }
  
    public function save(){
    $query = DB::connection()->prepare('INSERT INTO Opiskelija (id, nimi, syntymaaika, salasana) VALUES (:id, :nimi, :syntymaaika, :salasana) RETURNING id');
    $query->execute(array('id' => $this->id, 'nimi' => $this->nimi, 'syntymaaika' => $this->syntymaaika, 'salasana' => $this->salasana));
    $row = $query->fetch();
    $this->id = $row['id'];
  }
}