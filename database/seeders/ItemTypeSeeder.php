<?php

namespace Database\Seeders;

use App\Models\CollectionItemType;
use Illuminate\Database\Seeder;

class ItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CollectionItemType::updateOrCreate(['name' => 'Pokemon cards'], ['label' => 'Pokeman Cards']);
        CollectionItemType::updateOrCreate(['name' => 'Sports cards'], ['label' => 'Sports Cards']);
        CollectionItemType::updateOrCreate(['name' => 'Coins'], ['label' => 'Coins']);
        CollectionItemType::updateOrCreate(['name' => 'Stamps'], ['label' => 'Stamps']);
        CollectionItemType::updateOrCreate(['name' => 'Art'], ['label' => 'Art']);
        CollectionItemType::updateOrCreate(['name' => 'Movie collectibles'], ['label' => 'Movie collectibles']);
        CollectionItemType::updateOrCreate(['name' => 'Cars'], ['label' => 'Cars']);
        CollectionItemType::updateOrCreate(['name' => 'Baseball Cards'], ['label' => 'Baseball cards']);

    }
}
