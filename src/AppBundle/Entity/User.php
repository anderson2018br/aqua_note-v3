<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity(fields={"username"}, message="It looks like you already have an account")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var
     * @Assert\NotBlank(groups={"Registration"})
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="integer")
     */
    private $amountOfGenus = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $amountOfSubFamilies = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $amountOfNotes = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalAmountOfCreatedObjects = 0;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string")
     */
    private $avatarFileName;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Genus", mappedBy="user")
     */
    private $genus;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SubFamily", mappedBy="user")
     */
    private $subFamily;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\GenusNote", mappedBy="user")
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getRoles()
    {
        $roles = $this->roles;

        if (!in_array('ROLE_USER', $roles))
        {
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    /**
     * @param array $roles
     * @noinspection PhpUnused
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }


    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {

    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     * @noinspection PhpUnused
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        $this->password = null;
    }

    /**
     * @return mixed
     * @noinspection PhpUnused
     */
    public function getGenus()
    {
        return $this->genus;
    }

    /**
     * @return mixed
     * @noinspection PhpUnused
     */
    public function getSubFamily()
    {
        return $this->subFamily;
    }

    /**
     * @return mixed
     * @noinspection PhpUnused
     */
    public function getAvatarFileName()
    {
        return $this->avatarFileName;
    }

    /**
     * @param mixed $avatarFileName
     * @noinspection PhpUnused
     */
    public function setAvatarFileName($avatarFileName)
    {
        $this->avatarFileName = $avatarFileName;
    }

    /**
     * @return mixed
     * @noinspection PhpUnused
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @return mixed
     * @noinspection PhpUnused
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @noinspection PhpUnused
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     * @noinspection PhpUnused
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @noinspection PhpUnused
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     * @noinspection PhpUnused
     */
    public function getAmountOfGenus()
    {
        $this->amountOfGenus = count($this->genus);
        return $this->amountOfGenus;
    }

    /**
     * @noinspection PhpUnused
     */
    public function setAmountOfGenus()
    {
        $this->amountOfGenus = count($this->genus);
    }

    /**
     * @return int
     * @noinspection PhpUnused
     */
    public function getAmountOfSubFamilies()
    {
        $this->amountOfSubFamilies = count($this->subFamily);
        return $this->amountOfSubFamilies;
    }

    /**
     * @noinspection PhpUnused
     */
    public function setAmountOfSubFamilies()
    {
        $this->amountOfSubFamilies = count($this->subFamily);
    }

    /**
     * @return int
     * @noinspection PhpUnused
     */
    public function getAmountOfNotes()
    {
        $this->amountOfNotes = count($this->note);
        return $this->amountOfNotes;
    }

    /**
     * @noinspection PhpUnused
     */
    public function setAmountOfNotes()
    {
        $this->amountOfNotes = count($this->note);
    }

    public function __toString()
    {
        return $this->username;
    }

    /**
     * @return int
     * @noinspection PhpUnused
     */
    public function getTotalAmountOfCreatedObjects()
    {
        $this->totalAmountOfCreatedObjects = $this->getAmountOfGenus() + $this->getAmountOfNotes() + $this->getAmountOfSubFamilies();
        return $this->totalAmountOfCreatedObjects;
    }

    /**
     * @noinspection PhpUnused
     */
    public function setTotalAmountOfCreatedObjects()
    {
        $this->totalAmountOfCreatedObjects = $this->getAmountOfGenus() + $this->getAmountOfNotes() + $this->getAmountOfSubFamilies();;
    }


}
