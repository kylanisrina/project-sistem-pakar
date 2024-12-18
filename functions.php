<?php
error_reporting(E_ALL & ~E_NOTICE); // Menampilkan semua kesalahan kecuali E_NOTICE
session_start(); // Pastikan tidak ada spasi/baris kosong sebelum ini

include 'server.php';
include 'database/db_sp.php';
$db = new DB($config['server'], $config['username'], $config['password'], $config['database_name']);
include 'database/general.php';

// Memfilter input dari GET
$mod = isset($_GET['m']) ? htmlspecialchars($_GET['m']) : '';
$act = isset($_GET['act']) ? htmlspecialchars($_GET['act']) : '';

$JK = array(
    'Laki-laki' => 'Laki-laki',
    'Perempuan' => 'Perempuan',
);

function get_jk_option($selected = '')
{
    global $JK;
    $options = '';
    foreach ($JK as $key => $val) {
        if ($key == $selected)
            $options .= "<option value='$key' selected>$val</option>";
        else
            $options .= "<option value='$key'>$val</option>";
    }
    return $options;
}

function get_diagnosa_option($selected = '')
{
    global $db;
    $options = '';
    $rows = $db->get_results("SELECT kode_diagnosa, nama_diagnosa FROM tb_diagnosa ORDER BY kode_diagnosa");
    foreach ($rows as $row) {
        if ($row->kode_diagnosa == $selected)
            $options .= "<option value='$row->kode_diagnosa' selected>[$row->kode_diagnosa] $row->nama_diagnosa</option>";
        else
            $options .= "<option value='$row->kode_diagnosa'>[$row->kode_diagnosa] $row->nama_diagnosa</option>";
    }
    return $options;
}

function get_gejala_option($selected = '')
{
    global $db;
    $options = '';
    $rows = $db->get_results("SELECT kode_gejala, nama_gejala FROM tb_gejala ORDER BY kode_gejala");
    foreach ($rows as $row) {
        if ($row->kode_gejala == $selected)
            $options .= "<option value='$row->kode_gejala' selected>[$row->kode_gejala] $row->nama_gejala</option>";
        else
            $options .= "<option value='$row->kode_gejala'>[$row->kode_gejala] $row->nama_gejala</option>";
    }
    return $options;
}
