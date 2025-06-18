<?php

namespace App\Input;

use Symfony\Component\Validator\Constraints as Assert;

class ProductInput
{
    #[Assert\NotBlank]
    public mixed $name;

    #[Assert\NotNull]
    #[Assert\Type('float')]
    public mixed $price;

    #[Assert\NotBlank]
    public mixed $category;

    #[Assert\Type('array')]
    public mixed $attributes;

    public function __construct(mixed $name, mixed $price, mixed $category, mixed $attributes)
    {
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
        $this->attributes = $attributes;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? '',
            price: $data['price'] ?? 0,
            category: $data['category'] ?? '',
            attributes: $data['attributes'] ?? [],
        );
    }
}
