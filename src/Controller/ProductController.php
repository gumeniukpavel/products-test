<?php

namespace App\Controller;

use App\DTO\ProductDTO;
use App\Input\ProductInput;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ValidatorBuilder;

class ProductController
{
    private ProductRepository $repository;

    public function __construct()
    {
        $this->repository = new ProductRepository();
    }

    public function index(Request $request): JsonResponse
    {
        $category = $request->query->get('category');
        $price = $request->query->get('price');

        $products = $this->repository->all($category, $price);
        return new JsonResponse($products);
    }

    public function store(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $input = ProductInput::fromArray($data);

        $validator = (new ValidatorBuilder())->enableAttributeMapping()->getValidator();
        $violations = $validator->validate($input);
        if (count($violations) > 0) {
            return new JsonResponse(['errors' => (string) $violations], 422);
        }

        $dto = ProductDTO::fromInput($input);
        $product = $this->repository->create($dto);
        return new JsonResponse($product, 201);
    }

    public function show(Request $request, array $args): JsonResponse
    {
        $product = $this->repository->find($args['id']);
        return $product ? new JsonResponse($product) : new JsonResponse(['error' => 'Not Found'], 404);
    }

    public function update(Request $request, array $args): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $updated = $this->repository->update($args['id'], $data);
        return $updated ? new JsonResponse($updated) : new JsonResponse(['error' => 'Not Found or Invalid'], 404);
    }

    public function delete(Request $request, array $args): JsonResponse
    {
        $deleted = $this->repository->delete($args['id']);
        return $deleted ? new JsonResponse(null, 204) : new JsonResponse(['error' => 'Not Found'], 404);
    }
}