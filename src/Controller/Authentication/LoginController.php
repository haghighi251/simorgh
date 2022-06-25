<?php

namespace App\Controller\Authentication;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\ConfigurationsServices;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginController extends AbstractController {

    // Loads application default settings.
    use ConfigurationsServices {
        ConfigurationsServices::__construct as private __CSconstruct;
    }

    public function __construct(SessionInterface $session) {
        $this->__CSconstruct($session);
    }

    /**
     * @Route("/login", name="login")
     */
    public function index(AuthenticationUtils $authenticationUtils, TranslatorInterface $translator): Response {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        // Get site language. Language files are stored in translations directory.
        $lang = $this->getLang();
        
        // Set page variables.
        $page_title = $translator->trans('login_page_title', [], 'messages', $lang);

        return $this->render('authentication/login/index.html.twig', [
                    'controller_name' => 'LoginController',
                    'last_username' => $lastUsername,
                    'error' => $error,
                    'page_title' => $page_title,
                    'body_class_name' => 'text-center',
                    'lang' => $lang,
                    'current_year' => date('Y'),
        ]);
    }
    
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(){}

}
