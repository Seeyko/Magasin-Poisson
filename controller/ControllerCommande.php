<?php
require_once (File::build_path(array(
    'model',
    'ModelCommande.php'
)));

class ControllerCommande
{

    public static function addPanier()
    {
        $id_item = $_POST['id_poisson']; // On recupere l'id du produit
        $qte = $_POST['quantite']; // On recupere la quantite qu'on veut ajouter
                                   // au panier
        if ($qte > 0) {
            $key = 0; // numéro ou est le produit
            $found = false;
            $panier = null;

            if (isset($_COOKIE['panier'])) {
                $panier = unserialize($_COOKIE['panier']);
            }
            if ($panier) {
                foreach ($panier as $p) { // On cherche si dans notre panier on
                                          // a déja le produit
                    if ($p[0] == $id_item) {
                        $found = true;
                        break; // Quand on break, $key est donc egale a
                               // l'endroit ou se situe notre produit dans
                               // l'array
                    }
                    $key ++;
                }
            }
            if ($found) { // Si on l'a trouvé dans notre panier
                setcookie("panier", "", time() - 1, "/"); // On supprime le
                                                          // cookie panier
                $panier[$key][1] += $qte; // On ajouter la quantite voulu a ce
                                          // qu'il y avait déja dans le panier
                setcookie("panier", serialize($panier), time() + 86400 * 5, "/"); // On
                                                                                  // le
                                                                                  // remet
            } else { // Si le produit n'etait pas déja dans notre panier
                setcookie("panier", "", time() - 1, "/"); // On supprime le
                                                          // cookie
                if (! $panier) { // Si le panier n'existais pas du tout qu'il
                                 // etait vide, on l'initialise en disant que
                                 // c'est une array contenant des arrays(id
                                 // produit, quantite)
                    $panier = array(
                        array(
                            $id_item,
                            $qte
                        )
                    );
                } else { // SI le panier existais déja
                    array_push($panier, array(
                        $id_item,
                        $qte
                    )); // On ajoute a la fin du panier une nouvelle
                       // array avec l'id du produit et ça quantité
                       // demandais
                }
                setcookie("panier", serialize($panier), time() + 86400 * 5, "/");
            }
        }
    }

    public static function changeQuantity()
    {
        $id_item = $_POST['id_poisson'];
        $qte = $_POST['quantite'];
        if ($qte < 1) {
            self::removePanier();
        } else {
            $panier = unserialize($_COOKIE['panier']);

            setcookie("panier", "", time() - 1, "/");

            $i = 0;
            foreach ($panier as $key) {
                if ($key[0] == $id_item) {
                    $panier[$i][1] = $qte;
                    break;
                }
                $i ++;
            }
            setcookie("panier", serialize($panier), time() + 86400 * 5, "/");
        }
    }

    public static function removePanier($qte)
    {
        $id_item = $_POST['id_poisson'];

        $key = 0;
        $found = false;
        $panier = null;
        if (isset($_COOKIE['panier'])) {
            $panier = unserialize($_COOKIE['panier']);
        }
        if ($panier) {
            foreach ($panier as $p) {
                if ($p[0] == $id_item) {
                    $found = true;
                    break;
                }
                $key ++;
            }
        }
        if ($found) {
            if ($panier[$key][1] > $qte) {
                $panier[$key][1] -= $qte;
            } else {
                $panier[$key] = null;
            }
            setcookie("panier", serialize($panier), time() + 86400 * 5, "/");
        }
    }

    public static function command()
    {
        if (isset($_SESSION['mail'])) {
            if (isset($_COOKIE['panier'])) {
                $panier = unserialize($_COOKIE['panier']);

                $user = ModelUser::getUserByMail($_SESSION['mail']);
                $command = $user->command($panier);

                setcookie("panier", "", time() - 1, "/");

                echo ("Votre commande a bien été passé !");
                ControllerUser::update();
            }else{
                ControllerUser::accueil();
            }
        } else {
            echo ("Veuillez vous connectez avant de commandez !");
            self::panier();
        }
    }

    public static function panier()
    {
        $items = ModelPoisson::getAllPoissons();
        $controller = 'panier';
        $view = 'panier';
        $pagetitle = "Panier";
        require_once (File::build_path(array(
            'view',
            'global',
            'view.php'
        )));
    }

    public static function read()
    {
        $commandes = ModelCommande::getCommandeForUser($_SESSION['mail']);
        require_once File::build_path(array(
            'view',
            'user',
            'command.php'
        ));
    }
}
?>
