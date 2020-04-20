<?php

namespace App\Models;

use App\CovidHeader;

class CovidSoetta
{
	public static function list()
	{
		$covids = CovidHeader::details()
			->where('kantor_permohonan', '050100')
			->where('status_bebas','Y')
			->get();
		return $covids;
	}

	public static function show($idTanggap)
	{
		$covid = CovidHeader::details()
			->where('idTanggap', $idTanggap)
			->firstOrFail();
		return $covid;
	}
}