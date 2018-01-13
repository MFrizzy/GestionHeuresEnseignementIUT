<?php
require_once File::build_path(array("model", 'Model.php'));

class ModelUniteDEnseignement extends Model
{

    protected static $primary = 'nUE';
    protected static $object = 'UniteDEnseignement';

    private $nUE;
    /**
     * @var $codeDiplome ModelDiplome
     */
    private $codeDiplome;
    private $idUE;
    private $semestre;
    private $heuresTP;
    private $heuresTD;
    private $heuresCM;

    /**
     * @return mixed
     */
    public function getIdUE()
    {
        return (int)$this->idUE;
    }

    /**
     * @return mixed
     */
    public function getSemestre()
    {
        return (int)$this->semestre;
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
     * @return mixed
     */
    public function getNUE()
    {
        return $this->nUE;
    }

    /**
     * @return mixed
     */
    public function getCodeDiplome()
    {
        return $this->codeDiplome;
    }

    /**
     * @param mixed $codeDiplome
     */
    public function setCodeDiplome($codeDiplome)
    {
        $this->codeDiplome = $codeDiplome;
    }

    /**
     * Retourne tous les ue, false s'il y a une erreur
     *
     * Return false s'il y a une erreur durant l'execution de la requete SQL
     *
     * @return bool|array(ModelUniteDEnseignement)
     */
    public static function selectAll()
    {
        $retourne = parent::selectAll();
        if(!$retourne) return false;
        foreach ($retourne as $cle => $item) {
            $retourne[$cle]->setCodeDiplome(ModelDiplome::select($item->getCodeDiplome()));
        }
        return $retourne;
    }

    /**
     * Retourne l'ue désigné par son numéro d'UE, false s'il n'existe pas ou qu'il y a une erreur
     *
     * Return false s'il y a une erreur durant l'execution de la requete SQL
     *
     * @param $primary_value int nUE
     * @return bool|ModelUniteDEnseignement
     */
    public static function select($primary_value)
    {
        $retourne = parent::select($primary_value);
        if (!$retourne) return false;
        $retourne->setCodeDiplome(ModelDiplome::select($retourne->getCodeDiplome()));
        return $retourne;
    }

    /**
     * Retourne une liste d'UE appartement à un certain semestre d'un diplome
     *
     * Return false s'il y a une erreur durant l'execution de la requete SQL
     *
     * @param $semestre int
     * @param $codeDiplome int
     * @return bool|array(ModelUniteDEnseignement)
     */
    public static function selectBySemestre($semestre, $codeDiplome) {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeDiplome=:codeDiplome AND semestre=:semestre ORDER BY idUE';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeDiplome' => $codeDiplome,
                'semestre' => $semestre);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelUniteDEnseignement');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setCodeDiplome(ModelDiplome::select($item->getCodeDiplome()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne tous les UE d'un diplome donné en paramètre, false s'il y aune erreur
     *
     * @param $codeDiplome string
     * @return bool|array(ModelUniteDEnseignement)
     */
    public static function selectAllByDiplome($codeDiplome)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeDiplome=:codeDiplome';
            $rep = Model::$pdo->prepare($sql);
            $values = array('codeDiplome' => $codeDiplome);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelUniteDEnseignement');
            $retourne = $rep->fetchAll();
            foreach ($retourne as $cle => $item) {
                $retourne[$cle]->setCodeDiplome(ModelDiplome::select($item->getCodeDiplome()));
            }
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retourne un UE grace à son codeDiplome, semestre et nUE, false s'il n'existe pas ou qu'il y a une erreur
     *
     * @param $codeDiplome int
     * @param $semestre int
     * @param $idUE int
     * @return bool|ModelUniteDEnseignement
     */
    public static function selectBy($codeDiplome, $semestre, $idUE)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE codeDiplome=:codeDiplome AND semestre=:semestre AND idUE=:idUE';
            $rep = Model::$pdo->prepare($sql);
            $values = array(
                'codeDiplome' => $codeDiplome,
                'semestre' => $semestre,
                'idUE' => $idUE);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelUniteDEnseignement');
            $retourne = $rep->fetchAll();
            if(empty($retourne)) return false;
            $retourne[0]->setCodeDiplome(ModelDiplome::select($retourne[0]->getCodeDiplome()));
            return $retourne[0];
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return int Volume horaire totale de l'ue
     */
    public function getVolumeHoraire()
    {
        return $this->getHeuresCM() + $this->getHeuresTD() + $this->getHeuresTP();
    }

    /**
     * @return string code du module via la nomenclature de format 'nSemestre nUE'
     * @example '33' Semestre 3 / nUE 3
     */
    public function nommer()
    {
        return $this->getSemestre().$this->getIdUE();
    }


}