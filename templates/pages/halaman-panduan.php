<?php
$level = $this->session->userdata('level');
if (!$level) {
	$level = 'Pengguna';
}
?>
<style>
	.guide-wrapper {
		max-width: 1100px;
		margin: 0 auto 40px auto;
	}
	.guide-header {
		background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0369a1 100%);
		border-radius: 16px;
		padding: 28px 36px;
		color: #ffffff;
		margin-bottom: 24px;
		box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap;
		gap: 16px;
	}
	.guide-header h2 {
		font-size: 24px;
		font-weight: 800;
		margin: 0 0 6px 0;
		letter-spacing: -0.5px;
		display: flex;
		align-items: center;
		gap: 10px;
	}
	.guide-header p {
		margin: 0;
		font-size: 13.5px;
		color: #cbd5e1;
		line-height: 1.5;
	}
	.badge-role-tag {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-size: 11.5px;
		font-weight: 700;
		padding: 4px 10px;
		border-radius: 20px;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		vertical-align: middle;
	}
	.btn-print-guide {
		background: #0284c7;
		color: #ffffff;
		border: none;
		padding: 10px 20px;
		border-radius: 8px;
		font-size: 13px;
		font-weight: 700;
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		box-shadow: 0 4px 12px rgba(2, 132, 199, 0.4);
		transition: all 0.2s;
		text-decoration: none;
	}
	.btn-print-guide:hover {
		background: #0369a1;
		color: #ffffff;
		text-decoration: none;
		transform: translateY(-2px);
	}
	.guide-nav {
		display: flex;
		gap: 10px;
		margin-bottom: 24px;
		flex-wrap: wrap;
	}
	.guide-tab-btn {
		background: #ffffff;
		border: 1px solid #e2e8f0;
		color: #475569;
		padding: 10px 18px;
		border-radius: 10px;
		font-size: 13px;
		font-weight: 700;
		cursor: pointer;
		transition: all 0.2s;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		text-decoration: none;
	}
	.guide-tab-btn:hover {
		background: #f8fafc;
		color: #0284c7;
		border-color: #cbd5e1;
		text-decoration: none;
	}
	.guide-tab-btn.active {
		background: #0284c7;
		color: #ffffff;
		border-color: #0284c7;
		box-shadow: 0 2px 8px rgba(2, 132, 199, 0.35);
	}
	.guide-card {
		background: #ffffff;
		border: 1px solid #e2e8f0;
		border-radius: 14px;
		padding: 28px;
		margin-bottom: 24px;
		box-shadow: 0 4px 10px -2px rgba(0, 0, 0, 0.04);
	}
	.guide-card-title {
		font-size: 18px;
		font-weight: 800;
		color: #0f172a;
		margin-bottom: 20px;
		padding-bottom: 12px;
		border-bottom: 2px solid #f1f5f9;
		display: flex;
		align-items: center;
		gap: 10px;
	}
	.step-list {
		display: flex;
		flex-direction: column;
		gap: 20px;
	}
	.step-item {
		display: flex;
		gap: 18px;
		align-items: flex-start;
	}
	.step-badge {
		width: 32px;
		height: 32px;
		border-radius: 50%;
		background: #e0f2fe;
		color: #0284c7;
		font-size: 14px;
		font-weight: 800;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
	}
	.step-content {
		flex-grow: 1;
	}
	.step-title {
		font-size: 15px;
		font-weight: 700;
		color: #1e293b;
		margin-bottom: 6px;
	}
	.step-desc {
		font-size: 13.5px;
		color: #64748b;
		line-height: 1.6;
		margin: 0 0 10px 0;
	}
	.callout-box {
		background: #f8fafc;
		border-left: 4px solid #0284c7;
		padding: 12px 16px;
		border-radius: 0 8px 8px 0;
		font-size: 13px;
		color: #334155;
		margin-top: 8px;
		line-height: 1.6;
	}
	.callout-warning {
		background: #fffbeb;
		border-left-color: #f59e0b;
		color: #92400e;
	}
	.callout-success {
		background: #f0fdf4;
		border-left-color: #16a34a;
		color: #166534;
	}
	.callout-danger {
		background: #fef2f2;
		border-left-color: #ef4444;
		color: #991b1b;
	}
	.account-table {
		width: 100%;
		border-collapse: collapse;
		margin-top: 14px;
		font-size: 13px;
	}
	.account-table th {
		background: #f1f5f9;
		color: #1e293b;
		text-align: left;
		padding: 10px 14px;
		font-weight: 700;
		border: 1px solid #e2e8f0;
	}
	.account-table td {
		padding: 10px 14px;
		border: 1px solid #e2e8f0;
		color: #334155;
	}

	@media print {
		.guide-nav, .btn-print-guide, .header-panel, .dropdown-info, footer {
			display: none !important;
		}
		body {
			background: #ffffff !important;
			padding: 0 !important;
		}
		.guide-wrapper {
			max-width: 100% !important;
			margin: 0 !important;
		}
		.guide-card {
			border: 1px solid #cbd5e1 !important;
			box-shadow: none !important;
			page-break-inside: avoid;
		}
	}
