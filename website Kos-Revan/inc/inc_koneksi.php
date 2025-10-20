<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'kosrevan_2';

$koneksi = mysqli_connect("localhost", "root", "", "kosrevan_2");

if (!$koneksi) {
    die('Koneksi Gagal!');
}

?>