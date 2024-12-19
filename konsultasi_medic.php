<?php include 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="assets/icon-images/icon_medicmate.png" />
    <title>MedicMate - Konsultasi</title>

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

        /* Enhanced Consultation Section Styles */
        .consultation-section {
            padding: 4rem 0;
            position: relative;
        }

        .consultation-wrapper {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 3rem;
            align-items: start;
        }

        .consultation-image-wrapper {
            position: relative;
        }

        .consultation-image {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(106, 156, 137, 0.15);
            transition: transform 0.5s ease;
        }

        .consultation-image:hover {
            transform: translateY(-10px);
        }

        .consultation-content {
            background: rgba(255, 255, 255, 0.95);
            padding: 3rem;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(106, 156, 137, 0.1);
            position: relative;
        }

        .consultation-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .consultation-subtitle {
            font-size: 1.2rem;
            color: var(--gray);
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }

        /* Enhanced Form Styles */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .form-group {
            position: relative;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.75rem;
            color: var(--primary);
            font-size: 1.1rem;
        }

        .form-required {
            color: #e74c3c;
            margin-left: 0.25rem;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid var(--tertiary);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-input:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 4px rgba(106, 156, 137, 0.1);
            outline: none;
        }

        /* Enhanced Table Styles */
        .symptoms-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 2.5rem;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .symptoms-table th,
        .symptoms-table td {
            padding: 1.25rem;
            border: 1px solid var(--tertiary);
        }

        .symptoms-table th {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: white;
            font-weight: 600;
            text-align: left;
            font-size: 1.1rem;
        }

        .symptoms-table tr {
            transition: all 0.3s ease;
        }

        .symptoms-table tr:nth-child(even) {
            background-color: rgba(196, 218, 210, 0.1);
        }

        .symptoms-table tr:hover {
            background-color: rgba(106, 156, 137, 0.1);
        }

        .symptoms-table td:first-child,
        .symptoms-table th:first-child {
            width: 50px;
            text-align: center;
        }

        /* Checkbox Styles */
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            border: 2px solid var(--secondary);
            border-radius: 4px;
        }

        /* Enhanced Button Styles */
        .submit-button {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: white;
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(106, 156, 137, 0.2);
            position: relative;
            overflow: hidden;
        }

        .submit-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.5s;
        }

        .submit-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(106, 156, 137, 0.3);
        }

        .submit-button:hover::before {
            left: 100%;
        }

        /* Enhanced Alert Styles */
        .alert {
            padding: 1.25rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
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
                    <a class="nav-link" href="index.php#team">Team</a>
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

    <!-- Main Content -->
    <main class="consultation-section">
        <div class="container">
            <div class="consultation-wrapper">
                <div class="consultation-image-wrapper">
                    <img src="assets/icon-images/support.png" alt="konsultasi" class="consultation-image">
                </div>

                <div class="consultation-content">
                    <h3 class="consultation-title">Konsultasi</h3>
                    <h5 class="consultation-subtitle">Isi Biodata dibawah ini untuk Mendiagnosa Penyakitmu:</h5>

                    <?php
                    $success = false;

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $nama = htmlspecialchars($_POST['nama'] ?? '');
                        $jk = htmlspecialchars($_POST['jk'] ?? '');
                        $umur = htmlspecialchars($_POST['umur'] ?? '');
                        $alamat = htmlspecialchars($_POST['alamat'] ?? '');
                        $selected_gejala = isset($_POST['gejala']) ? $_POST['gejala'] : [];

                        if (empty($nama) || empty($jk) || empty($umur) || empty($alamat)) {
                            echo '<div class="alert">Isikan nama, jenis kelamin, umur, dan alamat!</div>';
                        } elseif (empty($selected_gejala)) {
                            echo '<div class="alert">Belum ada gejala yang dipilih!</div>';
                        } else {
                            // Simpan ke database
                            $gejala_implode = implode(',', $selected_gejala); // Gabungkan gejala menjadi string
                            $query = "INSERT INTO tb_identitas (nama, jk, umur, alamat, gejala) 
                                      VALUES ('$nama', '$jk', '$umur', '$alamat', '$gejala_implode')";

                            if ($db->query($query)) {
                                // Simpan ke sesi untuk digunakan di cetak
                                $_SESSION['data'] = [
                                    'nama' => $nama,
                                    'jk' => $jk,
                                    'umur' => $umur,
                                    'alamat' => $alamat,
                                    'gejala' => $selected_gejala,
                                ];
                                $success = true;
                                echo '<div class="alert" style="background-color: #d4edda; color: #155724;">Data berhasil disimpan!</div>';
                            } else {
                                echo '<div class="alert">Terjadi kesalahan saat menyimpan data ke database!</div>';
                            }
                        }
                    }
                    ?>

                    <form method="POST" action="konsultasi_hasil.php">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Nama <span class="form-required">*</span></label>
                                <input class="form-input" type="text" name="nama" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Jenis Kelamin <span class="form-required">*</span></label>
                                <select class="form-input" name="jk">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <?= get_jk_option($_POST['jk'] ?? '') ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Umur <span class="form-required">*</span></label>
                                <input class="form-input" type="number" name="umur" value="<?= htmlspecialchars($_POST['umur'] ?? '') ?>">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Alamat <span class="form-required">*</span></label>
                                <input class="form-input" type="text" name="alamat" value="<?= htmlspecialchars($_POST['alamat'] ?? '') ?>">
                            </div>
                        </div>

                        <table class="symptoms-table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>No</th>
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
                                foreach ($rows as $row): ?>
                                    <tr>
                                        <td><input type="checkbox" name="gejala[]" value="<?= $row->kode_gejala ?>"></td>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row->nama_gejala ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <button type="submit" class="submit-button">Submit Diagnosa</button>
                    </form>

                    
                </div>
            </div>
        </div>
    </main>

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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Checkbox all functionality
        document.getElementById('checkAll').addEventListener('click', function() {
            const checkboxes = document.getElementsByName('gejala[]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Mobile menu toggle
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.querySelector('.navbar-nav').classList.toggle('show');
        });

        // Add smooth scrolling to navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Additional mobile menu overlay
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
        const navbarToggler = document.querySelector('.navbar-toggler');

        if (mobileMenuOverlay && navbarToggler) {
            navbarToggler.addEventListener('click', function() {
                mobileMenuOverlay.classList.toggle('active');
            });

            mobileMenuOverlay.addEventListener('click', function() {
                mobileMenuOverlay.classList.remove('active');
                document.querySelector('.navbar-nav').classList.remove('show');
            });
        }

        // Form validation enhancement
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const nama = form.querySelector('input[name="nama"]').value;
                const jk = form.querySelector('select[name="jk"]').value;
                const umur = form.querySelector('input[name="umur"]').value;
                const alamat = form.querySelector('input[name="alamat"]').value;
                const gejala = form.querySelectorAll('input[name="gejala[]"]:checked');

                if (!nama || !jk || !umur || !alamat) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua data yang diperlukan!');
                } else if (gejala.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal satu gejala!');
                }
            });
        }
    </script>
</body>

</html>