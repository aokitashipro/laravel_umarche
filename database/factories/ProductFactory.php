<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'information' => $this->faker->realText,
            'price' => $this->faker->numberBetween(10, 100000),
            'is_selling' => $this->faker->numberBetween(0,1),
            'sort_order' => $this->faker->randomNumber,
            'shop_id' => $this->faker->numberBetween(1,2),
            'secondary_category_id' => $this->faker->numberBetween(1,6),
            'image1' => $this->faker->numberBetween(1,6),
            'image2' => $this->faker->numberBetween(1,6),
            'image3' => $this->faker->numberBetween(1,6),
            'image4' => $this->faker->numberBetween(1,6),

        ];
    }
}
