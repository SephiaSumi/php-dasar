<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'tedc');
if ($mysqli->connect_error) die("Koneksi gagal: " . $mysqli->connect_error);

$studyPrograms = $mysqli->query("SELECT id, name FROM study_program")->fetch_all(MYSQLI_ASSOC);
$students = $mysqli->query("SELECT students.nim, students.nama, study_program.name AS program FROM students INNER JOIN study_program ON students.study_program_id = study_program.id")->fetch_all(MYSQLI_ASSOC);
$editData = isset($_GET['edit']) ? $mysqli->query("SELECT * FROM students WHERE nim = '" . $_GET['edit'] . "'")->fetch_assoc() : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $study_program_id = $_POST['study_program'];
    
    if (isset($_POST['edit'])) {
        $query = "UPDATE students SET nama = '$nama', study_program_id = '$study_program_id' WHERE nim = '$nim'";
    } elseif (isset($_POST['delete'])) {
        $query = "DELETE FROM students WHERE nim = '$nim'";
    } else {
        $query = "INSERT INTO students (nim, nama, study_program_id) VALUES ('$nim', '$nama', '$study_program_id')";
    }

    if ($mysqli->query($query)) {
        $_SESSION['success_message'] = 'Operasi berhasil!';
    } else {
        $_SESSION['error_message'] = 'Operasi gagal: ' . $mysqli->error;
    }
    header('Location: ?view=data');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #e6f7ff; }
        .container { max-width: 1200px; margin: 50px auto; }
        h1 { font-size: 3rem; color: #007bff; text-align: center; }
        .table { background: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); font-size: 1.1rem; }
        .table th { background: #007bff; color: #fff; text-align: center; padding: 10px; }
        .table td, .table th { padding: 10px; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <?php if (isset($_SESSION['success_message'])) echo "<div class='alert alert-success'>" . htmlspecialchars($_SESSION['success_message']) . "</div>"; unset($_SESSION['success_message']); ?>
        <?php if (isset($_SESSION['error_message'])) echo "<div class='alert alert-danger'>" . htmlspecialchars($_SESSION['error_message']) . "</div>"; unset($_SESSION['error_message']); ?>

        <?php if (isset($_GET['view']) && $_GET['view'] === 'data'): ?>
            <h1>Data Mahasiswa</h1>
            <a href="?" class="btn btn-primary mb-3">Input Data</a>
            <table class="table table-bordered">
                <thead><tr><th>No</th><th>NIM</th><th>Nama</th><th>Program Studi</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php foreach ($students as $no => $student): ?>
                        <tr>
                            <td><?= $no + 1; ?></td>
                            <td><?= htmlspecialchars($student['nim']); ?></td>
                            <td><?= htmlspecialchars($student['nama']); ?></td>
                            <td><?= htmlspecialchars($student['program']); ?></td>
                            <td>
                                <a href="?edit=<?= urlencode($student['nim']); ?>" class="btn btn-primary">Edit</a>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="nim" value="<?= htmlspecialchars($student['nim']); ?>">
                                    <button type="submit" name="delete" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <h1><?= $editData ? 'Form Edit Data Mahasiswa' : 'Form Input Data Mahasiswa'; ?></h1>
            <form method="POST">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="<?= htmlspecialchars($editData['nim'] ?? ''); ?>" placeholder="Masukkan NIM" <?= $editData ? 'readonly' : ''; ?> required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($editData['nama'] ?? ''); ?>" placeholder="Masukkan Nama" required>
                </div>
                <div class="mb-3">
                    <label for="study_program" class="form-label">Program Studi</label>
                    <select class="form-select" id="study_program" name="study_program" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <?php foreach ($studyPrograms as $program): ?>
                            <option value="<?= htmlspecialchars($program['id']); ?>" <?= isset($editData['study_program_id']) && $editData['study_program_id'] == $program['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($program['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="<?= $editData ? 'edit' : 'add'; ?>" class="btn btn-primary w-100">Simpan</button>
            </form>
            <div class="text-center mt-3">
                <a href="?view=data" class="btn btn-secondary">Lihat Data</a>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
