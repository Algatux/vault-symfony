<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=24, nullable=true)
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=24, nullable=true)
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=24, nullable=true)
     */
    private string $nickName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $telegramId;

    /**
     * @ORM\OneToMany(targetEntity=Wallet::class, mappedBy="owner")
     */
    private $ownedWallets;

    /**
     * @ORM\ManyToMany(targetEntity=Wallet::class, mappedBy="sharedWithUsers")
     */
    private $visibleWallets;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="transactedBy")
     */
    private $transactions;

    public function __construct()
    {
        $this->ownedWallets = new ArrayCollection();
        $this->visibleWallets = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * @param mixed $nickName
     */
    public function setNickName($nickName): void
    {
        $this->nickName = $nickName;
    }

    /**
     * @return mixed
     */
    public function getTelegramId()
    {
        return $this->telegramId;
    }

    /**
     * @param mixed $telegramId
     */
    public function setTelegramId($telegramId): void
    {
        $this->telegramId = $telegramId;
    }

    /**
     * @return Collection|Wallet[]
     */
    public function getOwnedWallets(): Collection
    {
        return $this->ownedWallets;
    }

    public function addOwnedWallet(Wallet $ownedWallet): self
    {
        if (!$this->ownedWallets->contains($ownedWallet)) {
            $this->ownedWallets[] = $ownedWallet;
            $ownedWallet->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedWallet(Wallet $ownedWallet): self
    {
        if ($this->ownedWallets->removeElement($ownedWallet)) {
            // set the owning side to null (unless already changed)
            if ($ownedWallet->getOwner() === $this) {
                $ownedWallet->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Wallet[]
     */
    public function getVisibleWallets(): Collection
    {
        return $this->visibleWallets;
    }

    public function addVisibleWallet(Wallet $visibleWallet): self
    {
        if (!$this->visibleWallets->contains($visibleWallet)) {
            $this->visibleWallets[] = $visibleWallet;
            $visibleWallet->addSharedWithUser($this);
        }

        return $this;
    }

    public function removeVisibleWallet(Wallet $visibleWallet): self
    {
        if ($this->visibleWallets->removeElement($visibleWallet)) {
            $visibleWallet->removeSharedWithUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setTransactedBy($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getTransactedBy() === $this) {
                $transaction->setTransactedBy(null);
            }
        }

        return $this;
    }
}
