<?php

namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;

class DiscoverController extends AbstractController
{

    public function index()
    {
        $news = [];
        $client = HttpClient::create();
        $response = $client->request(
            'GET',
            'https://test.spaceflightnewsapi.net/api/v2/articles'
        );
        // TODO: change link to get more content

        $statusCode = $response->getStatusCode(); // get Response status code 200

        if ($statusCode === 200) {
            $news = $response->getContent();
            // get the response in JSON format
            $news = $response->toArray();
            // convert the response (here in JSON) to an PHP array
        }
        // var_dump($news);die;
        return $this->twig->render('Discover/index.html.twig', ['news' => $news]);
    }
}
