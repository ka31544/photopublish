<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {
        $statusHistory = $this->getDoctrine()->getManager()->getRepository('AppBundle:StatusHistory')->findAll();

        return $this->render('dashboard/index.html.twig', array(
            'statusHistory' => $statusHistory,
        ));
    }
}