</style>

<div class="guide-wrapper">
	<!-- Header Banner Panduan Dinamis Berdasarkan Role -->
	<div class="guide-header">
		<div>
			<h2>
				<i class="fas fa-book-reader"></i>
				<?php if ($level == 'Pengguna'): ?>
					Buku Panduan Karyawan (Pengguna)
					<span class="badge-role-tag" style="background:#10b981; color:#fff;">Karyawan</span>
				<?php elseif ($level == 'Resepsionis'): ?>
					Buku Panduan Resepsionis (Front Office)
					<span class="badge-role-tag" style="background:#f59e0b; color:#fff;">Resepsionis</span>
				<?php else: ?>
					Buku Panduan Administrator (GA & IT)
					<span class="badge-role-tag" style="background:#0284c7; color:#fff;">Admin Sistem</span>
				<?php endif; ?>
			</h2>
			<p>
				<?php if ($level == 'Pengguna'): ?>
					Standard Operating Procedure (SOP) & Alur Reservasi Ruang Meeting, Sinkronisasi Kalender & Check-in bagi Karyawan PT Medquest Jaya Global.
				<?php elseif ($level == 'Resepsionis'): ?>
					Standard Operating Procedure (SOP) Operasional Front Desk, Verifikasi Kehadiran & Tata Kelola Ruang Meeting PT Medquest Jaya Global.
				<?php else: ?>
					Standard Operating Procedure (SOP) Tata Kelola Fasilitas, Manajemen Akun Pengguna, Analisis Utilisasi & Pelaporan PT Medquest Jaya Global.
				<?php endif; ?>
			</p>
		</div>
		<div>
			<button onclick="window.print()" class="btn-print-guide">
				<i class="fas fa-print"></i> Cetak / Simpan PDF
			</button>
		</div>
	</div>

	<!-- Navigasi Tab Peran Sesuai Level Akses -->
	<div class="guide-nav">
		<?php if ($level == 'Pengguna'): ?>
			<a href="#karyawan" class="guide-tab-btn active" onclick="switchGuide('karyawan', this)">
				<i class="fas fa-user"></i> 1. Panduan Reservasi & Check-In Karyawan
			</a>
			<a href="#aturan-karyawan" class="guide-tab-btn" onclick="switchGuide('aturan-karyawan', this)">
				<i class="fas fa-clipboard-check"></i> 2. Aturan, Etika & Kebijakan Meeting
			</a>

		<?php elseif ($level == 'Resepsionis'): ?>
			<a href="#resepsionis" class="guide-tab-btn active" onclick="switchGuide('resepsionis', this)">
				<i class="fas fa-concierge-bell"></i> 1. Panduan Operasional Resepsionis
			</a>
			<a href="#aturan-resepsionis" class="guide-tab-btn" onclick="switchGuide('aturan-resepsionis', this)">
				<i class="fas fa-tasks"></i> 2. SOP Kesiapan & Standar Fasilitas Ruang
			</a>

		<?php else: /* Admin */ ?>
			<a href="#admin" class="guide-tab-btn active" onclick="switchGuide('admin', this)">
				<i class="fas fa-user-shield"></i> 1. Panduan Administrator (GA & IT)
			</a>
			<a href="#aturan-admin" class="guide-tab-btn" onclick="switchGuide('aturan-admin', this)">
				<i class="fas fa-database"></i> 2. Aturan Sistem & Kredensial Demo
			</a>
			<a href="#karyawan" class="guide-tab-btn" onclick="switchGuide('karyawan', this)">
				<i class="fas fa-eye"></i> Supervisi: SOP Karyawan
			</a>
			<a href="#resepsionis" class="guide-tab-btn" onclick="switchGuide('resepsionis', this)">
				<i class="fas fa-eye"></i> Supervisi: SOP Resepsionis
			</a>
		<?php endif; ?>
	</div>

	<!-- ============================================== -->
	<!-- BAGIAN: PANDUAN KARYAWAN                       -->
	<!-- (Tampil untuk level Pengguna atau Admin)       -->
	<!-- ============================================== -->
	<?php if ($level == 'Pengguna' || $level == 'Admin'): ?>
	<div id="section-karyawan" class="guide-section" style="<?php echo ($level == 'Pengguna') ? 'display:block;' : 'display:none;'; ?>">
		<div class="guide-card">
			<div class="guide-card-title">
				<i class="fas fa-user" style="color:#0284c7;"></i>
				<span>Panduan Operasional Karyawan (Pengguna / Pemohon Meeting)</span>
			</div>
			<div class="step-list">
				<div class="step-item">
					<div class="step-badge">1</div>
					<div class="step-content">
						<div class="step-title">Cek Ketersediaan Ruangan</div>
						<p class="step-desc">
							Buka menu <strong>"Ketersediaan Ruangan"</strong> atau klik <strong>"Pilih Slot"</strong> pada Beranda. Pilih tanggal meeting yang diinginkan. Sistem akan menampilkan status slot per jam (08:00 - 17:00 WIB). Slot yang berwarna abu-abu/terisi tidak dapat dipilih.
						</p>
						<div class="callout-box">
							<i class="fas fa-lightbulb" style="color:#0284c7; margin-right:5px;"></i>
							<strong>Tips:</strong> Cek kapasitas ruangan (contoh: <em>Pulau Kalimantan</em> muat s.d 15 orang, <em>Pulau Komodo</em> 6 orang) agar sesuai dengan jumlah peserta rapat Anda.
						</div>
					</div>
				</div>

				<div class="step-item">
					<div class="step-badge">2</div>
					<div class="step-content">
						<div class="step-title">Mengisi Formulir Booking Ruang Meeting</div>
						<p class="step-desc">
							Klik tombol <strong>"Booking"</strong> pada kartu ruangan pilihan Anda. Lengkapi formulir:
						</p>
						<ul style="margin: 0 0 10px 20px; font-size:13.5px; color:#475569; line-height:1.6;">
							<li><strong>Agenda / Perihal:</strong> Tulis judul meeting dengan jelas (e.g., <em>Review Kinerja Q3 Divisi Sales</em>).</li>
							<li><strong>Tanggal & Jam:</strong> Pilih jam mulai dan jam selesai rapat.</li>
							<li><strong>Jumlah Peserta:</strong> Masukkan estimasi peserta untuk pertimbangan fasilitas.</li>
							<li><strong>Kebutuhan Tambahan:</strong> Centang jika butuh proyektor, kabel HDMI, pointer, atau mikrofon.</li>
						</ul>
						<div class="callout-box callout-warning">
							<i class="fas fa-exclamation-triangle" style="margin-right:5px;"></i>
							<strong>Pemberitahuan:</strong> Jika waktu meeting bentrok dengan peminjam lain, sistem akan otomatis menolak penyimpanan form dan memberikan notifikasi error.
						</div>
					</div>
				</div>

				<div class="step-item">
					<div class="step-badge">3</div>
					<div class="step-content">
						<div class="step-title">Sinkronisasi ke Kalender Kerja (Google Calendar & Outlook)</div>
						<p class="step-desc">
							Setelah berhasil booking, buka menu <strong>"Data Peminjaman"</strong>. Pada baris peminjaman Anda:
						</p>
						<ul style="margin: 0 0 10px 20px; font-size:13.5px; color:#475569; line-height:1.6;">
							<li>Klik tombol <strong><i class="fab fa-google"></i> Google Calendar</strong> untuk menambahkan meeting langsung ke kalender Gmail perusahaan Anda.</li>
							<li>Klik tombol <strong><i class="fas fa-calendar-plus"></i> Outlook (.ics)</strong> untuk mengunduh file kalender Outlook / Apple iCal.</li>
						</ul>
					</div>
				</div>

				<div class="step-item">
					<div class="step-badge">4</div>
					<div class="step-content">
						<div class="step-title">Wajib Check-In di Hari Pelaksanaan (Toleransi 10 Menit)</div>
						<p class="step-desc">
							Saat hari-H tiba dan Anda telah hadir di depan ruangan meeting:
						</p>
						<ul style="margin: 0 0 10px 20px; font-size:13.5px; color:#475569; line-height:1.6;">
							<li>Buka aplikasi lewat smartphone atau scan <strong>QR Code Poster</strong> yang terpasang di samping pintu ruang meeting.</li>
							<li>Atau klik tombol <strong>"Check-In Sekarang"</strong> di halaman Data Peminjaman Anda.</li>
						</ul>
						<div class="callout-box callout-danger">
							<i class="fas fa-clock" style="margin-right:5px;"></i>
							<strong>Aturan Kritis Auto-Cancel:</strong> Anda memiliki batas toleransi <strong>10 menit</strong> setelah jam mulai meeting. Jika dalam 10 menit tidak melakukan Check-In, status reservasi Anda otomatis <strong>DIBATALKAN</strong> oleh sistem dan ruang meeting dilepaskan untuk karyawan lain.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<!-- ============================================== -->
	<!-- BAGIAN: ATURAN & KEBIJAKAN KARYAWAN            -->
	<!-- (Tampil khusus untuk Pengguna)                 -->
	<!-- ============================================== -->
	<?php if ($level == 'Pengguna'): ?>
	<div id="section-aturan-karyawan" class="guide-section" style="display:none;">
		<div class="guide-card">
			<div class="guide-card-title">
				<i class="fas fa-clipboard-check" style="color:#0284c7;"></i>
				<span>Aturan, Etika & Kebijakan Reservasi Ruang Meeting PT Medquest Jaya Global</span>
			</div>
			
			<div class="callout-box callout-success" style="margin-bottom:20px;">
				<h4 style="margin:0 0 8px 0; font-size:15px; color:#166534;"><i class="fas fa-check-circle"></i> Ringkasan Aturan Penting:</h4>
				1. <strong>Toleransi Kehadiran</strong>: Maksimal 10 menit dari jadwal mulai rapat.<br>
				2. <strong>Auto-Cancel Otomatis</strong>: Peminjaman tanpa check-in dalam 10 menit akan otomatis dibatalkan sistem demi efisiensi ruangan kantor.<br>
				3. <strong>Kebersihan & Ketertiban</strong>: Pemohon wajib memastikan sisa konsumsi, papan tulis, dan spidol dirapikan kembali setelah meeting.<br>
				4. <strong>Fasilitas Elektronik</strong>: Harap matikan AC dan Proyektor / TV Screen setelah ruangan selesai digunakan.
			</div>

			<div style="font-weight:700; color:#0f172a; margin: 18px 0 10px 0; font-size:14px;">
				FAQ (Pertanyaan Umum Karyawan):
			</div>
			<div class="step-list">
				<div class="step-item">
					<div class="step-badge" style="background:#f1f5f9; color:#475569;">Q</div>
					<div class="step-content">
						<div class="step-title">Bagaimana jika meeting selesai lebih cepat?</div>
						<p class="step-desc">
							Anda dapat menginformasikan kepada Resepsionis / Operator agar status peminjaman diubah menjadi <strong>Selesai</strong>, sehingga ruangan dapat segera digunakan rekan kerja yang membutuhkan.
						</p>
					</div>
				</div>
				<div class="step-item">
					<div class="step-badge" style="background:#f1f5f9; color:#475569;">Q</div>
					<div class="step-content">
						<div class="step-title">Bagaimana jika HP saya mati dan tidak bisa scan QR Check-in?</div>
						<p class="step-desc">
							Segera hubungi Resepsionis di meja Front Desk. Resepsionis memiliki wewenang untuk melakukan <em>Manual Check-In</em> atas nama akun Anda sebelum batas toleransi 10 menit habis.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<!-- ============================================== -->
	<!-- BAGIAN: PANDUAN RESEPSIONIS                    -->
	<!-- (Tampil untuk Resepsionis atau Admin)          -->
	<!-- ============================================== -->
	<?php if ($level == 'Resepsionis' || $level == 'Admin'): ?>
	<div id="section-resepsionis" class="guide-section" style="<?php echo ($level == 'Resepsionis') ? 'display:block;' : 'display:none;'; ?>">
		<div class="guide-card">
			<div class="guide-card-title">
				<i class="fas fa-concierge-bell" style="color:#0284c7;"></i>
				<span>Panduan Operasional Resepsionis (Operator / Front Desk)</span>
			</div>
			<div class="step-list">
				<div class="step-item">
					<div class="step-badge">1</div>
					<div class="step-content">
						<div class="step-title">Memantau Jadwal & Tamu Hari Ini</div>
						<p class="step-desc">
							Setiap pagi, buka menu <strong>"Data Peminjaman"</strong> dan manfaatkan filter cepat <strong>"Hari Ini Saja"</strong> untuk melihat daftar agenda meeting, nama penanggung jawab, serta tamu eksternal yang akan hadir di PT Medquest Jaya Global.
						</p>
					</div>
				</div>

				<div class="step-item">
					<div class="step-badge">2</div>
					<div class="step-content">
						<div class="step-title">Verifikasi & Persetujuan Peminjaman</div>
						<p class="step-desc">
							Jika ada pengajuan dengan status <em>Menunggu Persetujuan</em>:
						</p>
						<ul style="margin: 0 0 10px 20px; font-size:13.5px; color:#475569; line-height:1.6;">
							<li>Klik tombol <strong>"Setujui"</strong> jika ruangan dan fasilitas siap.</li>
							<li>Klik tombol <strong>"Tolak"</strong> jika ada kendala mendesak atau maintenance ruangan, sertakan alasan penolakan.</li>
						</ul>
					</div>
				</div>

				<div class="step-item">
					<div class="step-badge">3</div>
					<div class="step-content">
						<div class="step-title">Membantu Check-In & Menyelesaikan Penggunaan Ruang</div>
						<p class="step-desc">
							Bila peminjam telah hadir namun mengalami kendala scan barcode mandiri, Resepsionis dapat menekan tombol <strong>"Check-In Manual"</strong> pada baris data peminjaman terkait. Setelah rapat bubar, tandai status meeting menjadi <strong>"Selesai"</strong>.
						</p>
					</div>
				</div>

				<div class="step-item">
					<div class="step-badge">4</div>
					<div class="step-content">
						<div class="step-title">Mencetak Rekapitulasi Laporan Harian & Bulanan</div>
						<p class="step-desc">
							Untuk arsip resepsionis dan laporan harian ke General Affairs (GA):
						</p>
						<ul style="margin: 0 0 10px 20px; font-size:13.5px; color:#475569; line-height:1.6;">
							<li>Gunakan tombol <strong><i class="fas fa-file-excel"></i> Export Excel</strong> untuk mengunduh rekap spreadsheet (.csv UTF-8).</li>
							<li>Gunakan tombol <strong><i class="fas fa-print"></i> Cetak PDF</strong> untuk mencetak rekapitulasi formal siap tanda tangan.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<!-- ============================================== -->
	<!-- BAGIAN: SOP KESIAPAN RUANGAN RESEPSIONIS       -->
	<!-- (Tampil khusus untuk Resepsionis)              -->
	<!-- ============================================== -->
	<?php if ($level == 'Resepsionis'): ?>
	<div id="section-aturan-resepsionis" class="guide-section" style="display:none;">
		<div class="guide-card">
			<div class="guide-card-title">
				<i class="fas fa-tasks" style="color:#0284c7;"></i>
				<span>SOP Kesiapan Ruangan & Checklist Front Desk PT Medquest Jaya Global</span>
			</div>
			
			<div class="callout-box callout-success" style="margin-bottom:20px;">
				<h4 style="margin:0 0 8px 0; font-size:15px; color:#166534;"><i class="fas fa-clipboard-list"></i> Checklist Rutin Front Desk:</h4>
				1. <strong>Pagi Hari (07:45 WIB)</strong>: Nyalakan AC ruang meeting utama 15 menit sebelum rapat pertama dimulai.<br>
				2. <strong>Cek Perangkat Presentasi</strong>: Pastikan kabel HDMI, sambungan proyektor/TV, dan pointer presentasi berada di tempatnya.<br>
				3. <strong>Penyambutan Tamu Luar</strong>: Cocokkan identitas tamu perusahaan dengan agenda meeting yang terdaftar di sistem.<br>
				4. <strong>Turnaround Room (15 Menit)</strong>: Setelah rapat selesai, lakukan pengecekan visual kebersihan sebelum dipakai sesi berikutnya.
			</div>
		</div>
	</div>
	<?php endif; ?>

	<!-- ============================================== -->
	<!-- BAGIAN: PANDUAN ADMINISTRATOR                  -->
	<!-- (Tampil untuk level Admin)                     -->
	<!-- ============================================== -->
	<?php if ($level == 'Admin'): ?>
	<div id="section-admin" class="guide-section" style="display:block;">
		<div class="guide-card">
			<div class="guide-card-title">
				<i class="fas fa-user-shield" style="color:#0284c7;"></i>
				<span>Panduan Administrator Sistem (General Affairs & Tim IT)</span>
			</div>
			<div class="step-list">
				<div class="step-item">
					<div class="step-badge">1</div>
					<div class="step-content">
						<div class="step-title">Manajemen Master Data Ruang Meeting & Cetak Poster QR</div>
						<p class="step-desc">
							Buka menu <strong>"Data Ruang"</strong> untuk menambah ruangan baru, mengedit kapasitas, atau mengubah fasilitas:
						</p>
						<ul style="margin: 0 0 10px 20px; font-size:13.5px; color:#475569; line-height:1.6;">
							<li>Klik tombol <strong>"Poster QR"</strong> pada setiap ruangan untuk men-generate poster akrilik siap cetak (termasuk instruksi scan untuk karyawan).</li>
							<li>Tempelkan poster QR hasil print di dekat pintu masuk tiap ruangan.</li>
						</ul>
					</div>
				</div>

				<div class="step-item">
					<div class="step-badge">2</div>
					<div class="step-content">
						<div class="step-title">Manajemen Akun Pengguna & Level Akses</div>
						<p class="step-desc">
							Buka menu <strong>"Data Pengguna"</strong> untuk mengelola hak akses sistem:
						</p>
						<ul style="margin: 0 0 10px 20px; font-size:13.5px; color:#475569; line-height:1.6;">
							<li><strong>Admin:</strong> Akses kontrol penuh, master data, konfigurasi dan analitik.</li>
							<li><strong>Resepsionis:</strong> Akses operasional harian, verifikasi kehadiran, dan rekapitulasi data.</li>
							<li><strong>Pengguna:</strong> Akses mandiri karyawan untuk pemesanan ruang dan sinkronisasi kalender.</li>
						</ul>
					</div>
				</div>

				<div class="step-item">
					<div class="step-badge">3</div>
					<div class="step-content">
						<div class="step-title">Pemantauan Dasbor Analitik & Utilisasi Eksekutif</div>
						<p class="step-desc">
							Pada menu <strong>"Beranda"</strong> (khusus Admin), sistem menyajikan widget Business Intelligence (BI):
						</p>
						<ul style="margin: 0 0 10px 20px; font-size:13.5px; color:#475569; line-height:1.6;">
							<li><strong>Top Ruangan Terfavorit:</strong> Memantau ruangan yang paling sering digunakan untuk pertimbangan ekspansi fasilitas.</li>
							<li><strong>Tingkat Kepatuhan Kehadiran:</strong> Menghitung persentase meeting yang sukses check-in vs dibatalkan.</li>
							<li><strong>Departemen Paling Aktif:</strong> Statistik utilisasi divisi kerja (Finance, Sales, GA, IT, dsb).</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- ============================================== -->
	<!-- BAGIAN: ATURAN SISTEM & KREDENSIAL DEMO ADMIN  -->
	<!-- ============================================== -->
	<div id="section-aturan-admin" class="guide-section" style="display:none;">
		<div class="guide-card">
			<div class="guide-card-title">
				<i class="fas fa-database" style="color:#0284c7;"></i>
				<span>Aturan Sistem, Parameter Otomasi & Akun Uji Coba (Demo Credentials)</span>
			</div>
			
			<div class="callout-box callout-success" style="margin-bottom:20px;">
				<strong>Parameter Otomasi Sistem Terpasang:</strong><br>
				1. <strong>Toleransi Check-In</strong>: 10 menit terhitung dari jam mulai meeting.<br>
				2. <strong>Auto-Cancel Bot</strong>: Jika >10 menit belum check-in, status booking berubah menjadi <code>Dibatalkan</code> dan slot langsung bebas untuk orang lain.<br>
				3. <strong>Pencegahan Bentrok (Double-Booking Lock)</strong>: Validasi jam di tingkat controller PHP dan query database.
			</div>

			<div style="font-weight:700; color:#0f172a; margin-bottom:8px; font-size:14px;">
				Daftar Akun Demo untuk Pengujian:
			</div>
			<table class="account-table">
				<thead>
					<tr>
						<th>Level Akses</th>
						<th>Username</th>
						<th>Password</th>
						<th>Nama Lengkap</th>
						<th>Tujuan Peran</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><span class="badge" style="background:#0284c7; color:#fff; padding:4px 8px; border-radius:4px;">Admin</span></td>
						<td><code>ryan</code></td>
						<td><code>123123</code></td>
						<td>Ryan (Administrator)</td>
						<td>Kelola sistem penuh, data ruangan, user, dan pantau analitik.</td>
					</tr>
					<tr>
						<td><span class="badge" style="background:#f59e0b; color:#fff; padding:4px 8px; border-radius:4px;">Resepsionis</span></td>
						<td><code>operator</code></td>
						<td><code>123123</code></td>
						<td>Operator Resepsionis</td>
						<td>Front desk: persetujuan agenda, verifikasi check-in, cetak laporan.</td>
					</tr>
					<tr>
						<td><span class="badge" style="background:#10b981; color:#fff; padding:4px 8px; border-radius:4px;">Pengguna</span></td>
						<td><code>nawal</code></td>
						<td><code>123123</code></td>
						<td>Nawwal Fadhil</td>
						<td>Karyawan: pemesanan slot ruangan & sinkronisasi kalender.</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<?php endif; ?>
</div>

<script>
function switchGuide(targetId, el) {
	// Sembunyikan semua section yang ada di halaman
	var sections = document.querySelectorAll('.guide-section');
	sections.forEach(function(sec) {
		sec.style.display = 'none';
	});

	// Hapus class active di semua tombol navigasi
	var btns = document.querySelectorAll('.guide-tab-btn');
	btns.forEach(function(btn) {
		btn.classList.remove('active');
	});

	// Tampilkan section yang dipilih
	var target = document.getElementById('section-' + targetId);
	if (target) {
		target.style.display = 'block';
	}
	if (el) {
		el.classList.add('active');
	}
}
</script>
