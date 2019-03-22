<?php

namespace App\Http\Controllers;

use App\ArticlesCaches;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ArticlesController extends Controller
{
	function getArticles($keywords){
    	$all_articles = [];
		$departements = json_decode($this->getDepartements()->getContent());
		$count = 0;

    	$apiUrl = 'https://api.ozae.com/gnw/articles';
		$dateNow = date("Ymd");
		$Ayearago = strtotime($dateNow.' -1 year');
		$dateAYearAgo = date("Ymd",$Ayearago);
		$country = "fr-fr";
    	foreach ($departements as $departement) {
    		$thiscities = json_decode($this->getCities($departement->code)->getContent());

    		foreach ($thiscities as $city) {
    			// var_dump($city->nom);die;
    			$client = new Client();
				$result = $client->get($apiUrl, [
				    'query' => [
				        'key' => "12eaaa6043714982be5b92fda9446de7",
				        'date' => $dateAYearAgo."__".$dateNow,
				        'edition' => $country,
				        'query' => $keywords.$city->nom,
				        'hard_limit' => '10'
				    ]
				]);

				$data = $result->getBody()->getContents();

				$articles = ArticlesCaches::where('keyword', $keywords.$city->nom)->first();
				if($articles){
					$all_articles = $all_articles + json_decode($articles->data)->articles;
				} else {
					$articles = new ArticlesCaches;
			        $articles->keyword = $keywords.$city->nom;
			        $articles->data = $data;
			        $articles->save();
					$all_articles = $all_articles + json_decode($articles->data)->articles;
				}
    		}
			$count++;
    	}
		return response()->json($all_articles);
	}

    function getCities($departements){
    		$client = new Client(); //GuzzleHttp\Client
	    	$url = "https://geo.api.gouv.fr/departements/".$departements."/communes";
			$result = $client->get($url, [
			    'query' => [
			        'fields' => 'nom,code,codesPostaux,centre,population',
			        'format' => 'json',
			        'geometry' => 'centre'
			    ]
			]);
			$cities = json_decode($result->getBody()->getContents());
		return response()->json($cities);
    }

    function getDepartements(){
    	$client = new Client(); //GuzzleHttp\Client
		$result = $client->get('https://geo.api.gouv.fr/departements', [
		    'query' => [
		        'fields' => 'nom,code'
		    ]
		]);
		return response()->json(json_decode($result->getBody()->getContents()));
    }
}
