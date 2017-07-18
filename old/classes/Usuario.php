<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author marina
 */
class Usuario {

    private $idusuario;
    private $nombre;
    private $apellidos;
    private $nif;
    private $email;
    private $telefono;

    function __construct($nombre, $apellidos, $nif, $email, $telefono) {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->nif = $nif;
        $this->email = $email;
        $this->telefono = $telefono;
    }

    function getIdusuario() {
        return $this->idusuario;
    }

    function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

        
    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getNif() {
        return $this->nif;
    }

    function getEmail() {
        return $this->email;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setNif($nif) {
        $this->nif = $nif;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }



}
