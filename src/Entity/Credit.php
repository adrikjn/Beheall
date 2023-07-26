<?php

namespace App\Entity;

use App\Repository\CreditRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'credits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'credits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'credits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Invoice $invoice = null;

    #[ORM\OneToMany(mappedBy: 'credit', targetEntity: Services::class, orphanRemoval: true)]
    private Collection $services;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $creditNumber = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $refundReason = null;

    #[ORM\Column]
    private ?float $refundedPrice = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $creditValidityDuration = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    private ?string $refundMethod = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct()
    {
        $this->services = new ArrayCollection();
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

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): static
    {
        $this->invoice = $invoice;

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
}
