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

/* --- HIRARKI FONT HEADER --- */
.header-tag {
    color: var(--color-blue);
    font-size: 0.825rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    display: block;
    margin-bottom: 4px;
}

.header-title {
    color: var(--color-dark-text);
    font-size: 2.1rem;
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.5px;
    margin-bottom: 8px;
}

.header-desc {
    color: var(--color-slate);
    font-size: 0.95rem;
    font-weight: 400;
    line-height: 1.5;
    margin-bottom: 2px;
}

.header-subdesc {
    color: #64748B;
    font-size: 0.85rem;
    font-weight: 400;
}

.text-main-dark {
    color: var(--color-dark-text) !important;
}

.text-slate {
    color: var(--color-slate) !important;
}

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

.card-summary {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card-summary:hover {
    transform: translateY(-3px);
    box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .08) !important;
}

.badge-soft-success {
    background-color: rgba(16, 185, 129, 0.15);
    color: var(--color-green);
}

.badge-soft-warning {
    background-color: rgba(245, 158, 11, 0.15);
    color: var(--color-yellow);
}

.badge-soft-danger {
    background-color: rgba(239, 68, 68, 0.15);
    color: var(--color-red);
}

.status-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 6px;
}

.table-custom-header {
    background-color: var(--color-light-teal) !important;
    color: var(--color-dark-text) !important;
}

.text-val-blue {
    color: var(--color-blue) !important;
}

.text-val-teal {
    color: var(--color-med-teal) !important;
}

.text-val-green {
    color: var(--color-green) !important;
}

.text-val-purple {
    color: var(--color-purple) !important;
}

/* Tombol Terapkan Filter */
.btn-filter {
    background-color: var(--color-blue);
    color: var(--color-white);
    border: none;
    padding: 0.5rem 1rem;
    font-weight: 600;
    transition: all 0.2s ease-in-out;
}

.btn-filter:hover {
    background-color: #125296;
    color: var(--color-white);
    transform: translateY(-1px);
}

.btn-filter:active {
    transform: translateY(0);
}

/* Select Outline */
.select-outline {
    border: 1.5px solid #30A1CE !important;
}

.select-outline:focus {
    border-color: #30A1CE !important;
    box-shadow: 0 0 0 0.25rem rgba(48, 161, 206, 0.25) !important;
}

/* Pagination Styling */
.pagination-custom .page-btn {
    border: 1.5px solid var(--color-light-teal);
    background-color: var(--color-white);
    color: var(--color-dark-teal);
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    user-select: none;
    padding: 0;
}

.pagination-custom .page-btn:hover:not(.disabled):not(.active) {
    background-color: var(--color-bg-main);
    border-color: var(--color-dark-teal);
    color: var(--color-dark-teal);
}

.pagination-custom .page-btn.active {
    background-color: var(--color-blue);
    color: var(--color-white);
    border-color: var(--color-blue);
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(26, 109, 196, 0.25);
}

.pagination-custom .page-btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    border-color: var(--color-light-teal);
}

.pagination-custom .page-btn.nav-btn {
    color: var(--color-light-teal);
    font-weight: bold;
    font-size: 18px;
}

.pagination-custom .page-btn.nav-btn:hover:not(.disabled) {
    color: var(--color-dark-teal);
    border-color: var(--color-dark-teal);
}

/* Export PDF (Print) */
@media print {
    body {
        background-color: white !important;
    }

    body>div.container-fluid>.container>.row,
    body>div.container-fluid>.container>.card:not(#printContainer) {
        display: none !important;
    }

    #printContainer {
        box-shadow: none !important;
        border: none !important;
    }

    #printHeader {
        display: block !important;
    }

    .screen-only {
        display: none !important;
    }

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

    .badge {
        background-color: transparent !important;
        padding: 0 !important;
        font-weight: normal !important;
        color: inherit !important;
    }

    .status-dot {
        display: none !important;
    }

    .print-text-clean {
        color: #475569 !important;
        font-weight: normal !important;
    }
}

