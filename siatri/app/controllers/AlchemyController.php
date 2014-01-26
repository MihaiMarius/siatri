<?php

class AlchemyController extends BaseController {
    public function test(){

        $dataUrl = 'http://en.wikipedia.org/wiki/World_wide_web';
        $personEntities = QuestionsManger::getEntities($dataUrl, null);
        // $companyEntities = QuestionsManger::getCompanyEntities($dataUrl, null);
        // $concepts = QuestionsManger::getConcepts($dataUrl, null);
        // $links = QuestionsManger::getLinks($dataUrl, null);
        return json_encode($personEntities);
        // var_dump($companyEntities);
        // var_dump($concepts);


    }
}