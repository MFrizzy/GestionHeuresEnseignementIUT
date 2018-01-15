<?php

// Temporaire
require_once File::build_path(array('model', 'ModelCours.php'));

class Extraction
{

    /**
     * Lit le fichier à l'adresse donnée en paramètre et le transforme en tableau php
     *
     * @param string $adresseFile
     * @return array
     */
    public static function csvToArray($adresseFile)
    {
        $cours = array();
        if (($handle = fopen($adresseFile, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 200, ",")) !== FALSE) {
                array_push($cours, $data);
            }
            fclose($handle);
        }
        return $cours;
    }

    /**
     * Lit le tableau donné en paramètre, l'analyse et l'envoie dans la BDD
     *
     * @param array $matrice
     */
    public static function ArrayToBDD($matrice)
    {
        /*
         * Struct :     0 : nomEns
         *              1 : codeEns
         *              2 : DepartementEns
         *              3 : Statut 1
         *              4 : Statut 2
         *              5 : Date
         *              6 : Durée
         *              7 : Code Activitée
         *              8 : Type Activitée
         *              9 : TODO SUITE
         */
        foreach ($matrice as $cle => $item) {
            $verif = Extraction::verifEnseignant($item);
            switch ($verif) {
                case 1:
                    $codeActivite = $item[7];
                    if (Extraction::verifDepartement($codeActivite)) {
                        $diplome = Extraction::verifDiplome($codeActivite);
                        if ($diplome->getTypeDiplome()[0] == 'P') $preCodeActivite = substr($codeActivite, 4);
                        else $preCodeActivite = substr($codeActivite, 3);
                        $ue = Extraction::verifUE($preCodeActivite, $diplome);
                        $module = Extraction::verifModule($preCodeActivite, $ue);
                        $date = Extraction::verifDate($item[5]);
                        if(!$date) Extraction::erreur($item,'date invalide');
                        else {
                            if (!ModelCours::save(array(
                                'codeEns' => $item[1],
                                'dateCours' => $date,
                                'codeModule' => $module->getCodeModule(),
                                'duree' => $item[6],
                                'typeCours' => $item[8]
                            ))) ControllerMain::erreur("Impossible de sauvegarder le cours");
                        }
                    } else Extraction::erreur($item, 'Département invalide');
                    break;
                case 2:
                    Extraction::erreur($item, 'statut');
                    break;
                case 3:
                    Extraction::erreur($item, 'departementEns');
                    break;
                default:
                    Extraction::erreur($item, '');
                    break;
            }
        }
    }


    /**
     * Analyse l'objet @see ModelErreurExport et l'enregistre dans la bdd
     *
     * @param $erreur ModelErreurExport
     * @return bool vrai si l'erreur est résolue, faux sinon
     */
    public static function erreurToBD($erreur)
    {
        $item = array(
            $erreur->getNomEns(),
            $erreur->getCodeEns(),
            $erreur->getDepartementEns(),
            $erreur->getStatut(),
            $erreur->getTypeStatut(),
            $erreur->getDateCours(),
            $erreur->getDuree(),
            $erreur->getActivitee(),
            $erreur->getTypeActivitee()
        );
        ModelErreurExport::delete($erreur->getIdErreur());
        $verif = Extraction::verifEnseignant($item);
        switch ($verif) {
            case 1:
                $codeActivite = $item[7];
                if (Extraction::verifDepartement($codeActivite)) {
                    $diplome = Extraction::verifDiplome($codeActivite);
                    if ($diplome->getTypeDiplome()[0] == 'P') $preCodeActivite = substr($codeActivite, 4);
                    else $preCodeActivite = substr($codeActivite, 3);
                    $ue = Extraction::verifUE($preCodeActivite, $diplome);
                    $module = Extraction::verifModule($preCodeActivite, $ue);
                    $date = Extraction::verifDate($item[5]);
                    if(!$date) Extraction::erreur($item,'date invalide');
                    else {
                        if (!ModelCours::save(array(
                            'codeEns' => $item[1],
                            'dateCours' => $item[5],
                            'codeModule' => $module->getCodeModule(),
                            'duree' => $item[6],
                            'typeCours' => $item[8]
                        ))) ControllerMain::erreur("Impossible de sauvegarder le cours");
                        else return true;
                    }
                } else ModelErreurExport::update(array(
                    'idErreur' => $erreur->getIdErreur(),
                    'typeErreur' => 'Département invalide'
                ));
                break;
            case 2:
                ModelErreurExport::update(array(
                    'idErreur' => $erreur->getIdErreur(),
                    'typeErreur' => 'statut'
                ));
                break;
            case 3:
                ModelErreurExport::update(array(
                    'idErreur' => $erreur->getIdErreur(),
                    'typeErreur' => 'departementEns'
                ));
                break;
            default:
                ModelErreurExport::update(array(
                    'idErreur' => $erreur->getIdErreur(),
                    'typeErreur' => ''
                ));
                break;
        }
        return false;
    }

    /**
     * Vérifie à partir d'un tableau si l'enseignant existe
     *
     * @param $item array
     * @return bool|int
     *      - bool si la création de l'enseignant échoue
     *      - int : - 1 : l'enseigant existe déjà
     *              - 2 : le statut de l'enseigant n'existe pas
     *              - 3 : le département de l'enseignant n'existe pas
     */
    public static function verifEnseignant($item)
    {
        if (!ModelEnseignant::select($item[1])) {
            $statut = ModelStatutEnseignant::selectByStatutType($item[3], $item[4]);
            if (!$statut) {
                return 2;
            } else {
                $codeDepartement = ModelDepartement::selectByName($item[2]);
                if (!$codeDepartement) {
                    return 3;
                } else {
                    if (ModelEnseignant::save(array(
                        'codeEns' => $item[1],
                        'nomEns' => $item[0],
                        'codeDepartement' => $codeDepartement->getCodeDepartement(),
                        'codeStatut' => $statut->getCodeStatut()
                    ))) return 1;
                    else return false;
                }
            }
        } else return 1;
    }

    /**
     * Vérifie si le département du code d'activité existe
     *
     * @param $codeActivite
     * @return bool : true si le département existe, non sinon
     */
    public static function verifDepartement($codeActivite)
    {
        if (isset($codeActivite[1])) {
            if (!ModelDepartement::select($codeActivite[1])) {
                return false;
            } else {
                return true;
            }
        } else return false;
    }

    /**
     * Vérifie l'existance du Diplome dans le code d'acitivité
     *
     * Si le diplome existe, il le renvoie
     * Sinon, il le créé et le renvoie
     *
     * @param $codeActivite
     * @return ModelDiplome
     */
    public static function verifDiplome($codeActivite)
    {
        $numDiplome = $codeActivite[2];
        if ($numDiplome == 'P') {
            $numDiplome = $codeActivite[2] . $codeActivite[3];
        }
        $diplome = ModelDiplome::selectBy($codeActivite[1], $numDiplome);
        if (!$diplome) {
            ModelDiplome::save(array(
                'codeDepartement' => $codeActivite[1],
                'typeDiplome' => $numDiplome
            ));
            $diplome = ModelDiplome::selectBy($codeActivite[1], $numDiplome);
        }
        return $diplome;
    }

    /**
     * Vérifie l'existance de l'unité d'enseignement
     *
     * Si l'unité d'enseignement existe, il le renvoie
     * Sinon, il le créé et le renvoie
     *
     * @param $precodeActivite string : morceau du code d'activité
     * @param $diplome ModelDiplome
     * @return ModelUniteDEnseignement
     */
    public static function verifUE($precodeActivite, $diplome)
    {
        $ue = ModelUniteDEnseignement::selectBy($diplome->getCodeDiplome(), $precodeActivite[0], $precodeActivite[1]);
        if (!$ue) {
            ModelUniteDEnseignement::save(array(
                'codeDiplome' => $diplome->getCodeDiplome(),
                'idUE' => $precodeActivite[1],
                'semestre' => $precodeActivite[0]
            ));
            $ue = ModelUniteDEnseignement::selectBy($diplome->getCodeDiplome(), $precodeActivite[0], $precodeActivite[1]);
        }
        return $ue;
    }

    /**
     * Vérifie l'existance du Module
     *
     * Si le module existe, il le renvoie
     * Sinon, il le créé et le renvoie
     *
     * @param $precodeActivite string
     * @param $ue ModelUniteDEnseignement
     * @return ModelModule
     */
    public static function verifModule($precodeActivite, $ue)
    {
        $module = ModelModule::selectBy($ue->getNUE(), substr($precodeActivite, 2));
        if (!$module) {
            ModelModule::save(array(
                'nUE' => $ue->getNUE(),
                'numModule' => substr($precodeActivite, 2)
            ));
            $module = ModelModule::selectBy($ue->getNUE(), substr($precodeActivite, 2));
        }
        return $module;
    }

    /**
     * Enregistre dans la table ErreurExport la ligne posant problème ainsi que l'erreur
     *
     * @param $item array
     * @param $typeErreur string
     */
    public static function erreur($item, $typeErreur)
    {
        ModelErreurExport::save(array(
            'nomEns' => $item[0],
            'codeEns' => $item[1],
            'departementEns' => $item[2],
            'statut' => $item[3],
            'typeStatut' => $item[4],
            'dateCours' => $item[5],
            'duree' => $item[6],
            'activitee' => $item[7],
            'typeActivitee' => $item[8],
            'typeErreur' => $typeErreur
        ));
    }

    /**
     * @param $date | @var $item[5]
     */
    public static function verifDate($date)
    {
        $date = explode('/', $date);
        if (count($date) == 3) {
            switch (strlen($date[2])) {
                case 2:
                    $annee = '20'.$date[2];
                    break;
                case 4:
                    $annee = $date[2];
                    break;
                default:
                    return false;
                    break;
            }
            $dateAuBonFormat = $annee.'-'.$date[1].'-'.$date[0];
            return $dateAuBonFormat;
        } else return false;
    }

}