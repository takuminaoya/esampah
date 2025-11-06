<?php
//-----------------------------------------------------------------
// Disini untuk fungsi khusus menyangkut applikasi yang dibuat
//-----------------------------------------------------------------
// Author          : AbsoluteHelix (OCW)
// Dibuat Pada     : 07/03/2023
// Tipe            : PHP
//----------------------------------------------------------------- 

// basik generasi index

use Illuminate\Support\Facades\DB;

function getNikInfo($nik)
{
    return DB::connection("ungasan")->table("penduduks")
        ->where("nik", $nik)
        ->first();
}

// fungsi untuk konversi status ke text
function getStatus($status_number, $custom_katas = [])
{
    if (count($custom_katas) <= 0) {
        $custom_katas = [
            "baru daftar",
            "diproses",
            "selesai",
            "dibatalkan"
        ];
    }

    return $custom_katas[$status_number];
}

// fungsi mendapatkan pekerjaan
function getJob($id)
{
    return DB::connection("ungasan")->table("jobs")->where("sid", $id)->first();;
}

// kepanjangan jenis
function longJenis($val)
{
    switch ($val) {
        case "lahir":
            return "Kelahiran";
            break;
        case "kawin":
            return "Pernikahan";
            break;
        case "mati":
            return "Kematian";
            break;
        default:
            return "Pernikahan";
            break;
    }
}

function getNonpermanentToday()
{
    $residents = DB::connection("ungasan")->table("penduduk_non_permanents")->where("sif_sid", 1)
        ->where("created_at", date("Y-m-d"))
        ->orderByDesc('created_at')
        ->count();

    return $residents;
}

function getSettingValue($key)
{
    $data =  DB::connection("ungasan")->table("settings")->where("setting_key", $key)->value("setting_value");

    return $data;
}

function getPenduduk($sid)
{
    return DB::connection("ungasan")->table("penduduks")->where("sid", $sid)
        ->first();
}

function getUserByID($sid)
{
    return DB::connection("ungasan")->table("users")->where("sid", $sid)
        ->first();
}

// 10072024
function jk($sid)
{
    return DB::connection("ungasan")->table("genders")->where("sid", $sid)
        ->first();
}

function agama($sid)
{
    return DB::connection("ungasan")->table("religions")->where("sid", $sid)
        ->first();
}

function kawin($sid)
{
    return DB::connection("ungasan")->table("marriages")->where("sid", $sid)
        ->first();
}

function job($sid)
{
    return DB::connection("ungasan")->table("jobs")->where("sid", $sid)
        ->first();
}

function jks()
{
    return DB::connection("ungasan")->table("genders")
        ->get();
}

function agamas()
{
    return DB::connection("ungasan")->table("religions")
        ->get();
}

function kawins()
{
    return DB::connection("ungasan")->table("marriages")
        ->get();
}

function jobs()
{
    return DB::connection("ungasan")->table("jobs")
        ->get();
}

function banjars()
{
    return DB::connection("ungasan")->table("banjars")
        ->get();
}

// add ref
function addRefLayanan($id_ref, $kode_layanan, $dibuat_oleh)
{
    // check dulu klo ada layanan denan id ref yang sama
    $cek = DB::connection("ungasan")->table("referensi_layanans")->where("id_ref", $id_ref)
        ->where("kode_layanan", $kode_layanan)->first();

    if ($cek == null) {
        $gen_no = addingZero($id_ref) . "/" . $kode_layanan . "/" . bulanRomawi(date("m")) . "/" . date("Y");

        $data = DB::connection("ungasan")->table("referensi_layanans")->insertGetId([
            "no" => $gen_no,
            "id_ref" => $id_ref,
            "kode_layanan" => $kode_layanan,
            "dibuat_oleh" => $dibuat_oleh,
        ]);
    } else {
        $data = $cek;
    }

    return $data;
}
