<?php include "../functions.php"; ?>
<?php
if (!isset($_SESSION['login_admin'])) {
    header("location:login_admin.php");
    exit;
}

$success = false;
$notification = '';

if ($_POST) {
    $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $jk = isset($_POST['jk']) ? trim($_POST['jk']) : '';
    $umur = isset($_POST['umur']) ? trim($_POST['umur']) : '';
    $alamat = isset($_POST['alamat']) ? trim($_POST['alamat']) : '';
    $selected = isset($_POST['gejala']) ? (array) $_POST['gejala'] : [];

    if ($nama == '' || $jk == '' || $umur == '' || $alamat == '') {
        $notification = '<div class="alert alert-error">
            <div class="alert-content">
                <i class="mdi mdi-alert-circle alert-icon"></i>
                <div>Isikan nama, jenis kelamin, umur dan alamat!</div>
            </div>
        </div>';
    } else if (empty($selected)) {
        $notification = '<div class="alert alert-error">
            <div class="alert-content">
                <i class="mdi mdi-alert-circle alert-icon"></i>
                <div>Belum ada gejala yang dipilih!</div>
            </div>
        </div>';
    } else {
        // Sanitasi gejala dan gabungkan menjadi string
        $gejala_sanitized = array_map('esc_field', $selected);
        $gejala_implode = implode(',', $gejala_sanitized);
        
        // Sanitasi input menggunakan fungsi yang sudah ada
        $nama = esc_field($nama);
        $jk = esc_field($jk);
        $umur = esc_field($umur);
        $alamat = esc_field($alamat);
        
        // Query untuk menyimpan ke database
        $query = "INSERT INTO tb_identitas (nama, jk, umur, alamat, gejala) 
                 VALUES ('$nama', '$jk', '$umur', '$alamat', '$gejala_implode')";
        
        if ($db->query($query)) {
            $success = true;
            $_SESSION['data'] = $_POST;
            $notification = '<div class="alert alert-success">
                <div class="alert-content">
                    <i class="mdi mdi-check-circle alert-icon"></i>
                    <div>Data berhasil disimpan!</div>
                </div>
            </div>';
        } else {
            $notification = '<div class="alert alert-error">
                <div class="alert-content">
                    <i class="mdi mdi-alert-circle alert-icon"></i>
                    <div>Gagal menyimpan data ke database!</div>
                </div>
            </div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konsultasi | Admin</title>
    <link rel="shortcut icon" href="images/icon_admin.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/4.0.0/font/MaterialIcons-Regular.ttf">
    <style>
        /* Reset & Root */        
        * {            
            margin: 0;            
            padding: 0;            
            box-sizing: border-box;            
            font-family: 'Segoe UI', sans-serif;        
        }        
        
        :root {            
            --primer: #4e73df;            
            --sekunder: #858796;            
            --merah: #e74a3b;            
            --kuning: #f6c23e;            
            --putih: #ffffff;            
            --abu: #f4f7fe;            
            --hijau: #28a745;        
        }        
        
        body {            
            background: #f4f7fe;        
        }        
        
        /* Navbar */        
        .navbar {            
            background: #fff;            
            padding: 15px 30px;            
            display: flex;            
            justify-content: space-between;            
            align-items: center;            
            position: fixed;            
            top: 0;            
            left: 0;            
            right: 0;            
            z-index: 100;            
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);        
        }        
        
        .logo-area {            
            display: flex;            
            align-items: center;            
            gap: 20px;        
        }        
        
        .logo {            
            height: 40px;        
        }        
        
        /* Konten */        
        .konten {            
            margin-left: 250px;            
            margin-top: 70px;            
            padding: 30px;        
        }        
        
        /* Header */        
        .header {            
            background: #fff;            
            padding: 20px;            
            border-radius: 10px;            
            margin-bottom: 30px; 
            margin-top: 20px;           
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);            
            display: flex;            
            justify-content: space-between;            
            align-items: center;        
        }        
        
        .judul {            
            display: flex;            
            align-items: center;            
            gap: 10px;            
            font-size: 20px;        
        }        
        
        .judul-icon {            
            background: #0d636e;            
            color: #fff;            
            width: 40px;            
            height: 40px;            
            border-radius: 8px;            
            display: grid;            
            place-items: center;        
        }        
        
        /* Form Konsultasi */        
        .kartu {            
            background: #fff;            
            border-radius: 10px;            
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);            
            padding: 25px;            
            margin-bottom: 20px;        
        }        
        
        .form-judul {            
            font-size: 18px;            
            margin-bottom: 20px;            
            color: #333;        
        }        
        
        .form-group {            
            margin-bottom: 20px;        
        }        
        
        .form-label {            
            display: block;            
            margin-bottom: 8px;            
            color: #333;            
            font-weight: 500;        
        }        
        
        .wajib {            
            color: var(--merah);            
            margin-left: 4px;        
        }        
        
        .form-input {            
            width: 100%;            
            padding: 10px 15px;            
            border: 1px solid #ddd;            
            border-radius: 8px;            
            font-size: 14px;            
            transition: all 0.3s;        
        }        
        
        .form-input:focus {            
            outline: none;            
            border-color: var(--primer);            
            box-shadow: 0 0 0 3px rgba(78,115,223,0.1);        
        }        
        
        .form-select {            
            width: 100%;            
            padding: 10px 15px;            
            border: 1px solid #ddd;            
            border-radius: 8px;            
            font-size: 14px;            
            background: white;        
        }        
        
        /* Tabel Gejala */        
        .tabel {            
            width: 100%;            
            border-collapse: collapse;            
            margin-top: 20px;        
        }        
        
        .tabel th {            
            background: #f8f9fc;            
            padding: 15px;            
            text-align: left;            
            font-weight: 600;        
        }        
        
        .tabel td {            
            padding: 12px 15px;            
            border-bottom: 1px solid #eee;        
        }        
        
        .tabel tr:hover {            
            background: #f8f9fc;        
        }        
        
        .checkbox-custom {            
            width: 18px;            
            height: 18px;            
            border-radius: 4px;            
            cursor: pointer;        
        }        
        
        .tombol {            
            padding: 12px 25px;            
            border: none;            
            border-radius: 8px;            
            font-size: 14px;            
            font-weight: 500;            
            cursor: pointer;            
            display: inline-flex;            
            align-items: center;            
            gap: 8px;            
            transition: all 0.3s;        
        }        
        
        .tombol-primer {            
            background: var(--primer);            
            color: #fff;        
        }        
        
        .tombol-primer:hover {            
            transform: translateY(-2px);            
            box-shadow: 0 4px 12px rgba(78,115,223,0.2);        
        }

        .btn-primary {
            display: inline-block;
            background: linear-gradient(45deg, #16423C, #6A9C89);
            color: #fff;
            border: 0;
            padding: 1.2rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1rem;
            transition: all 0.4s ease;
            box-shadow: 0 5px 15px rgba(22, 66, 60, 0.2);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg,transparent,rgba(255, 255, 255, 0.3),transparent);
            transition: 0.5s;
            }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(22, 66, 60, 0.3);
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        /* Alert Notifications */
        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: slideDown 0.4s ease-out;
        }

        .alert-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-icon {
            font-size: 24px;
        }

        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.2);
            color: var(--hijau);
        }

        .alert-error {
            background-color: rgba(231, 74, 59, 0.1);
            border: 1px solid rgba(231, 74, 59, 0.2);
            color: var(--merah);
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(-20px);
                opacity: 0;
            }
        }
        
        /* Responsive */        
        @media (max-width: 768px) {            
            .sidebar {                
                transform: translateX(-100%);            
            }            
            .konten {                
                margin-left: 0;            
            }            
            .form-grid {                
                grid-template-columns: 1fr;            
            }        
        }
    </style>
