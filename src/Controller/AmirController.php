<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AmirController extends AbstractController {

    /**
     * @Route("/amir", name="app_amir")
     */
    public function index(Request $rq, SessionInterface $session): Response {
        $page_number = $rq->query->get('page');
        $session->set('email', 'haghighi251');
        $this->addFlash('Notice', "Hi error");
        $task = new Task();
        //Processing the form
//        $form = $this->createForm(TaskType::class,$task);
//        if($form->isSubmitted() && $form->isValid()){
//            $task = $form->getData();
//            //do actions ...
//            return $this->redirectToRoute('success_task');
//        }


        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($task)
                ->add('task', TextType::class, ['label' => 'My custom label'])
                ->add('dueDate', DateType::class)
                ->add('save', SubmitType::class, ['label' => 'Create Task'])
                ->getForm();

        return $this->renderForm('amir/index.html.twig', [
        'controller_name' => 'AmirController',
        'page_number' => $page_number,
        'json' => $this->json(['Brand' => 'BMW']),
        'routeName' => $rq->attributes->get('_route'),
        'CurrentRouteName' => $rq->get('_route'),
        'form' => $form,
        ]);
    }
    
    public function show():Response{
        return new Response('Hi');
    }

}
