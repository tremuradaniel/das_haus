<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
#[ORM\Table(name:"sites")]
#[ApiResource]
class Site
{
    public const ACTIVE_STATUS = 'active';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $domain = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: UserSite::class)]
    private Collection $userSites;

    public function __construct()
    {
        $this->userSites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): static
    {
        $this->domain = $domain;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, UserSite>
     */
    public function getUserSites(): Collection
    {
        return $this->userSites;
    }

    public function addUserSite(UserSite $userSite): static
    {
        if (!$this->userSites->contains($userSite)) {
            $this->userSites->add($userSite);
            $userSite->setSite($this);
        }

        return $this;
    }

    public function removeUserSite(UserSite $userSite): static
    {
        if ($this->userSites->removeElement($userSite)) {
            // set the owning side to null (unless already changed)
            if ($userSite->getSite() === $this) {
                $userSite->setSite(null);
            }
        }

        return $this;
    }
}
