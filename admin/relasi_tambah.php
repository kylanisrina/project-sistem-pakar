<?php include "../functions.php"; ?>
<?php
if (!isset($_SESSION['login_admin'])) {
    header("location:login_admin.php");
    exit;
}

// Handle form submission
if (isset($_POST['relasi_tambah'])) {
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $kode_diagnosa = isset($_POST['kode_diagnosa']) ? $_POST['kode_diagnosa'] : '';
    $kode_gejala = isset($_POST['kode_gejala']) ? $_POST['kode_gejala'] : '';
    $mb = isset($_POST['mb']) ? trim($_POST['mb']) : '';
    $md = isset($_POST['md']) ? trim($_POST['md']) : '';

    // Validasi input
    if (empty($kode_diagnosa) || empty($kode_gejala) || empty($mb) || empty($md)) {
        $error = "Field bertanda * tidak boleh kosong!";
    } else {
        // Cek kombinasi
        $kombinasi_ada = $db->get_row("SELECT * FROM tb_relasi WHERE kode_diagnosa='$kode_diagnosa' AND kode_gejala='$kode_gejala'");
        if ($kombinasi_ada) {
            $error = "Kombinasi diagnosa dan gejala sudah ada!";
        } else {
            // Insert data
            $db->query("INSERT INTO tb_relasi (id, kode_diagnosa, kode_gejala, mb, md) VALUES ('$id', '$kode_diagnosa', '$kode_gejala', '$mb', '$md')");
            header("Location: relasi.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Relasi | Admin</title>
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
            --putih: #ffffff;
            --abu: #f4f7fe;
        }

        body {
            background: var(--abu);
        }

        

        /* Konten */
        .konten {
            margin-left: 250px;
            margin-top: 70px;
            padding: 30px;
        }

        /* Header */
        .header {
            background: var(--putih);
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
            color: var(--putih);
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: grid;
            place-items: center;
        }

        /* Form */
        .kartu {
            background: var(--putih);
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
            max-width: 500px;
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
            cursor: pointer;
        }

        .form-select:focus {
            outline: none;
            border-color: var(--primer);
            box-shadow: 0 0 0 3px rgba(78,115,223,0.1);
        }

        .error-msg {
            color: var(--merah);
            margin-top: 5px;
            font-size: 14px;
        }

        .tombol-grup {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .tombol {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            text-decoration: none;
            transition: all 0.4s ease;
            box-shadow: 0 5px 15px rgba(22, 66, 60, 0.2);
            position: relative;
            overflow: hidden;
        }

        .tombol-primer {
            background: linear-gradient(45deg, #16423C, #6A9C89);
            color: #fff;
        }
        
        .tombol-primer::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg,transparent,rgba(255, 255, 255, 0.3),transparent);
            transition: 0.5s;
        }

        .tombol-primer:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(22, 66, 60, 0.3);
        }

        .tombol-primer:hover::before {
            left: 100%;
        }

        .tombol-danger {
            text-decoration: none;
            background: linear-gradient(45deg, #6A9C89, #16423C);
            color: #fff;
        }

        .tombol-danger::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg,transparent,rgba(255, 255, 255, 0.3),transparent);
            transition: 0.5s;
        }

        .tombol-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(22, 66, 60, 0.3);
        }

        .tombol-danger:hover::before {
            left: 100%;
        }

        .tombol:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .konten {
                margin-left: 0;
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
                     <i class="icon-png"><img src="images/relasi.png" class="icon" alt="Icon Relasi"></i>   
                </div>
                Tambah Relasi
            </div>
            <div>Overview</div>
        </div>

        <!-- Form -->
        <div class="kartu">
            <?php if (isset($error)): ?>
                <div class="error-msg"><?= $error ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label class="form-label">
                        ID
                        <span class="wajib">*</span>
                    </label>
                    <input type="text" name="id" class="form-input" 
                           value="<?= isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '' ?>"
                           placeholder="Masukkan ID">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Diagnosa
                        <span class="wajib">*</span>
                    </label>
                    <select name="kode_diagnosa" class="form-select">
                        <option value="">Pilih Diagnosa</option>
                        <?= get_diagnosa_option(isset($_POST['kode_diagnosa']) ? $_POST['kode_diagnosa'] : '') ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Gejala
                        <span class="wajib">*</span>
                    </label>
                    <select name="kode_gejala" class="form-select">
                        <option value="">Pilih Gejala</option>
                        <?= get_gejala_option(isset($_POST['kode_gejala']) ? $_POST['kode_gejala'] : '') ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        MB
                        <span class="wajib">*</span>
                    </label>
                    <input type="text" name="mb" class="form-input"
                           value="<?= isset($_POST['mb']) ? htmlspecialchars($_POST['mb']) : '' ?>"
                           placeholder="Masukkan nilai MB">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        MD
                        <span class="wajib">*</span>
                    </label>
                    <input type="text" name="md" class="form-input"
                           value="<?= isset($_POST['md']) ? htmlspecialchars($_POST['md']) : '' ?>"
                           placeholder="Masukkan nilai MD">
                </div>

                <div class="tombol-grup">
                    <button type="submit" name="relasi_tambah" class="tombol tombol-primer">
                        Simpan
                    </button>
                    <a href="relasi.php" class="tombol tombol-danger">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Dropdown Menu
        document.querySelector('.user-menu').addEventListener('click', function() {
            this.querySelector('.dropdown').classList.toggle('aktif');
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-menu')) {
                document.querySelector('.dropdown').classList.remove('aktif');
            }
        });

        // Form Validation
        document.querySelector('form').addEventListener('submit', function(e) {
            let id = document.querySelector('input[name="id"]').value;
            let diagnosa = document.querySelector('select[name="kode_diagnosa"]').value;
            let gejala = document.querySelector('select[name="kode_gejala"]').value;
            let mb = document.querySelector('input[name="mb"]').value;
            let md = document.querySelector('input[name="md"]').value;

            if (!id || !diagnosa || !gejala || !mb || !md) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang bertanda *');
            }

            // Validasi MB dan MD harus angka
            if (isNaN(mb) || isNaN(md)) {
                e.preventDefault();
                alert('MB dan MD harus berupa angka');
            }
        });

        // Select Enhancement
        const selects = document.querySelectorAll('.form-select');
        selects.forEach(select => {
            select.addEventListener('change', function() {
                if (this.value) {
                    this.style.borderColor = 'var(--primer)';
                } else {
                    this.style.borderColor = '#ddd';
                }
            });
        });

        // Input Enhancement
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>