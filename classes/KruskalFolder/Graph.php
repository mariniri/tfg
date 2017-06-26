<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Graph
 *
 * @author marina
 */
class Graph {

    public $VerticesCount;
    public $EdgesCount;
    public $_edge = array();
    
    function __construct() {
        
    }
    function getVerticesCount() {
        return $this->VerticesCount;
    }

    function getEdgesCount() {
        return $this->EdgesCount;
    }

    function get_edge() {
        return $this->_edge;
    }

    function setVerticesCount($VerticesCount) {
        $this->VerticesCount = $VerticesCount;
    }

    function setEdgesCount($EdgesCount) {
        $this->EdgesCount = $EdgesCount;
    }

    function set_edge($_edge) {
        $this->_edge = $_edge;
    }

  


}
