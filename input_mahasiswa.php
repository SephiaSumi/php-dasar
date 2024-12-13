<?php
$mysqli = new mysqli('localhost', 'root', '', 'tedc');

// Fetch study programs for combobox
$studyPrograms = $mysqli->query("SELECT id, name FROM study_program")->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $study_program_id = $_POST['study_program'];

    if ($mysqli->query("INSERT INTO students (nim, nama, study_program_id) VALUES ('$nim', '$nama', '$study_program_id')")) {
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='?view=data';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data: {$mysqli->error}');</script>";
    }
}

// Fetch all students
$students = $mysqli->query("SELECT students.nim, students.nama, study_program.name AS program FROM students INNER JOIN study_program ON students.study_program_id = study_program.id")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Mahasiswa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
        }
        h1 {
            font-size: 3rem;
            color: #007bff;
            text-align: center;
        }
        .container {
            width: 80%;
            max-width: 800px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }
        .form-group label {
            font-size: 1.2rem;
        }
        .form-control {
            font-size: 1.1rem;
            padding: 10px;
        }
        .btn-primary {
            font-size: 1.2rem;
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px;
        }
        .btn-secondary {
            font-size: 1.2rem;
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 10px;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 10px;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <?php if (isset($_GET['view']) && $_GET['view'] === 'data'): ?>
        <h1>Data Mahasiswa</h1>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Program Studi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $student['nim']; ?></td>
                        <td><?= $student['nama']; ?></td>
                        <td><?= $student['program']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div style="text-align: center; margin-top: 20px;">
            <a href="?" class="btn btn-secondary">Kembali ke Input Data</a>
        </div>
    <?php else: ?>
        <div class="container">
            <h1>Form Input Data Mahasiswa</h1>
            <form method="POST">
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
                </div>
                <div class="form-group">
                    <label for="study_program">Program Studi</label>
                    <select class="form-control" id="study_program" name="study_program" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <?php foreach ($studyPrograms as $program): ?>
                            <option value="<?= $program['id']; ?>"><?= $program['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Simpan</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>
