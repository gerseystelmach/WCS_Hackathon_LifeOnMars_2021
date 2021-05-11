<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;

class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */


    public function index()
    {
        $client = HttpClient::create();
        $reponseTestiomonial = $client->request('GET', 'https://testimonialapi.toolcarton.com/api');
        $testimonials = $nasaImages = [];
        $statusCodeTes = $reponseTestiomonial->getStatusCode();
        if ($statusCodeTes === 200) {
            $testimonials = $reponseTestiomonial->toArray();
        }

        $reponseNasa = $client->request(
            'GET',
            'https://api.nasa.gov/mars-photos/api/v1/rovers/curiosity/photos?sol=1000&api_key='
            . APP_KEY
        );

        $statusCodeNasa = $reponseNasa->getStatusCode();
        if ($statusCodeNasa === 200) {
            $nasaImages = $reponseNasa->toArray();
        }


        return $this->twig->render(
            'Home/index.html.twig',
            ['testimonials' => $testimonials,
            'nasaImages' => $nasaImages['photos'],
            ]
        );
    }
}
