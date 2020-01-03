<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    /**
     * @param Request $request
     * @Route("/list", name="genus_list")
     * @noinspection PhpUnused
     * @return Response
     */
    public function listAction(Request $request)
    {
        $genuses = $this->getDoctrine()->getRepository('AppBundle:Genus')->findAll();
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
        return $genus;
    }
}
