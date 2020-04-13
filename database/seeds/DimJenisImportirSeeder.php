<?php

use Illuminate\Database\Seeder;
use App\DimJenisImportir;

class DimJenisImportirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'LEMBAGA NEGARA',
            'LEMBAGA NON PROFIT',
            'BADAN USAHA / PERORANGAN'
        ];

        foreach ($types as $type) {
            DimJenisImportir::create(['jns_importir' => $type]);
        }
    }
}
