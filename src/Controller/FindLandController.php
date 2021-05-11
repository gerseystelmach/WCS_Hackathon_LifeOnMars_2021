<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;

class FindLandController extends AbstractController
{
    public const PLANS = [
        0 => ['name' => 'Plan #1', 'square metres', 'price' => 10, 'description'],
        1 => ['name' => 'Plan #2','square metres', 'price' => 15, 'description'],
        2 => ['name' => 'Plan #3','square metres', 'price' => 20, 'description'],
    ];

    public function list()
    {
        $photos = [];
        $client = HttpClient::create();
        $response = $client->request(
            'GET',
            'https://api.nasa.gov/mars-photos/api/v1/rovers/curiosity/photos?sol=1000&page=5&api_key=' . APP_KEY
        );
        // TODO: change link to get more content

        $statusCode = $response->getStatusCode(); // get Response status code 200

        if ($statusCode === 200) {
            $photos = $response->getContent();
            // get the response in JSON format
            $photos = $response->toArray();
            // convert the response (here in JSON) to an PHP array
        }
        return $this->twig->render('FindLand/index.html.twig', ['photos' => $photos['photos']]);
    }
}
