document.addEventListener('DOMContentLoaded', function () {
    const configJenjang = document.getElementById('config_jenjang').value;
    const tingkatSelect = document.getElementById('tingkat_select');
    const jurusanSelect = document.getElementById('jurusan_select');

    if (configJenjang) {
        // --- 1. OTOMATISASI JURUSAN (SD/SMP) ---
        if (configJenjang === 'SD' || configJenjang === 'SMP') {
            const options = jurusanSelect.options;
            for (let i = 0; i < options.length; i++) {
                // Mencari opsi yang mengandung kata "umum"
                if (options[i].text.toLowerCase().includes('umum')) {
                    jurusanSelect.value = options[i].value; // Pilih ID-nya
                    break;
                }
            }
            // Kunci agar tidak diubah manual
            jurusanSelect.disabled = true;
            jurusanSelect.style.backgroundColor = '#e9ecef';
        }

        // --- 2. OTOMATISASI TINGKAT ---
        // Kita otomatis pilih tingkat pertama yang tersedia di dalam optgroup yang muncul
        if (tingkatSelect && tingkatSelect.options.length > 1) {
            // Mencari opsi pertama yang bukan "-- Pilih Tingkat --"
            for (let i = 0; i < tingkatSelect.options.length; i++) {
                if (tingkatSelect.options[i].value !== "") {
                    tingkatSelect.selectedIndex = i;
                    break;
                }
            }
        }
    }
});