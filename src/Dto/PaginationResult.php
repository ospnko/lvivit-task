<?php

declare(strict_types=1);

namespace App\Dto;

class PaginationResult
{
    public function __construct(
        private readonly int $page,
        private readonly int $step,
        private readonly int $totalItems,
        private readonly int $totalPages,
        private readonly array $items,
    ) {
    }

    public function toArray(): array
    {
        return [
            'pagination' => [
                'page' => $this->page,
                'step' => $this->step,
                'total_items' => $this->totalItems,
                'total_pages' => $this->totalPages,
            ],
            'items' => array_map(
                array: $this->items,
                callback: fn (object $item): array => $item->toArray(),
            ),
        ];
    }
}
