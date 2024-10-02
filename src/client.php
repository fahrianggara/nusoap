<?php

// Memuat pustaka NuSOAP
require_once __DIR__ . '/../vendor/econea/nusoap/src/nusoap.php';

// Inisialisasi variabel $result
$result = '';

// Jika tombol submit ditekan
if (isset($_POST['submit']))
{
    // Mengambil input dari form
    $bil1 = $_POST['bil1'];
    $bil2 = $_POST['bil2'];

    // Membuat instance client SOAP dengan WSDL yang ada di URL yang diberikan
    $client = new nusoap_client('http://localhost/nusoap/src/server.php?wsdl', 'wsdl', true);

    // Memanggil metode SOAP 'jumlahkan' dengan parameter $bil1 dan $bil2
    $resultJumlah = $client->call('jumlahkan', [
        'x' => $bil1,
        'y' => $bil2,
    ]);

    // Memanggil metode SOAP 'kurangkan' dengan parameter $bil1 dan $bil2
    $resultKurang = $client->call('kurangkan', [
        'x' => $bil1,
        'y' => $bil2,
    ]);

    // Mengecek apakah terjadi kesalahan SOAP
    if ($client->fault) {
        $result = "Terjadi kesalahan SOAP: ";
        $result .= print_r($client->fault, true); // Menyimpan hasil kesalahan ke dalam variabel $result
    } else {
        // Mengecek apakah terjadi error
        $err = $client->getError();
        if ($err) {
            $result = "Error: " . $err;
        } else {
            // Menampilkan hasil penjumlahan dan pengurangan dalam tabel
            $result = "
                <table>
                    <tr>
                        <td>Hasil penjumlahan $bil1 + $bil2</td>
                        <td> = $resultJumlah</td>
                    </tr>
                    <tr>
                        <td>Hasil pengurangan $bil1 - $bil2</td>
                        <td> = $resultKurang</td>
                    </tr>
                </table>
            ";
        }
    }
}
?>

<!-- HTML Form untuk menerima input dari pengguna -->
<form method="POST" action="">
    <table>
        <tr>
            <td>Bilangan Pertama</td>
            <td>: <input type="number" name="bil1" id="bil1" required 
                value="<?= isset($_POST['bil1']) ? $_POST['bil1'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>Bilangan Kedua</td>
            <td>: <input type="number" name="bil2" id="bil2" required 
                value="<?= isset($_POST['bil2']) ? $_POST['bil2'] : ''; ?>"></td>
        </tr>
        <tr>
            <td style="padding-top: 5px;">
                <button type="submit" name="submit">Hitung</button>
            </td>
        </tr>
    </table>
</form>

<!-- Menampilkan hasil -->
<?php
    if ($result) {
        echo "<h3 style='margin-bottom:5px; margin-left:2px;'>Hasil:</h3>";
        echo $result;
    }
?>
