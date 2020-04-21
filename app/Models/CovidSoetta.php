<?php

namespace App\Models;

use DateTime;
use App\CovidHeader;
use App\Impor;

class CovidSoetta
{
	public function __construct(CovidHeader $covid)
	{
		$this->covid = $covid;
	}

	public static function list()
	{
		$covids = CovidHeader::details()
			->where('kantor_permohonan', '050100')
			->where('status_bebas','Y')
			// ->with(['importasi' => function ($query) {
			// 	$query->whereNull('impor.idTangga');
			// }])
			->get();
		return $covids;
	}

	public static function get($idTanggap)
	{
		$covid = CovidHeader::details()
			->where('idTanggap', $idTanggap)
			->firstOrFail();
		return $covid;
	}

	public static function monitor($idTanggap)
	{
		$covid = CovidSoetta::get($idTanggap);
		$imporData = $covid;

		$cekCovid = Impor::withTrashed()
			->where('no_permohonan',$covid->no_permohonan)
			->first();
		$cekAwb = Impor::where('awb',$covid->awb)
			->first();

		if ($cekCovid == null) {
			if ($cekAwb == null) {
				$form = 'insert';
			} else {
				$form = 'update';
				$imporData->idImpor = $cekAwb->id;
			}
		} else {
			if ($cekCovid->idTanggap == null) {
				$form = 'update';
				$imporData->idImpor = $cekCovid->id;
			} else {
				$form = 'ignore';
			}
		}

		if ($imporData->awb != '') {
			$imporData->awb = preg_replace("/[^A-Za-z0-9 ]/", '', $imporData->awb);
		} else {
			$imporData->awb = 'id'.$imporData->idTanggap;
		}
		if ($imporData->tgl_awb != null) {
			$imporData->tgl_awb = DateTime::createFromFormat('Y-m-d', $imporData->tgl_awb)->format('d-m-Y');
		}
		if ($imporData->tgl_permohonan != null) {
			$imporData->tgl_permohonan = DateTime::createFromFormat('Y-m-d', $imporData->tgl_permohonan)->format('d-m-Y');
		}
		$imporData->importir = $imporData->nama_importir;
		$imporData->status_importir = $imporData->jenis_entitas;
		$imporData->pic = $imporData->nama_pic;
		$imporData->hp_pic = $imporData->telp_pic;
		$imporData->email_pic = $imporData->mail_pic;
		if ($imporData->no_rekomendasi_bnpb != '') {
			$imporData->check_rekomendasi = 1;
		}
		$imporData->dok_rekomendasi = $imporData->no_rekomendasi_bnpb;
		if ($imporData->tgl_rekomendasi_bnpb != null) {
			$imporData->tgl_rekomendasi = DateTime::createFromFormat('Y-m-d', $imporData->tgl_rekomendasi_bnpb)->format('d-m-Y');
		}
		if ($imporData->status_bebas == 'Y') {
			$imporData->bebas = 1;
		} else {
			$imporData->bebas = 0;
		}
		if ($imporData->no_skmk != '') {
			$imporData->check_bebas = 1;
		}
		$imporData->dok_bebas = $imporData->no_skmk;
		if ($imporData->tgl_skmk != null) {
			$imporData->tgl_bebas = DateTime::createFromFormat('Y-m-d', $imporData->tgl_skmk)->format('d-m-Y');
		}
		
		return [
			'form'=> $form,
			'data'=> $imporData
		];
	}
}