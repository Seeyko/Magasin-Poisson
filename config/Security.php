<?php


class Security
{
    private static $seed = 'gQOnkq0X2L';
    
    static public function getSeed() {
        return self::$seed;
    }
    
    static public function mdp_hash($mdp) {
        $seed_mdp = self::getSeed() . $mdp;
        $texte_chiffre = password_hash($seed_mdp, PASSWORD_BCRYPT);
        return $texte_chiffre;
    }
    
    static public function mdp_verify($password_param, $store_mdp) {
        $seed_mdp = self::getSeed() . $password_param;
        $equal = password_verify($seed_mdp, $store_mdp);
        return $equal;
    }
    
    static public function generateRandomHex() {
        // Generate a 32 digits hexadecimal number
        $numbytes = 16; // Because 32 digits hexadecimal = 16 bytes
        $bytes = openssl_random_pseudo_bytes($numbytes);
        $hex   = bin2hex($bytes);
        return $hex;
    }
       
}
?>