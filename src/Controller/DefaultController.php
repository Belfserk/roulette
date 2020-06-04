<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller
 *
 * @Route(path="/")
 */
class DefaultController extends AbstractController
{
    public function index()
    {
        return $this->render('index.html.twig');
    }
}
