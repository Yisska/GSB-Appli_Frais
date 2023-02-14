<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
    case 'getlesVisteurs':
        $lesVisiteurs = $pdo->getLesVisiteurs();
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
        $lesCles[] = array_keys($lesVisiteurs);
        $visiteurASelectionner = $lesCles[0];
        $mois = getMois(date('d/m/Y'));
        $lesMois = getLesDouzeDerniersMois($mois);
        $lesCles1[] = array_keys($lesMois);
        $moisASelectionner = $lesCles1[0];
        include 'vues/v_moisEtvisiteur.php';
        break;
    case 'valider':
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $existeMois = $pdo->estPremierFraisMois($idVisiteur, $mois);
        if ($existeMois) {
            //!is_array veut dire n'est pas dans le tableau
            ajouterErreur('Aucune fiche de frais pour ce mois-ci');
            include 'vues/v_erreurs.php';
            header("Refresh: 3;URL=index.php?uc=validerFrais&action=getlesVisteurs");
        } else {

            $lesVisiteurs = $pdo->getLesVisiteurs();
            $visiteurASelectionner = $idVisiteur;
            $mois1 = getMois(date('d/m/Y'));
            $lesMois = getLesDouzeDerniersMois($mois1);
            $moisASelectionner = $mois;
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
            $nombredejustificatif = $pdo->getNbjustificatifs($idVisiteur, $mois);

            include 'vues/v_detailsFraisForfait.php';
        }
        break;

    case 'quatreboutons';
        //si fonction ne retourne rien (return=null) la fonction appelée n'a pas de variable devant elle
        // la variable "les Frais" correspond aux données filtrées des fiches forfait par le filter input qu'elles soient corrigées ou non
        // dans le Filter input la valeur entre cote est trouvée grace au name correspondant à cette partie dans la vue 
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
        $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
        $idFrais = filter_input(INPUT_POST, 'idFrais', FILTER_SANITIZE_STRING);
        
        // isset vérifie le contenu de la variable POST et POST prend la valeur des différents boutons sur lequel on clique
        if (isset($_POST['corrigerfichef'])) {
            $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
            ajouterErreur('Votre modification a bien été prise en compte');
            include 'vues/v_erreurs.php';
            header("Refresh: 2;URL=index.php?uc=validerFrais&action=getlesVisiteurs");
            
        }else if (isset($_POST['validerfichef'])) {
            $pdo->majFraisHorsForfait($idVisiteur, $idFrais, $montant, $libelle, $mois);
            ajouterErreur('Votre modification a bien été prise en compte');
            include 'vues/v_erreurs.php';
            header("Refresh: 2;URL=index.php?uc=validerFrais&action=getlesVisiteurs");
            
        } else if (isset($_POST['reporterfichef'])) {
            //$pdo->supprimerFraisHorsForfait($idFrais);
            //$pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant,$moisactuel); 
            $libelle = 'refusé '.$libelle;
            $moisactuel = getMois(date('d/m/Y'));
            var_dump($idVisiteur,$mois,$libelle,$date,$montant,$moisactuel);
            
        } else if (isset($_POST['toutvalider'])) {
            $etat='VA';
            $pdo->majEtatFicheFrais($idVisiteur, $mois, $etat);
            $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteur, $mois);
            //$pdo->majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs); mise ajour pas par comptable mais par un pdf mais la fct n'est pas la pr pdf
            $sommeHF=$pdo->getMontantHF($idVisiteur,$mois);
            $totalHF=$sommeHF[0][0];
            $sommeFF=$pdo->getMontantFF($idVisiteur,$mois);
            $totalFF=$sommeFF[0][0];
            $montantTotal=$totalHF+$totalFF;
            $pdo->majTotal($idVisiteur,$mois,$montantTotal);
            include 'vues/v_retourAccueil.php';
        }
        
        break;
}