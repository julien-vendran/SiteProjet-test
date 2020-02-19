<?php
require_once '../../config/DB.php';
//require_once '../../config/DB.php';
class ModelProf {
   
  private $login;
  private $nom;
  private $prenom;
  private $idClasse;
  private $idPromo;
  private $promotion;
  private $dateConnexion;

  public function getLogin(){
    return $this->login;
  }

  public function afficherLogin(){
    echo $login;
  }

  public function __construct($l = NULL, $n = NULL, $p = NULL, $ic = NULL, $ip = NULL,$promo = NULL, $date = NULL)  {
    if (!is_null($l) && !is_null($n) && !is_null($p)&& !is_null($ic)&& !is_null($ip)&& !is_null($promo)&& !is_null($date)) {
      $this->login=$l;
      $this->nom=$n;
      $this->prenom=$p;
      $this->idClasse=$ic;
      $this->idPromo=$ip;
      $this->promotion=$promo;
      $this->dateConnexion=$date;
    }
  } 
//afficher tous les prof qui ne ce sont pas connecté depuis 1 ans 
  public static function getAllProf(){
    $rep=bdd::$pdo->query("SELECT * FROM Utilisateurs WHERE promotion='Enseignant' 
                            AND (DATEDIFF(NOW(), dateConnexion) >365 OR dateConnexion IS NULL)");
    $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelProf');
    $tab_p = $rep->fetchAll();
    return $tab_p;
  }
//supprime le prof passer en parametre
  public static function removeProf($log){
    $sql="DELETE FROM `Utilisateurs` WHERE `login`=:login";
    $req_prep = bdd::$pdo->prepare($sql);
    $values= array(
      "login"=>$log
    );
    $req_prep->execute($values);
  }   
}
?>