main {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
}
</style>

<div class="container-fluid py-4" style="background-color: var(--color-bg-main); min-height: 100vh;">

    <div class="container">

        <!-- Header Section -->
        <div class="row mb-4 align-items-center screen-only">
            <div class="col-md-7">
                <span class="header-tag">AQUATOR</span>
                <h1 class="header-title">Laporan Kualitas Air</h1>
                <p class="header-desc">Pantau dan analisis data kualitas air yang telah direkam oleh sistem.</p>
                <p class="header-subdesc mb-0">Menampilkan seluruh data monitoring yang tersimpan</p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <div class="dropdown d-inline-block">
                    <button class="btn btn-custom-primary px-4 shadow-sm dropdown-toggle rounded-3" type="button"
                        id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-download"></i> Export Data
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3"
                        aria-labelledby="exportDropdown">
                        <li>
                            <button class="dropdown-item py-2 d-flex align-items-center fw-medium text-val-green"
                                onclick="exportTableToExcel()">
                                <span style="font-size: 1.2rem; margin-right: 8px;">📊</span> Export Excel
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item py-2 d-flex align-items-center fw-medium text-danger"
                                onclick="printPDF()">
                                <span style="font-size: 1.2rem; margin-right: 8px;">📄</span> Export PDF
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
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

        <!-- Filter Data -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 screen-only">
            <div class="card-body p-4">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-2">
                        <label for="start_date" class="form-label small text-slate fw-semibold mb-2">Dari
                            Tanggal</label>
                        <input type="date" id="start_date" class="form-control rounded-3 border-light shadow-sm">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="end_date" class="form-label small text-slate fw-semibold mb-2">Sampai
                            Tanggal</label>
                        <input type="date" id="end_date" class="form-control rounded-3 border-light shadow-sm">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="status_filter" class="form-label small text-slate fw-semibold mb-2">Status</label>
                        <select id="status_filter" class="form-select rounded-3 border-light shadow-sm">
                            <option value="all">Semua</option>
                            <option value="normal">Normal</option>
                            <option value="warning">Warning</option>
                            <option value="critical">Critical</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="button" id="btn-apply-filter" class="btn btn-filter w-100 rounded-3 shadow-sm"
                            onclick="handleApplyFilter()">
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat -->
        <div id="printContainer" class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">

            <!-- Header khusus PDF -->
            <div id="printHeader" class="d-none px-4 pt-4 pb-3">
                <h2
                    style="color: #1A6DC4; font-weight: bold; font-family: Arial, sans-serif; margin-bottom: 5px; font-size: 22px;">
                    AQUATOR — Laporan Kualitas Air</h2>
                <p style="color: #4A7A78; font-family: Arial, sans-serif; font-size: 13px;" id="printSubtitle">Dicetak:
                    -, Total: - data</p>
            </div>

            <div
                class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center screen-only">
                <div>
                    <h5 class="fw-bold text-main-dark mb-0">Data Monitoring</h5>
                    <small class="text-slate" id="tabel_hasil_text">0 hasil</small>
                </div>
                <select id="sort_order" class="form-select w-auto rounded-3 shadow-sm text-slate select-outline"
                    onchange="loadHistoryData()">
                    <option value="latest">Latest First</option>
                    <option value="oldest">Oldest First</option>
                </select>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="historyTable">
                    <thead class="table-custom-header small">
                        <tr>
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

            <!-- Footer Pagination -->
            <div
                class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center screen-only">
                <div class="text-slate small">
                    Menampilkan <span class="fw-bold text-main-dark" id="page-range">0–0</span> dari <span
                        class="fw-bold text-main-dark" id="page-total">0</span> data
                </div>
                <div class="pagination-custom d-flex align-items-center gap-2 ms-auto" id="pagination-wrapper">
                    <!-- Tombol Pagination di-render via JS -->
                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
