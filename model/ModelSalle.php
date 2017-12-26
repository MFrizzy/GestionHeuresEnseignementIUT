<?php

require_once File::build_path(array('model', 'Model.php'));

class ModelSalle //extends Model
{

    // Nom de la table
    protected static $object = 'Salle';

    // Données
    private $numSalle;
    private $nomBatiment;
    private $capacite;
    private $typeSalle;
    private $tauxOccupation;

    /**
     * @return mixed
     */
    public function getNumSalle()
    {
        return $this->numSalle;
    }

    /**
     * @return mixed
     */
    public function getNomBatiment()
    {
        return $this->nomBatiment;
    }

    /**
     * @return mixed
     */
    public function getCapacite()
    {
        return $this->capacite;
    }

    /**
     * @return mixed
     */
    public function getTypeSalle()
    {
        return $this->typeSalle;
    }

    /**
     * @return mixed
     */
    public function getTauxOccupation()
    {
        return $this->tauxOccupation;
    }

    public static function selectAllByBatiment($nomBatiment)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE nomBatiment=:nomBatiment';
            $rep = Model::$pdo->prepare($sql);
            $values = array('nomBatiment' => $nomBatiment);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelSalle');
            $retourne = $rep->fetchAll();
            return $retourne;
        } catch (Exception $e) {
            return false;
        }
    }

    // Pas testée
    public static function select($nomBatiment, $numSalle)
    {
        try {
            $sql = 'SELECT * FROM ' . self::$object . ' WHERE nomBatiment=:nomBatiment AND numSalle=:numSalle';
            $rep = Model::$pdo->prepare($sql);
            $values = array(
                'nomBatiment' => $nomBatiment,
                'numSalle' => $numSalle);
            $rep->execute($values);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelSalle');
            $retourne = $rep->fetchAll();
            if(empty($retourne)) return false;
            return $retourne[0];
        } catch (Exception $e) {
            return false;
        }
    }

}