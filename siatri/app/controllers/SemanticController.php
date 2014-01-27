<?php

class SemanticController extends BaseController { // this is a testing place for the rdf parser
    public function testSparql(){
        // $url = "http://dbpedia.org/resource/Tim_Berners-Lee";

        
        // $triples = QuestionsManger::parseTriplesFromURL($url);
        // return Response::json($triples);
        $ng = Game::all()->first();
        // $ng->save();
        $u = User::all()->first();
        // $ng->users()->attach($u->id, array(
        //     'isHost' => true
        // ));
        // dd($u->pivot());
        // $games = $u->games()->get(array('score', 'isHost', 'active'));
        // foreach ($games as $game) {
        //     var_dump($game->isHost);
        // }
        $users = $ng->users;
        // foreach ($users as $user) {

        //     var_dump($user->pivot);
        // }

        $gms = $u->games;
        foreach ($gms as $g) {
            var_dump($g->pivot->isHost);
        }

    }
} 