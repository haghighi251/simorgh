<?php

namespace App\Controller;

use App\Entity\Users;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Products;
use App\Entity\Settings;

class IndexController extends AbstractController
{
    private $site_settings;

    public function __construct()
    {
        $this->site_settings = function (ManagerRegistry $managerRegistry) {
            try {
                $this->site_settings = $managerRegistry
                    ->getRepository(Settings::class)
                    ->findOneBy(['id' => 1]);
                dd($this->site_settings);
            } catch (Exception $error) {
                throw($error);
            }
        };
    }

    /**
     * @Route("/", name="app_index")
     */
    public function index(TranslatorInterface $translator, ManagerRegistry $manager_registry): Response
    {
        // usually you'll want to make sure the user is authenticated first,
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var Users $user */
        $user = $this->getUser();
        $message = $translator->trans('Symfony is great', [], 'messages', 'ir_IR');

        $products = $manager_registry->
        getRepository(Products::class)
            ->findBy(
                array(),
                array('id' => 'ASC'),
                10,
                0
            );

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'FirstName' => $user->getFirstName(),
            'message' => $message,
            'body_class_name' => '',
            'products' => $products,
        ]);
    }

}
