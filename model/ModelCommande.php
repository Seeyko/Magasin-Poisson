<?php
require_once (File::build_path(array(
        'model',
        'Model.php'
)));

class ModelCommande
{

    private $Code_co;

    private $mail;

    private $id_poisson;

    private $quantite;

    
    public function __construct ($Code_co = NULL, $mail = NULL, $id_poisson = NULL, $quantite = NULL)
    {
        if (! is_null($mail)) {
            $this->mail = $mail;
        }
        
        if (! is_null($Code_co)) {
            $this->Code_co = $Code_co;
        }
        
        if (! is_null($id_poisson)) {
            $this->id_poisson = $id_poisson;
        }
        
        if (! is_null($quantite)) {
            $this->quantite = $quantite;
        }
    }

    public function get ($p)
    {
        return $this->$p;
    }

    public function set ($p, $v)
    {
        $this->$p = $v;
    }

    public static function getAllCommandes ()
    {
        $requete = "SELECT * FROM passeCommande";
        $result = Model::$pdo->query($requete);
        
        $result->setFetchMode(PDO::FETCH_OBJ);
        $tab_user = $result->fetchAll();
        // print_r($tab_voit);
        
        return $tab_user;
    }


    public static function getCommandeForUser ($mail)
    {
        $sql = "SELECT c.Code_co, id_poisson, quantite from Commandes c JOIN passeCommande pc ON pc.Code_co = c.Code_co AND mail=:m ";
        try {
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                    'm' => $mail
            );
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_OBJ);
            $tab_commandes = $req_prep->fetchAll();
        } catch (PDOException $e) {
           
        }
        
        $commandes = array();
        foreach ($tab_commandes as $c){
            if(isset($commandes[$c->Code_co])){
                array_push($commandes[$c->Code_co],  array($c->id_poisson, $c->quantite));
            }else{
                $commandes[$c->Code_co] = array( array($c->id_poisson, $c->quantite));
            }
            
        }
       
        return $commandes;
        
    }


    public function command ($panier)
    {
        try {
            $sql = "INSERT INTO passeCommande(mail)
                VALUES(:m)";
            $req_prep = Model::$pdo->prepare($sql);
            
            $values = array(
                    ':m' => $this->mail
            );
            
            $req_prep->execute($values);
        } catch (Exception $e) {
        }
        
        $idCommande = Model::$pdo->lastInsertId('Code_co');
        foreach ($panier as $item) {
            $id = $item[0];
            $qte = $item[1];
            
            try {
                $sql = "INSERT INTO Commandes(Code_co, id_Poisson , quantite)
                    VALUES(:co, :id , :qte) ";
                $req_prep = Model::$pdo->prepare($sql);
                
                $values = array(
                        'co' => $idCommande,
                        'id' => $id,
                        'qte' => $qte
                );
                
                $req_prep->execute($values);
            } catch (Exception $e) {
                
            }
        }
    }
    
    public function getCommandes(){
        try {
            $sql = "SELECT DISTINCT c.Code_co, id_Poisson, quantite FROM Commandes c JOIN passeCommande pc ON c.Code_co = pc.Code_co WHERE pc.mail = :m";
            $req_prep = Model::$pdo->prepare($sql);
            $req_prep->bindParam(':m', $this->mail);
           
        
            $req_prep->execute();
            $commandes = $req_prep->fetchAll(PDO::FETCH_OBJ);
            return $commandes;
        } catch (Exception $e) {
        }
    }
    
}

?>

