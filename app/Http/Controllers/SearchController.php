<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;
use App\Utils;
use App\GoogleStatics;
class SearchController extends Controller
{

    public function index()
    {
        return "Search API working";
    }

    public function search(Request $request)
    {
        $allMatchedPlaces = array();
        $query = $request->input('query');  //input parameter
        $url = GoogleStatics::$searchByTextAPI . "?query=" . $query . "&key=" . GoogleStatics::$key;  //Google API
        $jsonResult = Utils::external_get_request($url);
        $arr = json_decode($jsonResult, true);  //parsing response
        $places = $arr["results"];

       foreach ($places as $place){   //fill into Place Model
            $newPlace = new Place;
            $newPlace->name = $place["name"];
            $newPlace->formatted_address = $place["formatted_address"];
            $newPlace->types = $place["types"];
            $newPlace->photos = $place["photos"];
            $newPlace->placeId = $place["place_id"];
            $allMatchedPlaces[] = $newPlace;
       }
       return $allMatchedPlaces; // JSON response of all matched results
    }

    public function placeDetails(Request $request){
        $placeId = $request->input('placeId');  //input parameter
        $url = GoogleStatics::$searchByPlaceId . "?placeid=" . $placeId . "&key=" . GoogleStatics::$key;  //Google API
        $jsonResult = Utils::external_get_request($url);
        $arr = json_decode($jsonResult, true);  //parsing response
        $details = $arr["results"];
        if($details)
            return $arr;
        else
            return "No results found or the Place id is wrong";
    }
}

