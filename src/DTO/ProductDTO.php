<?php

namespace App\DTO;

use App\Input\ProductInput;
use Symfony\Component\Validator\Constraints as Assert;

readonly class ProductDTO
{
    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Type("float")]
    public float $price;

    #[Assert\NotBlank]
    public string $category;

    #[Assert\Type("array")]
    public array $attributes;

    public function __construct(string $name, float $price, string $category, array $attributes)
    {
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
        $this->attributes = $attributes;
    }

    public static function fromInput(ProductInput $productInput): self
    {
        return new self(
            name: $productInput->name,
            price: $productInput->price,
            category: $productInput->category,
            attributes: $productInput->attributes,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'category' => $this->category,
            'attributes' => $this->attributes,
        ];
    }
}
