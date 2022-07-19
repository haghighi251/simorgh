<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Form\ProductsType;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductController extends AbstractController
{

    public function __construct()
    {
    }

    /**
     * @param TranslatorInterface $translatorInterface
     * @param ManagerRegistry $manager_registry
     * @return Response
     * @Route("/product/{slug}", name="product_show_by_slug")
     */
    public function product_show_by_slug(
        TranslatorInterface $translatorInterface,
        ManagerRegistry     $manager_registry,
        string              $slug
    ): Response
    {
        $message = "";
        $product = $manager_registry->getRepository(Products::class)->findOneBy(['slug' => $slug]);

        if (!$product) {
            throw $this->createNotFoundException('Product not found.');
        }

        // use inline documentation to tell your editor your exact User class
        /** @var Users $user */
        $user = $this->getUser();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'FirstName' => $user->getFirstName(),
            'message' => $message,
            'body_class_name' => '',
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product", name="app_product")
     */
    public function index(SessionInterface $session): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'session' => $session->get('email'),
        ]);
    }

    /**
     * @Route("/product/add", name="create_product")
     */
    public function createProduct(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Products();
        $product->setName('Keyboard2');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');
        $product->setPublishAt(new DateTime());

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id ' . $product->getId());
    }


    /**
     * @Route("/product/edit/{id}",name="product_update")
     */
    public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $doctrine->getRepository(Products::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product with id ' . $id . ' has not be found.');
        }
        $product->setName($product->getName() . ' ' . $id);
        $entityManager->flush();
        return new Response('Product has been updated.');
    }

    /**
     * @Route("/product/remove/{id}")
     */
    public function Remove(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $doctrine->getRepository(Products::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('There is no product with id ' . $id);
        }
        $entityManager->remove($product);
        $entityManager->flush();
        return new Response('Product has been removed.');
    }

    /**
     * @Route("/product/html/form",name="product_form")
     */
    public function form()
    {
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);
        return $this->renderForm('product/form.html.twig', [
            'form' => $form,
        ]);
    }

}
