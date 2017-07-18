<?php

class Life {

    public $selection;
    public $roadmap;
    

    public function __construct(Selection $selection = null) {
        $this->selection = ($selection === null) ? new Selection(20) : $selection;
        $this->roadmap = new Roadmap($places, "time",$allplaces); 
    }

    function getRoadmap() {
        return $this->roadmap;
    }

    function setRoadmap($roadmap) {
        $this->roadmap = $roadmap;
    }

        
    public function getShortestPath(Plan $plan) {
        $mutation = $this->selection->getMutations();

        $places = $plan->getPlaces();
        $allplaces=$places;
        $from = array_shift($places);

        $roadmap->addPlace($from);

        $roadmaps = $this->sortRoadmaps($this->explodeRoadmaps([$roadmap]));

        return $roadmaps[0];
    }

    private function explodeRoadmaps(array $roadmaps) {
        while (count($roadmaps[0]->getRemainingPlaces()) > 0) {
            $newRoadmaps = [];
            foreach ($roadmaps as $roadmap) {
                $newRoadmaps = array_merge($newRoadmaps, $this->createRoadmaps($roadmap));
            }
            $this->sortRoadmaps($newRoadmaps);

            $newRoadmaps = $this->selection->select($newRoadmaps);

            $roadmaps = $this->explodeRoadmaps($newRoadmaps);
        }

        return $roadmaps;
    }

    private function sortRoadmaps($roadmaps) {
        usort($roadmaps, function($a, $b) {
            return $a->distance() <=> $b->distance();
        });
        return $roadmaps;
    }

    private function createRoadmaps(Roadmap $roadmap) {
        $places = $roadmap->getRemainingPlaces();
        $from = $roadmap->getLastPlace();
        $matrix = $roadmap->getMatrix();
        $selections = [];
        foreach ($places as $selection) {
            $selections[] = [
                "distance" => $matrix[$from->getPosicion()][$selection->getPosicion()],
                "place" => $selection,
            ];
        }

        usort($selections, function($a, $b) {
            return $a["distance"] <=> $b["distance"];
        });
        $selections = $this->selection->select($selections);

        $roadmaps = [];
        foreach ($selections as $i => $selection) {
            $currentRoadmap = $roadmap;
            if ($i != count($selections) - 1) {
                $currentRoadmap = clone $roadmap;
            }

            $currentRoadmap->addPlace($selection["place"]);
            $roadmaps[] = $currentRoadmap;
        }

        return $roadmaps;
    }

}
