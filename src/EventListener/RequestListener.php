<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Psr\Log\LoggerInterface;
use Doctrine\Persistence\ManagerRegistry;

class RequestListener {

    private $tokenStorage;
    private $router;
    private $logger;
    private $doctrine;

    /**
     * 
     * @param TokenStorageInterface $tokenStorage
     * @param RouterInterface $router
     */
    public function __construct(TokenStorageInterface $tokenStorage, RouterInterface $router, LoggerInterface $logger, ManagerRegistry $doctrine) {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
        $this->logger = $logger;
        $this->doctrine = $doctrine;
    }

    /**
     * 
     * @param RequestEvent $event
     * @return type
     */
    public function onKernelRequest(RequestEvent $event) {
        // getting current user: $this->tokenStorage->getToken()->getUser()
        // Important: Don't edit or remove these four lines.
        if (!$event->isMainRequest()) {
            // don't do anything if it's not the main request
            return;
        }
        
        // Redirecting users to site home if they are logged and the requested route is login or register.
        if ($this->tokenStorage->getToken() &&
                $this->redirectIfAuthenticated($event->getRequest()->getpathInfo())
        ) {
            $response = new RedirectResponse($this->router->generate('app_index'));
            $event->setResponse($response);
        }
    }

    /**
     * Redirecting user to home index if is logged and request for login or register page.
     * @param string $route_name
     * @return boolean
     */
    private function redirectIfAuthenticated(string $route_name) {
        $redirect_in_routes = ['/login', '/register'];

        if (in_array($route_name, $redirect_in_routes)) {
            return true;
        } else {
            return false;
        }
    }

}
