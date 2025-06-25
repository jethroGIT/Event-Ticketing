@extends('layout.layout')
@section('title', 'Scan QR Code Kehadiran')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-indigo-800 mb-6 text-center">Scan QR Code Kehadiran</h1>

        <div id="scan-section" class="bg-white p-6 rounded-xl shadow-md max-w-xl mx-auto">
            <!-- Upload Area -->
            <div class="upload-area border-2 border-dashed border-indigo-300 rounded-lg p-8 text-center mb-6 transition-colors hover:border-indigo-500">
                <input type="file" id="qr-upload" accept="image/*" class="hidden">
                <label for="qr-upload" class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <p class="text-indigo-600 font-medium mt-2">Pilih Gambar QR</p>
                    <p class="text-gray-500 text-sm mt-1">Atau drag & drop gambar ke sini</p>
                </label>
            </div>

            <div class="text-center">
                <button onclick="startCamera()" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center justify-center mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Scan dengan Kamera
                </button>
            </div>

            <!-- Preview Gambar QR -->
            <div id="qr-preview" class="mt-6 mb-4 hidden">
                <p class="text-sm text-gray-500 mb-2">Preview QR Code:</p>
                <img id="qr-image-preview" src="" alt="Preview" class="mx-auto w-48 border border-gray-300 rounded shadow">
            </div>

            <!-- Hasil Scan -->
            <div id="scan-result" class="mt-6 hidden">
                <div id="scan-status" class="text-center py-3 px-4 rounded-lg flex items-center justify-center">
                    <svg id="status-icon" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <!-- Icon will be replaced dynamically -->
                    </svg>
                    <span id="status-message"></span>
                </div>

                <div id="scan-details" class="mt-4 bg-gray-50 p-4 rounded-lg hidden">
                    <h3 class="font-medium text-gray-700 mb-3">Detail Kehadiran:</h3>
                    <div id="detail-grid" class="grid grid-cols-2 gap-3">
                        <!-- Details will be populated dynamically -->
                    </div>
                </div>

                <div class="mt-6">
                    <button onclick="resetScanner()" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition-colors">
                        Scan Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('ExtraJS')
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module">
        import QrScanner from 'https://cdn.jsdelivr.net/npm/qr-scanner@1.4.2/qr-scanner.min.js';

        const fileInput = document.getElementById('qr-upload');
        const qrImagePreview = document.getElementById('qr-image-preview');
        const qrPreviewContainer = document.getElementById('qr-preview');
        const scanResult = document.getElementById('scan-result');
        const scanStatus = document.getElementById('scan-status');
        const statusIcon = document.getElementById('status-icon');
        const statusMessage = document.getElementById('status-message');
        const scanDetails = document.getElementById('scan-details');
        const detailGrid = document.getElementById('detail-grid');

        // Handle file input change
        fileInput.addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (!file) return;

            // Show preview
            qrImagePreview.src = URL.createObjectURL(file);
            qrPreviewContainer.classList.remove('hidden');

            try {
                const token = await QrScanner.scanImage(file);
                showScanStatus('loading', 'QR terbaca, sedang validasi...');
                scanResult.classList.remove('hidden');

                await validateQRCode(token);
            } catch (err) {
                showScanStatus('error', 'Gagal membaca QR');
                scanDetails.classList.add('hidden');
                
                Swal.fire({
                    icon: 'error',
                    title: 'QR Tidak Terbaca',
                    text: err.message
                });
            }
        });

        // Drag and drop functionality
        const uploadArea = document.querySelector('.upload-area');
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('border-indigo-500', 'bg-indigo-50');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('border-indigo-500', 'bg-indigo-50');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('border-indigo-500', 'bg-indigo-50');
            
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                const event = new Event('change');
                fileInput.dispatchEvent(event);
            }
        });

        async function validateQRCode(qrToken) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                const response = await fetch('/kehadiran/scan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ qr_token: qrToken })
                });

                const result = await response.json();

                if (!response.ok) {
                    showScanStatus('error', result.message || 'Kesalahan server');
                    populateDetails(result);
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Validasi',
                        text: result.message || 'QR tidak valid'
                    });
                    return;
                }

                // Success case
                showScanStatus('success', 'Kehadiran berhasil dicatat');
                populateDetails(result.data);
                
                Swal.fire({
                    icon: 'success',
                    title: 'QR Valid!',
                    text: 'Kehadiran berhasil dicatat',
                    confirmButtonColor: '#4F46E5'
                });

            } catch (error) {
                showScanStatus('error', 'Gagal mengirim ke server');
                scanDetails.classList.add('hidden');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Koneksi Gagal',
                    text: error.message
                });
            }
        }

        function showScanStatus(type, message) {
            // Clear previous classes
            scanStatus.className = 'text-center py-3 px-4 rounded-lg flex items-center justify-center';
            
            // Set icon and styling based on type
            switch(type) {
                case 'loading':
                    scanStatus.classList.add('bg-yellow-100', 'text-yellow-800');
                    statusIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    `;
                    break;
                case 'success':
                    scanStatus.classList.add('bg-green-100', 'text-green-800');
                    statusIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    `;
                    scanDetails.classList.remove('hidden');
                    break;
                case 'error':
                    scanStatus.classList.add('bg-red-100', 'text-red-800');
                    statusIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    `;
                    scanDetails.classList.remove('hidden');
                    break;
            }
            
            statusMessage.textContent = message;
        }

        function populateDetails(data) {
            // Clear previous details
            detailGrid.innerHTML = '';
            
            if (!data) return;
            
            // Add common details
            if (data.id) {
                addDetailItem('ID Tiket', data.id);
            }
            
            // Add event session details if available
            if (data.EventSessions) {
                const session = data.EventSessions;
                addDetailItem('Sesi', session.nama_sesi);
                addDetailItem('Waktu', `${session.jam_mulai} - ${session.jam_selesai}`);
            }
            
            // Add message if present (for error cases)
            if (data.message) {
                addDetailItem('Keterangan', data.message);
            }
        }

        function addDetailItem(label, value) {
            const item = document.createElement('div');
            item.className = 'bg-white p-2 rounded border border-gray-200';
            item.innerHTML = `
                <div class="text-xs text-gray-500">${label}</div>
                <div class="font-medium">${value}</div>
            `;
            detailGrid.appendChild(item);
        }

        function resetScanner() {
            // Reset file input
            fileInput.value = '';
            
            // Reset preview
            qrImagePreview.src = '';
            qrPreviewContainer.classList.add('hidden');
            
            // Reset scan result
            scanResult.classList.add('hidden');
            scanDetails.classList.add('hidden');
            detailGrid.innerHTML = '';
            
            // Reset status
            scanStatus.className = 'text-center py-3 px-4 rounded-lg flex items-center justify-center';
            statusIcon.innerHTML = '';
            statusMessage.textContent = '';
            
            // Focus back on upload area for better UX
            document.querySelector('.upload-area').scrollIntoView({ behavior: 'smooth' });
        }

        // Camera function (placeholder)
        window.startCamera = () => {
            Swal.fire({
                icon: 'info',
                title: 'Fitur Belum Siap',
                text: 'Scan langsung dengan kamera masih dalam tahap pengembangan.'
            });
        };
    </script>
@endsection