<?php

namespace AppBundle\Controller;

use AppBundle\Entity\GenusNote;
use AppBundle\Form\GenusNoteForm;
use DateTime;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GenusNoteController
 * @package AppBundle\Controller
 * @Route("/notes")
 * @noinspection PhpUnused
 * @Security("is_granted('ROLE_ADMIN')")
 */
class GenusNoteController extends Controller
{
    /**
     * @Route("/list", name="notes_list")
     * @noinspection PhpUnused
     * @param Request $request
     * @return Response
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function listAction(Request $request)
    {
        $this->get('app.check_authorization')->checkNonObjectAuthorization();
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
     * @param Request $request
     * @noinspection PhpUnused
     * @Route("/new", name="note_new")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function newAction(Request $request)
    {
        $this->get('app.check_authorization')->checkNonObjectAuthorization();
        $note = new GenusNote();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAuthenticatedUser($this->container);

        $note->setUser($user);
        $note->setCreatedAt(new DateTime());
        $note->setUpdatedAt(new DateTime());

        $form = $this->createForm(GenusNoteForm::class, $note);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $notes = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($notes);
            $em->flush();
            $this->get('app.update_amount')->updateEverything();
            $this->addFlash('success',sprintf('Note Created!'));

            return $this->redirectToRoute('notes_list');
        }

        return $this->render('Notes/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @noinspection PhpUnused
     * @Route("/show/{id}", name="note_show")
     * @param $id
     * @Security("is_granted('ROLE_ADMIN')")
     * @return Response
     */
    public function showAction($id)
    {
        $this->get('app.check_authorization')->checkNonObjectAuthorization();
        $note = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->find($id);

        return $this->render('Notes/show.html.twig', array(
            'note' => $note,
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @noinspection PhpUnused
     * @Route("/edit/{id}", name="note_edit")
     * @Security("is_granted('ROLE_ADMIN')")
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function editAction(Request $request, $id)
    {
        $url = $request->headers->get('referer');
        $this->get('app.check_authorization')->checkNonObjectAuthorization();
        $note = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->find($id);
        $note->setUpdatedAt(new DateTime());

        $form = $this->createForm(GenusNoteForm::class, $note);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $notes = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->merge($notes);
            $em->flush();
            $this->get('app.update_amount')->updateEverything();
            $this->addFlash('success', sprintf('Note Updated!'));

            return $this->redirect($url);
        }

        return $this->render('Notes/edit.html.twig', array(
            'form' => $form->createView(),
            'note' => $note,
            'url' => $url,
            'correctUrl' => 'http://127.0.0.1:8000'.$this->generateUrl('note_edit', array('id' => $id))
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     * @noinspection PhpUnused
     * @Route("/delete/{id}", name="note_delete")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteAction($id, Request $request)
    {
        $url = $request->headers->get('referer');
        $this->get('app.check_authorization')->checkNonObjectAuthorization();
        $note = $this->getDoctrine()->getRepository('AppBundle:GenusNote')->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($note);
        $em->flush();
        $this->get('app.update_amount')->updateEverything();
        $this->addFlash('danger', 'Note Deleted');
        return $this->redirect($url);
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
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('notes_list');
    }
}
