<?php

// config/routes.php
use App\Controller\BlogController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use App\Controller\ProductController;
use App\Controller\IndexController;

return function (RoutingConfigurator $routes) {
    //Home index
    $routes->add('site_home', '/')
        ->controller([IndexController::class, 'index']);


    $routes->add('blog_list', '/blog')
        // the controller value has the format [controller_class, method_name]
        ->controller([BlogController::class, 'list'])
        ->methods(['GET', 'POST'])//For restriction http methods such as put, file, etc...
        // if the action is implemented as the __invoke() method of the
        // controller class, you can skip the 'method_name' part:
        // ->controller(BlogController::class)
    ;


    //Getting just numbers as slug parameter
    $routes->add('blog_list', '/blog/{page}')
        ->controller([BlogController::class, 'list'])
        ->requirements(['page' => '\d+']);

    $routes->add('blog_show', '/blog/{slug}')
        ->controller([BlogController::class, 'show']);


    $routes->add('product_form', '/product/html/form')
        ->controller([ProductController::class, 'form']);

};
