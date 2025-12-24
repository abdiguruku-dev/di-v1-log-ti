/* --- FILE: public/js/custom-admin.js --- */

document.addEventListener("DOMContentLoaded", function () {
    // 1. LOGIC TOGGLE SIDEBAR (Mobile & Desktop)
    const toggleBtn = document.getElementById("sidebarToggle");
    const body = document.body;
    const content = document.getElementById("page-content-wrapper");
    const navLinks = document.querySelectorAll(
        '.nav-link:not([data-bs-toggle="collapse"])'
    );

    if (toggleBtn) {
        toggleBtn.onclick = function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (window.innerWidth >= 768) {
                body.classList.toggle("desktop-toggled");
                // Simpan status toggle di LocalStorage agar browser ingat
                localStorage.setItem(
                    "sb|desktop-toggle",
                    body.classList.contains("desktop-toggled")
                );
            } else {
                body.classList.toggle("mobile-toggled");
            }
        };
    }

    // Cek status toggle terakhir saat halaman dimuat
    if (
        window.innerWidth >= 768 &&
        localStorage.getItem("sb|desktop-toggle") === "true"
    ) {
        body.classList.add("desktop-toggled");
    }

    // Tutup sidebar mobile jika konten diklik
    if (content) {
        content.onclick = function () {
            if (window.innerWidth < 768)
                body.classList.remove("mobile-toggled");
        };
    }

    // Tutup sidebar mobile jika menu diklik
    navLinks.forEach((link) => {
        link.onclick = function () {
            if (window.innerWidth < 768)
                body.classList.remove("mobile-toggled");
        };
    });

    // 2. LOGIC AUTO SCROLL & HIGHLIGHT MENU AKTIF
    const sidebarNav = document.getElementById("sidebarAccordion");
    const activeLink = sidebarNav
        ? sidebarNav.querySelector(".submenu .nav-link.active")
        : null;

    if (activeLink) {
        // Scroll otomatis ke menu yang aktif
        activeLink.scrollIntoView({
            block: "center",
            inline: "nearest",
        });

        // Buka parent menu (dropdown) secara otomatis
        const parentCollapse = activeLink.closest(".collapse");
        if (parentCollapse) {
            const parentToggler = document.querySelector(
                `a[href="#${parentCollapse.id}"]`
            );
            if (parentToggler) {
                parentToggler.classList.add("active");
                parentToggler.classList.remove("collapsed");
                parentToggler.setAttribute("aria-expanded", "true");
                parentCollapse.classList.add("show");
            }
        }
    }

    // 3. SWEETALERT: KONFIRMASI GANTI MODE
    document.querySelectorAll(".btn-switch").forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            let form = this.closest("form");
            Swal.fire({
                title: "Ganti Mode Aplikasi?",
                text: "Menu akan berubah sesuai mode yang dipilih.",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Ya, Ganti!",
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    // 4. SWEETALERT: KONFIRMASI HAPUS
    document.querySelectorAll(".btn-delete").forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            let url = this.getAttribute("href");
            Swal.fire({
                title: "Yakin hapus data ini?",
                text: "Data tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!",
            }).then((result) => {
                if (result.isConfirmed) window.location.href = url;
            });
        });
    });

    // 5. SWEETALERT: KONFIRMASI LOGOUT
    document.querySelectorAll(".btn-logout").forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            let form = this.closest("form");
            Swal.fire({
                title: "Keluar Aplikasi?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "Ya, Logout",
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});

/**
 * CUSTOM GLOBAL JAVASCRIPT
 * Menangani interaksi umum di seluruh aplikasi
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // --- HANDLER TOMBOL "COMING SOON" (btn-not-ready) ---
    // Kode ini akan otomatis mendeteksi semua tombol dengan class 'btn-not-ready'
    const pendingButtons = document.querySelectorAll('.btn-not-ready');

    pendingButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah link pindah halaman
            
            // Ambil pesan dari atribut data-pesan
            let pesan = this.getAttribute('data-pesan') || 'Modul ini sedang dalam tahap pengembangan.';

            // Tampilkan SweetAlert (Neo-Glass Style)
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Coming Soon!',
                    text: pesan,
                    icon: 'info',
                    confirmButtonText: 'Oke, Siap!',
                    // Styling Manual agar sesuai tema Neo-Glass Anda
                    customClass: {
                        popup: 'swal2-glass-popup',
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false // Matikan style bawaan SweetAlert agar pakai Bootstrap btn
                });
            } else {
                // Fallback jika SweetAlert gagal dimuat
                alert(pesan);
            }
        });
    });

});

/* ==========================================================
   MODUL TAMBAHAN: PREVIEW FOTO & SWEETALERT DELETE
   ========================================================== */

document.addEventListener('DOMContentLoaded', function() {

    // 1. FITUR PREVIEW FOTO (Untuk Form Create/Edit)
    const inputFoto = document.getElementById('fotoInput');
    const previewFoto = document.getElementById('fotoPreview');

    if (inputFoto && previewFoto) {
        inputFoto.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewFoto.src = e.target.result;
                    previewFoto.style.display = 'block'; // Tampilkan gambar
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // 2. FITUR KONFIRMASI HAPUS (Ganti Alert Bawaan jadi SweetAlert)
    // Menangkap semua form yang punya class 'form-delete'
    const deleteForms = document.querySelectorAll('.form-delete');

    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Cegah form kirim langsung

            const namaData = this.getAttribute('data-name') || 'Data ini';

            Swal.fire({
                title: 'Yakin hapus data?',
                text: "Data " + namaData + " akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b', // Merah
                cancelButtonColor: '#858796', // Abu
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                // Styling Neo-Glass
                customClass: {
                    popup: 'swal2-glass-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Lanjutkan kirim form jika user klik Ya
                }
            });
        });
    });

});