<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Metadata as Operation;
use Sylius\Component\Resource\Metadata\Resource;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
#[Resource(
    templatesDir: '@SyliusAdmin\\Crud',
    routePrefix: 'admin',
)]
#[Operation\Create(grid: 'app_book', redirectToRoute: 'app_admin_book_index')]
#[Operation\Index(grid: 'app_book')]
#[Operation\Show(template: 'book/show.html.twig')]
#[Operation\Update]
#[Operation\Delete]
#[Operation\BulkDelete]
#[Operation\ApplyStateMachineTransition(
    methods: ['GET'],
    redirectToRoute: 'app_admin_book_index',
    stateMachineTransition: 'publish'
)]
class Book implements ResourceInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "new"})
     */
    private string $visibility = 'new';

    /**
     * @ORM\ManyToMany(targetEntity=Library::class, inversedBy="books")
     */
    private $library;

    public function __construct()
    {
        $this->library = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getVisibility(): string
    {
        return $this->visibility;
    }

    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }

    /**
     * @return Collection<int, Library>
     */
    public function getLibrary(): Collection
    {
        return $this->library;
    }

    public function addLibrary(Library $library): self
    {
        if (!$this->library->contains($library)) {
            $this->library[] = $library;
        }

        return $this;
    }

    public function removeLibrary(Library $library): self
    {
        $this->library->removeElement($library);

        return $this;
    }
}
