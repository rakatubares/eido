<?php

namespace App\Models;

use App\Impor;

class ImporDetail
{
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