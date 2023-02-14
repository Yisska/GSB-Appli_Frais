<?php
/**
 * Index du projet GSB
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

require_once 'includes/fct.inc.php'; //avant de faire toute action on aura besoin de se qui va suivre
//c'est obligatoire pour le démarrage de la page, en orange c'est une adresse de fichier(chemin d'accès)
 
require_once 'includes/class.pdogsb.inc.php';
session_start(); /*fonction mettant en place une super globale SESSION
 * 
 */
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte() ;
require 'vues/v_entete.php';
$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);/* get=formulaire on voit les infos et 
 * post= info entourées d'un blocage pour empecher leur vue
 */
if ($uc && !$estConnecte) {
    $uc = 'connexion';
} elseif (empty($uc)) {
    $uc = 'accueil';
}
switch ($uc) {
case 'connexion':
    include 'controleurs/c_connexion.php';
    break;
case 'accueil':
    include 'controleurs/c_accueil.php';
    break;
case 'gererFrais':
    include 'controleurs/c_gererFrais.php';
    break;
case 'etatFrais':
    include 'controleurs/c_etatFrais.php';
    break;
case 'deconnexion':
    include 'controleurs/c_deconnexion.php';
    break;
case 'suivrePaiement':
    include 'controleurs/c_suiviPaiement.php';
    break;
case 'validerFrais':
    include 'controleurs/c_validerFrais.php';
    break;
}
require 'vues/v_pied.php';
