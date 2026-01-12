/**
 * Show global notification (jika ada fungsi showNotification di layout)
 * Fallback ke alert jika fungsi tidak tersedia
 */
function notify(type, title, message, autoClose = true) {
    if (typeof showNotification === "function") {
        showNotification(type, title, message, autoClose);
    } else {
        alert(`${title}: ${message}`);
    }
}

/**
 * Handle successful operation with notification and optional refresh
 */
function handleSuccess(message, refreshDelay = 1500) {
    notify("success", "Berhasil!", message);
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
    notify("error", "Error!", message, false);
}

/**
 * Handle warning with notification
 */
function handleWarning(message) {
    notify("warning", "Peringatan!", message);
}

/**
 * Handle info with notification
 */
function handleInfo(message) {
    notify("info", "Informasi", message);
}

/**
 * Handle validation errors
 */
function handleValidationErrors(errors) {
    const fieldLabels = {
        judul_surat: "Judul Surat",
        nomor_surat: "Nomor Surat",
        tentang: "Tentang",
        identitas_penetap: "Identitas Penetap",
        id_regulasi: "Keputusan",
        menimbang: "Menimbang",
        mengingat: "Mengingat",
        memutuskan: "Memutuskan",
        tempat_dibuat: "Tempat",
        tanggal_dibuat: "Tanggal Surat",
        jabatan_pembuat: "Jabatan Pembuat",
        nama_pembuat: "Nama Pembuat",
        nama_ruangan: "Nama Ruangan",
        username: "Username",
        password: "Password",
        role: "Role",
    };

    let errorMsg = "";
    for (let [field, messages] of Object.entries(errors)) {
        const fieldLabel = fieldLabels[field] || field;
        const messageText = Array.isArray(messages)
            ? messages.join(", ")
            : messages;
        errorMsg += `• ${fieldLabel}: ${messageText}\n`;
    }

    notify("error", "Validasi Gagal", errorMsg.trim(), false);
}

/**
 * Open modal by ID
 * Note: Added extra arguments handling (shim) to prevent recursion from old cached views
 */
function openModal(modalId, templateName = null, templateId = null) {
    const modalElement = document.getElementById(modalId);
    if (!modalElement) {
        console.error(`Modal with ID '${modalId}' not found.`);
        return;
    }
    modalElement.classList.remove("hidden");

    if (!window.location.href.includes("template-surat")) {
        document.body.classList.add("overflow-hidden");
    }

    window.dispatchEvent(
        new CustomEvent("modal-opened", { detail: { modalId: modalId } })
    );
    if (templateId) {
        let inputId = "";
        if (modalId === "modalCreateSOP") inputId = "template_surat_sop";
        else if (modalId === "modalCreateSK") inputId = "template_surat_sk";

        if (inputId) {
            const input = document.getElementById(inputId);
            if (input) input.value = templateId;
        }
    }

    if (templateName) {
        const titleElement = modal.querySelector("#modalTitle");
        if (titleElement) {
            const textarea = document.createElement("textarea");
            textarea.innerHTML = templateName;
            titleElement.textContent = "Buat " + textarea.value;
        }
    }
}

/**
 * Check if any modal is currently open
 */
function isAnyModalOpen() {
    const potentialModals = document.querySelectorAll(
        "div[fixed].inset-0, .fixed.inset-0"
    );
    for (let modal of potentialModals) {
        if (modal.classList.contains("hidden")) continue;
        if (modal.offsetParent !== null) return true;
        if (
            modal.style.display !== "none" &&
            window.getComputedStyle(modal).display !== "none"
        )
            return true;
    }
    return false;
}

/**
 * Close modal by ID and reset its form
 */
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        const forms = modal.querySelectorAll("form");
        forms.forEach((form) => form.reset());

        modal.dispatchEvent(
            new CustomEvent("modal-closed", {
                bubbles: true,
                detail: { modalId },
            })
        );

        modal.classList.add("hidden");

        window.dispatchEvent(new CustomEvent("modal-state-changed"));

        setTimeout(() => {
            if (
                !isAnyModalOpen() &&
                !document.body.classList.contains("sidebar-open")
            ) {
                document.body.classList.remove("overflow-hidden");
            }
            if (window.location.href.includes("template-surat")) {
                document.body.classList.remove("overflow-hidden");
            }
        }, 100);
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
