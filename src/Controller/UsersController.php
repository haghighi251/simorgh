<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Service\MessageGenerator;
use App\bundles\date\show_date;

/**
 * @Route("/users")
 */
class UsersController extends AbstractController {

    private $message;
    private $date;

    public function __construct(MessageGenerator $message, show_date $date) {
        $this->message = $message->getHappyMessage();
        $this->date = $date->show();
    }

    /**
     * @Route("/", name="app_users_index", methods={"GET"})
     */
    public function index(UsersRepository $usersRepository): Response {
        return $this->render('users/index.html.twig', [
                    'users' => $usersRepository->findAll(),
                    'message' => $this->message,
                    'date' => $this->date,
        ]);
    }

    /**
     * @Route("/new", name="app_users_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UsersRepository $usersRepository, UserPasswordHasherInterface $passwordHasher): Response {
        $user = new Users();

        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Hashing password 
            $hash_password = $passwordHasher->hashPassword(
                    $user,
                    $user->getPassword(),
            );
            $user->setPassword($hash_password);
            //َAdding user role. One is admin and two is user.
            $user->setRoles(2);
            $usersRepository->add($user);
            return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/new.html.twig', [
                    'user' => $user,
                    'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_users_show", methods={"GET"})
     */
    public function show(Users $user): Response {
        return $this->render('users/show.html.twig', [
                    'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_users_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Users $user, UsersRepository $usersRepository): Response {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersRepository->add($user);
            return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/edit.html.twig', [
                    'user' => $user,
                    'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_users_delete", methods={"POST"})
     */
    public function delete(Request $request, Users $user, UsersRepository $usersRepository): Response {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $usersRepository->remove($user);
        }

        return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * 
     * This method looks for a user by email. It will return false if the user 
     * can't be found.
     * @param type $email
     * @return boolean
     */
    public static function get_user_by_email($email,$usersRepository) {
        $user = $usersRepository->findOneByEmail($email);
        if (false !== $user && !is_null($user)) {
            return $user;
        } else {
            return false;
        }
    }
    
    public static function get_user_by_user_name($user_name,$usersRepository) {
        $user = $usersRepository->findOneByUserName($user_name);
        if (false !== $user && !is_null($user)) {
            return $user;
        } else {
            return false;
        }
    }

}