const colors = {
    green: '#10B981',
    yellow: '#F59E0B',
    red: '#EF4444'
};

let currentFilteredData = [];
let currentPage = 1;
const itemsPerPage = 10;

function setDefaultDates() {
    let today = new Date();
    let twoMonthsAgo = new Date();
    twoMonthsAgo.setMonth(today.getMonth() - 2);

    $("#end_date").val(today.toISOString().slice(0, 10));
    $("#start_date").val(twoMonthsAgo.toISOString().slice(0, 10));
}

function getStatusInfo(kualitas_persen) {
    let val = parseFloat(kualitas_persen) || 0;
    if (val >= 75) return {
        label: 'Normal',
        key: 'normal',
        color: colors.green,
        class: 'text-val-green'
    };
    if (val >= 40) return {
        label: 'Warning',
        key: 'warning',
        color: colors.yellow,
        class: 'text-warning'
    };
    return {
        label: 'Critical',
        key: 'critical',
        color: colors.red,
        class: 'text-danger'
    };
}

function getKualitasBadge(kualitas_persen) {
    let val = parseFloat(kualitas_persen) || 0;
    if (val >= 75)
        return '<span class="badge badge-soft-success rounded-pill px-3 py-2 fw-bold">Baik</span>';
    if (val >= 40)
        return '<span class="badge badge-soft-warning rounded-pill px-3 py-2 fw-bold">Sedang</span>';
    return '<span class="badge badge-soft-danger rounded-pill px-3 py-2 fw-bold">Buruk</span>';
}

/* Eksekusi Filter */
function handleApplyFilter() {
    let $btn = $("#btn-apply-filter");
    let originalText = $btn.html();

    $btn.prop("disabled", true).html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Memuat...');

    loadHistoryData(function() {
        $btn.prop("disabled", false).html(originalText);
    });
}

function loadHistoryData(callback) {
    let startDate = $("#start_date").val();
    let endDate = $("#end_date").val();
    let selectedStatus = $("#status_filter").val();

    $.ajax({
        url: "{{ route('history.filter') }}",
        type: "GET",
        data: {
            start_date: startDate,
            end_date: endDate,
            status: selectedStatus
        },
        dataType: "json",
        success: function(response) {
            let seenIntervals = new Set();
            currentFilteredData = [];

            let sortOrder = $("#sort_order").val();
            if (sortOrder === 'oldest') {
                response.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
            } else {
                response.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            }

            response.forEach(function(data) {
                let dateObj = new Date(data.created_at);

                // --- 1. FILTER TANGGAL (Pelapis Client-Side) ---
                let dataDateStr = dateObj.toISOString().slice(0, 10);
                if (startDate && dataDateStr < startDate) return;
                if (endDate && dataDateStr > endDate) return;

                // --- 2. FILTER STATUS (Pelapis Client-Side) ---
                let statusInfo = getStatusInfo(data.kualitas);
                if (selectedStatus !== 'all' && statusInfo.key !== selectedStatus) {
                    return; // Lewati jika status tidak cocok dengan pilihan filter
                }

                // --- 3. DEDUPLIKASI / INTERVAL 30 MENIT ---
                let roundedDate = new Date(dateObj);
                let roundedMinutes = Math.round(roundedDate.getMinutes() / 30) * 30;
                roundedDate.setMinutes(roundedMinutes);
                roundedDate.setSeconds(0);

                let intervalKey =
                    `${roundedDate.getFullYear()}-${roundedDate.getMonth()}-${roundedDate.getDate()}-${roundedDate.getHours()}-${roundedDate.getMinutes()}`;

                if (!seenIntervals.has(intervalKey)) {
                    seenIntervals.add(intervalKey);
                    data.roundedDate = roundedDate;
                    currentFilteredData.push(data);
                }
            });

            // Update Ringkasan Summary
            let totalData = currentFilteredData.length;
            let sumPh = 0,
                sumSuhu = 0,
                sumTds = 0,
                sumKekeruhan = 0,
                normalCount = 0;

            currentFilteredData.forEach(function(d) {
                sumPh += parseFloat(d.ph) || 0;
                sumSuhu += parseFloat(d.suhu) || 0;
                sumTds += d.tds ? parseFloat(d.tds) : 0;
                sumKekeruhan += parseFloat(d.kekeruhan) || 0;
                if (parseFloat(d.kualitas) >= 75) normalCount++;
            });

            if (totalData === 0) {
                $("#summary_total").text("0");
                $("#summary_ph, #summary_suhu, #summary_tds, #summary_kekeruhan").text("-");
                $("#summary_kualitas").text("-").removeClass("text-val-green text-warning text-danger")
                    .addClass("text-slate");
                $("#tabel_hasil_text").text("0 hasil");
            } else {
                $("#summary_total").text(totalData);
                $("#summary_ph").text((sumPh / totalData).toFixed(1));
                $("#summary_suhu").text((sumSuhu / totalData).toFixed(1) + " °C");
                $("#summary_tds").text((sumTds / totalData).toFixed(0) + " ppm");
                $("#summary_kekeruhan").text((sumKekeruhan / totalData).toFixed(1) + " NTU");
                $("#tabel_hasil_text").text(totalData + " hasil");

                let normalRatio = normalCount / totalData;
                let kualitasClass = normalRatio >= 0.75 ? "text-val-green" : normalRatio >= 0.40 ?
                    "text-warning" : "text-danger";
                $("#summary_kualitas").text(normalRatio >= 0.75 ? "Baik" : normalRatio >= 0.40 ? "Sedang" :
                        "Buruk")
                    .removeClass("text-val-green text-warning text-danger text-slate").addClass(
                        kualitasClass);
            }

            renderTablePage(1);

            if (typeof callback === 'function') callback();
        },
        error: function(xhr, status, error) {
            console.error("Error loading history data:", error);
            if (typeof callback === 'function') callback();
        }
    });
}

