<?php

class Extraction
{
    /**
     * @param string $adresseFile
     * @return array
     */
    public static function csvToArray($adresseFile)
    {


    }

    /**
     * @param array $matrice
     * @return boolean
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
            if (Extraction::verifEnseignant($item)) {
                $codeActivite=$item[7];
                
            }



        }

    }

    public static function verifEnseignant($item)
    {
        if (!ModelEnseignant::select($item[1])) {
            $statut = ModelStatutEnseignant::selectByStatutType($item[3], $item[4]);
            if (!$statut) {
                //TODO ENTREE dans erreur
                return false;
            } else {
                $codeDepartement = ModelDepartement::selectByName($item[2]);
                if (!$codeDepartement) {
                    // TODO ENTREE DANS ERREUR + GRAPH
                    return false;
                } else {
                    if(ModelEnseignant::save(array(
                        'codeEns' => $item[1],
                        'nomEns' => $item[0],
                        'codeDepartement' => $codeDepartement->getCodeDepartement(),
                        'codeStatut' => $statut->getCodeStatut()
                    ))) return true;
                    else return false;
                }
            }
        }
        else return true;
    }

}