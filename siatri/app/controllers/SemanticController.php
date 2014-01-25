<?php

class SemanticController extends BaseController {
    public function testSparql( ){
        /* configuration */ 
        $config = array(
          /* remote endpoint */
          'remote_store_endpoint' => 'http://dbpedia.org/sparql',
        );

        /* instantiation */
        $store = ARC2::getRemoteStore($config);
        $q = 'SELECT ?airport ?iata ?name
WHERE {
    ?airport a dbpedia-owl:Airport ;
             dbpedia-owl:iataLocationIdentifier ?iata ;
             rdfs:label ?name .
    FILTER langMatches( lang( ?name ), "EN" )
}
order by ?airport';
        $rs = $store->query($q);
        var_dump($store->getErrors());
        dd($rs);
    }
}