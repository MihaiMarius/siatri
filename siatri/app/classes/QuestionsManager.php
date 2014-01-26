<?php

class QuestionsManger{
	
	private static $entityTypes = array('Person' => array("ns6:birthDate",
														"ns6:birthPlace",
														"ns6:nationality",
														"ns6:author",
														"ns7:founder",
														"ns7:inventor"   ),
										 'Company' => => array("ns6:foundedBy",
										 						"foundingDate"));
/*
	Return a list of persons that have linkeddata to dbpedia
	@params url =  url to get the persons from
*/
	// public static function getPersonEntities($url, $options)
	// {
	// 	return static::getEntities('Person', $url, $options);
	// }

	// public static function getCompanyEntities($url, $options)
	// {
	// 	return static::getEntities('Company', $url, $options);
	// }


	public static function getEntities($url, $options)
	{
		$alchemyapi = new AlchemyAPI('e74d8cd625be67883f77395f60325145923d744c');
		$dataType = 'url';

		$et = static::$entityTypes;


		if(is_null($url))
			$url = "http://en.wikipedia.org/wiki/World_wide_web";
		
		if(is_null($options))
			$options = array('disambiguate' => 1,
				'linkedData' => 1);


		$response = $alchemyapi->entities($dataType, $url, $options);
		$result = array();

		foreach ($response['entities'] as $entity) {
			$resultEntity = array("");

			foreach ($et as $t) {
				if($entity['type'] == $t
					&& array_key_exists('disambiguated', $entity)
					&& array_key_exists('dbpedia', $entity['disambiguated']))
				{
					$resultEntity['type'] = $entity['type'];
					$resultEntity['name'] = $entity['disambiguated']['name'];
					$resultEntity['dbpedia'] = $entity['disambiguated']['dbpedia'];

					if(array_key_exists('subType', $entity['disambiguated']))
						$resultEntity['subType'] = $entity['disambiguated']['subType'];

					array_push($result, (object)$resultEntity);

				}


			}
		}
		return $result;
	}

	public static function getConcepts($url, $options){
		$alchemyapi = new AlchemyAPI('e74d8cd625be67883f77395f60325145923d744c');
		$dataType = 'url';
		
		if(is_null($url))
			$url = "http://en.wikipedia.org/wiki/World_wide_web";
		
		if(is_null($options))
			$options = array('maxRetrieve' => 50,
				'linkedData' => 1);

		$response = $alchemyapi->concepts($dataType, $url, $options);

		$result = array();

		foreach ($response['concepts'] as $concept) {
			$resultEntity = array();

			$resultEntity['name'] = $concept['text'];
			$resultEntity['dbpedia'] = $concept['dbpedia'];

			array_push($result, $resultEntity);
		}
		return $result;
	}

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
}