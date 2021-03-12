<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    const NB_PRODUCTS = 15;
    private $faker;

    public function __construct(){
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager){
        // $product = new Product();
        // $manager->persist($product);
        $this->loadProducts($manager);
        $this->loadCategories($manager);

        $manager->flush();
    }

    private  function loadProducts(ObjectManager $manager){

        for ($i=1; $i <= self::NB_PRODUCTS ; $i++){
            $product = new Product();
            $product->setLabel($this->faker->sentence(4))
                ->setDescription($this->faker->paragraph(3))
                ->setUnitPrice($this->faker->randomFloat(2,10,150))
                ->setQuantity(\mt_rand(0,18))
                ->setCover('https://picsum.photos/255/309');
            $manager->persist($product);
        }
    }

    private  function loadCategories(ObjectManager $manager){

        for ($i=1; $i <= self::NB_PRODUCTS ; $i++){
            $category = new Category();
            $category->setLabel($this->faker->sentence(1))
                ->setSlug($this->faker->sentence(4));
            $manager->persist($category);
        }
    }
}
