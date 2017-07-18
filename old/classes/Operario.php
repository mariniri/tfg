<?php

include 'Usuario.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Operario
 *
 * @author marina
 */
class Operario { //extends Usuario {
    //put your code here
    public $user;
    public $idoperario;
    public $posicionactual;
    public $jornada;
    
    function __construct($user, $idoperario, $posicionactual) {
        // parent::__construct();
        $this->user = $user;
        $this->idoperario = $idoperario;
        $this->posicionactual = $posicionactual;
        $this->jornada = array();
    }

    function getUser() {
        return $this->user;
    }

    function getIdoperario() {
        return $this->idoperario;
    }

    function getJornada() {
        return $this->jornada;
    }

    function getPosicionactual() {
        return $this->posicionactual;
    }
    
    function addJornada($j) {
        $aux=$j->getFecha();
        $this->jornada["$aux"] = $j;

    }

    function getJornadaDia($fecha) {
        if (array_key_exists("$fecha", $this->jornada)) {
            return $this->jornada["$fecha"];
        } else {
            return null;
        }
    }

    function setPosicionactual($posicionactual) {
        $this->user = $posicionactual;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setHorario($horario) {
        $this->horario = $horario;
    }

    function setIdOperario($idoperario) {
        $this->idoperario = $idoperario;
    }

    public function __toString() {
        
    }

}
