// Global helper functions for notifications and auto-refresh

/**
 * Show global notification (jika ada fungsi showNotification di layout)
 * Fallback ke alert jika fungsi tidak tersedia
 */
function notify(type, title, message, autoClose = true) {
    if (typeof showNotification === 'function') {
        showNotification(type, title, message, autoClose);
    } else {
        alert(`${title}: ${message}`);
    }
}

/**
 * Handle successful operation with notification and optional refresh
 */
function handleSuccess(message, refreshDelay = 1500) {
    notify('success', 'Berhasil!', message);
    if (refreshDelay > 0) {
        setTimeout(() => {
            window.location.reload();
        }, refreshDelay);
    }
}

/**
 * Handle error with notification
 */
function handleError(message) {
    notify('error', 'Error!', message, false);
}

/**
 * Handle warning with notification
 */
function handleWarning(message) {
    notify('warning', 'Peringatan!', message);
}

/**
 * Handle info with notification
 */
function handleInfo(message) {
    notify('info', 'Informasi', message);
}

/**
 * Handle validation errors
 */
function handleValidationErrors(errors) {
    const fieldLabels = {
        'judul_surat': 'Judul Surat',
        'nomor_surat': 'Nomor Surat',
        'tentang': 'Tentang',
        'identitas_penetap': 'Identitas Penetap',
        'id_regulasi': 'Keputusan',
        'menimbang': 'Menimbang',
        'mengingat': 'Mengingat',
        'memutuskan': 'Memutuskan',
        'tempat_dibuat': 'Tempat Dibuat',
        'tanggal_dibuat': 'Tanggal Dibuat',
        'jabatan_pembuat': 'Jabatan Pembuat',
        'nama_pembuat': 'Nama Pembuat',
        'nama_ruangan': 'Nama Ruangan',
        'username': 'Username',
        'password': 'Password',
        'role': 'Role'
    };
    
    let errorMsg = '';
    for (let [field, messages] of Object.entries(errors)) {
        const fieldLabel = fieldLabels[field] || field;
        const messageText = Array.isArray(messages) ? messages.join(', ') : messages;
        errorMsg += `• ${fieldLabel}: ${messageText}\n`;
    }
    
    notify('error', 'Validasi Gagal', errorMsg.trim(), false);
}

/**
 * Close modal by ID
 */
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
    }
}

/**
 * Open modal by ID
 */
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
    }
}

/**
 * Auto refresh page after delay
 */
function autoRefresh(delay = 1500) {
    setTimeout(() => {
        window.location.reload();
    }, delay);
}
