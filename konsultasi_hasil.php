<?php
session_start();
include 'functions.php';

// Cek apakah ada data POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: konsultasi_medic.php");
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
    echo "<script>alert('Isikan nama, jenis kelamin, umur, dan alamat!'); window.location.href='konsultasi_medic.php';</script>";
    exit;
} 

if (empty($selected_gejala)) {
    echo "<script>alert('Belum ada gejala yang dipilih!'); window.location.href='konsultasi_medic.php';</script>";
    exit;
}

// Simpan ke database
$gejala_implode = implode(',', $selected_gejala);
$query = "INSERT INTO tb_identitas (nama, jk, umur, alamat, gejala) 
          VALUES ('$nama', '$jk', '$umur', '$alamat', '$gejala_implode')";

if (!$db->query($query)) {
    echo "<script>alert('Terjadi kesalahan saat menyimpan data!'); window.location.href='konsultasi_medic.php';</script>";
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
            --dark: #2C3E50;
            --spacing: 6rem;
            --section-padding: 120px;
            --gray: #636e72;
            --border: #dfe6e9;
        }

        /* Reset and Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--light) 0%, #ffffff 50%, var(--light) 100%);
            color: var(--dark);
            line-height: 1.8;
            padding-top: 80px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 4rem;
        }

        /* Navbar Styles */
        .navbar {
            background-color: rgba(44, 62, 80, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;

        }

        .navbar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--light);
        }

        .logo-icon {
            width: 220px;
            margin-right: 15px;
            transition: transform 0.3s ease;
        }

        .logo-icon:hover {
            transform: scale(1.05);
        }

        .navbar-nav {
            display: flex;
            gap: 3rem;
            list-style: none;
        }

        .nav-item {
            position: relative;
            z-index: 1;
        }

        .nav-link {
            color: var(--light);
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.7rem 1.2rem;
            transition: all 0.4s ease;
            border-radius: 8px;
            display: block;
        }

        .nav-link[href="konsultasi_medic.php"] {
            margin-right: 1rem;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--secondary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover {
            color: var(--tertiary);
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .btn-login {
            background-color: var(--secondary);
            color: var(--light);
            padding: 0.7rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.4s ease;
            font-weight: 500;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 2;
            margin-left: 0.5rem;
            display: inline-block;
        }

        .btn-login:hover {
            background-color: var(--tertiary);
            color: var(--dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(106, 156, 137, 0.4);
        }

        /* Footer Styles - Same as previous design */
        .footer {
            background: linear-gradient(135deg, var(--dark) 0%, #1a2634 100%);
            color: var(--light);
            padding: 4rem 0 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--tertiary));
        }

        .footer-content {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-brand {
            max-width: 350px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .footer-logo img {
            max-width: 100%;
            height: auto;
        }

        .footer-description {
            color: var(--tertiary);
            font-size: 0.95rem;
            line-height: 1.6;
            opacity: 0.9;
        }

        .footer-links h4,
        .footer-contact h4 {
            color: var(--light);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            position: relative;
        }

        .footer-links h4::after,
        .footer-contact h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--secondary);
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links ul li {
            margin-bottom: 0.75rem;
        }

        .footer-links ul li a {
            color: var(--tertiary);
            text-decoration: none;
            font-size: 0.95rem;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .footer-links ul li a:hover {
            color: var(--light);
            transform: translateX(5px);
        }

        .footer-contact p {
            color: var(--tertiary);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-bottom p {
            color: var(--tertiary);
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .consultation-wrapper {
                grid-template-columns: 1fr;
            }

            .consultation-image {
                max-width: 600px;
                margin: 0 auto;
            }

            .footer-content {
                grid-template-columns: 1fr 1fr;
            }

            .footer-brand {
                grid-column: span 2;
                max-width: none;
                text-align: center;
            }

            .footer-logo {
                justify-content: center;
            }
        }

        @media (max-width: 992px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-brand {
                grid-column: auto;
            }

            .footer-links h4::after,
            .footer-contact h4::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .footer-links ul li a {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1.5rem;
            }

            .consultation-content {
                padding: 2rem;
            }

            .consultation-title {
                font-size: 1.8rem;
            }

            .form-input {
                padding: 0.875rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 0 1rem;
            }

            .consultation-content {
                padding: 1.5rem;
            }

            .symptoms-table th,
            .symptoms-table td {
                padding: 1rem;
                font-size: 0.9rem;
            }
        }

        .btn-login {
            background-color: var(--secondary);
            color: var(--light);
            padding: 0.7rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.4s ease;
            font-weight: 500;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 2;
            margin-left: 0.5rem;
            display: inline-block;
        }

        .btn-login:hover {
            background-color: var(--tertiary);
            color: var(--dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(106, 156, 137, 0.4);
        }

        /* Hasil Diagnosa Container */
        .hasil-diagnosa {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem auto;
            max-width: 1000px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Header Styles */
        .diagnosa-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #eee;
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

        /* Box Styles */
        .gejala-box,
        .analisa-box,
        .diagnosa-final {
            background: #f8f9fa;
            border-radius: 12px;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .box-header {
            background: var(--secondary);
            color: white;
            padding: 1rem 1.5rem;
        }

        .box-header h5 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Gejala List Styles */
        .gejala-list {
            padding: 1.5rem;
        }

        .gejala-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            margin-bottom: 0.8rem;
            transition: transform 0.2s ease;
        }

        .gejala-item:hover {
            transform: translateX(5px);
        }

        .gejala-item .nomor {
            background: var(--secondary);
            color: white;
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

    

        /* Analisa List Styles */
        .analisa-list {
            padding: 1.5rem;
        }

        .analisa-item {
            padding: 1.2rem;
            background: white;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid var(--gray);
            transition: all 0.3s ease;
        }

        .analisa-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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

        .final-header {
            background: var(--secondary);
            color: white;
            padding: 1rem 1.5rem;
        }

        .final-content {
            padding: 1.5rem;
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
            background: white;
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
            color: white;
        }

        .btn-ulang:hover,
        .btn-cetak:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* No Data Message */
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
<body data-spy="scroll" data-target=".navbar" data-offset="50">
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="assets/icon-images/medicmate_logoo.png" alt="Logo MedicMate" class="logo-icon">
            </a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php#home">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#features">Fitur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#penting">Penting</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#myteam">Team</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="konsultasi_medic.php">Konsultasi</a>
                </li>
                <li class="nav-item">
                    <a class="btn-login" href="admin/login_admin.php">Login Admin</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="hasil-diagnosa">
        <div class="diagnosa-header">
            <div class="header-icon"><img src="assets/icon-images/logo_medic.png" alt="Logo Medic Mate" width="450" height="120"></div>
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
            <a href="konsultasi_medic.php" class="btn-ulang">
                <span>🔄</span> Diagnosa Ulang
            </a>
            <a href="cetak.php?m=konsultasi" target="_blank" class="btn-cetak">
                <span>🖨️</span> Cetak Hasil
            </a>
        </div>
    </div>
  <!-- Footer -->
  <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <!-- Brand -->
                <div class="footer-brand">
                    <div class="footer-logo">
                        <img src="assets/icon-images/logo_medic.png" alt="Logo MedicMate" width="300">
                    </div>
                    <p class="footer-description">
                        Sistem Pakar Diagnosis Penyakit Menular yang membantu Anda mendapatkan diagnosis awal dengan cepat dan akurat.
                    </p>
                </div>

                <!-- Links -->
                <div class="footer-links">
                    <h4>Menu</h4>
                    <ul>
                        <li><a href="#home">Beranda</a></li>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#penting">Penting</a></li>
                        <li><a href="#myteam">Team</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="footer-contact">
                    <h4>Kontak</h4>
                    <p><i class="fas fa-envelope"></i> medicmate@support.com</p>
                    <p><i class="fas fa-phone"></i> (62) 813-7018-1649</p>
                    <p><i class="fas fa-map-marker-alt"></i> Bandar Lampung</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2024 MedicMate</p>
            </div>
        </div>
    </footer>
</body>

</html>