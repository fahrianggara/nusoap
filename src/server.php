<?php

// Memuat pustaka NuSOAP
require_once __DIR__ . '/../vendor/econea/nusoap/src/nusoap.php';

// Membuat instance server SOAP
$server = new nusoap_server();

// Mengonfigurasi WSDL dengan nama 'server_wsdl' dan namespace 'urn:server_wsdl'
$server->configureWSDL('server_wsdl', 'urn:server_wsdl');

/**
 * Fungsi untuk menjumlahkan dua angka
 *
 * @param  int $x Bilangan pertama
 * @param  int $y Bilangan kedua
 * @return int Hasil penjumlahan dari $x dan $y
 */
function jumlahkan($x, $y)
{
    return $x + $y;
}

// Mendaftarkan fungsi 'jumlahkan' ke dalam server SOAP
$server->register('jumlahkan', [
    'x' => 'xsd:int', // Tipe data parameter 'x'
    'y' => 'xsd:int', // Tipe data parameter 'y'
], [
    'return' => 'xsd:int', // Tipe data return
]);

/**
 * Fungsi untuk mengurangi dua angka
 *
 * @param  int $x Bilangan pertama
 * @param  int $y Bilangan kedua
 * @return int Hasil pengurangan dari $x dan $y
 */
function kurangkan($x, $y)
{
    return $x - $y;
}

// Mendaftarkan fungsi 'kurangkan' ke dalam server SOAP
$server->register('kurangkan', [
    'x' => 'xsd:int', // Tipe data parameter 'x'
    'y' => 'xsd:int', // Tipe data parameter 'y'
], [
    'return' => 'xsd:int', // Tipe data return
]);

// Mendapatkan data mentah HTTP
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : ''; 
$server->service(file_get_contents('php://input')); // Memproses request SOAP

// Mendekode JSON hasil dari service SOAP
$result = json_decode($server);

// Menampilkan hasil yang telah didekode
echo $result;

exit();
