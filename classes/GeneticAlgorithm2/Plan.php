<?php

class Plan
{
    public $places;

    public function __construct()
    {
        $this->places = [];
    }

    public function addPlace(Visita $place)
    {
        $this->places[] = $place;
    }

    public function getPlaces()
    {
        return $this->places;
    }
}

