<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    public function indexAction(Request $request)
    {
        $photosForPhotographer = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Photo')->findBy([

            ]);
        $statusHistory = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:StatusHistory')->findBy([

            ], [
                'date'=>'DESC'
            ]);

        return $this->render('dashboard/index.html.twig', array(
            'statusHistory' => $statusHistory,
            'photosForPhotographer' => $photosForPhotographer,
        ));
    }
}
