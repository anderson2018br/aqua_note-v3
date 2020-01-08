<?php

namespace AppBundle\Controller;

use AppBundle\Form\GenusNoteForm;
use AppBundle\Form\MyAccountEditAvatarForm;
use AppBundle\Form\MyAccountEditUsernameForm;
use AppBundle\Form\UserChangePasswordForm;
use DateTime;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

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
        if ($formUsername->isSubmitted() && !$formUsername->isValid())
        {
            $this->addFlash('danger', 'Username Already exists');

            return $this->redirectToRoute('account_index');
        }
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
            $users->setImageFile(null);
            return  $this->redirectToRoute('account_index');
        }

        $formChangePassword = $this->createForm(UserChangePasswordForm::class);
        $formChangePassword->handleRequest($request);

        if ($formChangePassword->isSubmitted() && $formChangePassword->isValid())
        {

            $password = $formChangePassword->getData();
            if ($this->get('app.security.login_form_authenticator')->checkCredentials($password, $user))
            {
                $user->setPlainPassword($password['plainPassword']);
                $em->merge($user);
                $em->flush();

                $this->addFlash('success','Password Updated');

                return  $this->redirectToRoute('account_index');
            }

            $this->addFlash('danger', sprintf('Current Password is Wrong'));

            return $this->redirectToRoute('account_index');
        }

        return $this->render('MyAccount/index.html.twig', array(
            'user' => $user,
            'formUsername' => $formUsername->createView(),
            'formAvatar'   => $formAvatar->createView(),
            'formPassword' => $formChangePassword->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     * @noinspection PhpUnused
     */
    public function showAmountOfGenus(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        $formGenus = $this->createForm(GenusNoteForm::class, $user->getGenus());
        $formGenus->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($formGenus->isSubmitted() && $formGenus->isValid())
        {
            $genus = $formGenus->getData();

            $em->merge($genus);
            $em->flush();
        }

        return $this->render('MyAccount/showGenus.html.twig', array(
            'user' => $user,
            'formGenus' => $formGenus->createView()
        ));
    }
}
