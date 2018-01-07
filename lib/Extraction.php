<?php

// Temporaire
require_once File::build_path(array('model', 'ModelCours.php'));

class Extraction
{

    /**
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
                        if (!ModelCours::save(array(
                            'codeEns' => $item[1],
                            'dateCours' => $item[5],
                            'codeModule' => $module->getCodeModule(),
                            'duree' => $item[6],
                            'typeCours' => $item[8]
                        ))) ControllerMain::erreur("Impossible de sauvegarder le cours");
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
                    if (!ModelCours::save(array(
                        'codeEns' => $item[1],
                        'dateCours' => $item[5],
                        'codeModule' => $module->getCodeModule(),
                        'duree' => $item[6],
                        'typeCours' => $item[8]
                    ))) ControllerMain::erreur("Impossible de sauvegarder le cours");
                    else return true;
                } else ModelErreurExport::update(array(
                    'idErreur' => $erreur->getIdErreur() ,
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

    public static function verifDepartement($codeActivite)
    {
        if(isset($codeActivite[1])) {
            if (!ModelDepartement::select($codeActivite[1])) {
                return false;
            } else {
                return true;
            }
        } else return false;
    }

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

}