<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelStatutEnseignant.php'));
require_once File::build_path(array('model', 'ModelDepartement.php'));

class ModelEnseignant extends Model
{

    // Nom de la table
    protected static $object = 'Enseignant';
    protected static $primary = 'codeEns';

    private $codeEns;
    private $codeStatut;
    private $nomEns;
    private $prenomEns;
    private $etatService;
    private $codeDepartement;
    private $remarque;

    /**
     * @return mixed
     */
    public function getRemarque()
    {
        return $this->remarque;
    }

    /**
     * @return mixed
     */
    public function getCodeDepartement()
    {
        return $this->codeDepartement;
    }

    /**
     * @param mixed $codeDepartement
     */
    public function setCodeDepartement($codeDepartement)
    {
        $this->codeDepartement = $codeDepartement;
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
    public function getCodeStatut()
    {
        return $this->codeStatut;
    }

    /**
     * @param mixed $codeStatut
     */
    public function setCodeStatut($codeStatut)
    {
        $this->codeStatut = $codeStatut;
    }

    /**
     * @return mixed
     */
    public function getNomEns()
    {
        return $this->nomEns;
    }

    /**
     * @return mixed
     */
    public function getPrenomEns()
    {
        return $this->prenomEns;
    }

    /**
     * @return mixed
     */
    public function getEtatService()
    {
        return $this->etatService;
    }

    /**
     * @param $primary_value
     * @return bool
     */
    public static function select($primary_value)
    {
        $retourne = parent::select($primary_value);
        if(!$retourne) return false;
        $retourne->setCodeStatut(ModelStatutEnseignant::select($retourne->getCodeStatut()));
        $retourne->setCodeDepartement(ModelDepartement::select($retourne->getCodeDepartement()));
        return $retourne;
    }

    public static function selectAll()
    {
        $retourne = parent::selectAll();
        foreach ($retourne as $cle => $item) {
            $retourne[$cle]->setCodeStatut(ModelStatutEnseignant::select($retourne[$cle]->getCodeStatut()));
            $retourne[$cle]->setCodeDepartement(ModelDepartement::select($item->getCodeDepartement()));
        }
        return $retourne;
    }

    public static function selectAllByDepartement($codeDepartement)
    {
        try {
            $sql = 'SELECT * FROM '.self::$object.' WHERE codeDepartement=:codeDepartement';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeDepartement' => $codeDepartement);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelEnseignant');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setCodeStatut(ModelStatutEnseignant::select($retourne[$cle]->getCodeStatut()));
                $retourne[$cle]->setCodeDepartement(ModelDepartement::select($item->getCodeDepartement()));
            }
            return $retourne;
        }
        catch (Exception $e) {
            return false;
        }
    }

    public static function selectAllByStatut($codeStatut)
    {
        try {
            $sql = 'SELECT * FROM '.self::$object.' WHERE codeStatut=:codeStatut';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeStatut' => $codeStatut);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelEnseignant');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setCodeStatut(ModelStatutEnseignant::select($retourne[$cle]->getCodeStatut()));
                $retourne[$cle]->setCodeDepartement(ModelDepartement::select($item->getCodeDepartement()));
            }
            return $retourne;
        }
        catch (Exception $e) {
            return false;
        }
    }

    public static function selectAllByName($npEns)
    {
        try {
            $sql = 'SELECT * FROM '.self::$object.' WHERE nomEns OR prenomEns LIKE CONCAT(\'%\',:npEns,\'%\')';
            $rep = Model::$pdo->prepare($sql);
            $values = array('npEns' => $npEns);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelEnseignant');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setCodeStatut(ModelStatutEnseignant::select($retourne[$cle]->getCodeStatut()));
                $retourne[$cle]->setCodeDepartement(ModelDepartement::select($item->getCodeDepartement()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

}