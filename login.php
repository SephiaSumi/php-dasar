<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'tedc');
$studyPrograms = $mysqli->query("SELECT id, name FROM study_program")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];

    if (isset($_POST['login'])) {
        $result = $mysqli->query("SELECT * FROM students WHERE nim = '$nim' AND nama = '$nama'");
        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
            $_SESSION['logged_in'] = true;
            $_SESSION['nim'] = $student['nim'];
            $_SESSION['nama'] = $student['nama'];
            setcookie('user_nim', $student['nim'], time() + 86400 * 30, "/");
            setcookie('user_nama', $student['nama'], time() + 86400 * 30, "/");
            echo "<script>alert('Login Berhasil!'); window.location.href='?view=data';</script>";
        } else {
            echo "<script>alert('NIM atau Nama salah');</script>";
        }
    } elseif (isset($_POST['edit'])) {
        $study_program_id = $_POST['study_program'];
        $mysqli->query("UPDATE students SET nama = '$nama', study_program_id = '$study_program_id' WHERE nim = '$nim'");
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='?view=data';</script>";
    } elseif (isset($_POST['delete'])) {
        $mysqli->query("DELETE FROM students WHERE nim = '$nim'");
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='?view=data';</script>";
    } else {
        $study_program_id = $_POST['study_program'];
        $mysqli->query("INSERT INTO students (nim, nama, study_program_id) VALUES ('$nim', '$nama', '$study_program_id')");
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='?view=data';</script>";
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        setcookie('user_nim', '', time() - 3600, "/");
        setcookie('user_nama', '', time() - 3600, "/");
        echo "<script>alert('Logout Berhasil'); window.location.href='';</script>";
    }
}

$students = $mysqli->query("SELECT students.nim, students.nama, study_program.name AS program FROM students INNER JOIN study_program ON students.study_program_id = study_program.id")->fetch_all(MYSQLI_ASSOC);
$editData = isset($_GET['edit']) ? $mysqli->query("SELECT * FROM students WHERE nim = '{$_GET['edit']}'")->fetch_assoc() : null;

if (isset($_COOKIE['user_nim']) && isset($_COOKIE['user_nama'])) {
    $_SESSION['logged_in'] = true;
    $_SESSION['nim'] = $_COOKIE['user_nim'];
    $_SESSION['nama'] = $_COOKIE['user_nama'];
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
        body { background-color: #e6f7ff; }
        .container { max-width: 1200px; margin-top: 50px; }
        h1 { font-size: 3rem; color: #007bff; text-align: center; }
        .table { background-color: white; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); font-size: 1.1rem; }
        .table th { background-color: #007bff; color: white; text-align: center; }
        .btn-primary { background-color: #007bff; border-color: #007bff; }
        .btn-primary:hover { background-color: #0056b3; border-color: #0056b3; }
        .btn-secondary { background-color: #6c757d; border-color: #6c757d; }
        .btn-secondary:hover { background-color: #5a6268; border-color: #5a6268; }
    </style>
</head>
<body>
    <?php if ($_SESSION['logged_in'] ?? false): ?>
        <div class="container">
            <h1>DATA MAHASISWA</h1>
            <form method="POST">
                <button type="submit" name="logout" class="btn btn-primary mb-3">Logout</button>
            </form>
            <?php if ($_GET['view'] ?? '' === 'data'): ?>
                <a href="?" class="btn btn-primary mb-3">Input Data</a>
                <table class="table table-bordered">
                    <thead>
                        <tr><th>No</th><th>NIM</th><th>Nama</th><th>Program Studi</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $index => $student): ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= $student['nim']; ?></td>
                                <td><?= $student['nama']; ?></td>
                                <td><?= $student['program']; ?></td>
                                <td>
                                    <a href="?edit=<?= $student['nim']; ?>" class="btn btn-primary">Edit</a>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="nim" value="<?= $student['nim']; ?>">
                                        <button type="submit" name="delete" class="btn btn-secondary" onclick="return confirm('Hapus data ini?')">Hapus</button>
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
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $editData['nama'] ?? ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="<?= $editData['nim'] ?? ''; ?>" <?= $editData ? 'readonly' : ''; ?> required>
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
                <div class="text-center mt-3"><a href="?view=data" class="btn btn-secondary">Lihat Data</a></div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="container">
            <h1>Login Mahasiswa</h1>
            <form method="POST">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
