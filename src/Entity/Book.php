<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BookRepository;
use App\ValueObject\Money;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $publisher = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?\DateTimeImmutable $published_at = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?int $words_count = null;

    #[Assert\NotBlank]
    #[Assert\Type('array')]
    #[ORM\Column(type: Types::JSON)]
    private ?array $cost = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;

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

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->published_at;
    }

    public function setPublishedAt(\DateTimeImmutable $published_at): self
    {
        $this->published_at = $published_at;

        return $this;
    }

    public function getWordsCount(): ?int
    {
        return $this->words_count;
    }

    public function setWordsCount(int $words_count): self
    {
        $this->words_count = $words_count;

        return $this;
    }

    public function getCost(): ?Money
    {
        return Money::fromArray($this->cost);
    }

    public function setCost(Money $cost): self
    {
        $this->cost = $cost->toArray();

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'publisher' => $this->publisher,
            'author' => $this->author,
            'genre' => $this->genre,
            'published_at' => $this->published_at,
            'words_count' => $this->words_count,
            'cost' => $this->cost,
        ];
    }
}
