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

        $notes = $this->getFilterResults($notes, $filter, $choice, $how);

        return $this->render('Notes/list.html.twig', array(
            'notes' => $notes,
            'filter' => $filter,
            'choice' => $choice,
            'how'   => $how,
        ));
    }

    /**
     * @param $notes
     * @param $filter
     * @param $choice
     * @param $how
     * @return mixed
     */
    public function getFilterResults($notes, $filter, $choice, $how)
    {
        if ($choice == 1)
        {
            switch ($how)
            {
                case 1: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByQueryAnywhere($filter); break;

                case 2: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByQueryStartingWith($filter); break;

                case 3: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByQueryEndingWith($filter); break;

                case 4: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByQueryExactWord($filter); break;
            }
        }
        else if ($choice == 2)
        {
            switch ($how)
            {
                case 1: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByGenusAnywhere($filter); break;

                case 2: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByGenusStartingWith($filter); break;

                case 3: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByGenusEndingWith($filter); break;

                case 4: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByGenusExactWord($filter); break;
            }
        }
        else if ($choice == 3)
        {
            switch ($how)
            {
                case 1: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByUserAnywhere($filter); break;

                case 2: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByUserStartingWith($filter); break;

                case 3: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByUserEndingWith($filter); break;

                case 4: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByUserExactWord($filter); break;
            }
        }
        else if ($choice == 4)
        {
            switch ($how)
            {
                case 1: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByNoteAnywhere($filter); break;

                case 2: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByNoteStartingWith($filter); break;

                case 3: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByNoteEndingWith($filter); break;

                case 4: $notes = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->findAllByNoteExactWord($filter); break;
            }
        }

        return $notes;
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
