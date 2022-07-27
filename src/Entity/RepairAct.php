<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

use App\Repository\RepairActRepository;
use Monolog\DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 * collectionOperations={"get"},
 * itemOperations={"get", "put", "patch"},
 * normalizationContext={"groups"={"repair:get"}},
 * denormalizationContext={"groups"={"repair:write"}},
 * )
 * 
 * 
 * 
 * @ORM\Entity(repositoryClass=RepairActRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class RepairAct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="repairs")
     */
    private $station;

    /**
     * @ORM\ManyToOne(targetEntity=Bike::class, inversedBy="repairs")
     * @Groups("repair:get")
     */
    private $bike;

    /**
     * @ORM\ManyToOne(targetEntity=Repair::class, inversedBy="bikes")
     */
    private $repair;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

   
    public function getId(): ?int
    {
        return $this->id;
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

    public function getBike(): ?Bike
    {
        return $this->bike;
    }

    public function setBike(?Bike $bike): self
    {
        $this->bike = $bike;

        return $this;
    }

    public function getRepair(): ?Repair
    {
        return $this->repair;
    }

    public function setRepair(?Repair $repair): self
    {
        $this->repair = $repair;

        return $this;
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

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $setDateTime = new DateTimeImmutable('now');

        $this->setUpdatedAt($setDateTime);

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($setDateTime);
        }
    }
}
