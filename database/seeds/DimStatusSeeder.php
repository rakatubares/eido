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
            10 => 'BELUM LENGKAP',
            20 => 'BELUM RH',
            21 => 'PROSES RH',
            22 => 'SPPB RH',
            30 => 'PENDING PERSYARATAN',
            40 => 'PROSES DOK. IMPOR',
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
