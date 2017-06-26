<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Edge
 *
 * @author marina
 */
class Edge {

    public $Source;
    public $Destination;
//    public $Sourceid;
 //   public $Destinationid;
    public $Weight;
    public $Duration;
    
    function __construct() {
        
    }

    
    function getSource() {
        return $this->Source;
    }

    function getDestination() {
        return $this->Destination;
    }

    function getSourceid() {
        return $this->Sourceid;
    }

    function getDestinationid() {
        return $this->Destinationid;
    }

    function getWeight() {
        return $this->Weight;
    }

    function setSource($Source) {
        $this->Source = $Source;
    }

    function setDestination($Destination) {
        $this->Destination = $Destination;
    }
//
//    function setSourceid($Sourceid) {
//        $this->Sourceid = $Sourceid;
//    }
//
//    function setDestinationid($Destinationid) {
//        $this->Destinationid = $Destinationid;
//    }

    function setWeight($Weight) {
        $this->Weight = $Weight;
    }

    function getDuration() {
        return $this->Duration;
    }

    function setDuration($Duration) {
        $this->Duration = $Duration;
    }


    
}
