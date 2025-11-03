<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Operation;
use App\Repository\GuestListRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Patch()],
    normalizationContext: ['groups' => ['guests:read']],
    denormalizationContext: ['groups' => ['guests:write']]
)]
#[ApiResource(
    uriTemplate: 'tables/{id}/guests',
    operations: [new GetCollection(openapi: new Operation(tags: ['Tables']))],
    uriVariables: [
        'id' => new Link(
            fromProperty: 'guestLists',
            fromClass: Tables::class
        )
    ],
)]
#[ORM\Entity(repositoryClass: GuestListRepository::class)]
class GuestList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['guests:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['guests:read', 'guests:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['guests:read', 'guests:write'])]
    #[ApiFilter(BooleanFilter::class)]
    private ?bool $isPresent = null;

    #[ORM\ManyToOne(inversedBy: 'guests')]
    #[Groups(['guests:read', 'guests:write'])]
    #[ApiProperty(readableLink: true, writableLink: false)]
    #[ORM\JoinColumn(name: 'tables_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    private ?Tables $tables = null;

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

    public function getIsPresent(): ?bool
    {
        return $this->isPresent;
    }

    public function setIsPresent(?bool $isPresent): static
    {
        $this->isPresent = $isPresent;

        return $this;
    }

    public function getTables(): ?Tables
    {
        return $this->tables;
    }

    public function setTables(?Tables $tables): static
    {
        $this->tables = $tables;

        return $this;
    }
}
