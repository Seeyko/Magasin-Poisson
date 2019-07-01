<?php
require_once (File::build_path(array(
        'model',
        'Model.php'
)));

class ModelUser
{

    private $mail;

    private $password;

    private $nom;

    private $prenom;

    private $isAdmin;

    private $nonce;
    
    // La syntaxe ... = NULL signifie que l'argument est optionel
    // Si un argument optionnel n'est pas fourni,
    // alors il prend la valeur par d�faut, NULL dans notre cas
    public function __construct ($mail = NULL, $password = NULL, $nom = NULL, $prenom = NULL, 
            $isAdmin = NULL, $nonce = NULL)
    {
        if (! is_null($mail)) {
            $this->mail = $mail;
        }
        
        if (! is_null($password)) {
            $this->password = $password;
        }
        
        if (! is_null($nom)) {
            $this->nom = $n;
        }
        
        if (! is_null($prenom)) {
            $this->prenom = $p;
        }
        
        if (! is_null($isAdmin)) {
            $this->isAdmin = $isAdmin;
        }
        
        if (! is_null($nonce)) {
            $this->nonce = $nonce;
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

    public static function getAllUsers ()
    {
        $requete = "SELECT * FROM user";
        $result = Model::$pdo->query($requete);
        
        $result->setFetchMode(PDO::FETCH_CLASS, 'ModelUser');
        $tab_user = $result->fetchAll();
        // print_r($tab_voit);
        
        return $tab_user;
    }

    public static function createUser ($mail, $password, $nom, $prenom)
    {
        $sql = 'INSERT INTO user (mail, password, nom, prenom, isAdmin, nonce) VALUES (:m, :ps, :n, :p, 0, :no);';
        try {
            
            $req_prep = Model::$pdo->prepare($sql);
            $pass_hash = Security::mdp_hash($password);
            
            $nonce = Security::generateRandomHex();
            $values = array(
                    ':m' => $mail,
                    ':ps' => $pass_hash,
                    ':n' => $nom,
                    ':p' => $prenom,
                    ':no' => $nonce
            );
            
            $req_prep->execute($values);
        } catch (Exception $e) {
            return array(
                    false,
                    $e->getMessage()
            );
        }
        
        return array(
                true,
                self::getUserByMail($mail)
        );
    }

    public static function getUserByMail ($mail)
    {
        $sql = "SELECT * from user WHERE mail=:m";
        try {
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                    'm' => $mail
            );
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUser');
            $tab_user = $req_prep->fetchAll();
        } catch (PDOException $e) {
           
        }
        
        if (empty($tab_user)) {
            return false;
        }
        return $tab_user[0];
    }

    public static function connectedUser ($mail, $password)
    {
        $sql = 'SELECT * from user WHERE mail=:m';
        try {
            $req_prep = Model::$pdo->prepare($sql);
            
            $values = array(
                    'm' => $mail
            );
            
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUser');
            $user = $req_prep->fetch();
        } catch (PDOException $e) {
            
        }
        if ($user) {
            $mdp = $user->password;
            if (Security::mdp_verify($password, $mdp))
                return $user;
            else
                return false;
        } else
            return false;
    }

    public static function isVerify ($mail)
    {
        $sql = 'SELECT nonce from user WHERE mail=:m';
        try {
            $req_prep = Model::$pdo->prepare($sql);
            
            $values = array(
                    'm' => $mail
            );
            
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_OBJ);
            $nonce_is_null = $req_prep->fetch();
        } catch (PDOException $e) {
            
        }
        
        return is_null($nonce_is_null->nonce) ? true : false;
    }

    public static function verifyUser ($mail, $nonce)
    {
        $user = self::getUserByMail($mail);
        
        if ($user) {
            $sql = "UPDATE user SET nonce = NULL WHERE mail=:m";
            try {
                $req_prep = Model::$pdo->prepare($sql);
                
                $values = array(
                        'm' => $mail
                );
                
                $req_prep->execute($values);
            } catch (PDOException $e) {
               
            }
        }
        
        return self::isVerify($mail);
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
    
    public function update(){
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        try{
            $sql = "UPDATE `user` SET `nom`=:n, `prenom`=:p, WHERE mail = :m";
            $req_prep = Model::$pdo->prepare($sql);
            $req_prep->bindParam(":n",$nom);
            $req_prep->bindParam(":p",$prenom);
            $req_prep->bindParam(":m",$this->mail);
            
            $req_prep->execute();
        }catch(Exception $e){
            echo($e->getMessage());
        }
    }
}

?>

