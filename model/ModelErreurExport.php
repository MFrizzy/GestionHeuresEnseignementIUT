<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelErreurExport extends Model
{

    protected static $object = 'ErreurExport';
    protected static $primary = 'idErreur';
    protected static $valeursParPage = 100;

    private $idErreur;
    private $nomEns;
    private $codeEns;
    private $departementEns;
    private $statut;
    private $typeStatut;
    private $dateCours;
    private $duree;
    private $activitee;
    private $typeActivitee;
    private $typeErreur;

    /**
     * @return mixed
     */
    public function getTypeErreur()
    {
        return $this->typeErreur;
    }

    /**
     * @return mixed
     */
    public function getIdErreur()
    {
        return $this->idErreur;
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
    public function getCodeEns()
    {
        return $this->codeEns;
    }

    /**
     * @return mixed
     */
    public function getDepartementEns()
    {
        return $this->departementEns;
    }

    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @return mixed
     */
    public function getTypeStatut()
    {
        return $this->typeStatut;
    }

    /**
     * @return mixed
     */
    public function getDateCours()
    {
        return $this->dateCours;
    }

    /**
     * @return mixed
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @return mixed
     */
    public function getActivitee()
    {
        return $this->activitee;
    }

    /**
     * @return mixed
     */
    public function getTypeActivitee()
    {
        return $this->typeActivitee;
    }

    public static function selectByPage($p)
    {
        try {
            $debut = ($p-1)*self::$valeursParPage;
            $sql = 'SELECT * FROM '.self::$object.' ORDER BY '.self::$primary.' DESC LIMIT '.$debut.' , '.self::$valeursParPage;
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelErreurExport');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getNbErr()
    {
        try {
            $sql = 'SELECT COUNT(*) AS total FROM ' . self::$object;
            $rep = Model::$pdo->prepare($sql);
            $rep->execute();
            $retourne = $rep->fetchAll(PDO::FETCH_ASSOC);
            return $retourne[0]['total'];
        } catch (Exception $e) {
            return 0;
        }
    }

    public static function getNbP()
    {
        return ceil(self::getNbErr() / self::$valeursParPage);
    }

}