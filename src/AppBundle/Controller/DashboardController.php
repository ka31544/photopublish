<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    public function indexAction(Request $request)
    {
        $user = $this->getLoggedUser();

        $photosForUser = [];
        $photos2ForUser  = [];
        $photos3ForUser = [];

        if (in_array('ROLE_PHOTOGRAPHER', $user->getRoles()))
        {
            $photosForUser = $this->photosForUser([
                'activeStatus' => 1,
                'assignedPhotographer' => $user
            ]);

            $photos2ForUser = $this->photosForUser([
                'activeStatus' => 3,
                'assignedPhotographer' => $user
            ]);
        }
        elseif (in_array('ROLE_RETOUCHER', $user->getRoles()))
        {
            $photosForUser = $this->photosForUser([
                'activeStatus' => 2,
//            'assignedRetoucher' => $user
            ]);
            $photos2ForUser = $this->photosForUser([
                'activeStatus' => 6,
//            'assignedRetoucher' => $user
            ]);
        }
        elseif (in_array('ROLE_ADMIN', $user->getRoles()))
        {
            $photosForUser = $this->photosForUser([
                'activeStatus' => 1,
            ]);
            $photos2ForUser = $this->photosForUser([
                'activeStatus' => 4,
            ]);
        }
        elseif (in_array('ROLE_WEBMASTER', $user->getRoles()))
        {
            $photosForUser = $this->photosForUser([
                'activeStatus' => 5,
//                'assignedWebmaster' => $user
            ]);
        }

        $statusHistory = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:StatusHistory')->findBy([

            ], [
                'date' => 'DESC'
            ],
                8
            );

        return $this->render('dashboard/index.html.twig', array(
            'photosForUser' => $photosForUser,
            'photos2ForUser' => $photos2ForUser,
            'photos3ForUser' => $photos3ForUser,
            'statusHistory' => $statusHistory,
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
