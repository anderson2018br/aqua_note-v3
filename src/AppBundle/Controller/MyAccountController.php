<?php

namespace AppBundle\Controller;

use AppBundle\Form\MyAccountEditAvatarForm;
use AppBundle\Form\MyAccountEditUsernameForm;
use DateTime;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MyAccountController
 * @package AppBundle\Controller
 * @Route("/myaccount")
 * @Security("is_granted('ROLE_USER')")
 * @noinspection PhpUnused
 */
class MyAccountController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/", name="account_index")
     * @throws Exception
     */
    public function indexAction(Request $request)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAuthenticatedUser($this->container);
        $em = $this->getDoctrine()->getManager();


        $formUsername = $this->createForm(MyAccountEditUsernameForm::class, $user);
        $formUsername->handleRequest($request);
        if ($formUsername->isSubmitted() && $formUsername->isValid())
        {
            $users = $formUsername->getData();
            $users->getUpdatedAt(new DateTime());
            $em->merge($users);
            $em->flush();

            return  $this->redirectToRoute('account_index');
        }
        $formAvatar = $this->createForm(MyAccountEditAvatarForm::class, $user);
        $formAvatar->handleRequest($request);
        if ($formAvatar->isSubmitted() && $formAvatar->isValid())
        {
            $users = $formAvatar->getData();
            $users->setUpdatedAt(new DateTime());

            $em->merge($users);
            $em->flush();

            return  $this->redirectToRoute('account_index');
        }

        return $this->render('MyAccount/index.html.twig', array(
            'user' => $user,
            'formUsername' => $formUsername->createView(),
            'formAvatar'   => $formAvatar->createView(),
        ));
    }
}
