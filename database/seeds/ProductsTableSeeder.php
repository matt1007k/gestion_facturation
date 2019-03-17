<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'code' => "P00001",
            'name' => "Producto 1",
            'price' => 25.0,
            'description' => "Descripcion del producto 1",
            'quantity' => 50,
            'img' => "producto_1.jpg",
            'user_id' => 1,
            'status' => "available",
        ]);

        Product::create([
            'code' => "P00002",
            'name' => "Producto 2",
            'price' => 40.0,
            'description' => "Descripcion del producto 2",
            'quantity' => 10,
            'img' => "producto_2.jpg",
            'user_id' => 1,
            'status' => "available",
        ]);

        Product::create([
            'code' => "P00003",
            'name' => "Producto 3",
            'price' => 20.0,
            'description' => "Descripcion del producto 3",
            'quantity' => 35,
            'img' => "producto_3.jpg",
            'user_id' => 1,
            'status' => "available",
        ]);
    }
}
