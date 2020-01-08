<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserRegistrationForm;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserRegistrationController extends Controller
{
    /**
     * @param Request $request
     * @Route("/register", name="user_register")
     * @return Response
     * @throws \Exception
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $user->setCreatedAt(new DateTime());
        $user->setUpdatedAt(new DateTime());
        $form = $this->createForm(UserRegistrationForm::class, $user);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $user = $form->getData();
            $user->setRoles(array());
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $user->setImageFile(null);
            $this->addFlash('success', 'Welcome '.$user->getusername());

            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main'
                );
        }
        return $this->render('Security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
