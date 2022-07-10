<?php

namespace App\Controller\Authentication;

use App\Controller\UsersController;
use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\ConfigurationsServices;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Form\FormFactoryInterface;

class RegisterController extends AbstractController {

    // Loads application default settings.
    use ConfigurationsServices {
        ConfigurationsServices::__construct as private __CSconstruct;
    }

    public function __construct(SessionInterface $session) {
        $this->__CSconstruct($session);
    }

    /**
     * @Route("/register", name="app_authentication_register")
     */
    public function register(Request $request, UsersRepository $usersRepository, UserPasswordHasherInterface $passwordHasher, TranslatorInterface $translator
            , FormFactoryInterface $formFactory): Response {
        // Error variable keeps different errors inside its.
        $error = [];

        // Get site language. Language files are stored in translations directory.
        $lang = $this->getLang();

        // Set page variables.
        $page_title = $translator->trans('login_page_title', [], 'messages', $lang);

        // Make instance of users 
        $user = new Users();

        // Create registration form.
        $form = $formFactory->createNamed('RegisterForm', UsersType::class, $user, [
            'action' => '',
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        // Register form submit and add new user
        if ($form->isSubmitted() && $form->isValid()) {
            // We must check if the email is unique or not.
            if (UsersController::get_user_by_email($user->getEmail(),$usersRepository) !== false) {
                array_push($error, $translator->trans('email_is_not_unique', [], 'messages', $lang));
            }
            
            // We must check if the user name is unique or not.
            if (UsersController::get_user_by_email($user->getUserName(),$usersRepository) !== false) {
                array_push($error, $translator->trans('user_name_is_not_unique', [], 'messages', $lang));
            }
            
            if(strlen($user->getPassword()) < 6){
             array_push($error, $translator->trans('minimum_password_length', [], 'messages', $lang));   
            }

            // There is no error and we can add user.
            if (count($error) == 0) {
                // Hashing password 
                $hash_password = $passwordHasher->hashPassword(
                        $user,
                        $user->getPassword(),
                );
                $user->setPassword($hash_password);

                // Adding user role. One is admin and two is user.
                $user->setRoles(2);

                // Default user is not activated.
                $user->setStatus(0);

                // Set current time for register date field.
                $user->setRegisterAt(DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));

                // Set default salt for user.
                $user->setSalt(uniqid());

                $usersRepository->add($user);
                return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('authentication/register/index.html.twig', [
                    'controller_name' => 'RegisterController',
                    'user' => $user,
                    'form' => $form,
                    'error' => $error,
                    'page_title' => $page_title,
                    'body_class_name' => 'text-center',
                    'lang' => $lang,
                    'current_year' => date('Y'),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }

}
