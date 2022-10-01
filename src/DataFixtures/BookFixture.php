<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Book;
use App\Enum\Currency;
use App\ValueObject\Money;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; $i++) {
            $book = new Book();
            $book->setTitle("Book #$i");
            $book->setPublisher('Publisher #' . ($i % 5));
            $book->setAuthor('Author #' . ($i % 4));
            $book->setGenre('Genre #' . ($i % 3));
            $book->setPublishedAt(new DateTimeImmutable("now+{$i}m"));
            $book->setWordsCount(random_int(100, 1000));
            $book->setCost(new Money(random_int(10, 100), Currency::Usd));

            $manager->persist($book);
        }

        $manager->flush();
    }
}
