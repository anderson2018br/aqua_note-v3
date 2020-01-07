<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class UpdateUserAmount
{
    private $entityManager;
    private $router;

    public function __construct(EntityManagerInterface $entityManager, RouterInterface $router)
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    public function updateAmountOfGenus()
    {
        $users = $this->entityManager->getRepository('AppBundle:User')->findAll();

        foreach ($users as $user)
        {
            $user->setAmountOfGenus();

            $this->entityManager->persist($user);
        }
        $this->entityManager->flush();
    }

    public function updateAmountOfSubFamilies()
    {
        $users = $this->entityManager->getRepository('AppBundle:User')->findAll();

        foreach ($users as $user)
        {
            $user->setAmountOfSubFamilies();

            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();
    }

    public function updateAmountOfNotes()
    {
        $users = $this->entityManager->getRepository('AppBundle:User')->findAll();

        foreach ($users as $user)
        {
            $user->setAmountOfNotes();

            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();
    }

    public function updateAmountOfGenusNotes()
    {
        $genuses = $this->entityManager->getRepository('AppBundle:Genus')->findAll();

        foreach ($genuses as $genus)
        {
            $genus->setAmountOfNotes();

            $this->entityManager->persist($genus);
        }

        $this->entityManager->flush();
    }

    public function updateSubFamilyGenusAmount()
    {
        $subFamilies = $this->entityManager->getRepository('AppBundle:SubFamily')->findAll();

        foreach ($subFamilies as $subFamily)
        {
            $subFamily->setAmountOfGenus();
            $this->entityManager->persist($subFamily);
        }

        $this->entityManager->flush();
    }

    public function updateTotalAmountOfEverything()
    {
        $users = $this->entityManager->getRepository('AppBundle:User')
            ->findAll();

        foreach ($users as $user)
        {
            $user->setTotalAmountOfCreatedObjects();

            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();
    }

    public function updateEverything()
    {
        $this->updateAmountOfGenus();
        $this->updateAmountOfSubFamilies();
        $this->updateAmountOfNotes();
        $this->updateAmountOfGenusNotes();
        $this->updateSubFamilyGenusAmount();
        $this->updateTotalAmountOfEverything();
    }
}
