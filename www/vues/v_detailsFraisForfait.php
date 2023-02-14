<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>
<form method="post" action="index.php?uc=validerFrais&action=quatreboutons" 
      role="form">
    <div class="row">
        <div class="col-md-4">

            <div class="form-group">
                <label for="lstVisiteurs" accesskey="n">Visiteur : </label>
                <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $id = $unVisiteur['id'];
                        $nom = $unVisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                        if ($id == $visiteurASelectionner) {
                            ?>
                            <option selected value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>
        </div>
        <div class="col-md-4">

            <div class="form-group">
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        if ($mois == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>
        </div>       
        <br>  <br> <br>       
        <div class="row">    
            <h3>Eléments forfaitisés</h3>
            <div class="col-md-4">

                <fieldset>       
                    <?php
                    foreach ($lesFraisForfait as $unFrais) {
                        $idFrais = $unFrais['idfrais'];
                        $libelle = htmlspecialchars($unFrais['libelle']);
                        $quantite = $unFrais['quantite'];
                        ?>
                        <div class="form-group">
                            <label for="idFrais"><?php echo $libelle ?></label>
                            <input type="text" id="idFrais" 
                                   name="lesFrais[<?php echo $idFrais ?>]"
                                   size="10" maxlength="5" 
                                   value="<?php echo $quantite ?>" 
                                   class="form-control">
                        </div>
                        <?php
                    }
                    ?>
                    <input class="btn btn-success" id="corrigerfichef" name="corrigerfichef" type="submit" value="Corriger" />

                    <input class="btn btn-danger" id="reinitialiserfichef" name="reinitialiserfichef" type="reset" value="Reinitialiser" />
                    <!--<a href="index.php?uc=validerFrais&action=corrigerfichef">
                        <p><input id='validerfichef'  name='validerfichef' class="btn btn-success" type="submit">Corriger>
                    </a>
                    <button class="btn btn-danger" type="reset">Réinitialiser</button>-->

                </fieldset>

            </div>
        </div>
        <br> <br>
        <div class="row">
            <div class="panel" style="border-color: #ec971f;color:#fff">

                <div class="panel-heading" style="background-color: #ec971f">Descriptif des éléments hors forfait</div>
                <table class="table table-bordered table-responsive" style="color: #000" >
                    <thead>
                        <tr>
                            <th class="date">Date</th>
                            <th class="libelle">Libellé</th>  
                            <th class="montant">Montant</th> 
                            <th class="action">&nbsp;</th> 
                        </tr>
                    </thead>  
                    <tbody>
                        <?php
                        foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                            $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                            $date = $unFraisHorsForfait['date'];
                            $montant = $unFraisHorsForfait['montant'];
                            $idFrais = $unFraisHorsForfait['id'];
                            ?>           
                            <tr>
                                <td><input type="text" name="date" value="<?php echo $date ?>"></td>
                                <td> <input type="text" name="libelle" value="<?php echo $libelle ?>"></td>
                                <td><input type="text" name="montant" value="<?php echo $montant ?>" >
                                    <input type="hidden" name="idFrais" value="<?php echo $idFrais?>"></td>
                              
                                <td><input class="btn btn-success" id='validerfichef' name='validerfichef' type='submit' value='Corriger'/>
                                    <input class="btn btn-danger" id='reporterfichef' name='reporterfichef' type='submit' value='Reporter'>
                                    <!-- <a href="index.php?uc=validerFrais&action=validerfichef">
                                       <button class="btn btn-success" type="submit">Valider</button>
                                        </a>
                                    <a href="index.php?uc=validerFrais&action=retirerfichef">
                                        <button class="btn btn-danger" type="submit">Reporter</button>
                                    </a>-->

                                </td>
                            </tr>

                            <?php
                        }
                        ?>

                    </tbody>  
                </table>
            </div>
        </div>
    </div>

    <label for="lstVisiteur" accesskey="n"> Nombre de justificatif : <input size="10" maxlength="5" 
                                                                            name="nbrejustificatifs" value="<?php echo $nombredejustificatif ?>"></label>
    <br>
    <input class="btn btn-success" id='toutvalider' name='toutvalider' type='submit' value='Valider' />
    <!--<button class="btn btn-success" type="submit">Valider</button>-->
</form>
