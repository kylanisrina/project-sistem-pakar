<?php include "../functions.php"; ?>
<?php
if (!isset($_SESSION['login_admin'])) {
    header("location:login_admin.php");
    exit;
}

// Handle form submission
if (isset($_POST['gejala_tambah'])) {
    $kode = isset($_POST['kode']) ? trim($_POST['kode']) : '';
    $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';

    if (empty($kode) || empty($nama)) {
        $error = "Field bertanda * tidak boleh kosong!";
    } elseif ($db->get_results("SELECT * FROM tb_gejala WHERE kode_gejala='$kode'")) {
        $error = "Kode sudah ada!";
    } else {
        $db->query("INSERT INTO tb_gejala (kode_gejala, nama_gejala) VALUES ('$kode', '$nama')");
        header("Location: gejala.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Gejala | Admin</title>
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

        /* Form */
        .kartu {
            background: #fff;
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
                <i class="icon-png"><img src="images/gejala.png" class="icon" alt="Icon Gejala"></i>   
                </div>
                Tambah Gejala
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
                        Kode Gejala
                        <span class="wajib">*</span>
                    </label>
                    <input type="text" name="kode" class="form-input"
                           value="<?= isset($_POST['kode']) ? htmlspecialchars($_POST['kode']) : '' ?>"
                           placeholder="Masukkan kode gejala">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Nama Gejala
                        <span class="wajib">*</span>
                    </label>
                    <input type="text" name="nama" class="form-input"
                           value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>"
                           placeholder="Masukkan nama gejala">
                </div>

                <div class="tombol-grup">
                    <button type="submit" name="gejala_tambah" class="tombol tombol-primer">
                        Simpan
                    </button>
                    <a href="gejala.php" class="tombol tombol-danger">
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
            let kode = document.querySelector('input[name="kode"]').value;
            let nama = document.querySelector('input[name="nama"]').value;

            if (!kode || !nama) {
                e.preventDefault();
                alert('Mohon lengkapi field yang bertanda *');
            }
        });
    </script>
</body>
</html>