function renderTablePage(page) {
    currentPage = page;
    let tableBody = $("#historyBody");
    tableBody.empty();

    let totalData = currentFilteredData.length;

    if (totalData === 0) {
        tableBody.append('<tr><td colspan="8" class="text-center py-4 text-slate">🔍 Data tidak ditemukan</td></tr>');
        $("#page-range").text("0–0");
        $("#page-total").text("0");
        $("#pagination-wrapper").empty();
        return;
    }

    let startIndex = (page - 1) * itemsPerPage;
    let endIndex = Math.min(startIndex + itemsPerPage, totalData);
    let pageData = currentFilteredData.slice(startIndex, endIndex);

    pageData.forEach(function(data) {
        let dateObj = new Date(data.created_at);
        let datePart = dateObj.toLocaleDateString("id-ID", {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });

        let rDate = data.roundedDate || dateObj;
        let hours = String(rDate.getHours()).padStart(2, '0');
        let mins = String(rDate.getMinutes()).padStart(2, '0');
        let timePart = `${hours}:${mins}:00`;

        let tdsValue = data.tds ? parseFloat(data.tds) : 0;
        let statusInfo = getStatusInfo(data.kualitas);
        let badgeHTML = getKualitasBadge(data.kualitas);

        let row = `
            <tr>
                <td class="ps-4 fw-bold text-main-dark print-text-clean" style="font-size:14px;">${datePart}</td>
                <td class="text-slate print-text-clean" style="font-size:14px;">${timePart}</td>
                <td class="text-val-teal fw-bold print-text-clean">${data.ph}</td>
                <td class="text-val-green fw-bold print-text-clean">${data.suhu}</td>
                <td class="text-val-green fw-bold print-text-clean">${tdsValue.toFixed(2)}</td>
                <td class="text-val-purple fw-bold print-text-clean">${data.kekeruhan}</td>
                <td>${badgeHTML}</td>
                <td class="pe-4 ${statusInfo.class} fw-bold print-text-clean" style="font-size:14px;">
                    <span class="status-dot" style="background-color: ${statusInfo.color};"></span> <span class="status-text">${statusInfo.label}</span>
                </td>
            </tr>
        `;
        tableBody.append(row);
    });

    $("#page-range").text(`${startIndex + 1}–${endIndex}`);
    $("#page-total").text(totalData);

    renderPaginationControls(totalData, page);
}

