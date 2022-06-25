<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentsController extends AbstractController
{
    /**
     * @Route("/contents", name="app_contents")
     */
    public function index(): Response
    {
        return $this->render('contents/index.html.twig', [
            'controller_name' => 'ContentsController',
        ]);
    }
}
