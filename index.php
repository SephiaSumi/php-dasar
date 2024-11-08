<?php
    $NAMA = "SEPHIA SUMI JAYATININGRUM";
    $JENIS_KELMIN = "PEREMPUAN";
    $UMUR = 22;
    $BERAT_BADAN = 63;
    $TINGGI_BADAN = 169;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TUGAS PEMOGRAMAN WEB</title>
    <body>
    <h1>BIODATA</h1>
    <h6>
        <table border="1" cellspacing="0" cellpadding="9">
            <tr>
                <td> NAMA </td>
                <td> : </td>
                <td><?php echo $NAMA; ?></td>
            </tr>
            <tr>
                <td> JENIS KELAMIN </td>
                <td> : </td>
                <td><?php echo $JENIS_KELMIN; ?> </td>
            </tr>
            <tr>
                <td> UMUR </td>
                <td> : </td>
                <td> <?php echo $UMUR; ?> </td>
            </tr>
            <tr>
                <td> BERAT BADAN</td>
                <td> : </td>
                <td><?php echo $BERAT_BADAN; ?> </td>
            </tr>
            <tr>
                <td> TINGGI BADAN </td>
                <td> : </td>
                <td><?php echo $TINGGI_BADAN; ?> </td>
            </tr>
        </table>
</body>
</html>