<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Monolog\DateTimeImmutable;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventoryRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Inventory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="inventories")
     */
    private $station;

    /**
     * @ORM\ManyToMany(targetEntity=Bike::class, inversedBy="inventories")
     */
    private $bikes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status = true;

    public function __construct()
    {
        $this->bikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): self
    {
        $this->station = $station;

        return $this;
    }

    /**
     * @return Collection<int, Bike>
     */
    public function getBikes(): Collection
    {
        return $this->bikes;
    }

    public function addBike(Bike $bike): self
    {
        if (!$this->bikes->contains($bike)) {
            $this->bikes[] = $bike;
        }

        return $this;
    }

    public function removeBike(Bike $bike): self
    {
        $this->bikes->removeElement($bike);

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

}
