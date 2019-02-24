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
            'name' => "Producto 1",
            'price' => 25.0,
            'description' => "Descripcion del producto 1",
            'img' => "producto_1.jpg",
            'status' => "available",
        ]);

        Product::create([
            'name' => "Producto 2",
            'price' => 40.0,
            'description' => "Descripcion del producto 2",
            'img' => "producto_2.jpg",
            'status' => "available",
        ]);

        Product::create([
            'name' => "Producto 3",
            'price' => 20.0,
            'description' => "Descripcion del producto 3",
            'img' => "producto_3.jpg",
            'status' => "available",
        ]);
    }
}
