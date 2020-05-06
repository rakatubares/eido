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
			->with('latest_status')
			->with('officer')
			->get();

		for ($i=0; $i < count($importasi); $i++) { 
			$history = $importasi[$i]->latest_status;
			$importasi[$i]->status = $history->first();
			$importasi[$i]->status->waktu = Carbon::createFromFormat(
					'Y-m-d H:i:s', $importasi[$i]->status->pivot->created_at
				)->format('Y-m-d');
			unset($importasi[$i]->latest_status);
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

	public static function getDokumenPenutup()
	{
		$importasi = Impor::select('id', 'awb')
			->with('history')
			->get();

		for ($i=0; $i < count($importasi); $i++) { 
			$stat_selesai = $importasi[$i]->history->where('kd_status',50)->last();
			if ($stat_selesai != null) {
				$dok = $stat_selesai['jns_dok_impor'];
			} else {
				$dok = null;
			}
			$importasi[$i]->stat_selesai = $stat_selesai;
			$importasi[$i]->dok = $dok;
		};

		$filtered = $importasi->whereNotNull('dok');
		$grouped = $filtered->groupBy('dok');
		$count = $grouped->map(function ($item, $key) {
			return collect($item)->count();
		});

		return $count;
	}

	public static function getDokumenOutstanding()
	{
		$importasi = Impor::select('id')
			->with('latest_status')
			->get();

		for ($i=0; $i < count($importasi); $i++) { 
			$history = $importasi[$i]->latest_status;
			$status = $history->first()->ur_status;
			$importasi[$i]->status = $history->first()->ur_status;
			unset($importasi[$i]->latest_status);
		}

		$filtered = $importasi->filter(function ($impor) {
			return $impor->status != 'SELESAI';
		});
		$grouped = $filtered->groupBy('status');
		$count = $grouped->map(function ($item, $key) {
			return collect($item)->count();
		});

		return $count;
	}
}