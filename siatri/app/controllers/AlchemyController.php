<?php

class AlchemyController extends BaseController {
    public function test(){

        $alchemyapi = new AlchemyAPI('e74d8cd625be67883f77395f60325145923d744c');

        $dataUrl = 'http://en.wikipedia.org/wiki/World_wide_web';
        $dataType = 'url';
        $options = array();

        $response = $alchemyapi->entities($dataType, $dataUrl, $options);

        foreach ($response['entities'] as $entity) {
            if($entity['text'] == 'Web 2.0')
            // var_dump('entity: '. $entity['text']);
                var_dump($entity);
        }
    }
}