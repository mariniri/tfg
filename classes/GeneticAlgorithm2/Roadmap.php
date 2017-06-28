<?php

class Roadmap
{
    public $places;
    private $remainingPlaces;
    private $matrix;

    public function __construct(array $remainingPlaces,$type,$allplaces)
    {
        $this->places = [];
        $this->remainingPlaces = $remainingPlaces;
        $this->matrix = ($type=="time")?Distance::getTimeMatrix($allplaces):Distance::getDistMatrix($allplaces);
    }

    public function addPlace(Visita $place)
    {
        $this->places[] = $place;
        $this->dropFromremainingPlaces($place);
    }

    private function dropFromremainingPlaces(Visita $place)
    {
        foreach ($this->remainingPlaces as $i => $city) {
            if ($place->getIdvisita() == $city->getIdvisita()) {
                unset($this->remainingPlaces[$i]);
            }
        }
        $this->remainingPlaces = array_values($this->remainingPlaces);
    }

    public function distance()
    {
        $distance = 0;

        for ($i=0; $i<count($this->places)-1; $i++) {
            $distance += $this->matrix[$i][$i+1];
        }

        return $distance;
    }

    public function getRemainingPlaces()
    {
        return $this->remainingPlaces;
    }
    
    function getMatrix() {
        return $this->matrix;
    }

    function setMatrix($matrix) {
        $this->matrix = $matrix;
    }

    public function getLastPlace()
    {
        return $this->places[count($this->places)-1];
    }
}
