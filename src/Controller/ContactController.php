<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

class ContactController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public const MAX_TEXT_LENGTH = 255;

    public function index()
    {
        $errors = $client = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $client = array_map('trim', $_POST);
            $errors =  $this->validateForm($client, $errors);
            if (empty($errors)) {
                header('Location: /contact/index');
            }
        }
        return $this->twig->render('Contact/index.html.twig', [
            'errors' => $errors,
            'client' => $client,
        ]);
    }

    private function validateForm($client, $errors): array
    {
        if (empty($client['firstname'])) {
            $errors[] = 'Please enter your first name.';
        } elseif (strlen($client['firstname']) > self::MAX_TEXT_LENGTH) {
            $errors[] = 'Your first name should not exceed ' . self::MAX_TEXT_LENGTH . ' characters.';
        }
        if (empty($client['lastname'])) {
            $errors[] = 'Please enter your last name.';
        } elseif (strlen($client['lastname']) > self::MAX_TEXT_LENGTH) {
            $errors[] = 'Your last name should not exceed ' . self::MAX_TEXT_LENGTH . '  characters.';
        }
        if (empty($client['email'])) {
            $errors[] = 'Please enter your email.';
        } elseif (!filter_var($client['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valide email.';
        }
        if (empty($client['message'])) {
            $errors[] = 'Please enter your message.';
        } elseif (strlen($client['message']) > self::MAX_TEXT_LENGTH) {
            $errors[] = 'Your message should not exceed ' . self::MAX_TEXT_LENGTH . '  characters.';
        }
        return $errors;
    }
}
