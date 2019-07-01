<?php
require_once (File::build_path(array(
    'model',
    'Model.php'
)));

class ModelPoisson
{

    private $id_poisson;

    private $taille;

    private $famille;

    private $nomCommun;

    private $nomScientifique;

    private $zoneDeVie;

    private $esperanceDeVie;

    private $prix;

    // un constructeur
    public function __construct($id = NULL, $n_sc = NULL, $fam = NULL, $n_c = NULL, $taille = NULL, $zdv = NULL, $edv = NULL, $prix = NULL)
    {
        if (! is_null($id)) {
            $this->id_poisson = $id;
        }
        if (! is_null($n_sc)) {
            $this->nomScientifique = $n_sc;
        }
        if (! is_null($fam)) {
            $this->famille = $fam;
        }
        if (! is_null($n_c)) {
            $this->nomCommun = $n_c;
        }
        if (! is_null($taille)) {
            $this->taille = $taille;
        }
        if (! is_null($zdv)) {
            $this->zoneDeVie = $zdv;
        }
        if (! is_null($edv)) {
            $this->esperanceDeVie = $edv;
        }
        if (! is_null($prix)) {
            $this->prix = $prix;
        }
    }

    // un getter
    public function get($v)
    {
        return $this->$v;
    }

    public function image()
    {
        return file_exists("assets/produits/poissons/$this->nomCommun.jpg") ? "assets/produits/poissons/$this->nomCommun.jpg" : "assets/produits/poissons/default.jpg";
    }

    // une methode d'affichage.
    /*
     * public function afficher() {
     * echo "<plPoisson {$this->codeP} de taille {$this->taille} typeEau
     * {$this->typeEau} </p>";
     * // À compléter dans le prochain exercice
     * }
     */
    public static function getAllPoissons($sortedMode = NULL, $asc = NULL, $filters = NULL)
    {
        $sql = "SELECT * from Poissons";
        $i = 0;

        $old_Column = null;
        $column_name = null;
        if (! is_null($filters)) {
            $sql .= " WHERE ";
            foreach ($filters as $filter) {
                $a = explode("_", $filter);
                $column_name = $a[0];
                if ($i > 0) {
                    $sql .= ($column_name != $old_Column ? " AND " : " OR ") . "$column_name =:filtre$i ";
                } else {
                    $sql .= $column_name . " =:filtre$i ";
                }
                $i ++;
                $old_Column = $column_name;
            }
        }

        if (! is_null($sortedMode)) {
            $possibleSort = array(
                'prix',
                'nomCommun',
                'taille'
            );
            if (in_array($sortedMode, $possibleSort)) {
                $sql .= " ORDER BY $sortedMode " . ($asc ? "" : "DESC");
            } else {
                $sql .= " ORDER BY nomCommun " . ($asc ? "" : "DESC");
            }
        } else {
            $sql .= " ORDER BY nomCommun ";
        }

        try {
            $req_prep = Model::$pdo->prepare($sql);
            $param = array();

            if (! is_null($filters)) {
                $i = 0;
                foreach ($filters as $filter) {
                    $a = explode("_", $filter);
                    $value = $a[1];
                    $param["filtre$i"] = $value;
                    $i ++;
                }
            }

            // echo ("<pre>" . print_r($sql) . "</pre>");
            // echo ("<pre>" . print_r($param) . "</pre>");

            $req_prep->execute($param);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelPoisson');
            $tab_p = $req_prep->fetchAll();
            return $tab_p;
        } catch (Exception $e) {}
        return false;
    }

    public static function getById($id)
    {
        try {
            $sql = "SELECT * from Poissons WHERE id_poisson=:nom_tag";
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                "nom_tag" => $id
            );
            // nomdutag => valeur, ...

            // On donne les valeurs et on exécute la requête
            $req_prep->execute($values);

            // On récupère les résultats comme précédemment
            $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelPoisson');
            $tab_voit = $req_prep->fetchAll();
            // Attention, si il n'y a pas de résultats, on renvoie false
            if (empty($tab_voit)) {
                return false;
            }
            return $tab_voit[0];
        } catch (Exception $e) {}
    }

    public function save()
    {
        try {
            $sql = "INSERT INTO Poissons (nomScientifique, famille, nomCommun, taille, zoneDeVie, esperanceDeVie, prix) VALUES (:ns, :f, :nc, :t, :zdv, :edv, :p)";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                ":ns" => $this->nomScientifique,
                ":f" => $this->famille,
                ":nc" => $this->nomCommun,
                ":t" => $this->taille,
                ":zdv" => $this->zoneDeVie,
                ":edv" => $this->esperanceDeVie,
                ":p" => $this->prix
            );
            $req_prep->execute($values);
        } catch (Exception $e) {}
    }

    public function update($prix, $taille, $zdv, $edv, $fam)
    {
        try {
            $sql = "UPDATE `Poissons` SET `famille`=:f, `taille`=:t, `zoneDeVie`=:z, `esperanceDeVie`=:e, `prix`=:p WHERE id_poisson=:i";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                ":p" => $prix,
                ":f" => $fam,
                ":t" => $taille,
                ":z" => $zdv,
                ":e" => $edv,
                ":i" => $this->id_poisson
            );
            $req_prep->execute($values);
        } catch (Exception $e) {}
    }

    public static function deleteBycodeP($codeP)
    {
        try {
            $sql = "DELETE FROM Poissons WHERE id_poisson = :i";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                ":i" => $codeP
            );
            $req_prep->execute($values);
        } catch (Exception $e) {}
    }

    public static function getColumn($c)
    {
        try {
            $sql = "SELECT DISTINCT $c from Poissons";
            $req_prep = Model::$pdo->prepare($sql);

            $req_prep->execute();

            $zdv = $req_prep->fetchAll(PDO::FETCH_OBJ);
            // Attention, si il n'y a pas de résultats, on renvoie false
            if (empty($zdv)) {
                return false;
            }
            return $zdv;
        } catch (Exception $e) {}
    }
}
?>


