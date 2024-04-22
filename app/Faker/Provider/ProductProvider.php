<?php

namespace App\Faker\Provider;

use Faker\Provider\Base;

class ProductProvider extends Base
{
    protected static $productName = [
        'Rice' => ['Jasmine Rice', 'Brown Rice', 'Glutinous Rice'],
        'Canned Goods' => ['Corned Beef', 'Sardines', 'Tuna Flakes'],
        'Instant Noodles' => ['Pancit Canton', 'Lucky Me! Instant Noodles', 'Nissin Cup Noodles'],
        'Beverages (Soft Drinks, Juices, etc.)' => ['Coke', 'Mango Juice', 'Iced Tea'],
        'Cooking Oil' => ['Vegetable Oil', 'Coconut Oil', 'Canola Oil'],
        'Condiments (Soy Sauce, Vinegar, etc.)' => ['Soy Sauce', 'Vinegar', 'Fish Sauce'],
        'Snacks (Chips, Biscuits, etc.)' => ['Potato Chips', 'Oreo Cookies', 'Chocolate Wafer'],
        'Frozen Foods' => ['Frozen Dumplings', 'Frozen Vegetables', 'Frozen Chicken Nuggets'],
        'Fresh Produce (Fruits and Vegetables)' => ['Bananas', 'Tomatoes', 'Carrots'],
        'Meat and Poultry' => ['Chicken Breast', 'Pork Belly', 'Beef Sirloin'],
        'Fish and Seafood' => ['Tilapia', 'Shrimp', 'Bangus'],
        'Dairy Products (Milk, Cheese, Yogurt, etc.)' => ['Fresh Milk', 'Cheddar Cheese', 'Yogurt'],
        'Bakery Products (Bread, Pastries, etc.)' => ['Pandesal', 'Ensaymada', 'Spanish Bread'],
        'Cereals and Breakfast Items' => ['Corn Flakes', 'Oatmeal', 'Instant Champorado'],
        'Instant Coffee and Tea' => ['3-in-1 Coffee', 'Green Tea', 'Instant Black Coffee'],
        'Canned Meat (Corned Beef, Luncheon Meat, etc.)' => ['Corned Beef', 'Luncheon Meat', 'Hotdog'],
        'Pasta and Noodles (Spaghetti, Macaroni, etc.)' => ['Spaghetti Pasta', 'Macaroni', 'Fettuccine'],
        'Canned Fruits and Vegetables' => ['Pineapple Slices', 'Sweet Corn', 'Green Peas'],
        'Sauces and Dressings' => ['Tomato Sauce', 'Mayonnaise', 'Oyster Sauce'],
        'Baking Supplies (Flour, Sugar, etc.)' => ['All-Purpose Flour', 'Granulated Sugar', 'Baking Powder'],
    ];

    /**
     * @param int $category_id
     */
    public static function productName($category_id)
    {
        return static::randomElement(
            array_values(static::$productName)[$category_id - 1]
        );
    }
}
