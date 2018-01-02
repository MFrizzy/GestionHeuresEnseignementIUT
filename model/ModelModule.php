<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelUniteDEnseignement.php'));

class ModelModule extends Model
{

    protected static $object = 'Module';
    protected static $primary = 'codeModule';

    private $codeModule;
    private $nUE;
    private $nomModule;
    private $heuresTP;
    private $heuresTD;
    private $heuresCM;

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
        return $this->heuresTP;
    }

    /**
     * @return mixed
     */
    public function getHeuresTD()
    {
        return $this->heuresTD;
    }

    /**
     * @return mixed
     */
    public function getHeuresCM()
    {
        return $this->heuresCM;
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
            $sql='SELECT * FROM '.self::$object.' WHERE nUE=:nUE';
            $rep = Model::$pdo->prepare($sql);
            $values=array('nUE' => $nue);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelDiplome');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setNUE(ModelUniteDEnseignement::select($item->getNUE()));
            }
            return $retourne;
        }
        catch (Exception $e) {
            return false;
        }
    }
}