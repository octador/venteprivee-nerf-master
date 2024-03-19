<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $methodpayment = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToOne(mappedBy: 'payment', cascade: ['persist', 'remove'])]
    private ?Delivery $delivery = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMethodpayment(): ?string
    {
        return $this->methodpayment;
    }

    public function setMethodpayment(?string $methodpayment): static
    {
        $this->methodpayment = $methodpayment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): static
    {
        // unset the owning side of the relation if necessary
        if ($delivery === null && $this->delivery !== null) {
            $this->delivery->setPayment(null);
        }

        // set the owning side of the relation if necessary
        if ($delivery !== null && $delivery->getPayment() !== $this) {
            $delivery->setPayment($this);
        }

        $this->delivery = $delivery;

        return $this;
    }
}
