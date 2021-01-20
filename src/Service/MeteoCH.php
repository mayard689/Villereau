<?php

namespace App\Service;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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
        try{
            return $meteoData['current_condition']['icon_big'];
        } catch (TransportExceptionInterface $e) {
        }

        return null;
    }

    public function getWeather(String $cityName='villereau-45')
    {
        $content=null;
        $data=array();

        try {
            $response = $this->client->request(
                'GET',
                'https://prevision-meteo.ch/services/json/' . $cityName
            );

            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                // get the response in JSON format
                //$content = $response->getContent();

                // convert the response (here in JSON) to an PHP array
                $data = $response->toArray();

            }

            return $data;
        } catch (TransportExceptionInterface $e) {
        }

        return null;
    }
}
