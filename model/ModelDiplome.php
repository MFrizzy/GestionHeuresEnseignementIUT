<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelDepartement.php'));

class ModelDiplome extends Model
{

    protected static $object = 'Diplome';
    protected static $primary = 'codeDiplome';

    private $codeDiplome;
    private $codeDepartement;
    private $typeDiplome;
    private $nomDiplome;
    private $heuresTP;
    private $heuresTD;
    private $heuresCM;
    private $heuresProjet;
    private $heuresStage;

    private static $typesDiplome = array(
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
     * @param mixed $codeDepartement
     */
    public function setCodeDepartement($codeDepartement)
    {
        $this->codeDepartement = $codeDepartement;
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
    public function getNomDiplome()
    {
        return $this->nomDiplome;
    }

    /**
     * @return int
     */
    public function getHeuresTP()
    {
        return (int)$this->heuresTP;
    }

    /**
     * @return int
     */
    public function getHeuresTD()
    {
        return (int)$this->heuresTD;
    }

    /**
     * @return int
     */
    public function getHeuresCM()
    {
        return (int)$this->heuresCM;
    }

    /**
     * @return int
     */
    public function getHeuresProjet()
    {
        return (int)$this->heuresProjet;
    }

    /**
     * @return int
     */
    public function getHeuresStage()
    {
        return (int)$this->heuresStage;
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
                $retourne[$cle]->setCodeDepartement(ModelDepartement::select($item->getCodeDepartement()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function select($primary_value)
    {
        $retourne = parent::select($primary_value);
        $retourne->setTypeDiplome(self::$typesDiplome[$retourne->getTypeDiplome()]);
        $retourne->setCodeDepartement(ModelDepartement::select($retourne->getCodeDepartement()));
        return $retourne;
    }

    public function getVolumeHoraire()
    {
        $heuresTP = (int)$this->heuresTP;
        $heuresTD = (int)$this->heuresTD;
        $heuresCM = (int)$this->heuresCM;
        $heuresProjet = (int)$this->heuresProjet;
        $heuresStage = (int)$this->heuresStage;
        $total = $heuresTP+$heuresProjet+$heuresStage+$heuresCM+$heuresTD;
        return $total;
    }

}