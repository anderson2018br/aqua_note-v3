<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $subFamilies = $this->getDoctrine()->getRepository('AppBundle:SubFamily')->findAll();

        return $this->render('SubFamily/list.html.twig', array(
            'subFamilies' => $subFamilies
        ));
    }
}
