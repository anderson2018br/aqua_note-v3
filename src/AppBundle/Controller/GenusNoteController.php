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
        $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAll();

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
}
