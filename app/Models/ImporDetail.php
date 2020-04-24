<?php

namespace App\Models;

use DateTime;
use App\Impor;
use Carbon\Carbon;

class ImporDetail
{
	public static function list()
	{
		$importasi = Impor::select(
				'id',
				'no_permohonan',
				'tgl_permohonan',
				'awb',
				'awb_duplicate',
				'tgl_awb',
				'importir',
				'check_rekomendasi',
				'bebas',
				'check_bebas',
				'officer_id'
			)
			->with('history_status')
			->with('officer')
			->get();

		for ($i=0; $i < count($importasi); $i++) { 
			$history = $importasi[$i]->history_status;
			$importasi[$i]->latest_status = $history->last();
			$importasi[$i]->latest_status->waktu = Carbon::createFromFormat(
					'Y-m-d H:i:s', $importasi[$i]->latest_status->pivot->created_at
				)->format('Y-m-d');
			unset($importasi[$i]->history_status);
		}

		return $importasi;
	}

	public static function checkDuplicate($awb)
	{
		$cekAwb = Impor::withTrashed()
			->where('awb',$awb)
			->orderBy('awb_duplicate', 'desc')
			->first();

		if ($cekAwb == null) {
			return 0;
		} else {
			return (int)$cekAwb->awb_duplicate + 1;
		}
	}

	public static function checkDuplicateUpdate($id_impor, $awb, $awb_duplicate)
	{
		$cekAwbUpdate = Impor::withTrashed()
			->where('awb',$awb)
			->where('awb_duplicate', $awb_duplicate)
			->where('id', '!=', $id_impor)
			->get();

		if ($cekAwbUpdate) {
			return $awb_duplicate;
		} else {
			$cekAwb = ImporDetail::checkDuplicate($awb);
			return $cekAwb;
		}
	}
}