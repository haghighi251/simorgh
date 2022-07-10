<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
//use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Form\ProductsType;

class ProductController extends AbstractController {

    /**
     * @Route("/product", name="app_product")
     */
    public function index(SessionInterface $session): Response {

        return $this->render('product/index.html.twig', [
                    'controller_name' => 'ProductController',
                    'session' => $session->get('email'),
        ]);
    }

    /**
     * @Route("/product/add", name="create_product")
     */
    public function createProduct(ManagerRegistry $doctrine): Response {
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
     * @Route("/product/{id}", name="product_show")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response {
        $product = $doctrine->getRepository(Products::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Not found product id: ' . $id);
        }

        return new Response('Product title is: ' . $product->getName());
    }

    /**
     * @Route("/product_show/{id}", name="product_show2")
     */
    public function show2(Products $product): Response {
        if (!$product) {
            throw $this->createNotFoundException('Not found product id: ' . $id);
        }

        return new Response('Product title is: ' . $product->getName());
    }

    /**
     * @Route("/product/edit/{id}",name="product_update")
     */
    public function update(ManagerRegistry $doctrine, int $id): Response {
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
    public function Remove(ManagerRegistry $doctrine, int $id): Response {
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
    public function form() {
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);
        return $this->renderForm('product/form.html.twig', [
                    'form' => $form,
        ]);
    }

}
