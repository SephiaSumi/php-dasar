<?php
$mysqli = new mysqli('localhost', 'root', '', 'tedc');

$result = $mysqli->query("SELECT students.nim, students.nama, study_program.name 
                          FROM students INNER JOIN study_program ON students.study_program_id = study_program.id 
                          WHERE study_program.id = 11;");

$mahasiswa = [];

while ($row = $result->fetch_assoc()) {
    array_push($mahasiswa, $row);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAHASISWA</title>

    <!-- Bootstrap CSS (Updated to Bootstrap 4) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-pzjw8f+ua7Kw1TIq0s9z1F9ftE5oPq3yppf6XKqSbYhq54Xi5a0zx3+bzIuK6dcd" crossorigin="anonymous">

    <!-- Custom CSS -->
    <style>
        /* Custom Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        h1 {
            font-size: 2.5rem;
            color: #007bff;
            margin-top: 20px;
        }

        .table {
            margin-top: 20px;
            background-color: white;
            border: 1px solid #dee2e6;
            width: 80%; /* Adjust table width */
        }

        .table th, .table td {
            text-align: center;
            padding: 15px;
        }

        .table th {
            background-color: #007bff;
            color: white;
        }

        /* Center Nama column */
        .table td:nth-child(2) { 
            text-align: center; 
        }

        /* Align Program Studi column (3rd column) to left-right */
        .table td:nth-child(3) { 
            text-align: left; 
            white-space: nowrap;
        }

        .table-bordered {
            border: 2px solid #007bff;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .container {
            margin-top: 50px;
            display: flex;
            justify-content: center; /* Center content horizontally */
        }
    </style>
</head>
<body>
    <h1 align="center"> Data Mahasiswa KA 2021 </h1>
    <div class="container">
        <table class="table table-bordered table-hover">
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Program Studi</th>
            </tr>
            <?php $no = 1; // Initialize row number ?>
            <?php foreach ($mahasiswa as $row) { ?>
                <tr>
                    <td><?= $no++; ?></td> <!-- Display row number -->
                    <td><?= $row['nim']; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['name']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