function renderPaginationControls(totalData, page) {
    let totalPages = Math.ceil(totalData / itemsPerPage);
    let wrapper = $("#pagination-wrapper");
    wrapper.empty();

    if (totalPages <= 1) return;

    let prevDisabled = page === 1 ? 'disabled' : '';
    let prevOnClick = page > 1 ? `onclick="renderTablePage(${page - 1})"` : '';
    wrapper.append(`<button class="page-btn nav-btn ${prevDisabled}" ${prevOnClick}>&lsaquo;</button>`);

    let startPage = Math.max(1, page - 2);
    let endPage = Math.min(totalPages, startPage + 4);

    if (endPage - startPage < 4) {
        startPage = Math.max(1, endPage - 4);
    }

    if (startPage > 1) {
        wrapper.append(`<button class="page-btn" onclick="renderTablePage(1)">1</button>`);
        if (startPage > 2) {
            wrapper.append(`<span class="px-1 text-slate small align-self-center">...</span>`);
        }
    }

    for (let i = startPage; i <= endPage; i++) {
        let active = i === page ? 'active' : '';
        wrapper.append(`<button class="page-btn ${active}" onclick="renderTablePage(${i})">${i}</button>`);
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            wrapper.append(`<span class="px-1 text-slate small align-self-center">...</span>`);
        }
        wrapper.append(`<button class="page-btn" onclick="renderTablePage(${totalPages})">${totalPages}</button>`);
    }

    let nextDisabled = page === totalPages ? 'disabled' : '';
    let nextOnClick = page < totalPages ? `onclick="renderTablePage(${page + 1})"` : '';
    wrapper.append(`<button class="page-btn nav-btn ${nextDisabled}" ${nextOnClick}>&rsaquo;</button>`);
}

