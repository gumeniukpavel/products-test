<?php

namespace App\Repository;

use App\Database\DatabaseConnection;
use App\DTO\ProductDTO;
use PDO;

class ProductRepository
{
    private PDO $pdo;


    public function __construct()
    {
        $this->pdo = DatabaseConnection::getConnection();
    }

    public function all(?string $category = null, ?float $price = null): array
    {
        $query = 'SELECT * FROM products WHERE 1=1';
        $params = [];

        if ($category) {
            $query .= ' AND category = :category';
            $params[':category'] = $category;
        }

        if ($price) {
            $query .= ' AND price <= :price';
            $params[':price'] = $price;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(ProductDTO $dto): array
    {
        $sql = 'INSERT INTO products (name, price, category, attributes) 
                VALUES (:name, :price, :category, :attributes)
                RETURNING *';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $dto->name,
            ':price' => $dto->price,
            ':category' => $dto->category,
            ':attributes' => json_encode($dto->attributes),
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function find(string $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute([':id' => $id]);

        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product ?: null;
    }

    public function update(string $id, array $data): ?array
    {
        $product = $this->find($id);
        if (!$product) {
            return null;
        }

        $updateData = array_merge($product, $data);
        $sql = 'UPDATE products SET name = :name, price = :price, category = :category, attributes = :attributes WHERE id = :id RETURNING *';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':name' => $updateData['name'],
            ':price' => $updateData['price'],
            ':category' => $updateData['category'],
            ':attributes' => json_encode($updateData['attributes']),
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete(string $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM products WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
