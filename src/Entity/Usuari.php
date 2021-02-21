<?php

namespace App\Entity;

use App\Repository\UsuariRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsuariRepository::class)
 */
class Usuari implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $rol;

    public function getId()
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /*public function getPassword(): ?string
    {
        return $this->password;
    }*/

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(string $rol): self
    {
        $this->rol = $rol;

        return $this;
    }
    //  nous mètodes per les interfícies que hem implementat
    public function getUserName()
    {
        return $this->login;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getSalt()
    {
        return null;
    }
    public function getRoles()
    {
        return array($this->rol);
    }
    public function eraseCredentials()
    {
    }
    public function serialize()
    {
        return serialize(array(
                $this->id,
                $this->login,
                $this->password));
    }
    public function unserialize($dades_serialitzades)
    {
        list(
            $this->id,
            $this->login,
            $this->password
            ) = unserialize($dades_serialitzades,
                        array('allowed_classes' => false));
    }
}
