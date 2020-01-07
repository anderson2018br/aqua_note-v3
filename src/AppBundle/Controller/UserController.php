<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @return Response
     */
    public function listAction(Request $request)
    {
        $this->get('app.check_authorization')->checkNonObjectAuthorization();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAllOrdered();

        $filter = $request->query->get('filter');
        $choice = $request->query->get('choice');
        $how    = $request->query->get('how');

        $user = $this->getFilterResults($user, $filter, $choice, $how);

        return $this->render('User/index.html.twig', array(
            'users' => $user
        ));
    }

    public function getFilterResults($users, $filter, $choice, $how)
    {
        if ($choice == 1)
        {
            switch ($how)
            {
                case 1: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByQueryAnywhere($filter);
            }
        }

        return $users;
    }
}
