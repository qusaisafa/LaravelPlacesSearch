<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/23/2018
 * Time: 10:47 AM
 */
namespace App;
use GuzzleHttp;
class Utils
{
    public static function external_get_request($url)
    {
        $res = file_get_contents($url);
        return $res;
    }
}