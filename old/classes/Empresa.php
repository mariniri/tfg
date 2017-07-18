<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Empresa
 *
 * @author marina
 */
class Empresa {
   private $listaoperarios;
   private $numerooperarios;
   
   function __construct() {
       $this->listaoperarios = array();
   }
   
   function getListaoperarios() {
       return $this->listaoperarios;
   }

   function getNumerooperarios() {
       return $this->numerooperarios;
   }
   
   function addOperario($operario){
       $this->listaoperarios[$this->numerooperarios]=$operario;
       $this->numerooperarios++;
   }
   
}
