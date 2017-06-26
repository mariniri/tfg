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
    public $horario;
    public $idoperario;
    public $posicionactual;
    public $itinerario;

    function __construct($user, $horario, $idoperario, $posicionactual) {
        // parent::__construct();
        $this->user = $user;
        $this->horario = $horario;
        $this->idoperario = $idoperario;
        $this->posicionactual = $posicionactual;
        $this->itinerario = array();
    }

    function getUser() {
        return $this->user;
    }

    function getHorario() {
        return $this->horario;
    }

    function getIdoperario() {
        return $this->idoperario;
    }

    function getItinerario() {
        return $this->itinerario;
    }

    function getPosicionactual() {
        return $this->posicionactual;
    }

    function setItinerarioDia($itinerariodia, $fecha) {
        $this->itinerario["$fecha"] = $itinerariodia;

    }

    function getItinerarioDia($fecha) {
        if (array_key_exists("$fecha", $this->itinerario)) {
            return $this->itinerario["$fecha"];
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
