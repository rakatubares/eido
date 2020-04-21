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
}