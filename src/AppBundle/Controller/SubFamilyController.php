<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SubFamily;
use AppBundle\Form\SubFamilyForm;
use DateTime;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubFamilyController
 * @package AppBundle\Controller
 * @noinspection PhpUnused
 * @Route("/subfamily")
 */
class SubFamilyController extends Controller
{
    /**
     * @param Request $request
     * @Route("/list", name="subfamily_list")
     * @noinspection PhpUnused
     * @return Response
     */
    public function listAction(Request $request)
    {
        $subFamilies = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllOrderedBy();
        $filter = $request->query->get('filter');
        $choice = $request->query->get('choice');
        $how    = $request->query->get('how');
        $subFamilies = $this->getFilterResults($subFamilies, $filter, $choice, $how);
        return $this->render('SubFamily/list.html.twig', array(
            'subFamilies' => $subFamilies,
            'filter'      => $filter,
            'choice'      => $choice,
            'how'         => $how,
        ));
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/new", name="family_new")
     * @param Request $request
     * @noinspection PhpUnused
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function newAction(Request $request)
    {
        $url = $this->generateUrl('subfamily_list');
        $subFamily = new SubFamily();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAuthenticatedUser($this->container);
        $subFamily->setUser($user);
        $subFamily->setCreatedAt(new DateTime());
        $subFamily->setUpdatedAt(new DateTime());

        $form = $this->createForm(SubFamilyForm::class, $subFamily);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $family = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($family);
            $em->flush();

            $this->addFlash('success', 'SubFamily Created');

            return $this->redirectToRoute('subfamily_list');
        }

        return $this->render('SubFamily/new.html.twig',array(
            'form' => $form->createView(),
            'url' => $url
        ));
    }
    /**
     * @param $id
     * @Route("/show/{id}", name="show_family")
     * @return Response
     */
    public function showAction($id)
    {
        $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->find($id);
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAuthenticatedUser($this->container);
        return $this->render('SubFamily/show.html.twig', array(
            'subFamily' => $subFamily,
            'user'      => $user,
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/{id}/edit", name="family_edit")
     * @Security("is_granted('ROLE_USER')")
     * @noinspection PhpUnused
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function editAction(Request $request, $id)
    {
        $url = $request->headers->get('referer');
        if ($url == $this->generateUrl('family_edit',array('id' => $id)))
        {
            $url = $this->generateUrl('subfamily_list');
        }
        $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->find($id);
        $this->get('app.check_authorization')->checkAuthorization($subFamily, "You are not allowed to edit this subFamily");

        $subFamily->setUpdatedAt(new DateTime());

        $form = $this->createForm(SubFamilyForm::class, $subFamily);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $family = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->merge($family);
            $em->flush();

            $this->addFlash('success',sprintf('SubFamily updated!'));

            return $this->redirect($url);
        }

        return $this->render('SubFamily/edit.html.twig', array(
            'form' => $form->createView(),
            'subFamily' => $subFamily,
            'url' => $url,
            'correctUrl' => 'http://127.0.0.1:8000'.$this->generateUrl('family_edit',array('id' => $id))
        ));
    }

    /**
     * @param $id
     * @noinspection PhpUnused
     * @Route("/{id}/delete", name="family_delete")
     * @Security("is_granted('ROLE_USER')")
     * @return RedirectResponse
     */
    public function deleteAction($id)
    {
        $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->find($id);
        $this->get('app.check_authorization')->checkAuthorization($subFamily, "You are not allowed to delete this SubFamily");

        $em = $this->getDoctrine()->getManager();

        foreach ($subFamily->getGenus() as $genus)
        {
            /** @noinspection PhpUndefinedMethodInspection */
            foreach ($genus->getNote() as $note)
                {
                    $em->remove($note);
                }
                $em->remove($genus);
        }

        $em->remove($subFamily);
        $em->flush();

        $this->addFlash('danger', sprintf("SubFamily Deleted"));

        return $this->redirectToRoute('subfamily_list');
    }

    public function getFilterResults($subFamily, $filter, $choice, $how)
    {
        if ($choice == 1)
        {
            switch ($how)
            {
                case 1: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByQueryAnywhere($filter); break;

                case 2: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByQueryStartingWith($filter); break;

                case 3: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByQueryEndingWith($filter); break;

                case 4: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByQueryExactWord($filter); break;
            }
        }
        else if ($choice == 2)
        {
            switch ($how)
            {
                case 1: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByNameAnywhere($filter); break;

                case 2: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByNameStartingWith($filter); break;

                case 3: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByNameEndingWith($filter); break;

                case 4: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByNameExactWord($filter); break;
            }
        }
        else if ($choice == 3)
        {
            switch ($how)
            {
                case 1: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByUserAnywhere($filter); break;

                case 2: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByUserStartingWith($filter); break;

                case 3: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByUserEndingWith($filter); break;

                case 4: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByUserExactWord($filter); break;
            }
        }
        else if ($choice == 4)
        {
            switch ($how)
            {
                case 1: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByDescriptionAnywhere($filter); break;

                case 2: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByDescriptionStartingWith($filter); break;

                case 3: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByDescriptionEndingWith($filter); break;

                case 4: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByDescriptionExactWord($filter); break;
            }
        }
        else if ($choice == 5)
        {
            switch ($how)
            {
                case 1: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByAmountOfGenusAnywhere($filter); break;

                case 2: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByAmountOfGenusStartingWith($filter); break;

                case 3: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByAmountOfGenusEndingWith($filter); break;

                case 4: $subFamily = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAllByAmountOfGenusExactWord($filter); break;
            }
        }

        return $subFamily;
    }

    /**
     * @Route("/")
     * @noinspection PhpUnused
     */
    public function indexAction()
    {
        return $this->redirectToRoute('subfamily_list');
    }
}
