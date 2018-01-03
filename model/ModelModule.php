<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelUniteDEnseignement.php'));

class ModelModule extends Model
{

    protected static $object = 'Module';
    protected static $primary = 'codeModule';

    private $codeModule;
    private $nUE;
    private $numModule;
    private $nomModule;
    private $heuresTP;
    private $heuresTD;
    private $heuresCM;

    /**
     * @return mixed
     */
    public function getNumModule()
    {
        return $this->numModule;
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
    public function getNUE()
    {
        return $this->nUE;
    }

    /**
     * @param mixed $nUE
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

    public static function select($primary_value)
    {
        $retourne = parent::select($primary_value);
        $retourne->setNUE(ModelUniteDEnseignement::select($retourne->getNUE()));
        return $retourne;
    }

    public static function selectAll()
    {
        $retourne = parent::selectAll();
        foreach ($retourne as $cle => $item) {
            $retourne[$cle]->setNUE(ModelUniteDEnseignement::select($item->getNUE()));
        }
        return $retourne;
    }

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

    public static function selectBy($nUE, $numModule)
    {
        try {
            $sql = 'SELECT * FROM '.self::$object.' WHERE nUE=:nUE AND numModule=:numModule';
            $rep = Model::$pdo->prepare($sql);
            $values = array('nUE' => $nue);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelModule');
            $retourne = $rep->fetchAll()[0];
            $retourne->setNUE(ModelUniteDEnseignement::select($retourne->getNUE()));
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getVolumeHoraire()
    {
        return $this->getHeuresTD() + $this->getHeuresCM() + $this->getHeuresTP();
    }
}