function renderAllRowsForPrint() {
    let tableBody = $("#historyBody");
    tableBody.empty();

    currentFilteredData.forEach(function(data) {
        let dateObj = new Date(data.created_at);
        let datePart = dateObj.toLocaleDateString("id-ID", {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        let rDate = data.roundedDate || dateObj;
        let hours = String(rDate.getHours()).padStart(2, '0');
        let mins = String(rDate.getMinutes()).padStart(2, '0');
        let timePart = `${hours}:${mins}:00`;

        let tdsValue = data.tds ? parseFloat(data.tds) : 0;
        let statusInfo = getStatusInfo(data.kualitas);
        let badgeHTML = getKualitasBadge(data.kualitas);

        let row = `
            <tr>
                <td class="ps-4 fw-bold text-main-dark print-text-clean" style="font-size:14px;">${datePart}</td>
                <td class="text-slate print-text-clean" style="font-size:14px;">${timePart}</td>
                <td class="text-val-teal fw-bold print-text-clean">${data.ph}</td>
                <td class="text-val-green fw-bold print-text-clean">${data.suhu}</td>
                <td class="text-val-green fw-bold print-text-clean">${tdsValue.toFixed(2)}</td>
                <td class="text-val-purple fw-bold print-text-clean">${data.kekeruhan}</td>
                <td>${badgeHTML}</td>
                <td class="pe-4 ${statusInfo.class} fw-bold print-text-clean" style="font-size:14px;">
                    <span class="status-dot" style="background-color: ${statusInfo.color};"></span> <span class="status-text">${statusInfo.label}</span>
                </td>
            </tr>
        `;
        tableBody.append(row);
    });
}

function printPDF() {
    let printDate = new Date().toLocaleString('id-ID', {
        day: 'numeric',
        month: 'numeric',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    }).replace(/\./g, ':');
    let totalData = $("#summary_total").text();

    $("#printSubtitle").text(`Dicetak: ${printDate} - Total: ${totalData} data`);

    renderAllRowsForPrint();
    window.print();
    renderTablePage(currentPage);
}

async function exportTableToExcel() {
    const workbook = new ExcelJS.Workbook();
    const worksheet = workbook.addWorksheet("Laporan");

    worksheet.mergeCells('A1:H1');
    const titleCell = worksheet.getCell('A1');
    titleCell.value = 'AQUATOR — Laporan Kualitas Air';
    titleCell.font = {
        name: 'Arial',
        size: 16,
        bold: true,
        color: {
            argb: 'FF1A6DC4'
        }
    };

    let printDate = new Date().toLocaleString('id-ID', {
        day: 'numeric',
        month: 'numeric',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    }).replace(/\./g, ':');
    const totalData = $("#summary_total").text();

    worksheet.mergeCells('A2:H2');
    const subtitleCell = worksheet.getCell('A2');
    subtitleCell.value = `Dicetak: ${printDate} - Total: ${totalData} data`;
    subtitleCell.font = {
        name: 'Arial',
        size: 10,
        color: {
            argb: 'FF4A7A78'
        }
    };

    worksheet.addRow([]);

    const headerRow = worksheet.getRow(4);
    headerRow.values = ['Tanggal', 'Waktu', 'pH', 'Suhu (°C)', 'TDS (ppm)', 'Kekeruhan (NTU)', 'Kualitas Air',
        'Status'
    ];
    headerRow.font = {
        bold: true,
        color: {
            argb: 'FF8C8C8C'
        }
    };
    headerRow.border = {
        bottom: {
            style: 'thin',
            color: {
                argb: 'FF9DD4D1'
            }
        }
    };

    worksheet.columns = [{
            key: "tanggal",
            width: 15
        },
        {
            key: "waktu",
            width: 15
        },
        {
            key: "ph",
            width: 10
        },
        {
            key: "suhu",
            width: 15
        },
        {
            key: "tds",
            width: 15
        },
        {
            key: "kekeruhan",
            width: 20
        },
        {
            key: "kualitas_air",
            width: 15
        },
        {
            key: "status",
            width: 15
        }
    ];

    currentFilteredData.forEach(data => {
        let dateObj = new Date(data.created_at);
        let datePart = dateObj.toLocaleDateString("id-ID", {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        let rDate = data.roundedDate || dateObj;
        let hours = String(rDate.getHours()).padStart(2, '0');
        let mins = String(rDate.getMinutes()).padStart(2, '0');
        let timePart = `${hours}:${mins}:00`;

        let tdsValue = data.tds ? parseFloat(data.tds) : 0;
        let statusInfo = getStatusInfo(data.kualitas);
        let kualitasText = parseFloat(data.kualitas) >= 75 ? "Baik" : parseFloat(data.kualitas) >= 40 ?
            "Sedang" : "Buruk";

        worksheet.addRow({
            tanggal: datePart,
            waktu: timePart,
            ph: parseFloat(data.ph) || 0,
            suhu: parseFloat(data.suhu) || 0,
            tds: tdsValue,
            kekeruhan: parseFloat(data.kekeruhan) || 0,
            kualitas_air: kualitasText,
            status: statusInfo.label
        });
    });

    const buffer = await workbook.xlsx.writeBuffer();
    saveAs(new Blob([buffer]), "Laporan_Kualitas_Air_Aquator.xlsx");
}

$(document).ready(function() {
    setDefaultDates();
    loadHistoryData();
    setInterval(loadHistoryData, 30000);

    $("#start_date, #end_date, #status_filter").on("keypress", function(e) {
        if (e.which === 13) {
            handleApplyFilter();
        }
    });
});
</script>
@endsection