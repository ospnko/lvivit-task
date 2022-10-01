<?php

namespace App\Tests\Books;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class IndexTest extends ApiTestCase
{
    private function paginationDataProvider(): array
    {
        return [
            [1, 10, 10, 100, 10],
            [1, 11, 11, 100, 10],
            [10, 11, 1, 100, 10],
            [1, 50, 50, 100, 2],
        ];
    }

    /**
     * @dataProvider paginationDataProvider
     */
    public function testIndex(
        int $page,
        int $step,
        int $pageItemsCount,
        int $totalItems,
        int $totalPages,
    ): void {
        $response = static::createClient()
            ->request('GET', '/v1/books', [
                'query' => [
                    'page' => $page,
                    'step' => $step,
                ],
            ]);

        $this->assertResponseIsSuccessful();

        $result = $response->toArray();

        $this->assertArrayHasKey('pagination', $result);

        $pagination = $result['pagination'];

        $this->assertArrayHasKey('page', $pagination);
        $this->assertEquals($page, $pagination['page']);

        $this->assertArrayHasKey('step', $pagination);
        $this->assertEquals($step, $pagination['step']);

        $this->assertArrayHasKey('total_items', $pagination);
        $this->assertEquals($totalItems, $pagination['total_items']);

        $this->assertArrayHasKey('total_pages', $pagination);
        $this->assertEquals($totalPages, $pagination['total_pages']);

        $this->assertArrayHasKey('items', $result);

        $items = $result['items'];

        $this->assertEquals($pageItemsCount, count($items));

        foreach ($items as $book) {
            $this->assertArrayHasKey('id', $book);
            $this->assertArrayHasKey('title', $book);
            $this->assertArrayHasKey('publisher', $book);
            $this->assertArrayHasKey('author', $book);
            $this->assertArrayHasKey('genre', $book);
            $this->assertArrayHasKey('published_at', $book);
            $this->assertArrayHasKey('words_count', $book);
            $this->assertArrayHasKey('cost', $book);
            $this->assertArrayHasKey('amount', $book['cost']);
            $this->assertArrayHasKey('currency', $book['cost']);
        }
    }

    public function testShow(): void
    {
        static::createClient()
            ->request('GET', '/v1/books/' . 10);

        $this->assertResponseIsSuccessful();
    }

    public function testDestroy(): void
    {
        $id = 99;

        static::createClient()
            ->request('DELETE', '/v1/books/' . $id);

        $this->assertResponseIsSuccessful();

        static::createClient()
            ->request('GET', '/v1/books/' . $id);

        $this->assertResponseStatusCodeSame(404);
    }
}
