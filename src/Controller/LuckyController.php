<?php

// src/Controller/LuckyController.php

namespace App\Controller;

use App\Service\MessageGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LuckyController extends AbstractController {

    public function number(): Response {
        $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', [
                    'number' => $number,
        ]);
    }

    #[Route('/user', name: 'user_id')]
    public function id(Request $request, $p, SessionInterface $session, MessageGenerator $messageGenerator): Response {
// stores an attribute for reuse during a later user request
        $session->set('foo', 'bar');

        // gets the attribute set by another controller in another request
        $foobar = $session->get('foobar');
//        $user_id = $_GET['id'];
        $page = $request->query->get('page', 1);
        $url = $this->generateUrl('app_lucky_number', ['max' => 10]);

        $this->addFlash(
                'notice',
                'Your changes were saved!'
        );
        // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
//return $this->json(['name'=>'value']);
        return $this->render('lucky/user_id.html.twig', [
                    'page' => $page,
                    'url' => $url,
                    'foobar' => $foobar,
                    'messageGenerator' =>  $messageGenerator->getHappyMessage(),
        ]);

//        return new Response('<html><body>url is: ' . $url . ' '
//                . 'and page number is: ' . $page . ' and $p is :' . $p . '</body></html>');
    }

}
