document.addEventListener('DOMContentLoaded', function () {
    const configJenjang = document.getElementById('config_jenjang').value;
    const jenjangSelect = document.getElementById('jenjang_select');
    const inputKode = document.getElementById('kode_jurusan');
    const inputNama = document.getElementById('nama_jurusan');

    if (jenjangSelect) {
        // 1. Samakan nilai dropdown dengan Identitas Sekolah
        jenjangSelect.value = configJenjang;

        // 2. KUNCI DROPDOWN (Semua Jenjang Terkunci)
        // Agar tidak rancu, user tidak bisa mengubah jenjang di sini
        jenjangSelect.disabled = true;

        // 3. Logika Isi Otomatis
        if (configJenjang === 'SD' || configJenjang === 'SMP') {
            // Jika SD/SMP, paksa isi UMUM dan kunci inputnya
            inputKode.value = 'UMUM';
            inputNama.value = 'Umum';
            inputKode.readOnly = true;
            inputNama.readOnly = true;
            inputKode.style.backgroundColor = '#e9ecef';
            inputNama.style.backgroundColor = '#e9ecef';
        } else {
            // Jika SMA/SMK, biarkan kosong agar bisa diisi (IPA/IPS/TKJ)
            // Namun dropdown Jenjang tetap terkunci di atas
            inputKode.readOnly = false;
            inputNama.readOnly = false;
            inputKode.style.backgroundColor = '#ffffff';
            inputNama.style.backgroundColor = '#ffffff';
        }
    }
});