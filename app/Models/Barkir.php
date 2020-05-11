<?php

namespace App\Models;

use DateTime;
use App\BarkirHeader;

class Barkir
{
	public static function topHs()
	{
		$barkir = BarkirHeader::select('id', 'ndpbm_penetapan')
			->with('barang_penetapan')
			->get();

		$listBarang = collect([]);
		for ($i=0; $i < count($barkir); $i++) { 
			$dataBarkir = $barkir[$i];
			$ndpbm = $dataBarkir->ndpbm_penetapan;
			for ($b=0; $b < count($dataBarkir->barang_penetapan); $b++) { 
				$dataBarang = $dataBarkir->barang_penetapan[$b];
				$hs = $dataBarang->hs;
				$cif = $dataBarang->cif;
				$nilai = $cif * $ndpbm;

				$barang = [
					'hs' => $hs,
					'nilai' => $nilai
				];

				$listBarang->push($barang);
			}
		}

		$grouped = $listBarang->groupBy('hs');
		$sum = $grouped->map(function ($item, $key) {
			return [
				'label' => $key,
				'nilai' => round($item->sum('nilai')/1000000, 2)
			];
		});
		$sorted = $sum->sortByDesc('nilai')->values()->take(10);
		$reversed = $sorted->reverse()->values();

		return $reversed;
	}

	public static function topNegara()
	{
		$barkir = BarkirHeader::select('negara_pengirim', 'ndpbm_penetapan', 'cif_penetapan')
			->get();

		for ($i=0; $i < count($barkir); $i++) { 
			$barkir[$i]->append('nilai_pabean');
		}

		$grouped = $barkir->groupBy('negara_pengirim');
		$sum = $grouped->map(function ($item, $key) {
			return [
				'label' => $key,
				'nilai' => round($item->sum('nilai_pabean')/1000000, 2)
			];
		});
		$sorted = $sum->sortByDesc('nilai')->values()->take(10);
		$reversed = $sorted->reverse()->values();

		return $reversed;
	}

	public static function tesTopHs()
	{
		$barkir = BarkirHeader::select('id', 'ndpbm_penetapan')
			->with('barang_penetapan')
			->get();

		$listBarang = collect([]);
		for ($i=0; $i < count($barkir); $i++) { 
			$dataBarkir = $barkir[$i];
			$ndpbm = $dataBarkir->ndpbm_penetapan;
			for ($b=0; $b < count($dataBarkir->barang_penetapan); $b++) { 
				$dataBarang = $dataBarkir->barang_penetapan[$b];
				$hs = $dataBarang->hs;
				$cif = $dataBarang->cif;
				$nilai = $cif * $ndpbm;

				$barang = [
					'hs' => $hs,
					'nilai' => $nilai
				];

				$listBarang->push($barang);
			}
		}

		$grouped = $listBarang->groupBy('hs');
		$sum = $grouped->map(function ($item, $key) {
			return [
				'hs' => $key,
				'nilai' => $item->sum('nilai')
			];
		});
		// $sorted = $sum->sortByDesc('nilai')->values()->take(10);
		// $reversed = $sorted->reverse()->values();

		return $sum;
	}
}
?>