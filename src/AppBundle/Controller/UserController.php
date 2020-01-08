<?php

namespace AppBundle\Controller;
use AppBundle\Form\UserEditForm;
use AppBundle\Form\userNewForm;
use AppBundle\Form\UserPassword;
use DateTime;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
            'users' => $user,
            'filter' => $filter,
            'choice' => $choice,
            'how' => $how,
        ));
    }

    /**
     * @noinspection PhpUnused
     * @Route("/genus/{id}/show", name="user_genus_show")
     * @param $id
     * @return Response
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function showGenusAction($id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        return $this->render('User/showGenus.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @param $id
     * @Route("/genus/{id}/delete", name="user_delete_genus")
     * @noinspection PhpUnused
     * @return RedirectResponse
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteAllGenusAction($id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        $em = $this->getDoctrine()->getManager();
        foreach ($user->getGenus() as $genus) {
            /** @noinspection PhpUndefinedMethodInspection */
            foreach ($genus->getNote() as $note)
            {
                $em->remove($note);
            }
            $em->remove($genus);
        }

        $em->flush();
        $this->get('app.update_amount')->updateEverything();

        $this->addFlash('success','All genus Deleted');

        return $this->redirectToRoute('user_list');
    }

    /**
     * @Route("/subFamily/{id}/show", name="user_subFamily_show")
     * @noinspection PhpUnused
     * @param $id
     * @return Response
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function showSubFamilyAction($id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        return $this->render('User/showSubFamilies.html.twig', array(
           'user' => $user
        ));
    }


    /**
     * @param $id
     * @Route("/subFamily/{id}/delete", name="user_delete_subFamilies")
     * @noinspection PhpUnused
     * @return RedirectResponse
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteAllSubFamiliesAction($id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        $em = $this->getDoctrine()->getManager();
        foreach ($user->getSubFamily() as $subFamily)
        {
            /** @noinspection PhpUndefinedMethodInspection */
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
        }

        $em->flush();

        $this->addFlash('success','All SubFamilies Deleted');

        return $this->redirectToRoute('user_subFamily_show',array('id' => $id));
    }

    /**
     * @param $id
     * @Route("/notes/{id}/show", name="user_show_notes")
     * @noinspection PhpUnused
     * @return Response
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function showNotesAction($id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')
            ->find($id);

        return $this->render('User/showNotes.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @param $id
     * @noinspection PhpUnused
     * @Route("/user/notes/{id}/delete", name="user_notes_delete")
     * @return RedirectResponse
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteAllNotesAction($id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        $em = $this->getDoctrine()->getManager();
        foreach ($user->getNote() as $note)
        {
            $em->remove($note);
        }
        $em->flush();

        $this->addFlash('success','All Notes Deleted');

        return $this->redirectToRoute('user_show_notes', array('id' => $id));
    }

    /**
     * @param $id
     * @noinspection PhpUnused
     * @Route("/{id}/show", name="user_show")
     * @return Response
     */
    public function showAction($id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        return $this->render('User/show.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @noinspection PhpUnused
     * @Route("/new", name="user_new")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(userNewForm::class);

        $form->handleRequest($request);
        if ($form->isValid())
        {
            $user = $form->getData();
            $user->setCreatedAt(new DateTime());
            $user->setUpdatedAt(new DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success',sprintf('User Created!'));

            return $this->redirectToRoute('user_list');
        }

        return $this->render('User/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @noinspection PhpUnused
     * @Route("/edit/{id}", name="user_edit")
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function editAction($id, Request $request)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        $form = $this->createForm(UserEditForm::class, $user);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $users = $form->getData();
            $users->setUpdatedAt(new DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($users);
            $em->flush();

            $this->addFlash('success', sprintf('User Updated!'));

            return $this->redirectToRoute('user_list');
        }

        return $this->render('User/edit.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     * @throws Exception
     * @Route("/{id}/password/edit", name="user_password")
     * @noinspection PhpUnused
     */
    public function passwordAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        $form = $this->createForm(UserPassword::class, $user);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $users = $form->getData();
            $users->setUpdatedAt(new DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->merge($users);
            $em->flush();

            $this->addFlash('success', sprintf('User\'s Password Updated!'));

            return $this->redirectToRoute('user_list');
        }

        return $this->render('User/password.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @noinspection PhpUnused
     * @Route("/user/{id}/delete", name="user_delete")
     */
    public function deleteAction($id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        $em = $this->getDoctrine()->getManager();
        foreach ($user->getGenus() as $genus)
        {
            /** @noinspection PhpUndefinedMethodInspection */
            foreach ($genus->getNote() as $note)
            {
                $em->remove($note);
            }
            $em->remove($genus);
        }
        foreach ($user->getSubFamily() as $subFamily)
        {
            /** @noinspection PhpUndefinedMethodInspection */
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
        }
        foreach ($user->getNote() as $note)
        {
            $em->remove($note);
        }
        $em->remove($user);
        $em->flush();

        $this->addFlash('success', sprintf('User Deleted!'));
        return $this->redirectToRoute('user_list');
    }

    public function getFilterResults($users, $filter, $choice, $how)
    {
        if ($choice == 1)
        {
            switch ($how)
            {
                case 1: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByQueryAnywhere($filter); break;

                case 2: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByQueryStartingWith($filter); break;

                case 3: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByQueryEndingWith($filter); break;

                case 4: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByQueryExactWord($filter); break;
            }
        }
        else if ($choice == 2)
        {
            switch ($how)
            {
                case 1: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByUsernameAnywhere($filter); break;

                case 2: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByUsernameStartingWith($filter); break;

                case 3: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByUsernameEndingWith($filter); break;

                case 4: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByUsernameExactWord($filter); break;
            }
        }
        else if ($choice == 3)
        {
            switch ($how)
            {
                case 1: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAmountOfGenusAnywhere($filter); break;

                case 2: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAmountOfGenusStartingWith($filter); break;

                case 3: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAmountOfGenusEndingWith($filter); break;

                case 4: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAmountOfGenusExactWord($filter); break;
            }
        }
        else if ($choice == 4)
        {
            switch ($how)
            {
                case 1: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAmountOfSubFamiliesAnywhere($filter); break;

                case 2: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAmountOfSubFamiliesStartingWith($filter); break;

                case 3: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAmountOfSubFamiliesEndingWith($filter); break;

                case 4: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAmountOfSubFamiliesExactWord($filter); break;
            }
        }
        else if ($choice == 5)
        {
            switch ($how)
            {
                case 1: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAmountOfNotesAnywhere($filter); break;

                case 2: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAmountOfNotesStartingWith($filter); break;

                case 3: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAmountOfNotesEndingWith($filter); break;

                case 4: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAmountOfNotesExactWord($filter); break;
            }
        }
        else if ($choice == 6)
        {
            switch ($how)
            {
                case 1: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByTotalAmountOfCreatedObjectsAnywhere($filter); break;

                case 2: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByTotalAmountOfCreatedObjectsStartingWith($filter); break;

                case 3: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByTotalAmountOfCreatedObjectsEndingWith($filter); break;

                case 4: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByTotalAmountOfCreatedObjectsExactWord($filter); break;
            }
        }
        else if ($choice == 7)
        {
            switch ($how)
            {
                case 1: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAvatarFileNameAnywhere($filter); break;

                case 2: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAvatarFileNameStartingWith($filter); break;

                case 3: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAvatarFileNameEndingWith($filter); break;

                case 4: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByAvatarFileNameExactWord($filter); break;
            }
        }
        else if ($choice == 8)
        {
            switch ($how)
            {
                case 1: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByRolesAnywhere($filter); break;

                case 2: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByRolesStartingWith($filter); break;

                case 3: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByRolesEndingWith($filter); break;

                case 4: $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAllByRolesExactWord($filter); break;
            }
        }

        return $users;
    }
}
