<?php
// Array mahasiswa
$mahasiswa = [
    [
        "NIM" => "D212111013",
        "NAMA" => "RENALDI IRAWAN"
    ],
    [
        "NIM" => "D212111014",
        "NAMA" => "RIZALDY MUHAMAD SOFYAN"
    ],
    [
        "NIM" => "D212111015",
        "NAMA" => "RUDI LOILATU"
    ],
    [
        "NIM" => "D212111016",
        "NAMA" => "SELI PEBRIANI"
    ],
    [
        "NIM" => "D212111017",
        "NAMA" => "SEPHIA SUMI JAYATINIGRUM"
    ],
];
// Tampilkan tabel
echo "<table border= 1 cellpadding= 5 cellspacing= 0>";
echo "<tr><th>No</th><th>NIM</th><th>Nama</th></tr>";
$no = 1;
foreach ($mahasiswa as $mhs) {
    echo "<tr>";
    echo "<td align = center>" . $no++ . "</td>";
    echo "<td>" . $mhs["NIM"] . "</td>";
    echo "<td>" . $mhs["NAMA"] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>