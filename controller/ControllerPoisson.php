<?php
require_once (File::build_path(array('model','ModelPoisson.php'))); // chargement du modèle


class ControllerPoisson {
    
    public static function readAll() {
        $sortedMode = null;
        $asc = null;
        $filters = null;
        if(isset($_POST['tri'])){
            $a  = explode("_", $_POST['tri']);
            $sortedMode = $a[0];  
            $asc = $a[1] == 'asc' ? true : false;
        }        
        if(isset($_POST['filter'])){
            $filters = $_POST['filter'];   
        }
        
        $tab_poisson = ModelPoisson::getAllPoissons($sortedMode, $asc, $filters);
      
        $controller='poisson';
        $view='list';
        $pagetitle='Liste des Poissons';

        require (File::build_path(array('view' , 'global' , 'view.php')));  //'redirige' vers la vue
    }

   public static function read() {
   		$id = $_GET['id'];
        $poisson = ModelPoisson::getById($id);     //appel au modèle pour gerer la BD
        $controller='poisson';
        $view='detail';
        $pagetitle='Detail du Poissons';

        require (File::build_path(array('view' , 'global' , 'view.php')));  //'redirige' vers la vue
    }

    public static function create() {
        if(!isset($_SESSION['isAdmin'])){
            self::readAll();
            return;
        }
        $nomScientifique = $_POST['nomScientifique'];
        $nomCommun = $_POST['nomCommun'];
        
        $prix = $_POST['prix'];
        $taille = $_POST['taille'];
        $zoneDeVie = $_POST['zoneDeVie'];
        $esperanceDeVie = $_POST['esperanceDeVie'];
        $famille = $_POST['famille'];
        
        $poisson = new ModelPoisson(null, $nomScientifique, $famille, $nomCommun, $taille, $zoneDeVie, $esperanceDeVie, $prix);
        echo 'Poisson crée';
    	$poisson->save();
    	ControllerPoisson::readAll();
    }
    public static function created(){
        if(!isset($_SESSION['isAdmin'])){
            self::readAll();
            return;
        }
        $controller='poisson';
        $view='create';
        $pagetitle='Ajouter un Poissons';
        
        require (File::build_path(array('view' , 'global' , 'view.php')));  //'redirige' vers la vue
    }
    
    public static function delete(){
       
        ModelPoisson::deleteBycodeP($_POST['id_poisson']);
    }
    public static function update(){
        if(!isset($_SESSION['isAdmin'])){
            self::readAll();
            return;
        }
        $poisson = ModelPoisson::getById($_GET['id']);
        $prix = $_POST['prix'];
        $taille = $_POST['taille'];
        $zoneDeVie = $_POST['zoneDeVie'];
        $esperanceDeVie = $_POST['esperanceDeVie'];
        $famille = $_POST['famille'];
        $poisson->update($prix, $taille, $zoneDeVie, $esperanceDeVie, $famille);
        self::read();
    }

}


?>
