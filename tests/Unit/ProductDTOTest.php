<?php

use App\Input\ProductInput;
use PHPUnit\Framework\TestCase;
use App\DTO\ProductDTO;

class ProductDTOTest extends TestCase
{
    public function testFromArray(): void
    {
        $data = [
            'name' => 'iPhone',
            'price' => 999.99,
            'category' => 'electronics',
            'attributes' => ['color' => 'black', 'brand' => 'Apple']
        ];
        $input = ProductInput::fromArray($data);

        $dto = ProductDTO::fromInput($input);

        $this->assertSame('iPhone', $dto->name);
        $this->assertSame(999.99, $dto->price);
        $this->assertSame('electronics', $dto->category);
        $this->assertSame(['color' => 'black', 'brand' => 'Apple'], $dto->attributes);
    }
}