<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelUniteDEnseignement.php'));

class ModelModule extends Model
{

    protected static $object = 'Module';
    protected static $primary = 'codeModule';

    private $codeModule;
    /**
     * @var $nUE ModelUniteDEnseignement
     */
    private $nUE;
    private $numModule;
    private $nomModule;
    private $heuresTP;
    private $heuresTD;
    private $heuresCM;

    /**
     * @return int
     */
    public function getNumModule()
    {
        return (int)$this->numModule;
    }

    /**
     * @return mixed
     */
    public function getCodeModule()
    {
        return $this->codeModule;
    }

    /**
     * @return ModelUniteDEnseignement
     */
    public function getNUE()
    {
        return $this->nUE;
    }

    /**
     * @param int $nUE
     */
    public function setNUE($nUE)
    {
        $this->nUE = $nUE;
    }

    /**
     * @return mixed
     */
    public function getNomModule()
    {
        return $this->nomModule;
    }

    /**
     * @return mixed
     */
    public function getHeuresTP()
    {
        return (int)$this->heuresTP;
    }

    /**
     * @return mixed
     */
    public function getHeuresTD()
    {
        return (int)$this->heuresTD;
    }

    /**
     * @return mixed
     */
    public function getHeuresCM()
    {
        return (int)$this->heuresCM;
    }

    /**
     * Retourne le module désigné par son codeModule, false s'il n'existe pas ou qu'il y a une erreur
     *
     * @param $primary_value codeModule
     * @return bool|ModelModule
     */
    public static function select($primary_value)
    {
        $retourne = parent::select($primary_value);
        if (!$retourne) return false;
        $retourne->setNUE(ModelUniteDEnseignement::select($retourne->getNUE()));
        return $retourne;
    }

    /**
     * Retourne tous les modules qui existent, false s'il y a une erreur
     *
     * @return bool|array(ModelModule)
     */
    public static function selectAll()
    {
        $retourne = parent::selectAll();
        if (!$retourne) return false;
        foreach ($retourne as $cle => $item) {
            $retourne[$cle]->setNUE(ModelUniteDEnseignement::select($item->getNUE()));
        }
        return $retourne;
    }

    /**
     * Retourne tous les modules d'un UE désigné par son nUE, false s'il y a une erreur
     *
     * @param $nue int numéro d'unité d'enseignement
     * @return bool|array(ModelModule)
     */
    public static function selectAllByNUE($nue)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE nUE=:nUE';
            $rep = Model::$pdo->prepare($sql);
            $values = array('nUE' => $nue);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelModule');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setNUE(ModelUniteDEnseignement::select($item->getNUE()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne le module désigné par son UE et son numéro de module, false s'il n'existe pas ou qu'il y a une erreur
     *
     * @param $nUE int numéro d'unité d'enseignement
     * @param $numModule string numéro de module
     * @return bool|ModelModule
     */
    public static function selectBy($nUE, $numModule)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE nUE=:nUE AND numModule=:numModule';
            $rep = Model::$pdo->prepare($sql);
            $values = array(
                'nUE' => $nUE,
                'numModule' => $numModule);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelModule');
            $retourne = $rep->fetchAll();
            if (empty($retourne)) return false;
            $retourne[0]->setNUE(ModelUniteDEnseignement::select($retourne[0]->getNUE()));
            return $retourne[0];
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return int Volume horaire totale du module
     */
    public function getVolumeHoraire()
    {
        return $this->getHeuresTD() + $this->getHeuresCM() + $this->getHeuresTP();
    }

    /**
     * @return string code du module du format : 'M nSemestre nUE nModule'
     * @example 'M3301'
     */
    public function nommer()
    {
        if ($this->getNumModule() < 10) $nM = '0' . $this->getNumModule();
        else $nM = $this->getNumModule();
        return 'M' . $this->getNUE()->nommer() . $nM;
    }
}