<?php

namespace App\Tests\Books;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

class UpdateTest extends ApiTestCase
{
    public function successfulDataProvider(): array
    {
        return [
            [
                10,
                'Book #1',
                'Publisher #1',
                'Author #1',
                'Genre #1',
                '2020-01-01T00:00:00+00:00',
                10,
                10,
                'usd'
            ],
            [
                11,
                'Book #100000000000000000000',
                'Publisher #10000000000000000000',
                'Author #10000000000000000000000',
                'Genre #100000000000000000000',
                '2020-01-01T10:00:00+00:00',
                100000,
                10.0000001,
                'usd'
            ],
        ];
    }

    /**
     * @dataProvider successfulDataProvider
     */
    public function testSuccessfulStore(
        int $id,
        string $title,
        string $publisher,
        string $author,
        string $genre,
        string $publishedAt,
        int $wordsCount,
        float $costAmount,
        string $costCurrency,
    ): void {
        $response = $this->sendRequest(
            id: $id,
            title: $title,
            publisher: $publisher,
            author: $author,
            genre: $genre,
            publishedAt: $publishedAt,
            wordsCount: $wordsCount,
            costAmount: $costAmount,
            costCurrency: $costCurrency,
        );

        $this->assertResponseIsSuccessful();

        $result = $response->toArray();

        $this->assertArrayHasKey('item', $result);

        $book = $result['item'];

        $this->assertArrayHasKey('id', $book);
        $this->assertEquals($id, $book['id']);

        $this->assertArrayHasKey('title', $book);
        $this->assertEquals($title, $book['title']);

        $this->assertArrayHasKey('publisher', $book);
        $this->assertEquals($publisher, $book['publisher']);

        $this->assertArrayHasKey('author', $book);
        $this->assertEquals($author, $book['author']);

        $this->assertArrayHasKey('genre', $book);
        $this->assertEquals($genre, $book['genre']);

        $this->assertArrayHasKey('published_at', $book);
        $this->assertEquals($publishedAt, $book['published_at']);

        $this->assertArrayHasKey('words_count', $book);
        $this->assertEquals($wordsCount, $book['words_count']);

        $this->assertArrayHasKey('cost', $book);
        $this->assertArrayHasKey('amount', $book['cost']);
        $this->assertArrayHasKey('currency', $book['cost']);

        $this->assertEquals($costAmount, $book['cost']['amount']);
        $this->assertEquals($costCurrency, $book['cost']['currency']);
    }

    private function sendRequest(
        ?int $id,
        ?string $title,
        ?string $publisher,
        ?string $author,
        ?string $genre,
        ?string $publishedAt,
        ?int $wordsCount,
        ?float $costAmount,
        ?string $costCurrency,
    ): ResponseInterface {
        return static::createClient()
            ->request('PATCH', '/v1/books/' . $id, [
                'json' => [
                    'title' => $title,
                    'publisher' => $publisher,
                    'author' => $author,
                    'genre' => $genre,
                    'published_at' => $publishedAt,
                    'words_count' => $wordsCount,
                    'cost' => [
                        'amount' => $costAmount,
                        'currency' => $costCurrency,
                    ],
                ],
            ]);
    }
}
