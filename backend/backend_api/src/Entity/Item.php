<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ItemRepository;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\Table(name:"items")]
#[ApiResource]
#[UniqueEntity('userSite', 'path')]
class Item
{
    public const ACTIVE_STATUS = 'active';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserSite $userSite = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: ItemHistory::class)]
    private Collection $itemHistories;

    public function __construct()
    {
        $this->itemHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserSite(): ?UserSite
    {
        return $this->userSite;
    }

    public function setUserSite(?UserSite $userSite): static
    {
        $this->userSite = $userSite;

        return $this;
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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

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
     * @return Collection<int, ItemHistory>
     */
    public function getItemHistories(): Collection
    {
        return $this->itemHistories;
    }

    public function addItemHistory(ItemHistory $itemHistory): static
    {
        if (!$this->itemHistories->contains($itemHistory)) {
            $this->itemHistories->add($itemHistory);
            $itemHistory->setItem($this);
        }

        return $this;
    }

    public function removeItemHistory(ItemHistory $itemHistory): static
    {
        if ($this->itemHistories->removeElement($itemHistory)) {
            // set the owning side to null (unless already changed)
            if ($itemHistory->getItem() === $this) {
                $itemHistory->setItem(null);
            }
        }

        return $this;
    }
}
