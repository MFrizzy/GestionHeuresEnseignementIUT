<?php
require_once File::build_path(array('model','Model.php'));

class ModelDiplome extends Model
{

    protected static $object = 'Diplome';
    protected static $primary = 'codeDiplome';

    private $codeDiplome;
    private $codeDepartement;
    private $typeDiplome;
    private $volumeHoraire;

    private static $typesDiplome=array(
        "D" => "DUT",
        "U" => "DU",
        "P" => "Licence Pro"
    );

    /**
     * @return mixed
     */
    public function getCodeDiplome()
    {
        return $this->codeDiplome;
    }

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
    public function getTypeDiplome()
    {
        return $this->typeDiplome;
    }

    /**
     * @param mixed $typeDiplome
     */
    public function setTypeDiplome($typeDiplome)
    {
        $this->typeDiplome = $typeDiplome;
    }

    /**
     * @return mixed
     */
    public function getVolumeHoraire()
    {
        return $this->volumeHoraire;
    }

    public static function selectAllByDepartement($codeDepartement)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeDepartement=:codeDepartement';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeDepartement' => $codeDepartement);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelDiplome');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setTypeDiplome(self::$typesDiplome[$item->getTypeDiplome()]);
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

}