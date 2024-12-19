<?php
session_start();
include '../functions.php';

// Cek apakah ada data POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: konsultasi.php");
    exit;
}

// Ambil data dari form
$nama = htmlspecialchars($_POST['nama'] ?? '');
$jk = htmlspecialchars($_POST['jk'] ?? '');
$umur = htmlspecialchars($_POST['umur'] ?? '');
$alamat = htmlspecialchars($_POST['alamat'] ?? '');
$selected_gejala = isset($_POST['gejala']) ? $_POST['gejala'] : [];

// Validasi data
if (empty($nama) || empty($jk) || empty($umur) || empty($alamat)) {
    echo "<script>alert('Isikan nama, jenis kelamin, umur, dan alamat!'); window.location.href='konsultasi.php';</script>";
    exit;
} 

if (empty($selected_gejala)) {
    echo "<script>alert('Belum ada gejala yang dipilih!'); window.location.href='konsultasi.php';</script>";
    exit;
}

// Simpan ke database
$gejala_implode = implode(',', $selected_gejala);
$query = "INSERT INTO tb_identitas (nama, jk, umur, alamat, gejala) 
          VALUES ('$nama', '$jk', '$umur', '$alamat', '$gejala_implode')";

if (!$db->query($query)) {
    echo "<script>alert('Terjadi kesalahan saat menyimpan data!'); window.location.href='konsultasi.php';</script>";
    exit;
}

