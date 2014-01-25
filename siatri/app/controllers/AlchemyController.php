<?php

class AlchemyController extends BaseController {
    public function test(){

        $dataUrl = 'http://en.wikipedia.org/wiki/World_wide_web';
        AlchemyManger::getPersonEntities($dataUrl, null);

       
    }
}