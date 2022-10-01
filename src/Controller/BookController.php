<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use App\Factory\BookFactory;
use App\Repository\BookRepository;
use App\Utils\ValidationErrors;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/v1/books', name: 'books')]
class BookController extends AbstractController
{
    #[Route(methods: ['GET'])]
    public function index(
        ManagerRegistry $managerRegistry,
        Request $request,
    ): JsonResponse {
        /** @var BookRepository */
        $bookRepository = $managerRegistry->getRepository(Book::class);

        $paginationResult = $bookRepository->paginate(
            page: (int) $request->query->get('page', 1),
            step: (int) $request->query->get('step', 15),
        );

        return $this->json($paginationResult->toArray());
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(
        int $id,
        ManagerRegistry $managerRegistry,
    ): JsonResponse {
        /** @var BookRepository */
        $bookRepository = $managerRegistry->getRepository(Book::class);

        $book = $bookRepository->find($id);

        if ($book === null) {
            return $this->json([
                'message' => 'Book was not found',
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json([
            'item' => $book->toArray(),
        ]);
    }

    #[Route(methods: ['POST'])]
    public function store(
        BookFactory $bookFactory,
        EntityManagerInterface $entityManager,
        Request $request,
        ValidatorInterface $validator,
    ): JsonResponse {
        $book = $bookFactory->createFromArray($request->toArray());

        $errors = new ValidationErrors($validator->validate($book));

        if ($errors->hasErrors()) {
            return $this->json([
                'errors' => $errors->toArray(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($book);

        $entityManager->flush();

        return $this->json([
            'item' => $book->toArray(),
        ]);
    }

    #[Route('/{id}', methods: ['PATCH'])]
    public function update(
        int $id,
        BookFactory $bookFactory,
        EntityManagerInterface $entityManager,
        ManagerRegistry $managerRegistry,
        Request $request,
        ValidatorInterface $validator
    ): JsonResponse {
        /** @var BookRepository */
        $bookRepository = $managerRegistry->getRepository(Book::class);

        $book = $bookRepository->find($id);

        if ($book === null) {
            return $this->json([
                'message' => 'Book was not found',
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $book = $bookFactory->createFromArray($request->toArray(), $book);

        $errors = new ValidationErrors($validator->validate($book));

        if ($errors->hasErrors()) {
            return $this->json([
                'errors' => $errors->toArray(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($book);

        $entityManager->flush();

        return $this->json([
            'item' => $book->toArray(),
        ]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function destroy(
        Book $book,
        ManagerRegistry $managerRegistry,
    ): JsonResponse {
        $manager = $managerRegistry->getManager();

        $manager->remove($book);
        $manager->flush();

        return $this->json('', JsonResponse::HTTP_NO_CONTENT);
    }
}
