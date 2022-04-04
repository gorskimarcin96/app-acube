<?php

namespace App\Entity;

use App\DBAL\Types\FileType;
use App\DBAL\Types\StatusType;
use App\Repository\ConvertFileRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

#[ORM\Entity(repositoryClass: ConvertFileRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ConvertFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'text')]
    private string $contentFrom;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $contentTo = null;

    #[ORM\Column(type: 'string')]
    #[DoctrineAssert\EnumType(entity: FileType::class)]
    private string $typeFrom;

    #[ORM\Column(type: 'string')]
    #[DoctrineAssert\EnumType(entity: FileType::class)]
    private string $typeTo;

    #[ORM\Column(type: 'string')]
    #[DoctrineAssert\EnumType(entity: StatusType::class)]
    private string $status = StatusType::DRAFT;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function getContentFrom(): ?string
    {
        return $this->contentFrom;
    }

    public function setContentFrom(string $contentFrom): self
    {
        $this->contentFrom = $contentFrom;

        return $this;
    }

    public function getContentTo(): ?string
    {
        return $this->contentTo;
    }

    public function setContentTo(string $contentTo): self
    {
        $this->contentTo = $contentTo;

        return $this;
    }

    public function getTypeFrom(): ?string
    {
        return $this->typeFrom;
    }

    public function setTypeFrom(string $typeFrom): self
    {
        $this->typeFrom = $typeFrom;

        return $this;
    }

    public function getTypeTo(): ?string
    {
        return $this->typeTo;
    }

    public function setTypeTo(string $typeTo): self
    {
        $this->typeTo = $typeTo;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt ?? new DateTimeImmutable();
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt ?? new DateTimeImmutable();
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps(): void
    {
        $now = new DateTimeImmutable();
        $this->setUpdatedAt($now);

        if (null === $this->getId()) {
            $this->setCreatedAt($now);
        }
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function changeStatus(): void
    {
        if (null === $this->getId()) {
            $this->setStatus(StatusType::DRAFT);
        } elseif ($this->getContentTo() === null) {
            $this->setStatus(StatusType::PENDING);
        } else {
            $this->setStatus(StatusType::DONE);
        }
    }
}