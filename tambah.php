<?php
    session_start();
    if (!isset($_SESSION['login'])) {
        if ($_SESSION['login'] != true) {
            header("Location: login.php");
            exit;
        }
    }
    $mysqli = new mysqli('localhost', 'root', '', 'tedc');
    
    // Fetch study programs for the dropdown
    $studyPrograms = $mysqli->query("SELECT id, name FROM study_program");
    
    if (isset($_POST['nim']) && isset($_POST['nama'])) {
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $studyProgram = $_POST['study_program'];
    
        // Insert into the students table
        $insert = $mysqli->query("INSERT INTO students (nim, nama, study_program_id) VALUES ('$nim', '$nama', '$studyProgram')");
    
        if ($insert) {
            $_SESSION['success'] = true;
            $_SESSION['message'] = 'Data Berhasil Ditambahkan';
            header("Location: mahasiswa.php");
            exit();
        }
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tambah Mahasiswa</title>
    
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    </head>
    <body>
        <div class="container">
            <h1 class="text-center">Form Tambah Mahasiswa</h1>
    
            <form method="POST">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
                </div>
                <div class="mb-3">
                    <label for="study_program" class="form-label">Program Studi</label>
                    <select class="form-select" id="study_program" name="study_program" required>
                        <option value="">Pilih Program Studi</option>
                        <?php while ($row = $studyPrograms->fetch_assoc()) { ?>
                            <option value="<?= $row['id']; ?>">
                                <?= $row['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="mahasiswa.php" class="btn btn-warning">Cancel</a>
                </div>
            </form>
        </div>
    </body>
    </html>
    