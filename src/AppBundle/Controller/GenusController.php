<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use AppBundle\Form\GenusForm;
use AppBundle\Form\GenusShowNoteForm;
use DateTime;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GenusController
 * @package AppBundle\Controller
 * @Route("/genus")
 * @noinspection PhpUnused
 */
class GenusController extends Controller
{
    private $url;
    private $urlOld;
    /**
     * @param Request $request
     * @Route("/list", name="genus_list")
     * @noinspection PhpUnused
     * @return Response
     */
    public function listAction(Request $request)
    {
        $genuses = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllOrderedBy();
        $filter = $request->query->get('filter');
        $choice = $request->query->get('choice');
        $how = $request->query->get('how');
        $genuses = $this->getFilterResults($genuses, $filter, $choice, $how);
        return $this->render('genus/list.html.twig', array(
            'genuses' => $genuses,
            'choice' => $choice,
            'filter' => $filter,
            'how' => $how
        ));
    }

    /**
     * @param Request $request
     * @noinspection PhpUnused
     * @Route("/new", name="genus_new")
     * @Security("is_granted('ROLE_USER')")
     * @return Response
     * @throws Exception
     */
    public function newAction(Request $request)
    {
        $url = $request->headers->get('referer');

        $genus = new Genus();
        $genus->setCreatedAt(new DateTime());
        $genus->setUpdatedAt(new DateTime());
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAuthenticatedUser($this->container);
        $genus->setUser($user);
        $form = $this->createForm(GenusForm::class, $genus);

        $form->handleRequest($request);
        if ($form->isValid())
        {
            $genus = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($genus);
            $this->get('app.update_amount')->updateEverything();
            $this->addFlash('success', sprintf('Genus Created'));
            return $this->redirectToRoute('genus_list');
        }

        return $this->render('genus/new.html.twig', array(
            'form' => $form->createView(),
            'url' => $this->generateUrl('genus_list'),
            'correctUrl' => ''
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/{id}", name="genus_show")
     * @return Response
     * @throws Exception
     */
    public function showAction(Request $request, $id)
    {
        $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->find($id);
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAuthenticatedUser($this->container);
        $note = new GenusNote();
        $note->setGenus($genus);
        $note->setCreatedAt(new DateTime());
        $note->setUpdatedAt(new DateTime());
        $note->setUser($user);

        $form = $this->createForm(GenusShowNoteForm::class, $note);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $notes = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($notes);
            $em->flush();
            $this->get('app.update_amount')->updateEverything();
            return $this->redirectToRoute('genus_show', array('id' => $genus->getId()));
        }
        return $this->render('genus/show.html.twig', array(
            'genus' => $genus,
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     * @noinspection PhpUnused
     * @Route("/{id}/edit", name="genus_edit")
     * @Security("is_granted('ROLE_USER')")
     * @throws Exception
     */
    public function editAction(Request $request, $id)
    {
        $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->find($id);
        $this->url = $request->headers->get('referer');
        if (($this->url == 'http://127.0.0.1:8000'.$this->generateUrl('genus_list')) || ($this->url == 'http://127.0.0.1:8000'.$this->generateUrl('user_delete_genus', array('id' => $genus->getUser()->getId()))))
        {
            $this->urlOld = $this->url;
        }
        else {
            $this->urlOld = 'http://127.0.0.1:8000'.$this->generateUrl('genus_list');
        }

        $this->get('app.check_authorization')->checkAuthorization($genus, "You are not allowed to edit this genus");
        $genus->setUpdatedAt(new DateTime());
        $form = $this->createForm(GenusForm::class, $genus);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $genus = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->merge($genus);
            $em->flush();
            $this->get('app.update_amount')->updateEverything();
            $this->addFlash('success', sprintf('Genus Updated'));

            return $this->redirect($this->urlOld);
        }
        return $this->render('genus/edit.html.twig', array(
            'genus' => $genus,
            'form' => $form->createView(),
            'url' => $this->urlOld,
            'correctUrl' => 'http://127.0.0.1:8000'.$this->generateUrl('genus_edit',array('id' => $id))
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     * @Route("/{id}/delete", name="genus_delete")
     * @Security("is_granted('ROLE_USER')")
     * @noinspection PhpUnused
     */
    public function deleteAction($id, Request $request)
    {
        $url = $request->headers->get('referer');
        $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->find($id);
        $this->get('app.check_authorization')->checkAuthorization($genus, "You are not allowed to delete this genus");
        $em = $this->getDoctrine()->getManager();
        foreach ($genus->getNote() as $note)
        {
            $em->remove($note);
        }

        $em->remove($genus);
        $em->flush();
        $this->get('app.update_amount')->updateEverything();

        $this->addFlash('danger', sprintf("Genus Deleted"));

        return $this->redirect($url);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @Route("/{id}/note", name="genus_show_note", methods={"GET"})
     * @noinspection PhpUnused
     */
    public function getNotesAction($id)
    {
        $notes = [];
        $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->find($id);
        foreach ($genus->getNote() as $note)
        {
            /** @noinspection PhpUndefinedMethodInspection */
            $notes[] = [
                'id' => $note->getId(),
                'username' => $note->getUser()->getUsername(),
                'avatarUri' => '/images/'.$note->getUser()->getAvatarFileName(),
                'note' => $note->getNote(),
                'date' => $note->getCreatedAt()->format('M d, Y')
            ];
        }

        $data = [
            'notes' => $notes
        ];

        return new JsonResponse($data);
    }

    public function getFilterResults($genus, $filter, $choice, $how)
    {
        if ($choice == 1)
        {
            switch ($how)
            {
                case 1: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByQueryAnywhere($filter); break;

                case 2: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByQueryStartingWith($filter); break;

                case 3: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByQueryEndingWith($filter); break;

                case 4: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByQueryExactWord($filter); break;
            }
        }
        else if ($choice == 2)
        {
            switch ($how)
            {
                case 1: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByNameAnywhere($filter); break;

                case 2: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByNameStartingWith($filter); break;

                case 3: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByNameEndingWith($filter); break;

                case 4: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByNameExactWord($filter); break;
            }
        }
        else if ($choice == 3)
        {
            switch ($how)
            {
                case 1: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllBySubFamilyAnywhere($filter); break;

                case 2: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllBySubFamilyStartingWith($filter); break;

                case 3: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllBySubFamilyEndingWith($filter); break;

                case 4: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllBySubFamilyExactWord($filter); break;
            }
        }
        else if ($choice == 4)
        {
            switch ($how)
            {
                case 1: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAlByUserAnywhere($filter); break;

                case 2: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByUserStartingWith($filter); break;

                case 3: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByUserEndingWith($filter); break;

                case 4: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByUserExactWord($filter); break;
            }
        }
        else if ($choice == 5)
        {
            switch ($how)
            {
                case 1: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllBySpeciesCountAnywhere($filter); break;

                case 2: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllBySpeciesCountStartingWith($filter); break;

                case 3: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllBySpeciesCountEndingWith($filter); break;

                case 4: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllBySpeciesCountExactWord($filter); break;
            }
        }
        else if ($choice == 6)
        {
            switch ($how)
            {
                case 1: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByDiscoveredAtAnywhere($filter); break;

                case 2: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByDiscoveredAtStartingWith($filter); break;

                case 3: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByDiscoveredAtEndingWith($filter); break;

                case 4: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByDiscoveredAtExactWord($filter); break;
            }
        }
        else if ($choice == 7)
        {
            switch ($how)
            {
                case 1: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByAmountOfNotesAnywhere($filter); break;

                case 2: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByAmountOfNotesStartingWith($filter); break;

                case 3: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByAmountOfNotesEndingWith($filter); break;

                case 4: $genus = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAllByAmountOfNotesExactWord($filter); break;
            }
        }
        return $genus;
    }

    /**
     * @return RedirectResponse
     * @Route("/")
     * @noinspection PhpUnused
     */
    public function indexAction()
    {
        return $this->redirectToRoute('genus_list');
    }
}
