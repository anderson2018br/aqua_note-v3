<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/update/everything/{url}", name="update_everything")
     * @noinspection PhpUnused
     * @Security("is_granted('ROLE_ADMIN')")
     * @param $url
     * @return RedirectResponse
     */
    public function updateEverything($url)
    {
        $this->get('app.update_amount')->updateEverything();
        if ($url == 'user')
        {
            return $this->redirectToRoute('user_list');
        }
        else if ($url == 'genus')
        {
            return  $this->redirectToRoute('genus_list');
        }
        else if ($url == 'family')
        {
            return  $this->redirectToRoute('subfamily_list');
        }

        throw $this->createNotFoundException();
    }
}
