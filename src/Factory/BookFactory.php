<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Book;
use App\Enum\Currency;
use App\ValueObject\Money;
use DateTimeImmutable;

class BookFactory
{
    public function createFromArray(
        array $data,
        ?Book $book = null,
    ): Book {
        $book ??= new Book();

        if ($data['title'] ?? false) {
            $book->setTitle($data['title']);
        }

        if ($data['publisher'] ?? false) {
            $book->setPublisher($data['publisher']);
        }

        if ($data['author'] ?? false) {
            $book->setAuthor($data['author']);
        }

        if ($data['genre'] ?? false) {
            $book->setGenre($data['genre']);
        }

        if ($data['published_at'] ?? false) {
            $book->setPublishedAt(
                new DateTimeImmutable($data['published_at']),
            );
        }

        if ($data['words_count'] ?? false) {
            $book->setWordsCount((int) $data['words_count']);
        }

        if (
            ($data['cost'] ?? false)
            && ($data['cost']['amount'] ?? false)
            && ($data['cost']['currency'] ?? false)
        ) {
            $book->setCost(
                new Money(
                    amount: $data['cost']['amount'],
                    currency: Currency::from(
                        $data['cost']['currency'],
                    ),
                ),
            );
        }

        return $book;
    }
}
