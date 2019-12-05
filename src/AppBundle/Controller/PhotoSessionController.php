<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class PhotoSessionController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('photoSession/index.html.twig');
    }
}
