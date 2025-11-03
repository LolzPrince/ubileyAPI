<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Dto\TablesStatsDto;
use App\Repository\TablesRepository;
use App\State\TablesStatsProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Patch(),
        new GetCollection(uriTemplate: 'tables_stats', output: TablesStatsDto::class, provider: TablesStatsProvider::class)
    ],
    normalizationContext: ['groups' => ['tables:read', 'guests:read']],
    denormalizationContext: ['groups' => ['tables:write']],
    paginationEnabled: false
)]
#[UniqueEntity(fields: ['num'], message: 'Это название уже занято')]
#[ORM\Entity(repositoryClass: TablesRepository::class)]
class Tables
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tables:read', 'guests:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['tables:read', 'guests:read', 'tables:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    #[Assert\NotBlank(message: "Номер стола обязателен")]
    #[Assert\Positive(message: "Номер стола должен быть положительным числом")]
    private ?int $num = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['tables:read', 'guests:read', 'tables:write'])]
    #[Assert\Length(
        max: 255,
        maxMessage: "Описание не должно превышать 255 символов"
    )]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['tables:read', 'guests:read', 'tables:write'])]
    #[Assert\Positive(message: "Максимальное количество гостей должно быть положительным числом")]
    #[Assert\LessThan(
        value: 50,
        message: "Стол не может вмещать более 50 гостей"
    )]
    private ?int $maxGuests = null;

    /**
     * @var Collection<int, GuestList>
     */
    #[ORM\OneToMany(targetEntity: GuestList::class, mappedBy: 'tables')]
    #[Groups(['tables:read', 'guests:read'])]
    #[ApiProperty(readableLink: false)]
    private Collection $guests;

    public function __construct()
    {
        $this->guests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): static
    {
        $this->num = $num;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMaxGuests(): ?int
    {
        return $this->maxGuests;
    }

    public function setMaxGuests(?int $maxGuests): static
    {
        $this->maxGuests = $maxGuests;

        return $this;
    }

    /**
     * @return Collection<int, GuestList>
     */
    public function getGuests(): Collection
    {
        return $this->guests;
    }

    public function addGuest(GuestList $guest): static
    {
        if (!$this->guests->contains($guest)) {
            $this->guests->add($guest);
            $guest->setTables($this);
        }

        return $this;
    }

    public function removeGuest(GuestList $guest): static
    {
        if ($this->guests->removeElement($guest)) {
            // set the owning side to null (unless already changed)
            if ($guest->getTables() === $this) {
                $guest->setTables(null);
            }
        }

        return $this;
    }

    #[Groups(['tables:read', 'guests:read'])]
    public function getGuestsDef(): ?int
    {
        return $this->guests->count();
    }

    #[Groups(['tables:read', 'guests:read'])]
    public function getGuestsNow(): ?int
    {
        return $this->guests->filter(function(GuestList $guest) {
            return $guest->getIsPresent();
        })->count();
    }
}
