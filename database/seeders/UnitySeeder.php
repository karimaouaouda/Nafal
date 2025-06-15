<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \Illuminate\Support\Facades\DB::table('unities')->insert([
            ['name' => 'Kilogram', 'code' => 'kg', 'abbreviation' => 'KG'],
            ['name' => 'Gram', 'code' => 'gr', 'abbreviation' => 'GR'],
            ['name' => 'Milligram', 'code' => 'mi', 'abbreviation' => 'MI'],
            ['name' => 'Liter', 'code' => 'li', 'abbreviation' => 'LI'],
            ['name' => 'Milliliter', 'code' => 'ml', 'abbreviation' => 'ML'],
            ['name' => 'Meter', 'code' => 'me', 'abbreviation' => 'ME'],
            ['name' => 'Centimeter', 'code' => 'ce', 'abbreviation' => 'CE'],
            ['name' => 'Millimeter', 'code' => 'mm', 'abbreviation' => 'MM'],
            ['name' => 'Inch', 'code' => 'in', 'abbreviation' => 'IN'],
            ['name' => 'Foot', 'code' => 'fo', 'abbreviation' => 'FO'],
            ['name' => 'Yard', 'code' => 'ya', 'abbreviation' => 'YA'],
            ['name' => 'Piece', 'code' => 'pi', 'abbreviation' => 'PI'],
            ['name' => 'Box', 'code' => 'bo', 'abbreviation' => 'BO'],
            ['name' => 'Pack', 'code' => 'pa', 'abbreviation' => 'PA'],
            ['name' => 'Dozen', 'code' => 'do', 'abbreviation' => 'DO'],
            ['name' => 'Pound', 'code' => 'po', 'abbreviation' => 'PO'],
            ['name' => 'Ounce', 'code' => 'ou', 'abbreviation' => 'OU'],
            ['name' => 'Gallon', 'code' => 'ga', 'abbreviation' => 'GA'],
            ['name' => 'Quart', 'code' => 'qu', 'abbreviation' => 'QU'],
            ['name' => 'Pint', 'code' => 'pi', 'abbreviation' => 'PI'],
            ['name' => 'Can', 'code' => 'ca', 'abbreviation' => 'CA'],
            ['name' => 'Bottle', 'code' => 'bo', 'abbreviation' => 'BO'],
            ['name' => 'Bag', 'code' => 'ba', 'abbreviation' => 'BA'],
            ['name' => 'Roll', 'code' => 'ro', 'abbreviation' => 'RO'],
            ['name' => 'Sheet', 'code' => 'sh', 'abbreviation' => 'SH'],
            ['name' => 'Barrel', 'code' => 'ba', 'abbreviation' => 'BA'],
            ['name' => 'Carton', 'code' => 'ca', 'abbreviation' => 'CA'],
            ['name' => 'Set', 'code' => 'se', 'abbreviation' => 'SE'],
            ['name' => 'Pair', 'code' => 'pa', 'abbreviation' => 'PA'],
            ['name' => 'Tube', 'code' => 'tu', 'abbreviation' => 'TU'],
            ['name' => 'Sack', 'code' => 'sa', 'abbreviation' => 'SA'],
        ]);
    }
}
