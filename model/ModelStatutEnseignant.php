<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelStatutEnseignant extends Model
{

    // Nom de la table
    protected static $object = 'StatutEnseignant';
    protected static $primary = 'codeStatut';

    private $codeStatut;
    private $statut;
    private $typeStatut;
    private $nombresHeures;

    /**
     * @return mixed
     */
    public function getCodeStatut()
    {
        return $this->codeStatut;
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
    public function getNombresHeures()
    {
        return $this->nombresHeures;
    }

    public static function selectByStatutType($codeStatut, $typeStatut)
    {
        try {
            $sql = 'SELECT * FROM '.self::$object.' WHERE codeStatut=:codeStatut AND typeStatut=:typeStatut';
            $rep = Model::$pdo->prepare($sql);
            $values = array(
                'codeStatut' => $codeStatut,
                'typeStatut' => $typeStatut);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelStatutEnseignant');
            $retourne=$rep->fetchAll();
            if(empty($retourne)) return false;
            return $retourne[0];
        } catch (Exception $e) {
            return false;

        }
    }


}