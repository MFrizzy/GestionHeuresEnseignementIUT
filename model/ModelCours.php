<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelEnseignant.php'));
require_once File::build_path(array('model', 'ModelSalle.php'));
require_once File::build_path(array('model', 'ModelModule.php'));
require_once File::build_path(array('model', 'ModelSalle.php'));

class ModelCours extends Model
{

    protected static $object = 'Cours';
    protected static $primary = 'idCours';

    private $idCours;
    private $codeEns; // Objet Enseignant
    private $nomClasse; // Objet Classe
    private $dateCours;
    private $heureDebut;
    private $numSalle; // Objet Salle
    private $nomBatiment;
    private $codeModule; // Objet Module
    private $duree;
    private $typeCours;
    private $remarque;

    /**
     * @return mixed
     */
    public function getIdCours()
    {
        return $this->idCours;
    }

    /**
     * @return mixed
     */
    public function getCodeEns()
    {
        return $this->codeEns;
    }

    /**
     * @return mixed
     */
    public function getNomClasse()
    {
        return $this->nomClasse;
    }

    /**
     * @return mixed
     */
    public function getDateCours()
    {
        return $this->dateCours;
    }

    /**
     * @return mixed
     */
    public function getHeureDebut()
    {
        return $this->heureDebut;
    }

    /**
     * @return mixed
     */
    public function getNumSalle()
    {
        return $this->numSalle;
    }

    /**
     * @return mixed
     */
    public function getNomBatiment()
    {
        return $this->nomBatiment;
    }

    /**
     * @return mixed
     */
    public function getCodeModule()
    {
        return $this->codeModule;
    }

    /**
     * @return mixed
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @return mixed
     */
    public function getTypeCours()
    {
        return $this->typeCours;
    }

    /**
     * @return mixed
     */
    public function getRemarque()
    {
        return $this->remarque;
    }

    /**
     * @param mixed $codeEns
     */
    public function setCodeEns($codeEns)
    {
        $this->codeEns = $codeEns;
    }

    /**
     * @param mixed $nomClasse
     */
    public function setNomClasse($nomClasse)
    {
        $this->nomClasse = $nomClasse;
    }

    /**
     * @param mixed $numSalle
     */
    public function setNumSalle($numSalle)
    {
        $this->numSalle = $numSalle;
    }

    /**
     * @param mixed $codeModule
     */
    public function setCodeModule($codeModule)
    {
        $this->codeModule = $codeModule;
    }

    public static function selectAllByEns($codeEns)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeEns=:codeEns';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeEns' => $codeEns);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelCours');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setNumSalle(ModelSalle::select($item->getNomBatiment(),$item->getNumSalle()));
                $retourne[$cle]->setCodeEns(ModelEnseignant::select($item->getCodeEns()));
                $retourne[$cle]->setCodeModule(ModelModule::select($item->getCodeModule()));
                // Setter objet classe
                $retourne[$cle]->setNomClasse(ModelClasse::select($item->getNomClasse()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }
}