<?php

class AlchemyController extends BaseController {
    public function test(){

        $dataUrl = 'http://en.wikipedia.org/wiki/World_wide_web';
        $personEntities = QuestionsManger::getEntities($dataUrl, null);
        $links = QuestionsManger::getLinks($dataUrl, null);
         var_dump($personEntities);
    }
}