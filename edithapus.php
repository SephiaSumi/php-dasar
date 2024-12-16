<?php
$mysqli = new mysqli('localhost', 'root', '', 'tedc');

// Fetch study programs for combobox
$studyPrograms = $mysqli->query("SELECT id, name FROM study_program")->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $study_program_id = $_POST['study_program'];

        if ($mysqli->query("UPDATE students SET nama = '$nama', study_program_id = '$study_program_id' WHERE nim = '$nim'") === TRUE) {
            echo "<script>alert('Data berhasil diperbarui!'); window.location.href='?view=data';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data: {$mysqli->error}');</script>";
        }
    } elseif (isset($_POST['delete'])) {
        $nim = $_POST['nim'];

        if ($mysqli->query("DELETE FROM students WHERE nim = '$nim'") === TRUE) {
            echo "<script>alert('Data berhasil dihapus!'); window.location.href='?view=data';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data: {$mysqli->error}');</script>";
        }
    } else {
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $study_program_id = $_POST['study_program'];

        if ($mysqli->query("INSERT INTO students (nim, nama, study_program_id) VALUES ('$nim', '$nama', '$study_program_id')")) {
            echo "<script>alert('Data berhasil disimpan!'); window.location.href='?view=data';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data: {$mysqli->error}');</script>";
        }
    }
}

// Fetch all students
$students = $mysqli->query("SELECT students.nim, students.nama, study_program.name AS program FROM students INNER JOIN study_program ON students.study_program_id = study_program.id")->fetch_all(MYSQLI_ASSOC);

// Fetch student data if editing
$editData = null;
if (isset($_GET['edit'])) {
    $editNim = $_GET['edit'];
    $editData = $mysqli->query("SELECT * FROM students WHERE nim = '$editNim'")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Mahasiswa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #e6f7ff; /* Light blue background */
        }
        .container {
            max-width: 1200px; /* Increase container width */
            margin-top: 50px;
        }
        h1 {
            font-size: 3rem;
            color: #007bff; /* Blue text for the title */
            text-align: center;
        }
        .table {
            background-color: white; /* White background for table */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for raised effect */
            font-size: 1.1rem; /* Adjust font size */
            width: 100%;
        }
        .table th {
            background-color: #007bff; /* Blue background for table headers */
            color: white;
            text-align: center;
        }
        .table td, .table th {
            padding: 10px; /* Increased padding for better readability */
        }
        .btn-primary {
            background-color: #007bff; /* Blue button */
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue when hovering */
            border-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d; /* Default gray button */
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268; /* Darker gray when hovering */
            border-color: #5a6268;
        }
    </style>
</head>
<body>
    <?php if (isset($_GET['view']) && $_GET['view'] === 'data'): ?>
        <div class="container">
            <h1>Data Mahasiswa</h1>
            <a href="?" class="btn btn-primary mb-3">Input Data</a> <!-- Move button to the top -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Aksi</th>
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
                            <td>
                                <a href="?edit=<?= $student['nim']; ?>" class="btn btn-primary">Edit</a>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="nim" value="<?= $student['nim']; ?>">
                                    <button type="submit" name="delete" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="container">
            <h1><?= $editData ? 'Form Edit Data Mahasiswa' : 'Form Input Data Mahasiswa'; ?></h1>
            <form method="POST">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="<?= $editData['nim'] ?? ''; ?>" placeholder="Masukkan NIM" <?= $editData ? 'readonly' : ''; ?> required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $editData['nama'] ?? ''; ?>" placeholder="Masukkan Nama" required>
                </div>
                <div class="mb-3">
                    <label for="study_program" class="form-label">Program Studi</label>
                    <select class="form-select" id="study_program" name="study_program" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <?php foreach ($studyPrograms as $program): ?>
                            <option value="<?= $program['id']; ?>" <?= isset($editData['study_program_id']) && $editData['study_program_id'] == $program['id'] ? 'selected' : ''; ?>><?= $program['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="<?= $editData ? 'edit' : 'add'; ?>" class="btn btn-primary w-100">Simpan</button>
            </form>
            <div class="text-center mt-3">
                <a href="?view=data" class="btn btn-secondary">Lihat Data</a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
