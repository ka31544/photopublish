<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    public function indexAction(Request $request)
    {
        $user = $this->getLoggedUser();

        $photosForPhotographer = $this->photosForUser([
            'activeStatus' => 1,
            'assignedPhotographer' => $user
        ]);

        $photosNotAcceptedForPhotographer = $this->photosForUser([
                'activeStatus' => 3,
                'assignedPhotographer' => $user
            ]);
        $photosForRetoucher = $this->photosForUser([
            'activeStatus' => 2,
//            'assignedRetoucher' => $user
        ]);
        $photosNotAcceptedForRetoucher = $this->photosForUser([
            'activeStatus' => 6,
//            'assignedRetoucher' => $user
        ]);
        $photosForLeader = $this->photosForUser([
            'activeStatus' => 1,
        ]);
        $retouchedPhotosForLeader = $this->photosForUser([
            'activeStatus' => 4,
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
            'photosForRetoucher' => $photosForRetoucher,
            'photosNotAcceptedForRetoucher' => $photosNotAcceptedForRetoucher,
            'photosForLeader' => $photosForLeader,
            'retouchedPhotosForLeader' => $retouchedPhotosForLeader,
        ));
    }
    private function getLoggedUser() {
        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $user = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:User')->find($userId);

        return $user;
    }
    private function photosForUser(array $conditions, array $sort = ['uploadAt' => 'DESC']) {
        $photos = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Photo')->findBy($conditions, $sort);

        return $photos;
    }
}
