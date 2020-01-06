<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        $this->checkNonObjectAuthorization();
        $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllOrdered();

        $filter = $request->query->get('filter');
        $choice = $request->query->get('choice');
        $how    = $request->query->get('how');

        return $this->render('Notes/list.html.twig', array(
            'notes' => $notes,
            'filter' => $filter,
            'choice' => $choice,
            'how'   => $how,
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
