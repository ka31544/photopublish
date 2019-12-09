<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    public function indexAction(Request $request)
    {
        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $user = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:User')->find($userId);

        $photosForPhotographer = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Photo')->findBy([
                'activeStatus' => 1,
                'assignedPhotographer' => $user
            ], [
                'uploadAt' => 'DESC'
            ]);
        $photosNotAcceptedForPhotographer = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Photo')->findBy([
                'activeStatus' => 3,
                'assignedPhotographer' => $user
            ], [
                'uploadAt' => 'DESC'
            ]);
        $photosForLeader = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Photo')->findBy([
                'activeStatus' => 1,
            ], [
                'uploadAt' => 'DESC'
            ]);
        $statusHistory = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:StatusHistory')->findBy([

            ], [
                'date' => 'DESC'
            ],
                8
            );

        return $this->render('dashboard/index.html.twig', array(
            'statusHistory' => $statusHistory,
            'photosForPhotographer' => $photosForPhotographer,
            'photosNotAcceptedForPhotographer' => $photosNotAcceptedForPhotographer,
            'photosForLeader' => $photosForLeader,
        ));
    }
}
