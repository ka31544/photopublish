<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Status History Controller
 *
 */
class StatusHistoryController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $statusHistory = $em->getRepository('AppBundle:StatusHistory')->findBy([

        ],[
            'date' => 'DESC',
        ]);

        return $this->render('statusHistory/index.html.twig', array(
            'statusHistory' => $statusHistory,
        ));
    }

}
