<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelBatiment.php'));

class ModelDepartement extends Model
{

    protected static $object = 'Departement';
    protected static $primary = 'codeDepartement';

    private $codeDepartement;
    private $nomDepartement;
    private $nomBatiment;

    /**
     * @return mixed
     */
    public function getCodeDepartement()
    {
        return $this->codeDepartement;
    }

    /**
     * @return mixed
     */
    public function getNomDepartement()
    {
        return $this->nomDepartement;
    }

    /**
     * @return mixed
     */
    public function getNomBatiment()
    {
        return $this->nomBatiment;
    }

    /**
     * @param mixed $nomBatiment
     */
    public function setNomBatiment($nomBatiment)
    {
        $this->nomBatiment = $nomBatiment;
    }

    public static function select($primary_value)
    {
        $retourne = parent::select($primary_value);
        $retourne->setNomBatiment(ModelBatiment::select($retourne->getNomBatiment()));
        return $retourne;
    }

    public static function selectAll()
    {
        $retourne= parent::selectAll();
        foreach ($retourne as $cle => $item) {
            $retourne[$cle]->setNomBatiment(ModelBatiment::select($item->getNomBatiment()));
        }
        return $retourne;
    }

    public static function selectByName($nomDepartement)
    {
        try {
            $sql = 'SELECT * FROM '.self::$object.' WHERE nomDepartement=:nomDepartement';
            $rep = Model::$pdo->prepare($sql);
            $values = array(
                'nomDepartement' => $nomDepartement);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelDepartement');
            return $rep->fetchAll()[0];
        } catch (Exception $e) {
            return false;
        }
    }

}