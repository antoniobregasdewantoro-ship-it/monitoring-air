@extends('layouts.app')

    @section('content')
    <style>
        /* Menggunakan Palet Warna */
        :root {
            --color-bg-main: #D6F0EE; 
            --color-dark-teal: #4A7A78;
            --color-light-teal: #9DD4D1;
            --color-white: #FFFFFF;
            --color-green: #10B981;
            --color-dark-text: #0D2626;
            --color-blue: #1A6DC4;
            --color-yellow: #F59E0B;
            --color-med-teal: #34ABA4;
            --color-purple: #8B5CF6;
            --color-slate: #475569;
            --color-red: #EF4444;
        }

        .text-main-dark { color: var(--color-dark-text) !important; }
        .text-slate { color: var(--color-slate) !important; }
        
        .btn-custom-primary {
            background-color: var(--color-med-teal);
            color: var(--color-white);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-custom-primary:hover {
            background-color: var(--color-dark-teal);
            color: var(--color-white);
        }

        .card-summary { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-summary:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.08) !important;
        }

        .badge-soft-success { background-color: rgba(16, 185, 129, 0.15); color: var(--color-green); }
        .badge-soft-warning { background-color: rgba(245, 158, 11, 0.15); color: var(--color-yellow); }
        .badge-soft-danger { background-color: rgba(239, 68, 68, 0.15); color: var(--color-red); }
        
        .status-dot {
            display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-right: 6px;
        }

        .table-custom-header {
            background-color: var(--color-light-teal) !important;
            color: var(--color-dark-text) !important;
        }
        
        .text-val-blue { color: var(--color-blue) !important; }
        .text-val-teal { color: var(--color-med-teal) !important; }
        .text-val-green { color: var(--color-green) !important; }
        .text-val-purple { color: var(--color-purple) !important; }

        /* Class baru untuk tombol Terapkan Filter */
        .btn-filter {
            background-color: var(--color-blue); /* #1A6DC4 */
            color: var(--color-white);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-filter:hover {
            background-color: #125296; /* Warna biru sedikit lebih gelap saat di-hover */
            color: var(--color-white);
        }

        /* Class baru untuk Select Latest First */
        .select-outline {
            border: 1.5px solid #30A1CE !important;
        }
        .select-outline:focus {
            border-color: #30A1CE !important;
            box-shadow: 0 0 0 0.25rem rgba(48, 161, 206, 0.25) !important;
        }

        /* --- PENGATURAN KHUSUS EXPORT PDF (PRINT) --- */
        @media print {
            body { background-color: white !important; }
            
            /* Sembunyikan semua elemen kecuali area print container */
            body > div.container-fluid > .container > .row,
            body > div.container-fluid > .container > .card:not(#printContainer) {
                display: none !important;
            }
            
            #printContainer {
                box-shadow: none !important;
                border: none !important;
            }

            /* Tampilkan Header Print & Sembunyikan elemen layar interaktif */
            #printHeader { display: block !important; }
            .screen-only { display: none !important; }

            /* Styling Tabel Saat Print Menyesuaikan Gambar */
            #historyTable thead th {
                color: #8C8C8C !important;
                background-color: transparent !important;
                border-bottom: 1px solid #9DD4D1 !important;
                font-size: 13px !important;
                font-weight: bold;
            }
            #historyTable td {
                font-size: 12px !important;
                color: #475569 !important;
                border-bottom: 1px solid #f1f5f9 !important;
            }
            
            /* Hilangkan warna background badge dan dot pada PDF */
            .badge {
                background-color: transparent !important;
                padding: 0 !important;
                font-weight: normal !important;
                color: inherit !important;
            }
            .status-dot { display: none !important; }
            .print-text-clean { color: #475569 !important; font-weight: normal !important; }
        }

        /* Tambahkan ini di dalam tag <style> Anda */
        main {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }
    </style>

    <div class="container-fluid py-4" style="background-color: var(--color-bg-main); min-height: 100vh;">
        
        <!-- BUNGKUS INI DITAMBAHKAN AGAR KONTEN KE TENGAH -->
        <div class="container">

            <!-- Header Section -->
            <div class="row mb-4 align-items-center screen-only">
                <div class="col-md-6">
                    <h2 class="fw-bold text-main-dark mb-1">Laporan Kualitas Air</h2>
                    <p class="text-slate small mb-0">Pantau dan analisis data kualitas air yang telah direkam oleh sistem.</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-custom-primary px-4 shadow-sm dropdown-toggle rounded-3" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-download"></i> Export Data
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3" aria-labelledby="exportDropdown">
                            <li>
                                <button class="dropdown-item py-2 d-flex align-items-center fw-medium text-val-green" onclick="exportTableToExcel()">
                                    <span style="font-size: 1.2rem; margin-right: 8px;">📊</span> Export Excel
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item py-2 d-flex align-items-center fw-medium text-danger" onclick="printPDF()">
                                    <span style="font-size: 1.2rem; margin-right: 8px;">📄</span> Export PDF
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Summary Cards (Hidden on Print) -->
            <div class="row mb-4 g-3 screen-only">
                <div class="col-6 col-md-2">
                    <div class="card card-summary border-0 shadow-sm rounded-4 h-100 p-3">
                        <p class="text-slate small fw-bold text-uppercase mb-1">Total Data</p>
                        <h4 class="fw-bold text-val-blue mb-0" id="summary_total">0</h4>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="card card-summary border-0 shadow-sm rounded-4 h-100 p-3">
                        <p class="text-slate small fw-bold text-uppercase mb-1">Rata-rata pH</p>
                        <h4 class="fw-bold text-val-teal mb-0" id="summary_ph">-</h4>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="card card-summary border-0 shadow-sm rounded-4 h-100 p-3">
                        <p class="text-slate small fw-bold text-uppercase mb-1">Rata-rata Suhu</p>
                        <h4 class="fw-bold text-val-green mb-0" id="summary_suhu">-</h4>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="card card-summary border-0 shadow-sm rounded-4 h-100 p-3">
                        <p class="text-slate small fw-bold text-uppercase mb-1">Rata-rata TDS</p>
                        <h4 class="fw-bold text-val-green mb-0" id="summary_tds">-</h4>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="card card-summary border-0 shadow-sm rounded-4 h-100 p-3">
                        <p class="text-slate small fw-bold text-uppercase mb-1">Avg Kekeruhan</p>
                        <h4 class="fw-bold text-val-purple mb-0" id="summary_kekeruhan">-</h4>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="card card-summary border-0 shadow-sm rounded-4 h-100 p-3">
                        <p class="text-slate small fw-bold text-uppercase mb-1">Kualitas Air</p>
                        <h4 class="fw-bold text-val-green mb-0" id="summary_kualitas">-</h4>
                    </div>
                </div>
            </div>

            <!-- Filter Data (Hidden on Print) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 screen-only">
                <div class="card-body p-4">
                    <div class="row align-items-end">
                        <div class="col-md-3 mb-2">
                            <label class="form-label small text-slate">Dari Tanggal</label>
                            <input type="date" id="start_date" class="form-control rounded-3 border-light shadow-sm">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label small text-slate">Sampai Tanggal</label>
                            <input type="date" id="end_date" class="form-control rounded-3 border-light shadow-sm">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label small text-slate">Status</label>
                            <select id="status_filter" class="form-select rounded-3 border-light shadow-sm">
                                <option value="all">Semua</option>
                                <option value="normal">Normal</option>
                                <option value="warning">Warning</option>
                                <option value="critical">Critical</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-filter w-100 rounded-3 shadow-sm" onclick="loadHistoryData()">Terapkan Filter</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Riwayat (Print Container) -->
            <div id="printContainer" class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                
                <!-- Header khusus PDF (Dihide saat tampilan web) -->
                <div id="printHeader" class="d-none px-4 pt-4 pb-3">
                    <h2 style="color: #1A6DC4; font-weight: bold; font-family: Arial, sans-serif; margin-bottom: 5px; font-size: 22px;">AQUATOR — Laporan Kualitas Air</h2>
                    <p style="color: #4A7A78; font-family: Arial, sans-serif; font-size: 13px;" id="printSubtitle">Dicetak: -, Total: - data</p>
                </div>

                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center screen-only">
                    <div>
                        <h5 class="fw-bold text-main-dark mb-0">Data Monitoring</h5>
                        <small class="text-slate" id="tabel_hasil_text">0 hasil</small>
                    </div>
                    <select class="form-select w-auto rounded-3 shadow-sm text-slate select-outline">
                        <option>Latest First</option>
                        <option>Oldest First</option>
                    </select>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="historyTable">
                        <thead class="table-custom-header small">
                            <tr>
                                <!-- Header dipisah menyesuaikan dengan gambar laporan -->
                                <th class="ps-4 py-3 fw-bold">Tanggal</th>
                                <th class="py-3 fw-bold">Waktu</th>
                                <th class="py-3 fw-bold">pH</th>
                                <th class="py-3 fw-bold">Suhu (°C)</th>
                                <th class="py-3 fw-bold">TDS (ppm)</th>
                                <th class="py-3 fw-bold">Kekeruhan (NTU)</th>
                                <th class="py-3 fw-bold">Kualitas Air</th>
                                <th class="pe-4 py-3 fw-bold">Status</th>
                            </tr>
                        </thead>
                        <tbody id="historyBody" class="bg-white">
                            <!-- Data dimuat via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div> <!-- PENUTUP .container Yg BARU DITAMBAHKAN -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <script>
        const colors = { green: '#10B981', yellow: '#F59E0B', red: '#EF4444' };

        function setDefaultDates() {
            let today = new Date();
            let twoMonthsAgo = new Date();
            twoMonthsAgo.setMonth(today.getMonth() - 2);

            $("#end_date").val(today.toISOString().slice(0, 10));
            $("#start_date").val(twoMonthsAgo.toISOString().slice(0, 10));
        }

        function getStatusInfo(kualitas_persen) {
            if (kualitas_persen >= 75) return { label: 'Normal', color: colors.green, class: 'text-val-green' };
            if (kualitas_persen >= 40) return { label: 'Warning', color: colors.yellow, class: 'text-warning' };
            return { label: 'Critical', color: colors.red, class: 'text-danger' };
        }

        function getKualitasBadge(kualitas_persen) {
            if (kualitas_persen >= 75) return '<span class="badge badge-soft-success rounded-pill px-3 py-2 fw-bold">Baik</span>';
            if (kualitas_persen >= 40) return '<span class="badge badge-soft-warning rounded-pill px-3 py-2 fw-bold">Sedang</span>';
            return '<span class="badge badge-soft-danger rounded-pill px-3 py-2 fw-bold">Buruk</span>';
        }

        function loadHistoryData() {
            $.ajax({
                url: "{{ route('history.filter') }}",
                type: "GET",
                data: {
                    start_date: $("#start_date").val(),
                    end_date: $("#end_date").val(),
                    status: $("#status_filter").val()
                },
                dataType: "json",
                success: function(response) {
                    let tableBody = $("#historyBody");
                    tableBody.empty(); 
                    
                    let totalData = response.length;
                    let sumPh = 0, sumSuhu = 0, sumTds = 0, sumKekeruhan = 0, normalCount = 0;

                    if (totalData === 0) {
                        tableBody.append('<tr><td colspan="8" class="text-center py-4 text-slate">🔍 Data tidak ditemukan</td></tr>');
                        $("#summary_total").text("0");
                        $("#summary_ph, #summary_suhu, #summary_tds, #summary_kekeruhan").text("-");
                        $("#summary_kualitas").text("-").removeClass("text-val-green text-warning text-danger").addClass("text-slate");
                        $("#tabel_hasil_text").text("0 hasil");
                    } else {
                        response.forEach(function(data) {
                            let dateObj = new Date(data.created_at);
                            let datePart = dateObj.toLocaleDateString("id-ID", { day: '2-digit', month: 'short', year: 'numeric' });
                            let timePart = dateObj.toLocaleTimeString("id-ID", { hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/\./g, ':');

                            let tdsValue = data.tds ? parseFloat(data.tds) : 0;
                            sumPh += parseFloat(data.ph) || 0;
                            sumSuhu += parseFloat(data.suhu) || 0;
                            sumTds += tdsValue;
                            sumKekeruhan += parseFloat(data.kekeruhan) || 0;

                            if (data.kualitas >= 75) normalCount++;

                            let statusInfo = getStatusInfo(data.kualitas);
                            let badgeHTML = getKualitasBadge(data.kualitas);

                            let row = `
                                <tr>
                                    <td class="ps-4 fw-bold text-main-dark print-text-clean" style="font-size:14px;">${datePart}</td>
                                    <td class="text-slate print-text-clean" style="font-size:14px;">${timePart}</td>
                                    <td class="text-val-teal fw-bold print-text-clean">${data.ph}</td>
                                    <td class="text-val-green fw-bold print-text-clean">${data.suhu} <span class="text-slate fw-normal" style="font-size:11px;"></span></td>
                                    <td class="text-val-green fw-bold print-text-clean">${tdsValue.toFixed(2)} <span class="text-slate fw-normal" style="font-size:11px;"></span></td>
                                    <td class="text-val-purple fw-bold print-text-clean">${data.kekeruhan} <span class="text-slate fw-normal" style="font-size:11px;"></span></td>
                                    <td>${badgeHTML}</td>
                                    <td class="pe-4 ${statusInfo.class} fw-bold print-text-clean" style="font-size:14px;">
                                        <span class="status-dot" style="background-color: ${statusInfo.color};"></span> <span class="status-text">${statusInfo.label}</span>
                                    </td>
                                </tr>
                            `;
                            tableBody.append(row);
                        });

                        $("#summary_total").text(totalData);
                        $("#summary_ph").text((sumPh / totalData).toFixed(1));
                        $("#summary_suhu").text((sumSuhu / totalData).toFixed(1) + " °C");
                        $("#summary_tds").text((sumTds / totalData).toFixed(0) + " ppm");
                        $("#summary_kekeruhan").text((sumKekeruhan / totalData).toFixed(1) + " NTU");
                        $("#tabel_hasil_text").text(totalData + " hasil");

                        let normalRatio = normalCount / totalData;
                        let kualitasClass = normalRatio >= 0.75 ? "text-val-green" : normalRatio >= 0.40 ? "text-warning" : "text-danger";
                        $("#summary_kualitas").text(normalRatio >= 0.75 ? "Baik" : normalRatio >= 0.40 ? "Sedang" : "Buruk")
                            .removeClass("text-val-green text-warning text-danger text-slate").addClass(kualitasClass);
                    }
                }
            });
        }

        // Fungsi Cetak PDF Dinamis
        function printPDF() {
            let printDate = new Date().toLocaleString('id-ID', {
                day: 'numeric', month: 'numeric', year: 'numeric',
                hour: '2-digit', minute: '2-digit', second: '2-digit'
            }).replace(/\./g, ':'); 
            let totalData = $("#summary_total").text();
            
            // Suntikkan tanggal cetak dan total data ke header PDF
            $("#printSubtitle").text(`Dicetak: ${printDate} - Total: ${totalData} data`);
            window.print();
        }

        // Fungsi Cetak Excel Sesuai Gambar
        async function exportTableToExcel() {
            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet("Laporan");

            // 1. Baris Judul
            worksheet.mergeCells('A1:H1');
            const titleCell = worksheet.getCell('A1');
            titleCell.value = 'AQUATOR — Laporan Kualitas Air';
            titleCell.font = { name: 'Arial', size: 16, bold: true, color: { argb: 'FF1A6DC4' } };

            // 2. Baris Subtitle (Tanggal & Total)
            let printDate = new Date().toLocaleString('id-ID', {
                day: 'numeric', month: 'numeric', year: 'numeric',
                hour: '2-digit', minute: '2-digit', second: '2-digit'
            }).replace(/\./g, ':');
            const totalData = $("#summary_total").text();

            worksheet.mergeCells('A2:H2');
            const subtitleCell = worksheet.getCell('A2');
            subtitleCell.value = `Dicetak: ${printDate} - Total: ${totalData} data`;
            subtitleCell.font = { name: 'Arial', size: 10, color: { argb: 'FF4A7A78' } };

            worksheet.addRow([]); // Kosongkan baris 3

            // 3. Header Tabel
            const headerRow = worksheet.getRow(4);
            headerRow.values = ['Tanggal', 'Waktu', 'pH', 'Suhu (°C)', 'TDS (ppm)', 'Kekeruhan (NTU)', 'Kualitas Air', 'Status'];
            headerRow.font = { bold: true, color: { argb: 'FF8C8C8C' } }; // Warna teks abu-abu sesuai gambar
            headerRow.border = { bottom: { style: 'thin', color: { argb: 'FF9DD4D1' } } }; // Border bawah tosca

            worksheet.columns = [
                { key: "tanggal", width: 15 },
                { key: "waktu", width: 15 },
                { key: "ph", width: 10 },
                { key: "suhu", width: 15 },
                { key: "tds", width: 15 },
                { key: "kekeruhan", width: 20 },
                { key: "kualitas_air", width: 15 },
                { key: "status", width: 15 }
            ];

            // 4. Input Data per Baris
            const rows = document.querySelectorAll("#historyTable tbody tr");
            rows.forEach(row => {
                const cells = row.querySelectorAll("td");
                if (cells.length === 8 && !cells[0].innerText.includes('tidak ditemukan')) {
                    worksheet.addRow({
                        tanggal: cells[0].innerText.trim(),
                        waktu: cells[1].innerText.trim(),
                        ph: parseFloat(cells[2].innerText),
                        suhu: parseFloat(cells[3].innerText),
                        tds: parseFloat(cells[4].innerText),
                        kekeruhan: parseFloat(cells[5].innerText),
                        kualitas_air: cells[6].innerText.trim(),
                        status: cells[7].innerText.trim()
                    });
                }
            });

            const buffer = await workbook.xlsx.writeBuffer();
            saveAs(new Blob([buffer]), "Laporan_Kualitas_Air_Aquator.xlsx");
        }

        $(document).ready(function() {
            setDefaultDates();
            loadHistoryData(); 
            setInterval(loadHistoryData, 30000); 
        });
    </script>
    @endsection