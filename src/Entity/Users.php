<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users implements UserInterface, PasswordAuthenticatedUserInterface {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $user_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string")
     */
    private $roles;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $register_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $update_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Salt;

    public function getId(): ?int {
        return $this->id;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self {
        $this->last_name = $last_name;

        return $this;
    }

    public function getUserName(): ?string {
        return $this->user_name;
    }

    public function setUserName(string $user_name): self {
        $this->user_name = $user_name;

        return $this;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array {
        if($this->roles == 1){
            return array('ROLE_ADMIN');
        }
        else{
            return array('ROLE_USER');
        }
    }

    public function setRoles(string $roles): self {
        $this->roles = $roles;

        return $this;
    }

    public function getStatus(): ?int {
        return $this->status;
    }

    public function setStatus(int $status): self {
        $this->status = $status;

        return $this;
    }

    public function getRegisterAt(): ?DateTimeInterface {
        return $this->register_at;
    }

    public function setRegisterAt(DateTimeInterface $register_at): self {
        $this->register_at = $register_at;

        return $this;
    }

    public function getUpdateAt(): ?DateTimeInterface {
        return $this->update_at;
    }

    public function setUpdateAt(?DateTimeInterface $update_at): self {
        $this->update_at = $update_at;

        return $this;
    }

    public function getSalt() {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return $this->Salt;
    }

    public function eraseCredentials() {
        
    }

    public function setSalt(string $Salt): self {
        $this->Salt = $Salt;

        return $this;
    }
    
}
