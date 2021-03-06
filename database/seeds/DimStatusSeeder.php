<?php

use Illuminate\Database\Seeder;
use App\DimStatus;

class DimStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            10 => 'PEREKAMAN',
            20 => 'BELUM RH',
            22 => 'SPPB RH',
            30 => 'PENDING PERSYARATAN',
            40 => 'DOK. IMPOR BELUM DIAJUKAN',
            41 => 'PROSES DOK. IMPOR',
            50 => 'SELESAI'
        ];

        foreach ($statuses as $code => $status) {
            DimStatus::create([
                'kd_status' => $code,
                'ur_status' => $status
            ]);
        }
    }
}