// Simpan ke session untuk keperluan cetak
$_SESSION['data'] = [
    'nama' => $nama,
    'jk' => $jk,
    'umur' => $umur,
    'alamat' => $alamat,
    'gejala' => $selected_gejala,
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa - MedicMate</title>
    <style>
        /* Root Variables */
        :root {
            --primary: #16423C;
            --secondary: #6A9C89;
            --tertiary: #C4DAD2;
            --light: #E9EFEC;
            --gray: #636e72;
            --border: #dfe6e9;
            --white: #ffffff;
        }

        /* Layout Components */
        body {
            background-color: #f4f7fe;
            margin: 0;
            padding: 0;
            font-family: system-ui, -apple-system, sans-serif;
        }

        /* Topbar Styles */
        .topbar {
            background: var(--white);
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
            height: 60px;
            margin-left: 40px;
        }

        /* User Interface Components */
        .user-dropdown {
            position: relative;
            cursor: pointer;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .user-info:hover {
            background: var(--light);
        }

        .user-foto,
        .user-img {
            border-radius: 50%;
            object-fit: cover;
        }

        .user-foto {
            width: 40px;
            height: 40px;
        }

        .user-img {
            width: 80px;
            height: 80px;
        }

        .user-name {
            color: #333;
            font-weight: 500;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            width: 200px;
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 10px;
            margin-top: 10px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s;
        }

        .dropdown-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .dropdown-item:hover {
            background: var(--light);
        }

        /* Sidebar Styles */
        .sidebar {
            background: #0d636e;
            width: 220px;
            height: 100vh;
            position: fixed;
            top: 70px;
            left: 0;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .menu-list {
            list-style: none;
            margin-top: 20px;
        }

        .menu-item {
            margin-bottom: 8px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            text-decoration: none;
            color: var(--white);
            border-radius: 8px;
            transition: all 0.3s;
        }

        .menu-link:hover {
            background: #2C9582;
        }

        .icon {
            width: 24px;
            height: auto;
        }

        /* Hasil Diagnosa Container */
        .hasil-diagnosa {
            background: var(--white);
            border-radius: 15px;
            padding: 2rem;
            margin-left: 400px;
            margin-top: 140px;
            max-width: 1000px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        /* Diagnosa Header */
        .diagnosa-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--border);
        }

        .header-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--secondary);
        }

        .diagnosa-header h4 {
            color: var(--primary);
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .diagnosa-header p {
            color: var(--gray);
            font-size: 1.1rem;
        }

        /* Box Components */
        .gejala-box,
        .analisa-box,
        .diagnosa-final {
            background: #f8f9fa;
            border-radius: 12px;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .box-header,
        .final-header {
            background: var(--secondary);
            color: var(--white);
            padding: 1rem 1.5rem;
        }

        .box-header h5,
        .final-header h5 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Gejala Styles */
        .gejala-list,
        .analisa-list,
        .final-content {
            padding: 1.5rem;
        }

        .gejala-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: var(--white);
            border-radius: 8px;
            margin-bottom: 0.8rem;
            transition: transform 0.2s ease;
        }

        .gejala-item:hover {
            transform: translateX(5px);
        }

        .gejala-item .nomor {
            background: var(--secondary);
            color: var(--white);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 0.9rem;
        }

        .gejala-nama {
            color: var(--primary);
            font-size: 1.05rem;
        }

        /* Analisa Styles */
        .analisa-item {
            padding: 1.2rem;
            background: var(--white);
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid var(--gray);
            transition: all 0.3s ease;
        }

        .analisa-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .hasil-tertinggi {
            border-left-color: var(--secondary);
            background: #f0f9f6;
        }

        .item-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .diagnosa-detail {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .diagnosa-detail h6 {
            margin: 0;
            color: var(--primary);
            font-size: 1.1rem;
            font-weight: 600;
        }

        .kepercayaan-badge {
            background: var(--light);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .kepercayaan-badge span {
            color: var(--gray);
            margin-right: 0.5rem;
        }

        .kepercayaan-badge strong {
            color: var(--secondary);
            font-size: 1rem;
        }

        /* Diagnosa Final Styles */
        .diagnosa-final {
            border: 2px solid var(--secondary);
        }

        .final-nama {
            font-size: 1.3rem;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .final-solusi {
            color: var(--gray);
            line-height: 1.6;
            background: var(--white);
            padding: 1.2rem;
            border-radius: 8px;
            font-size: 1.05rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: center;
        }

        .btn-ulang,
        .btn-cetak {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-ulang {
            background: var(--light);
            color: var(--primary);
        }

        .btn-cetak {
            background: var(--secondary);
            color: var(--white);
        }

        .btn-ulang:hover,
        .btn-cetak:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* Utility Classes */
        .no-data {
            text-align: center;
            padding: 2rem;
            color: var(--gray);
            font-style: italic;
        }

        /* Print Styles */
        @media print {
            .hasil-diagnosa {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }

            .action-buttons {
                display: none;
            }

            .gejala-item:hover,
            .analisa-item:hover {
                transform: none;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .diagnosa-header h4 {
                font-size: 1.5rem;
            }

            .diagnosa-detail {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.8rem;
            }

            .kepercayaan-badge {
                width: 100%;
                text-align: center;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-ulang,
            .btn-cetak {
                width: 100%;
                justify-content: center;
            }

            .final-nama {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
  <!-- Top Bar -->
  <nav class="topbar">
        <div class="logo-area">
            <img src="images/medicmate_logoo.png" alt="logo" class="logo">
        </div>
        <div class="user-dropdown">
            <div class="user-info">
                <img src="images/minggtg.jpg" alt="profile" class="user-foto">
                <span class="user-name"><?= $_SESSION['login_admin'] ?></span>
            </div>
            <div class="dropdown-menu">
                <a href="../pw_admin.php" class="dropdown-item">
                    Password
                </a>
                <a href="../logout_admin.php?act=logout" class="dropdown-item">
                    Signout
                </a>
            </div>
        </div>
    </nav>

 <!-- Sidebar -->
 <nav class="sidebar">
        <div class="menu-list">
            <div class="menu-item">
                <center>
            <img src="images/minggtg.jpg" alt="profile" class="user-img">
            <p style="color: #fff; margin-top:20px; font-size: 25px; "><?= $_SESSION['login_admin'] ?>   </p>
            </center>
        </div>
            <div class="menu-item">
                <a href="admin_dashboard.php" class="menu-link">
                    <i class="icon-png"><img src="images/home.png" class="icon" alt="Icon Home"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="diagnosa.php" class="menu-link">
                    <i class="icon-png"><img src="images/diagnosa.png" class="icon" alt="Icon Diagnosa"></i>
                    <span>Diagnosa</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="gejala.php" class="menu-link">
                    <i class="icon-png"><img src="images/gejala.png" class="icon" alt="Icon Gejala"></i>
                    <span>Gejala</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="relasi.php" class="menu-link">
                    <i class="icon-png"><img src="images/relasi.png" class="icon" alt="Icon Relasi"></i>
                    <span>Relasi</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="konsultasi.php" class="menu-link">
                    <i class="icon-png"><img src="images/konsultasi.png" class="icon" alt="Icon Konsultasi"></i>
                    <span>Konsultasi</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="hasil-diagnosa">
        <div class="diagnosa-header">
            <div class="header-icon"><img src="../assets/icon-images/logo_medic.png" alt="Logo Medic Mate" width="450" height="120"></div>
            <h4>HASIL DIAGNOSA</h4>
            <p>Hasil analisa berdasarkan gejala yang dipilih</p>
        </div>

        <!-- Gejala Terpilih -->
        <?php
        $gejala = isset($_POST['gejala']) ? (array) $_POST['gejala'] : [];
        $gejala_terpilih = $db->get_results("SELECT * FROM tb_gejala WHERE kode_gejala IN ('" . implode("','", array_map('htmlspecialchars', $gejala)) . "')");
        ?>

        <div class="gejala-box">
            <div class="box-header">
                <h5>Gejala Yang Dipilih</h5>
            </div>
            <div class="gejala-list">
                <?php
                if ($gejala_terpilih) {
                    $no = 1;
                    foreach ($gejala_terpilih as $row) : ?>
                        <div class="gejala-item">
                            <span class="nomor"><?= $no++ ?></span>
                            <span class="gejala-nama"><?= htmlspecialchars($row->nama_gejala) ?></span>
                        </div>
                <?php endforeach;
                } else {
                    echo "<div class='no-data'>Tidak ada gejala yang dipilih</div>";
                }
                ?>
            </div>
        </div>

        <!-- Hasil Analisa -->
        <?php
        if (!empty($gejala)) {
            $diagnosa_rows = $db->get_results("SELECT * 
                FROM tb_relasi r 
                INNER JOIN tb_diagnosa d ON d.kode_diagnosa = r.kode_diagnosa      
                WHERE r.kode_gejala IN ('" . implode("','", array_map('htmlspecialchars', $gejala)) . "') 
                ORDER BY r.kode_diagnosa, r.kode_gejala");

            $diagnosa = [];

            if ($diagnosa_rows) {
                foreach ($diagnosa_rows as $row) {
                    if (!isset($diagnosa[$row->kode_diagnosa])) {
                        $diagnosa[$row->kode_diagnosa] = [
                            'mb' => 0,
                            'md' => 0,
                            'cf' => 0,
                            'nama_diagnosa' => $row->nama_diagnosa,
                            'solusi' => $row->keterangan
                        ];
                    }

                    $diagnosa[$row->kode_diagnosa]['mb'] += $row->mb * (1 - $diagnosa[$row->kode_diagnosa]['mb']);
                    $diagnosa[$row->kode_diagnosa]['md'] += $row->md * (1 - $diagnosa[$row->kode_diagnosa]['md']);
                    $diagnosa[$row->kode_diagnosa]['cf'] = $diagnosa[$row->kode_diagnosa]['mb'] - $diagnosa[$row->kode_diagnosa]['md'];
                }

                function ranking($array)
                {
                    $new_arr = [];
                    foreach ($array as $key => $value) {
                        $new_arr[$key] = $value['cf'];
                    }
                    arsort($new_arr);

                    $result = [];
                    $rank = 1;
                    foreach ($new_arr as $key => $value) {
                        $result[$key] = $rank++;
                    }
                    return $result;
                }

                $rank = ranking($diagnosa);
        ?>

                <div class="analisa-box">
                    <div class="box-header">
                        <h5>Hasil Analisa</h5>
                    </div>
                    <div class="analisa-list">
                        <?php
                        $no = 1;
                        foreach ($rank as $key => $value) :
                            $kepercayaan = $diagnosa[$key]['cf'] * 100;
                            $statusClass = $value == 1 ? 'hasil-tertinggi' : 'hasil-lainnya';
                        ?>
                            <div class="analisa-item <?= $statusClass ?>">
                                <div class="item-content">
                                    <span class="nomor"><?= $no++ ?></span>
                                    <div class="diagnosa-detail">
                                        <h6><?= htmlspecialchars($diagnosa[$key]['nama_diagnosa']) ?></h6>
                                        <div class="kepercayaan-badge">
                                            <span>Tingkat Kepercayaan:</span>
                                            <strong><?= number_format($kepercayaan, 1) ?>%</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Diagnosa Final -->
                <div class="diagnosa-final">
                    <?php $topDiagnosaKey = array_key_first($rank); ?>
                    <div class="final-header">
                        <h5>Diagnosa Akhir</h5>
                    </div>
                    <div class="final-content">
                        <div class="final-nama">
                            <?= htmlspecialchars($diagnosa[$topDiagnosaKey]['nama_diagnosa']) ?>
                        </div>
                        <div class="final-solusi">
                            <?= htmlspecialchars($diagnosa[$topDiagnosaKey]['solusi']) ?>
                        </div>
                    </div>
                </div>

        <?php
            } else {
                echo "<div class='no-data'>Tidak ditemukan diagnosa yang sesuai</div>";
            }
        }
        ?>

        <!-- Tombol Aksi -->
        <div class="action-buttons">
            <a href="konsultasi.php" class="btn-ulang">
                <span>🔄</span> Diagnosa Ulang
            </a>
            <a href="cetak.php?m=konsultasi" target="_blank" class="btn-cetak">
                <span>🖨️</span> Cetak Hasil
            </a>
        </div>
    </div>

</body>

</html>