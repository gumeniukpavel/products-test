<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ProductApiTest extends TestCase
{
    /**
     * @throws TransportExceptionInterface
     */
    public function testCreateProduct(): void
    {
        $client = HttpClient::create();
        $response = $client->request('POST', 'http://localhost:8000/products', [
            'json' => [
                'name' => 'MacBook Pro',
                'price' => 1999.99,
                'category' => 'electronics',
                'attributes' => ['brand' => 'Apple', 'color' => 'space gray']
            ]
        ]);

        $this->assertSame(201, $response->getStatusCode());
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testCreateProductErrorValidation(): void
    {
        $client = HttpClient::create();
        $response = $client->request('POST', 'http://localhost:8000/products', [
            'json' => [
                'name' => 'MacBook Pro',
                'price' => 1999.99,
                'category' => 'electronics',
                'attributes' => 'test'
            ]
        ]);

        $this->assertSame(422, $response->getStatusCode());
    }
}