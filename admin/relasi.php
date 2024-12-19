<?php include "../functions.php"; ?>
<?php
if (!isset($_SESSION['login_admin'])) {
    header("location:login_admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relasi | Admin</title>
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

        

        /* Konten Utama */
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

        /* Kartu Data */
        .kartu {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            padding: 20px;
        }

        /* Form Pencarian */
        .tools {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 10px;
        }

        .pencarian {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 300px;
            transition: all 0.3s;
        }

        .pencarian:focus {
            outline: none;
            border-color: var(--primer);
            box-shadow: 0 0 0 3px rgba(78,115,223,0.1);
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

        /* Tabel */
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
            color: #333;
        }

        .tabel td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .tabel tr:hover {
            background: #f8f9fc;
        }

        .kolom-aksi {
            display: flex;
            gap: 8px;
        }

        .tombol-edit {
            background: #16423C;
            padding: 8px 12px;
            border-radius: 6px;
            color: #000;
        }

        .tombol-hapus {
            background: var(--merah);
            padding: 8px 12px;
            border-radius: 6px;
            color: #fff;
        }

        .tombol-edit:hover,
        .tombol-hapus:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .konten {
                margin-left: 0;
            }

            .tools {
                flex-direction: column;
            }

            .pencarian {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<?php require "sidebar-navbar/navbar.php"; ?>
    <?php require "sidebar-navbar/sidebar.php"; ?>

        <!-- Konten Utama -->
    <main class="konten">
        <!-- Header -->
        <div class="header">
            <div class="judul">
                <div class="judul-icon">
                <i class="icon-png"><img src="images/relasi.png" class="icon" alt="Icon Relasi"></i>
                </div>
                Data Relasi
            </div>
            <div>Overview</div>
        </div>

        <!-- Kartu Data -->
        <div class="kartu">
            <div class="tools">
                <form method="get" >
                    <input type="hidden" name="m" value="relasi" />
                    <input class="pencarian" type="text" placeholder="Cari relasi..." 
                           name="q" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>" />
                </form>
                <a href="relasi_tambah.php" class="btn-primary">
                    Tambah Data
                </a>
            </div>

            <table class="tabel">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Diagnosa</th>
                        <th>Gejala</th>
                        <th>MB</th>
                        <th>MD</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = isset($_GET['q']) ? esc_field($_GET['q']) : '';
                    
                    $rows = $db->get_results("SELECT r.ID, r.kode_gejala, d.kode_diagnosa, r.mb, r.md, 
                        g.nama_gejala, d.nama_diagnosa 
                        FROM tb_relasi r 
                        INNER JOIN tb_diagnosa d ON d.`kode_diagnosa` = r.`kode_diagnosa` 
                        INNER JOIN tb_gejala g ON g.`kode_gejala` = r.`kode_gejala`
                        WHERE r.kode_gejala LIKE '%$q%'
                        OR r.kode_diagnosa LIKE '%$q%'
                        OR g.nama_gejala LIKE '%$q%'
                        OR d.nama_diagnosa LIKE '%$q%' 
                        ORDER BY r.kode_diagnosa, r.kode_gejala");
                    
                    if ($rows) :
                        $no = 0;
                        foreach ($rows as $row) : ?>
                            <tr>
                                <td><?= ++$no ?></td>
                                <td>[<?= htmlspecialchars($row->kode_diagnosa) ?>] 
                                    <?= htmlspecialchars($row->nama_diagnosa) ?></td>
                                <td>[<?= htmlspecialchars($row->kode_gejala) ?>] 
                                    <?= htmlspecialchars($row->nama_gejala) ?></td>
                                <td><?= htmlspecialchars($row->mb) ?></td>
                                <td><?= htmlspecialchars($row->md) ?></td>
                                <td class="kolom-aksi">
                                    <a href="relasi_ubah.php?ID=<?= htmlspecialchars($row->ID) ?>">
                                       <img src="images/edit.png" width="30" height="25" style="margin-top: 18px;" alt="Edit">
                                       </a>
                                    <a href="aksi.php?act=relasi_hapus&ID=<?= htmlspecialchars($row->ID) ?>" 
                                    onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')">
                                       <img src="images/hapus.png" width="22" height="25" style="margin-top: 18px;" alt="Hapus">
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach;
                    else : ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Tidak ada data ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

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

        // Table Row Hover Effect
        const tableRows = document.querySelectorAll('.tabel tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseover', function() {
                this.style.transform = 'translateX(5px)';
                this.style.transition = 'all 0.3s';
            });
            row.addEventListener('mouseout', function() {
                this.style.transform = 'translateX(0)';
            });
        });

        // Search Input Animation
        const searchInput = document.querySelector('.pencarian');
        searchInput.addEventListener('focus', function() {
            this.style.width = '350px';
        });
        searchInput.addEventListener('blur', function() {
            this.style.width = '300px';
        });

        // Button Hover Animation
        const buttons = document.querySelectorAll('.tombol');
        buttons.forEach(button => {
            button.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-2px)';
            });
            button.addEventListener('mouseout', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>

</body>
</html>