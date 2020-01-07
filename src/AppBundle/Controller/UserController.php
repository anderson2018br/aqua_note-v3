<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package AppBundle\Controller
 * @Route("/user")
 * @Security("is_granted('ROLE_ADMIN')")
 * @noinspection PhpUnused
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @noinspection PhpUnused
     * @Route("/list", name="user_list")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function listAction(Request $request)
    {
        $this->get('app.check_authorization')->checkNonObjectAuthorization();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        $this->render('User/index.html.twig', array(
            'user' => $user
        ));
    }
}
