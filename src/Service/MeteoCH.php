<?php

namespace App\Service;


use Symfony\Component\HttpClient\HttpClient;

class MeteoCH
{
    protected $client;

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        $this->client = HttpClient::create();
    }

    /**
     * Return the URl of the current wethear icon.
     * This request for an array comming from getWeather since getWeather do the request
     * and next various function can manipulate it to extract data without doing again the request
     * @param array $meteoData : array coming from the getWeather function
     * @return String
     */
    public function getCurrentIcon(array $meteoData) : String
    {
        return $meteoData['current_condition']['icon_big'];
    }

    public function getWeather(String $cityName='villereau-45')
    {
        $content=null;
        $data=array();

        $response = $this->client->request(
            'GET',
            'https://prevision-meteo.ch/services/json/'.$cityName
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode === 200) {
            // get the response in JSON format
            //$content = $response->getContent();

            // convert the response (here in JSON) to an PHP array
            $data = $response->toArray();

        }

        return $data;
    }
}
