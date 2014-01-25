<?php

class AlchemyManger{
	// private AlchemyEntities = (object)array("person" => "Person",
	// 	"company" => "Company",
	// 	"concept" => "Concept");

	// protected $alchemyapi;
	// protected $dataType;

	// public function __construct (){
	// 	$alchemyapi = new AlchemyAPI('e74d8cd625be67883f77395f60325145923d744c');
	// 	$dataType = 'url';
	// }

	// static protected $alchemyApiKey = '';


/*
	Return a list of persons that have linkeddata to dbpedia
	@params url =  url to get the persons from
*/
	public static function getPersonEntities($url, $options)
	{
		$alchemyapi = new AlchemyAPI('e74d8cd625be67883f77395f60325145923d744c');
		$dataType = 'url';

		if(is_null($url))
			$url = "http://en.wikipedia.org/wiki/World_wide_web";
		
		if(is_null($options))
			$options = array('disambiguate' => 1
				,'linkedData' => 1);


		$response = $alchemyapi->entities($dataType, $url, $options);

		$result = array();

		foreach ($response['entities'] as $entity) {
			$resultEntity = array("");

			if($entity['type'] == 'Person'
				&& array_key_exists('disambiguated', $entity)
				&& array_key_exists('dbpedia', $entity['disambiguated']))
			{
				// dd($entity);

				$resultEntity['name'] = $entity['disambiguated']['name'];
				$resultEntity['dbpedia'] = $entity['disambiguated']['dbpedia'];

				if(array_key_exists('subType', $entity['disambiguated']))
					$resultEntity['subType'] = $entity['disambiguated']['subType'];

				array_push($result, (object)$resultEntity);
			}
		}
		return $result;
	}
}