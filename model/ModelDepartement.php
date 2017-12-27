<?php
require_once File::build_path(array('model','Model.php'));

class ModelDepartement extends Model
{

    protected static $object='Departement';
    protected static $primary='codeDepartement';

    private $codeDepartement;
    private $nomDepartement;

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


}