</head>
<body>
<?php require "sidebar-navbar/navbar.php"; ?>
    <?php require "sidebar-navbar/sidebar.php"; ?>

<!-- Konten -->
<main class="konten">
            <!-- Header -->
            <div class="header">
                <div class="judul">
                    <div class="judul-icon">
                        <i class="icon-png"><img src="images/konsultasi.png" class="icon" alt="Icon Konsultasi"></i>
                    </div>
                    Konsultasi
                </div>
                <div>Overview</div>
            </div>

            <!-- Notifikasi -->
            <?php if ($notification): ?>
                <div id="notification">
                    <?= $notification ?>
                </div>
            <?php endif; ?>

            <!-- Form Konsultasi -->
            <div class="kartu">
                <h5 class="form-judul">Isi Biodata Dan Pilih Gejala yang dirasakan :</h5>
                <form method="post" action="konsultasi_hasil.php">
                    <!-- Biodata -->
                    <div style="max-width: 500px;">
                        <div class="form-group">
                            <label class="form-label">
                                Nama
                                <span class="wajib">*</span>
                            </label>
                            <input type="text" name="nama" class="form-input" 
                                   value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Jenis Kelamin
                                <span class="wajib">*</span>
                            </label>
                            <select name="jk" class="form-select">
                                <option value="">&nbsp;</option>
                                <?= get_jk_option(isset($_POST['jk']) ? $_POST['jk'] : '') ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Umur
                                <span class="wajib">*</span>
                            </label>
                            <input type="text" name="umur" class="form-input" 
                                   value="<?= isset($_POST['umur']) ? htmlspecialchars($_POST['umur']) : '' ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Alamat
                                <span class="wajib">*</span>
                            </label>
                            <input type="text" name="alamat" class="form-input" 
                                   value="<?= isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : '' ?>">
                        </div>
                    </div>

                    <!-- Tabel Gejala -->
                    <table class="tabel">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" class="checkbox-custom" id="checkAll">
                                </th>
                                <th width="50">No</th>
                                <th>Nama Gejala</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q = isset($_GET['q']) ? esc_field($_GET['q']) : '';
                            $rows = $db->get_results("SELECT * FROM tb_gejala 
                                WHERE kode_gejala LIKE '%$q%' OR nama_gejala LIKE '%$q%'
                                ORDER BY kode_gejala");
                            $no = 1;
                            foreach ($rows as $row) : ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="gejala[]" class="checkbox-custom"
                                               value="<?= htmlspecialchars($row->kode_gejala) ?>">
                                    </td>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row->nama_gejala) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div style="margin-top: 30px;">
                        <button type="submit" class="btn-primary">
                            Submit Diagnosa
                        </button>
                    </div>
                </form>
            </div>

            
        </main>
    </div>

    <script>
        // Dropdown functionality
        document.querySelector('.user-dropdown').addEventListener('click', function() {
            this.querySelector('.dropdown-menu').classList.toggle('active');
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-dropdown')) {
                document.querySelector('.dropdown-menu').classList.remove('active');
            }
        });

        // Check All Checkboxes
        document.getElementById('checkAll')?.addEventListener('click', function() {
            let checkboxes = document.querySelectorAll('input[name="gejala[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Form Validation
        document.querySelector('form')?.addEventListener('submit', function(e) {
            let nama = document.querySelector('input[name="nama"]').value;
            let jk = document.querySelector('select[name="jk"]').value;
            let umur = document.querySelector('input[name="umur"]').value;
            let alamat = document.querySelector('input[name="alamat"]').value;
            let gejala = document.querySelectorAll('input[name="gejala[]"]:checked');

            if (!nama || !jk || !umur || !alamat) {
                e.preventDefault();
                alert('Mohon lengkapi semua data biodata!');
            } else if (gejala.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu gejala!');
            }
        });

        // Hover Effects
        const tableRows = document.querySelectorAll('.tabel tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseover', function() {
                this.style.transition = 'all 0.3s';
                this.style.transform = 'translateX(5px)';
            });
            row.addEventListener('mouseout', function() {
                this.style.transform = 'translateX(0)';
            });
        });

        // Notification auto-hide
        const notification = document.getElementById('notification');
        if (notification) {
            setTimeout(() => {
                notification.style.animation = 'slideUp 0.4s ease-out forwards';
                setTimeout(() => {
                    notification.remove();
                }, 400);
            }, 5000); // Hide after 5 seconds
        }
    </script>

</body>
</html>