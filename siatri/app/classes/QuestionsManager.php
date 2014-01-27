<?php

class QuestionsManger{
	
	private static $entityTypes = array(
		'Person' => array(
			"direct" => array( //answer is object
				"birthDate" => "When was %en born?",
				"birthPlace" => "Where was %en born?",
				"nationality" => "What is the nationality of %en?",
				"title" => "What is the title of %en?",
				"occupation" => "What is the occupation of %en?"
			),
			"inverse" => array( //answer is subject
				"author" => "What did %en author?",
				"foundedBy" => "What did %en found?",
				"founder" => "What did %en found?",
				"inventor" => "What did %en invent?"
			)	
		),
		'Company' => array(
			"direct" => array( 
				"foundedBy" => "Who founded %en?",
				"foundingDate" => "When was %en founded?"
			)
		)
	);

	private static $AlchemyAPI;

/*
	Return a list of persons that have linkeddata to dbpedia
	@params url =  url to get the persons from
*/
	private static function getAPI(){
		if(!isset(static::$AlchemyAPI))
			static::$AlchemyAPI = new AlchemyAPI('e74d8cd625be67883f77395f60325145923d744c');
		return static::$AlchemyAPI;
	}

	public static function getEntities($url, $options)
	{
		$api = static::getAPI();
		$dataType = 'url';

		$et = static::$entityTypes;


		if(is_null($url)) $url = "http://en.wikipedia.org/wiki/World_wide_web";
		
		if(is_null($options))	$options = array('disambiguate' => 1, 'linkedData' => 1);

		$response = $api->entities($dataType, $url, $options);
		$result = array();

		foreach ($response['entities'] as $entity) {
			$resultEntity = array();

			foreach ($et as $t => $attrs ) {
				if( $entity['type'] == $t
					&& array_key_exists('disambiguated', $entity)
					&& array_key_exists('dbpedia', $entity['disambiguated']))
				{
					$resultEntity['type'] = $entity['type'];
					$resultEntity['name'] = $entity['disambiguated']['name'];
					$resultEntity['dbpedia'] = $entity['disambiguated']['dbpedia'];

					if(array_key_exists('subType', $entity['disambiguated']))
						$resultEntity['subType'] = $entity['disambiguated']['subType'];
					
					$resultEntity = (object)$resultEntity;

					$resultEntity->questions = static::getInfo($resultEntity, false); // don't pretend

					array_push($result, $resultEntity);
				}
			}
		}
		return $result;
	}
	// not used atm
	// public static function getConcepts($url, $options){
	// 	$alchemyapi = new AlchemyAPI('e74d8cd625be67883f77395f60325145923d744c');
	// 	$dataType = 'url';
		
	// 	if(is_null($url))
	// 		$url = "http://en.wikipedia.org/wiki/World_wide_web";
		
	// 	if(is_null($options))
	// 		$options = array('maxRetrieve' => 50,
	// 			'linkedData' => 1);

	// 	$response = $alchemyapi->concepts($dataType, $url, $options);

	// 	$result = array();

	// 	foreach ($response['concepts'] as $concept) {
	// 		$resultEntity = array();

	// 		$resultEntity['name'] = $concept['text'];
	// 		$resultEntity['dbpedia'] = $concept['dbpedia'];

	// 		array_push($result, $resultEntity);
	// 	}
	// 	return $result;
	// }

	public static function getLinks($url, $options){
		$alchemyapi = new AlchemyAPI('e74d8cd625be67883f77395f60325145923d744c');
		$dataType = 'url';
		
		if(is_null($url))
			$url = "http://en.wikipedia.org/wiki/World_wide_web";
		
		if(is_null($options))
			$options = array('useMetadata' => 0,
				'extractLinks' => 1);

		$response = $alchemyapi->text($dataType, $url, $options);
		$match = array();
		preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $response['text'], $match);

		return $match[0];
	}

	public static function parseTriplesFromURL($url){ 
        $parser = ARC2::getRDFParser();
        $rdfurl = str_replace("resource", "data", $url) . ".rdf"; // url to dbpedia .rdf file
        $parser->parse($rdfurl);
        return $parser->getTriples();
    }

	private static function getInfo($entity, $pretend = "debug"){ // false for ignoring answer links; more accurate -> less questins;  true for using them
		$data = static::parseTriplesFromURL($entity->dbpedia);
		$entityProps = static::$entityTypes[$entity->type];
		$qas = array();
		foreach ($data as $triple) {
		  foreach ($entityProps as $propType => $props) 
			foreach ($props as $prop => $question) {
				if(stristr($triple['p'], $prop)){ //if the proprety is in the predicate
					$q = str_replace("%en", $entity->name, $question);

					if($triple['o_type'] == "literal"){ // and the object (answer) is a string
						$a = str_replace("_", " ", $triple['o']);
						$a = str_replace("-", " ", $a);
						$a = mb_strtolower($a);
						preg_replace('/,/', '', $a);
						// if(static::is_date($a)) dd($a);
						$qas[$a] = (object)array(
							'question' => $q,
							'answer' => $a
						);
					}
					elseif ($triple['o_type'] == "uri"){ // the answer is located in the URL
						if($pretend) 
							$a = $pretend == "debug" ? ( $propType == "direct" ? $triple['o'] : $triple['s'] ): null;
						else {
							$answerURL = $propType == "direct" ? $triple['o'] : $triple['s'];
							$answeTriples = static::parseTriplesFromURL($answerURL);

							// $aValues = array('name', 'title'); //possible property names for the answer 
							for ($a=0; $a < count($answeTriples); $a++) {
								$trip = $answeTriples[$a];
								if($trip['o_type'] == "literal"){
									// dd($trip);
									// for($i = 0; $i < count($aValues); $i++)
										if(stristr($trip['p'], 'label') && $trip['o_lang'] == 'en'){ //$aValues[$i]
											$a = $trip['o'];
											break ;
										}
								}
							}
						}
						if($a)
							$qas[$a] = (object)array(
								'question' => $q,
								'answer' => $a
							);
						// else throw new Exception("Didn't found answer for: ". $q ."on triple ", $triple);
						
					}
				}
			}
		}
		return $qas;
	}

	private static function is_date($x) {
	    return (date('Y-m-d H:i:s', strtotime($x)) == $x);
	}
}