<?php

use Illuminate\Database\Seeder;
use App\DimRekomendasi;

class DimRekomendasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documents = [
            'PIB',
            'BARANG KIRIMAN',
            'BARANG PENUMPANG'
        ];

        foreach ($documents as $document) {
            DimRekomendasi::create(['rekomendasi' => $document]);
        }
    }
}
