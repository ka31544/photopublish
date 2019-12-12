<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Photo;
use AppBundle\Entity\StatusHistory;
use AppBundle\Form\PhotoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Photo controller.
 *
 */
class PhotoController extends Controller
{
    /**
     * Lists all photo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $photos = $em->getRepository('AppBundle:Photo')->findAll();

        return $this->render('photo/index.html.twig', array(
            'photos' => $photos,
        ));
    }

    /**
     * Creates a new photo entity.
     *
     */
    public function newAction(Request $request)
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        //Pobranie zalogowanego użytkownika
        $user = $this->getLoggedUser();

        //Ustawienie statusu zdjęcia na upload (id=1) oraz przypisanie się fotografa do zdjęcia
        $status = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Status')->find(1);
        $photo->setActiveStatus($status);
        $photo->setAssignedPhotographer($user);

        $statusHistory = new StatusHistory();
        $statusHistory->setPhoto($photo);
        $statusHistory->setStatus($status);
        $statusHistory->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $photoFile */
            $photoFile = $form['src']->getData();

            if ($photoFile) {
                $originalFileName = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFileName = $originalFileName.'-'.uniqid().'.'.$photoFile->guessExtension();
                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFileName
                    );
                } catch (FileException $e) {
                }
                $newSrc = '/uploads/' . $newFileName;
                $photo->setSrc($newSrc);
            }

            $em = $this->getDoctrine()->getManager();
            $entities = [$photo, $statusHistory];

            foreach ($entities as $entity) {
                $em->persist($entity);
            }

            $em->flush();

            return $this->redirectToRoute('photo_show', array('id' => $photo->getId()));
        }

        return $this->render('photo/new.html.twig', array(
            'photo' => $photo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a photo entity.
     *
     */
    public function showAction(Photo $photo)
    {
        $deleteForm = $this->createDeleteForm($photo);

        return $this->render('photo/show.html.twig', array(
            'photo' => $photo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing photo entity.
     *
     */
    public function editAction(Request $request, Photo $photo)
    {

        $deleteForm = $this->createDeleteForm($photo);
        $editForm = $this->createForm(PhotoType::class, $photo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('photo_edit', array('id' => $photo->getId()));
        }

        return $this->render('photo/edit.html.twig', array(
            'photo' => $photo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a photo entity.
     *
     */
    public function deleteAction(Request $request, Photo $photo)
    {
        $form = $this->createDeleteForm($photo);
        $form->handleRequest($request);

        $photoSrc = $this->getParameter('root_directory').$photo->getSrc();
        $photoFile = new Filesystem();

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile->remove($photoSrc);
            $em = $this->getDoctrine()->getManager();
            $em->remove($photo);
            $em->flush();
        }

        return $this->redirectToRoute('_dashboard');
    }

    /**
     * Accept photo for action leader
     */
    public function acceptPhotoAction(Request $request, Photo $photo)
    {
        $this->acceptPhoto($photo, 2);

        return $this->redirectToRoute('photo_show', array('id' => $photo->getId()));
    }

    /**
     * Not accept photo for action leader
     */
    public function notAcceptPhotoAction(Photo $photo)
    {
        $this->acceptPhoto($photo, 3);

        return $this->redirectToRoute('photo_show', array('id' => $photo->getId()));
    }

    /**
     * Creates a form to delete a photo entity.
     *
     * @param Photo $photo The photo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Photo $photo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('photo_delete', array('id' => $photo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    private function getLoggedUser() {
        //Pobranie zalogowanego użytkownika
        $userId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        return $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:User')->find($userId);
    }
    private function acceptPhoto(Photo $photo, $statusId) {
        //Ustawienie statusu zdjęcia na upload (id=1)
        $status = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Status')->find($statusId);
        $photo->setActiveStatus($status);

        //Wstawienie rekordu do historii statusu
        $statusHistory = new StatusHistory();

        $user = $this->getLoggedUser();

        $statusHistory->setPhoto($photo);
        $statusHistory->setStatus($status);
        $statusHistory->setUser($user);


        $em = $this->getDoctrine()->getManager();
        $entities = [$photo, $statusHistory];

        foreach ($entities as $entity) {
            $em->persist($entity);
        }

        $em->flush();
    }
}
