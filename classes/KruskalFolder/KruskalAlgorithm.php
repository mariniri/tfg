<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kruskal
 *
 * @author marina
 */
class KruskalAlgorithm {

    function __construct() {
        
    }

    function CreateGraph($verticesCount, $edgesCount) {
        $graph = new Graph();
        $graph->VerticesCount = $verticesCount;
        $graph->EdgesCount = $edgesCount;
        $graph->_edge = array();

        for ($i = 0; $i < $graph->EdgesCount; ++$i) {
            $graph->_edge[$i] = new Edge();
        }

        return $graph;
    }

    function Find($subsets, $i) {
        if ($subsets[$i]->Parent != $i) {
            $subsets[$i]->Parent = $this->Find($subsets, $subsets[$i]->Parent);
        }
        return $subsets[$i]->Parent;
    }

    function Union($subsets, $x, $y) {
        $xroot = $this->Find($subsets, $x);
        $yroot = $this->Find($subsets, $y);

        if ($subsets[$xroot]->Rank < $subsets[$yroot]->Rank) {
            $subsets[$xroot]->Parent = $yroot;
        } else if ($subsets[$xroot]->Rank > $subsets[$yroot]->Rank) {
            $subsets[$yroot]->Parent = $xroot;
        } else {
            $subsets[$yroot]->Parent = $xroot;
            ++$subsets[$xroot]->Rank;
        }
    }

    function CompareEdges($a, $b) {
        return $a->Weight > $b->Weight;
    }

    function PrintResult($result, $e) {
        for ($i = 0; $i < $e; ++$i) {
            echo $result[$i]->Source . " -- " . $result[$i]->Destination . " == " . $result[$i]->Weight . "<br/>";
        }
    }

    function Kruskal($graph) {
        $verticesCount = $graph->VerticesCount;
        $result = array();
        $i = 0;
        $e = 0;

        usort($graph->_edge, array($this, 'CompareEdges'));

        $subsets = array();

        for ($v = 0; $v < $verticesCount; ++$v) {
            $subsets[$v] = new Subset();
            $subsets[$v]->Parent = $v;
            $subsets[$v]->Rank = 0;
        }

        while ($e < $verticesCount - 1) {
            $nextEdge = $graph->_edge[$i++];
            $x = $this->Find($subsets, $nextEdge->Source);
            $y = $this->Find($subsets, $nextEdge->Destination);

            if ($x != $y) {
                $result[$e++] = $nextEdge;
                $this->Union($subsets, $x, $y);
            }
        }
        $this->PrintResult($result, $e);
        return $result;
    }

}
