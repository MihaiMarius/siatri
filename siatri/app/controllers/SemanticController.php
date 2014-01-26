<?php

class SemanticController extends BaseController {
    public function testSparql( ){

        $parser = ARC2::getSemHTMLParser();
        // $parser->parse('http://dbpedia.org/page/Tim_Berners-Lee');
        // $parser->parse('http://dbpedia.org/page/Marc_Andreessen');
        // $parser->parse('http://dbpedia.org/resource/United_States');
        $parser->parse('http://dbpedia.org/page/Google');
        $parser->extractRDF('dc ');

        $triples = $parser->getTriples();
        $rdfxml = $parser->toRDFXML($triples);
        return $rdfxml;
        $result = simplexml_load_string($rdfxml);
        $bd = $result->xpath('//ns6:birthDate')[0];
        return $bd;
    }
} 