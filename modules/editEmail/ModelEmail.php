<?php
require_once '../../config/DB.php';
//require_once '../../config/DB.php';
class ModelEmail {
   
  private $idEmail;
  private $objet;
  private $promotion;
  private $mail;

  public function getPromotion(){
    return $this->promotion;
  }

  public function getEmail(){
    return $this->mail;
  }

  public function getIdEmail(){
    return $this->idEmail;
  }

  public function getObjet(){
    return $this->objet;
  }

  public function __construct($p = NULL, $m = NULL, $id = NULL, $obj = NULL)  {
    if (!is_null($p) && !is_null($m)&& !is_null($id)&& !is_null($obj)) {
      $this->promotion=$p;
      $this->mail=$m;
      $this->idEmail=$id;
      $this->objet=$obj;
    }
  }

  public function save(){
      $sql="INSERT INTO Email (promotion, mail, objet) VALUES (:promo, :mail, :obj)";
      $req_prep = bdd::$pdo->prepare($sql);
      $values= array(
        ":promo" =>$this->promotion,
        ":mail"=>$this->mail,
        ":obj"=>$this->objet
      );
      $req_prep->execute($values);
    }
 

  public static function getAllEmail(){
    $rep=bdd::$pdo->query("SELECT * FROM Email");
    $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelEmail');
    $tab_e = $rep->fetchAll();
    return $tab_e;
  }

  public static function getEmailWithPromotion($promotion){
    $sql="SELECT * FROM Email WHERE promotion=:promo";
    $req_prep = bdd::$pdo->prepare($sql);
    $values= array(
      ":promo" =>$promotion 
    );
    $req_prep->execute($values);
    $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelEmail');
    $tab = $req_prep->fetchAll();
    return $tab;

  }

  public static function delete($email,$promo){
    $sql="DELETE FROM Email WHERE mail=:email AND promotion=:promo";
      $req_prep = bdd::$pdo->prepare($sql);
      $values= array(
        ":email"=>$email,
        ":promo"=>$promo
      );
      $req_prep->execute($values);
  }

  public static function update($id,$email,$promo,$obj){
    $sql="UPDATE Email SET mail=:email, promotion=:promo, objet=:obj WHERE idEmail=:id";
      $req_prep = bdd::$pdo->prepare($sql);
      $values= array(
        ":id"=>$id,
        ":email"=>$email,
        ":promo"=>$promo,
        ":obj"=>$obj
      );
      $req_prep->execute($values);
  }

}
?>