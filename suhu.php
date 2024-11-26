<!DOCTYPE html>
<html>
<head>
    <title>Konversi Suhu</title>
    <style>
        label, select, input {
            font-size: 18px;
        }
        p {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1>Konversi Suhu</h1>

    <form method="post" action="">
        <label>Konversi ke:</label>
        <select name="konversi">
            <option value="fahrenheit">Fahrenheit</option>
            <option value="reamur">Reamur</option>
        </select>
        <br>

        <label>Suhu:</label>
        <input type="number" name="suhu" required>
        <br>

        <input type="submit" value="Hitung">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $suhu = $_POST['suhu'];
        $konversi = $_POST['konversi'];

        if ($konversi == "fahrenheit") {
            $hasil = ($suhu * 9/5) + 32;
            echo "<p>Hasil konversi ke Fahrenheit adalah: " . $hasil . "</p>";
        } else if ($konversi == "reamur") {
            $hasil = $suhu * 4/5;
            echo "<p>Hasil konversi ke Reamur adalah: " . $hasil . "</p>";
        }
    }
    ?>
</body>
</html>
