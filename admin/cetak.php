<?php 
include '../functions.php'; 

if (!isset($_SESSION['data'])) {
    echo '<div class="alert">Data tidak ditemukan! Silakan ulangi proses konsultasi.</div>';
    exit;
}

$data = $_SESSION['data'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa - MedicMate</title>
     <link rel="shortcut icon" href="images/icon_medicmate.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #2C3E50;
            background: #fff;
            padding: 40px 0;
            position: relative;
        }

        /* Watermark */
        body::before {
            content: 'MedicMate';
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(106, 156, 137, 0.05);
            white-space: nowrap;
            z-index: -1;
        }

        .wrapper {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            position: relative;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }

        /* Action Buttons */
        .action-buttons {
            position: sticky;
            top: 20px;
            z-index: 100;
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .action-button {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .print-button {
            background: #6A9C89;
            color: white;
        }

        .back-button {
            background: #16423C;
            color: white;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Header Design */
        .print-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px;
            background: linear-gradient(135deg, #6A9C89 0%, #16423C 100%);
            color: white;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .hospital-name {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .hospital-contact {
            font-size: 14px;
            opacity: 0.9;
            line-height: 1.8;
        }

        /* Patient Info */
        .patient-info {
            background: linear-gradient(to right, #f8f9fa, #fff);
            padding: 25px;
            border-radius: 10px;
            margin: 30px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .info-item {
            position: relative;
            padding-left: 15px;
        }

        .info-label {
            color: #6A9C89;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .info-value {
            color: #2C3E50;
            font-size: 16px;
        }

        /* Table Styles */
        .symptoms-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 20px 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }

        .symptoms-table th {
            background: linear-gradient(to right, #6A9C89, #16423C);
            color: white;
            padding: 15px 20px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
            text-align: left;
        }

        .symptoms-table td {
            padding: 12px 20px;
            border-bottom: 1px solid #eee;
            background: #fff;
        }

        .symptoms-table tr:last-child td {
            border-bottom: none;
        }

        .symptoms-table tr:hover td {
            background: #f8f9fa;
        }

        /* Diagnosis Results */
        .diagnosis-section {
            margin: 30px 0;
        }

        .section-title {
            font-size: 20px;
            color: #16423C;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #6A9C89;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .diagnosis-result {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            padding: 25px;
            border-radius: 10px;
            border-left: 5px solid #6A9C89;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .certainty-meter {
            margin: 15px 0;
            background: #eee;
            height: 10px;
            border-radius: 5px;
            overflow: hidden;
        }

        .certainty-fill {
            height: 100%;
            background: linear-gradient(to right, #6A9C89, #16423C);
            transition: width 1s ease-in-out;
        }

        .diagnosis-info {
            margin: 15px 0;
        }

        .diagnosis-info strong {
            color: #16423C;
            display: block;
            margin-bottom: 5px;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 60px;
            text-align: right;
            padding: 20px;
        }

        .signature-date {
            color: #666;
            margin-bottom: 10px;
        }

        .signature-line {
            width: 200px;
            margin-left: auto;
            border-bottom: 2px solid #16423C;
            margin-bottom: 10px;
            position: relative;
        }

        .doctor-name {
            font-weight: bold;
            color: #16423C;
            margin: 5px 0;
        }

        .doctor-title {
            color: #666;
            font-size: 14px;
        }

        /* Footer */
        .print-footer {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 2px solid #eee;
            text-align: center;
            color: #666;
            font-size: 12px;
        }

        /* Print Styles */
        @media print {
            body {
                padding: 0;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .wrapper {
                box-shadow: none;
                padding: 20px;
            }

            .action-buttons {
                display: none;
            }

            @page {
                margin: 1.5cm;
                size: A4;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Action Buttons -->
        <div class="action-buttons">
            <button onclick="window.print()" class="action-button print-button">
                <i class="fas fa-print"></i> Cetak Hasil
            </button>
            <a href="konsultasi.php" class="action-button back-button">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Header -->
        <div class="print-header">
            <div class="hospital-name">MedicMate</div>
            <div class="hospital-contact">
                Sistem Pakar Diagnosis Penyakit Menular<br>
                Email: medicmate@support.com | Tel: (62) 721-123456<br>
                Bandar Lampung, Indonesia
            </div>
        </div>

        <!-- Patient Information -->
        <div class="patient-info">
            <div class="section-title">
                <i class="fas fa-user-circle"></i>
                Informasi Pasien
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Pasien</span>
                    <span class="info-value"><?= htmlspecialchars($data['nama']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jenis Kelamin</span>
                    <span class="info-value"><?= htmlspecialchars($data['jk']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Umur</span>
                    <span class="info-value"><?= htmlspecialchars($data['umur']) ?> Tahun</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Alamat</span>
                    <span class="info-value"><?= htmlspecialchars($data['alamat']) ?></span>
                </div>
            </div>
        </div>

        <!-- Symptoms -->
        <div class="symptoms-section">
            <div class="section-title">
                <i class="fas fa-clipboard-list"></i>
                Gejala Yang Dialami
            </div>
            <table class="symptoms-table">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Gejala</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $gejala = $data['gejala'];
                    $sql = "SELECT nama_gejala FROM tb_gejala WHERE kode_gejala IN ('" . implode("','", array_map('htmlspecialchars', $gejala)) . "')";
                    $rows = $db->get_results($sql);
                    foreach ($rows as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row->nama_gejala) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Diagnosis Results -->
        <div class="diagnosis-section">
            <div class="section-title">
                <i class="fas fa-stethoscope"></i>
                Hasil Diagnosa
            </div>
            <?php
            $diagnosa_rows = $db->get_results("SELECT d.nama_diagnosa, d.keterangan, r.mb, r.md 
                FROM tb_relasi r 
                INNER JOIN tb_diagnosa d ON r.kode_diagnosa = d.kode_diagnosa 
                WHERE r.kode_gejala IN ('" . implode("','", array_map('htmlspecialchars', $gejala)) . "')");

            if ($diagnosa_rows) {
                $diagnosa_results = [];
                foreach ($diagnosa_rows as $row) {
                    if (!isset($diagnosa_results[$row->nama_diagnosa])) {
                        $diagnosa_results[$row->nama_diagnosa] = [
                            'mb' => 0,
                            'md' => 0,
                            'cf' => 0,
                            'solusi' => $row->keterangan
                        ];
                    }
                    $diagnosa_results[$row->nama_diagnosa]['mb'] += $row->mb * (1 - $diagnosa_results[$row->nama_diagnosa]['mb']);
                    $diagnosa_results[$row->nama_diagnosa]['md'] += $row->md * (1 - $diagnosa_results[$row->nama_diagnosa]['md']);
                    $diagnosa_results[$row->nama_diagnosa]['cf'] = $diagnosa_results[$row->nama_diagnosa]['mb'] - $diagnosa_results[$row->nama_diagnosa]['md'];
                }

                $max_cf = 0;
                $final_diagnosis = null;
                foreach ($diagnosa_results as $diagnosis => $values) {
                    if ($values['cf'] > $max_cf) {
                        $max_cf = $values['cf'];
                        $final_diagnosis = [
                            'diagnosis' => $diagnosis,
                            'cf' => $values['cf'],
                            'solusi' => $values['solusi']
                        ];
                    }
                }

                if ($final_diagnosis): ?>
                <div class="diagnosis-result">
                    <div class="diagnosis-info">
                        <strong>Diagnosa:</strong>
                        <?= htmlspecialchars($final_diagnosis['diagnosis']) ?>
                    </div>
                    
                    <div class="diagnosis-info">
                        <strong>Tingkat Kepastian:</strong>
                        <div class="certainty-meter">
                            <div class="certainty-fill" style="width: <?= number_format($final_diagnosis['cf'] * 100, 2) ?>%"></div>
                        </div>
                        <span><?= number_format($final_diagnosis['cf'] * 100, 2) ?>%</span>
                    </div>

                    <div class="diagnosis-info">
                        <strong>Solusi/Rekomendasi:</strong>
                        <?= nl2br(htmlspecialchars($final_diagnosis['solusi'])) ?>
                    </div>
                </div>
                <?php endif;
            } else {
                echo '<p class="no-results">Tidak ada hasil diagnosa yang ditemukan.</p>';
            }
            ?>
        </div>

        <!-- Signature -->
        <div class="signature-section">
            <p class="signature-date">Bandar Lampung, <?= date('d F Y') ?></p>
            <div class="signature-line"></div>
          <p class="doctor-name">dr. Rhalasya Eleina Putri</p>
            <p class="doctor-title">Dokter Penyakit Menular</p>
        </div>

        <!-- Footer -->
        <div class="print-footer">
            <p>Dokumen ini dicetak secara digital oleh Sistem Pakar MedicMate</p>
            <p>Hasil diagnosa ini bersifat prediktif berdasarkan gejala yang diinputkan</p>
            <p>Untuk hasil yang lebih akurat, silakan konsultasi dengan dokter</p>
            <p>&copy; <?= date('Y') ?> MedicMate. Semua hak cipta dilindungi undang-undang.</p>
        </div>
    </div>

    <script>
        // Animasi untuk certainty meter
        window.onload = function() {
            const certaintyFills = document.querySelectorAll('.certainty-fill');
            certaintyFills.forEach(fill => {
                const width = fill.style.width;
                fill.style.width = '0%';
                setTimeout(() => {
                    fill.style.width = width;
                }, 100);
            });
        };

        // Fungsi print dengan konfirmasi
        function printResults() {
            if(confirm('Apakah Anda yakin ingin mencetak hasil diagnosa?')) {
                window.print();
            }
        }

        // Menangani klik tombol kembali
        document.querySelector('.back-button')?.addEventListener('click', function(e) {
            if(!confirm('Apakah Anda yakin ingin kembali? Hasil diagnosa ini tidak akan tersimpan.')) {
                e.preventDefault();
            }
        });

        // Menambahkan nomor halaman saat print
        if(window.matchMedia) {
            const mediaQueryList = window.matchMedia('print');
            mediaQueryList.addListener(function(mql) {
                if(mql.matches) {
                    document.body.classList.add('printing');
                } else {
                    document.body.classList.remove('printing');
                }
            });
        }

        // Mencegah print menggunakan Ctrl+P
        document.addEventListener('keydown', function(e) {
            if(e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                printResults();
            }
        });

        // Menampilkan pesan jika javascript dinonaktifkan
        if(typeof window.print !== 'function') {
            const printButton = document.querySelector('.print-button');
            printButton.textContent = 'Browser Anda tidak mendukung pencetakan';
            printButton.disabled = true;
        }
        
        // Fungsi untuk kembali ke halaman sebelumnya
        function goBack() {
            window.history.back();
        }

        // Langsung print begitu halaman dimuat
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.history.back(); // Mengarahkan kembali ke halaman sebelumnya setelah print selesai
            }
        };
    
    </script>
</body>
</html>