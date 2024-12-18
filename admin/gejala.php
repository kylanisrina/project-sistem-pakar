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
    <title>Gejala | Admin</title>
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
            background: #f4f7fe;
        }

        /* Konten Utama */
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

        /* Kartu Data */
        .kartu {
            background: var(--putih);
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
            background: linear-gradient(120deg,transparent,rgba(255, 255, 255, 0.3),transparent );
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
            font-weight: 500;
        }

        .tabel td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .tabel tr:hover {
            background: #f8f9fc;
        }

        .aksi {
            display: flex;
            gap: 8px;
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

     <!-- Konten -->
     <main class="konten">
        <!-- Header -->
        <div class="header">
            <div class="judul">
                <div class="judul-icon">
                <i class="icon-png"><img src="images/gejala.png" class="icon" alt="Icon Gejala"></i>
                </div>
                Data Gejala
            </div>
            <div>Overview</div>
        </div>

        <!-- Kartu Data -->
        <div class="kartu">
            <div class="tools">
                <form method="get">
                    <input type="hidden" name="m" value="gejala" />
                    <input class="pencarian" type="text" placeholder="Cari gejala..." 
                           name="q" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>" />
                </form>
                <a href="gejala_tambah.php" class="btn-primary">
                    Tambah Data
                </a>
            </div>

            <table class="tabel">
                <thead>
                    <tr>
                        <th>Kode Gejala</th>
                        <th>Nama Gejala</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = isset($_GET['q']) ? esc_field($_GET['q']) : '';
                    
                    $rows = $db->get_results("SELECT * FROM tb_gejala 
                        WHERE kode_gejala LIKE '%$q%' OR nama_gejala LIKE '%$q%'  
                        ORDER BY kode_gejala");

                    if ($rows) :
                        foreach ($rows as $row) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row->kode_gejala) ?></td>
                                <td><?= htmlspecialchars($row->nama_gejala) ?></td>
                                <td class="aksi">
                                    <a href="gejala_ubah.php?ID=<?= urlencode($row->kode_gejala) ?>">
                                       <img src="images/edit.png" width="30" height="25" style="margin-top: 18px;" alt="Edit">
                                    </a>
                                    <a href="aksi.php?act=gejala_hapus&ID=<?= urlencode($row->kode_gejala) ?>" 
                                       onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')">
                                       <img src="images/hapus.png" width="22" height="25" style="margin-top: 18px;" alt="Hapus">
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach;
                    else : ?>
                        <tr>
                            <td colspan="3" style="text-align: center;">Tidak ada data ditemukan.</td>
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
    </script>
  
</body>
</html>