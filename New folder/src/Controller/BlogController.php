<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends AbstractController {


    public function list(int $page) {
        return new Response('<html><body>page number is: ' . $page . '</body></html>');
    }


    public function show($slug) {
        return new Response('<html><body>Slug is: ' . $slug . '</body></html>');
    }

    public function recentArticles(int $max = 3): Response {
        // get the recent articles somehow (e.g. making a database query)
        $articles = [
            ['slug'=>'slu1','title'=>'title 1'],
            ['slug'=>'slu2','title'=>'title 2'],
            ['slug'=>'slu3','title'=>'title 3'],
            ];

        return $this->render('blog/_recent_articles.html.twig', [
                    'articles' => $articles
        ]);
    }

}
