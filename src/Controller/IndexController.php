<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class IndexController extends AbstractController {

    /**
     * @Route("/", name="app_index")
     */
    public function index(TranslatorInterface $translator): Response {
        // usually you'll want to make sure the user is authenticated first,
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var Users $user */
        $user = $this->getUser();
        $message = $translator->trans('Symfony is great', [], 'messages', 'ir_IR');

        return $this->render('index/index.html.twig', [
                    'controller_name' => 'IndexController',
                    'FirstName' => $user->getFirstName(),
                    'message' => $message,
                    'body_class_name' => '',
        ]);
    }

}
