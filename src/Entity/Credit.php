<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CreditRepository;
use ApiPlatform\Metadata\ApiResource;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['credit:read']],
    denormalizationContext: ['groups' => ['credit:create']]
)]
#[ORM\Entity(repositoryClass: CreditRepository::class)]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['credit:read', 'credit:create'])] 
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'credits')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['credit:read', 'credit:create'])] 
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'credits')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['credit:read', 'credit:create'])] 
    private ?Customer $customer = null;

    #[ORM\OneToMany(mappedBy: 'credit', targetEntity: Services::class, orphanRemoval: true)]
    #[Groups(['credit:read', 'credit:create'])] 
    private Collection $services;

    #[ORM\Column(length: 255)]
    #[Groups(['credit:read', 'credit:create'])] 
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['credit:read', 'credit:create'])] 
    private ?string $creditNumber = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['credit:read', 'credit:create'])] 
    private ?string $refundReason = null;

    #[ORM\Column]
    #[Groups(['credit:read', 'credit:create'])] 
    private ?float $refundedPrice = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['credit:read', 'credit:create'])] 
    private ?\DateTimeInterface $creditValidityDuration = null;

    #[ORM\Column(length: 255)]
    #[Groups(['credit:read', 'credit:create'])] 
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    #[Groups(['credit:read', 'credit:create'])] 
    private ?string $refundMethod = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['credit:read'])] 
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToOne(inversedBy: 'credit', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['credit:read', 'credit:create'])] 
    private ?Invoice $invoice = null;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->createdAt = new DateTime();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection<int, Services>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Services $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setCredit($this);
        }

        return $this;
    }

    public function removeService(Services $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getCredit() === $this) {
                $service->setCredit(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCreditNumber(): ?string
    {
        return $this->creditNumber;
    }

    public function setCreditNumber(string $creditNumber): static
    {
        $this->creditNumber = $creditNumber;

        return $this;
    }

    public function getRefundReason(): ?string
    {
        return $this->refundReason;
    }

    public function setRefundReason(string $refundReason): static
    {
        $this->refundReason = $refundReason;

        return $this;
    }

    public function getRefundedPrice(): ?float
    {
        return $this->refundedPrice;
    }

    public function setRefundedPrice(float $refundedPrice): static
    {
        $this->refundedPrice = $refundedPrice;

        return $this;
    }

    public function getCreditValidityDuration(): ?\DateTimeInterface
    {
        return $this->creditValidityDuration;
    }

    public function setCreditValidityDuration(\DateTimeInterface $creditValidityDuration): static
    {
        $this->creditValidityDuration = $creditValidityDuration;

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

    public function getRefundMethod(): ?string
    {
        return $this->refundMethod;
    }

    public function setRefundMethod(string $refundMethod): static
    {
        $this->refundMethod = $refundMethod;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(Invoice $invoice): static
    {
        $this->invoice = $invoice;

        return $this;
    }
}
