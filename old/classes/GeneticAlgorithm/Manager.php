<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Manager{
    
        protected $cityList;
        protected $matriz;
	protected static $instance = null;
	
	public function __construct()
	{
	}
	
	public static function getInstance()
	{
            if (static::$instance == null) {
            static::$instance = new Manager();
        }

        return static::$instance;
	}

        public function &getCityList()
	{
		return $this->cityList;
	}
	
	public function getCityListCopy()
	{
		return $this->cityList;
	}
        
        function getMatrizCopy() {
                return $this->matriz;
        }

                
        public function load($listavisitas){
            $this->cityList=$listavisitas;
        }
    
}