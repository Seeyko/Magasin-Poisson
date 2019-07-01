<?php
require_once (File::build_path(array(
    'model',
    'ModelUser.php'
)));

class ControllerUser
{

    public static $url_mailValidation = "http://webinfo.iutmontp.univ-montp2.fr/~andrieut/PHP/ProjetPHP/index.php?controller=user&action=validate";

    public static function read()
    {
        $user = ModelUser::getUserByMail($_POST['mail']);
        $controller = 'user';
        $view = 'detail';
        $pagetitle = $user->get('nom');
        require_once (File::build_path(array(
            'view',
            'global',
            'view.php'
        )));
    }

    public static function updated()
    {
        $user = ModelUser::getUserByMail($_SESSION['mail']);
    
        $user->update();
        self::update();
    }

    public static function connected()
    {
        $mail = $_POST['mail'];
        $password = $_POST['password'];

        $user = ModelUser::connectedUser($mail, $password);

        if (! $user) {
            echo ("<br><h1>Erreur lors de la connexion</h1>");
            self::connecte();
        } else {
            if (is_null($user->get('nonce'))) {
                $_SESSION['mail'] = $mail;
                $_SESSION['nom'] = $user->get('nom');
                $_SESSION['prenom'] = $user->get('prenom');
                if ($user->get('isAdmin') == 1) {
                    $_SESSION['isAdmin'] = $user->get('isAdmin');
                }
                self::accueil();
            } else {
                echo ("<br><h1>Veuillez validez votre mail</h1>");
                self::connecte();
            }
        }
    }

    public static function created()
    {
        $mail = $_POST['mail'];

        $valide_mail = filter_var($mail, FILTER_VALIDATE_EMAIL);

        if ($valide_mail) {
            $mail = $_POST['mail'];
            $password = $_POST['password'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];

            $user = ModelUser::createUser($mail, $password, $nom, $prenom);
        } else {
            echo ("<br><h1>Veuillez rentrez une adresse mail valide svp</h1>");
            self::create();
        }
        if ($user[0]) {
            ControllerUser::sendMail($user[1]);
        } else {
            if (strpos($user[1], "PRIMARY")) {
                echo ("<br><br>Cette email est déja utilisé ! ");
            } else {
                echo ("<br><br>Erreur inconnu veuillez contactez l'adminstrateur hello@tomandrieu.com avec ce message : <br><br> $user[1]");
            }
            self::create();
        }
    }

    public static function validate()
    {
        $mail = $_GET['mail'];
        $nonce = $_GET['nonce'];

        if (ModelUser::verifyUser($mail, $nonce)) {
            echo ("<h1>Bienvenue sur notre site vous êtes validé !</h1>");
            self::connecte();
        } else {
            echo ("<br><br>Erreur lors de votre vérification reclicquer sur le lien ou contactez un admin");
            self::create();
        }
    }

    public static function sendMail($user)
    {
        $mail = $_POST['mail'];

        $message = "Bonjour " . $_POST['nom'] . "<br>Voici le lien pour activer votre compte sur notre site MagasinPoisson<br><a href='" . self::$url_mailValidation . "&nonce=" . $user->get('nonce') . "&mail=" . $user->get('mail') . "'>Lien</a>";
        mail($mail, "Validation pour le projet PHP", $message, "Content-Type: text/html; charset=\'iso-8859-1\'");

        echo ("<h1>Va voir tes mails !</h1>");

        self::accueil();
    }

    public static function deconnect()
    {
        unset($_SESSION['isAdmin']);
        unset($_SESSION['mail']);
        unset($_SESSION['nom']);
        unset($_SESSION['prenom']);

        $controller = 'global';
        $view = 'accueil';
        $pagetitle = "Accueil";
        require_once (File::build_path(array(
            'view',
            'global',
            'view.php'
        )));
    }

    public static function update()
    {
        $user = ModelUser::getUserByMail($_SESSION['mail']);
        $controller = 'user';
        $view = 'compte';
        $pagetitle = "Mon compte";
        require_once (File::build_path(array(
            'view',
            'global',
            'view.php'
        )));
    }

    public static function connecte()
    {
        $controller = 'user';
        $view = 'connexion';
        $pagetitle = "Connexion";
        require_once (File::build_path(array(
            'view',
            'global',
            'view.php'
        )));
    }

    public static function create()
    {
        $controller = 'user';
        $view = 'inscription';
        $pagetitle = "Inscription";
        require_once (File::build_path(array(
            'view',
            'global',
            'view.php'
        )));
    }

    public static function accueil()
    {
        $controller = 'global';
        $view = 'accueil';
        $pagetitle = "Accueil";
        require_once (File::build_path(array(
            'view',
            'global',
            'view.php'
        )));
    }
}
?>
