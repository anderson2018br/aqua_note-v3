<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GenusNoteController
 * @package AppBundle\Controller
 * @Route("/notes")
 * @noinspection PhpUnused
 */
class GenusNoteController extends Controller
{
    /**
     * @Route("/list", name="notes_list")
     * @noinspection PhpUnused
     */
    public function listAction()
    {
        $this->checkNonObjectAuthorization();
        $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllOrdered();

        return $this->render('Notes/list.html.twig', array(
            'notes' => $notes
        ));
    }

    /**
     * @Route("/")
     * @noinspection PhpUnused
     */
    public function indexAction()
    {
        return $this->redirectToRoute('notes_list');
    }

    public function checkNonObjectAuthorization()
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAuthenticatedUser($this->container);

        if (!in_array('ROLE_ADMIN', $user->getRoles()))
        {
            throw $this->createAccessDeniedException("You are not allowed to access this page");
        }
    }
}
