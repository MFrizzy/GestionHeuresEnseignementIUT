<?php

require_once File::build_path(array('model', 'Model.php'));

class ModelBatiment extends Model
{

    protected static $object = 'Batiment';
    protected static $primary = 'nomBatiment';

    private $nomBatiment;

    /**
     * @return string
     */
    public function getNomBatiment()
    {
        return $this->nomBatiment;
    }


}