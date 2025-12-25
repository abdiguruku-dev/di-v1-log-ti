/* --- FILE: public/js/custom-admin.js (FINAL CLEAN) --- */

document.addEventListener("DOMContentLoaded", function () {
    
    // ============================================================
    // 1. GLOBAL UI (SIDEBAR, LOGOUT, DELETE, DLL)
    // ============================================================
    
    const toggleBtn = document.getElementById("sidebarToggle");
    const body = document.body;
    const content = document.getElementById("page-content-wrapper");

    // Toggle Sidebar
    if (toggleBtn) {
        toggleBtn.onclick = function (e) {
            e.preventDefault();
            if (window.innerWidth >= 768) {
                body.classList.toggle("desktop-toggled");
                localStorage.setItem("sb|desktop-toggle", body.classList.contains("desktop-toggled"));
            } else {
                body.classList.toggle("mobile-toggled");
            }
        };
    }
    
    // Restore Sidebar State
    if (window.innerWidth >= 768 && localStorage.getItem("sb|desktop-toggle") === "true") {
        body.classList.add("desktop-toggled");
    }

    // Auto Close Mobile
    if (content) {
        content.onclick = function () { if (window.innerWidth < 768) body.classList.remove("mobile-toggled"); };
    }

    // Logout Confirmation
    document.querySelectorAll(".btn-logout").forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            let form = this.closest("form");
            Swal.fire({
                title: "Keluar Aplikasi?", icon: "warning", showCancelButton: true,
                confirmButtonColor: "#d33", confirmButtonText: "Ya, Logout",
            }).then((result) => { if (result.isConfirmed) form.submit(); });
        });
    });

    // Global Delete Confirmation
    document.querySelectorAll(".btn-delete, .form-delete").forEach((el) => {
        el.addEventListener(el.tagName === 'FORM' ? 'submit' : 'click', function (e) {
            e.preventDefault();
            const target = this;
            Swal.fire({
                title: "Yakin hapus data?", text: "Tidak bisa dikembalikan!", icon: "warning",
                showCancelButton: true, confirmButtonColor: "#d33", confirmButtonText: "Ya, Hapus!",
            }).then((result) => {
                if (result.isConfirmed) {
                    if (target.tagName === 'FORM') target.submit();
                    else window.location.href = target.getAttribute("href");
                }
            });
        });
    });

    // Preview Foto Global (Untuk Form Edit Biasa)
    const simpleInputFoto = document.getElementById('fotoInput');
    const simplePreviewFoto = document.getElementById('fotoPreview');
    if (simpleInputFoto && simplePreviewFoto) {
        simpleInputFoto.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) { simplePreviewFoto.src = e.target.result; }
                reader.readAsDataURL(file);
            }
        });
    }

    // ============================================================
    // 2. WIZARD FORM LOGIC (HANYA AKTIF DI HALAMAN WIZARD)
    // ============================================================
    
    const wizardForm = document.getElementById('formMuridWizard');
    if (wizardForm) {
        const steps = document.querySelectorAll('.tab-pane');
        const stepIndicators = document.querySelectorAll('.wizard-tabs .nav-link');
        let currentStep = 0;

        // FUNGSI VALIDASI
        function validateCurrentStep() {
            // Hanya validasi tab yang sedang TAMPIL
            const activeTab = document.querySelector('.tab-pane.show.active');
            if (!activeTab) return true;

            const inputs = activeTab.querySelectorAll('[required]');
            let isValid = true;
            let errorTarget = "";

            // Reset Error
            activeTab.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            inputs.forEach(input => {
                if (input.type === 'radio') {
                    const groupName = input.name;
                    if (!activeTab.querySelector(`input[name="${groupName}"]:checked`)) {
                        isValid = false;
                        errorTarget = "Pilihan opsi belum dipilih";
                    }
                } else {
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                        if (!errorTarget) errorTarget = "Data wajib belum diisi";
                    }
                }
            });

            if (!isValid) {
                Swal.fire({
                    icon: 'warning', title: 'Belum Lengkap!',
                    text: errorTarget, confirmButtonColor: '#f6c23e'
                });
            }
            return isValid;
        }

        // FUNGSI SIMPAN DRAFT & LANJUT
        window.nextStep = function() {
            if (!validateCurrentStep()) return;

            const formData = new FormData(wizardForm);
            formData.append('step', currentStep + 1); 
            
            const muridId = document.getElementById('murid_id_hidden').value;
            if(muridId) formData.append('id', muridId);

            const btnLanjut = steps[currentStep].querySelector('.btn-next');
            const originalText = btnLanjut.innerHTML;
            btnLanjut.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            btnLanjut.disabled = true;

            fetch('/admin/murid/save-draft', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json' // <--- INI KUNCINYA AGAR TIDAK ERROR TOKEN '<'
                }
            })
            .then(response => {
                // Cek jika response bukan JSON (misal HTML error)
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") === -1) {
                    return response.text().then(text => { throw new Error("Server Error (HTML): " + text.substring(0, 100)); });
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('murid_id_hidden').value = data.id;
                    changeStep(currentStep + 1);
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
                    Toast.fire({ icon: 'success', title: 'Draft tersimpan' });
                } else {
                    Swal.fire('Gagal!', data.message || 'Terjadi kesalahan validasi', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Oups!', 'Gagal menyimpan draft. Pastikan kolom database lengkap.', 'error');
            })
            .finally(() => {
                btnLanjut.innerHTML = originalText;
                btnLanjut.disabled = false;
            });
        };

        window.prevStep = function() { if (currentStep > 0) changeStep(currentStep - 1); };

        function changeStep(newStep) {
            steps[currentStep].classList.remove('show', 'active');
            stepIndicators[currentStep].classList.remove('active');
            
            if (newStep > currentStep) stepIndicators[currentStep].classList.add('passed');
            
            currentStep = newStep;
            steps[currentStep].classList.add('show', 'active');
            stepIndicators[currentStep].classList.add('active');
            document.querySelector('.card-header').scrollIntoView({ behavior: 'smooth' });
        }

        // Logic Exit Confirmation
        document.querySelectorAll('.btn-exit-wizard').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                Swal.fire({
                    title: 'Keluar Form?', text: "Data yang belum disave akan hilang.", icon: 'question',
                    showCancelButton: true, confirmButtonText: 'Ya, Keluar'
                }).then((res) => { if(res.isConfirmed) window.location.href = url; });
            });
        });
        
        // Logic NIS Otomatis
        const nisInput = document.getElementById('nis');
        const nisCheck = document.getElementById('nis_auto');
        if(nisInput && nisCheck && window.lastNis) {
            nisCheck.addEventListener('change', function() {
                if(this.checked) {
                    nisInput.value = parseInt(window.lastNis) + 1;
                    nisInput.setAttribute('readonly', true);
                    nisInput.classList.add('bg-light');
                } else {
                    nisInput.value = '';
                    nisInput.removeAttribute('readonly');
                    nisInput.classList.remove('bg-light');
                }
            });
        }
        
        // Preview File
        window.previewFile = function(input, id) {
            const previewBox = document.getElementById(id);
            if(input.files && input.files[0] && previewBox) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if(input.files[0].type.match('image.*')) previewBox.innerHTML = `<img src="${e.target.result}" style="max-width:100%;max-height:100%;object-fit:contain;">`;
                    else previewBox.innerHTML = `<div class="text-center text-danger py-4"><i class="fas fa-file-pdf fa-3x"></i><br><small>${input.files[0].name}</small></div>`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    }
});