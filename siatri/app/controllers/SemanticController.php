<?php

class SemanticController extends BaseController { // this is a testing place for the rdf parser
    public function testSparql(){
        $url = "http://dbpedia.org/resource/Tim_Berners-Lee";

        
        $triples = QuestionsManger::parseTriplesFromURL($url);
        return Response::json($triples);
    }
} 