function notify(type, title, message, autoClose = true) {
    if (typeof showNotification === "function") {
        showNotification(type, title, message, autoClose);
    } else {
        alert(`${title}: ${message}`);
    }
}

function handleSuccess(message, refreshDelay = 1500) {
    notify("success", "Berhasil", message);
    if (refreshDelay > 0) {
        setTimeout(() => {
            window.location.reload();
        }, refreshDelay);
    }
}

function handleError(message) {
    notify("error", "Error!", message, true);
}

function handleWarning(message) {
    notify("warning", "Peringatan!", message);
}

function handleInfo(message) {
    notify("info", "Informasi", message);
}

function handleValidationErrors(errors) {
    let errorMsg = "Terdapat beberapa isian yang belum sesuai:\n\n";
    let count = 1;
    
    for (let [field, messages] of Object.entries(errors)) {
        const messageText = Array.isArray(messages)
            ? messages.join(", ")
            : messages;
        
        errorMsg += `${count}. ${messageText}\n`;
        count++;
    }

    notify("error", "Periksa Kembali Isian Anda", errorMsg.trim(), false);
}

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

    window.dispatchEvent(new CustomEvent("modal-state-changed"));
    window.dispatchEvent(
        new CustomEvent("modal-opened", { detail: { modalId: modalId } }),
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

function isAnyModalOpen() {
    const potentialModals = document.querySelectorAll(".fixed.inset-0");
    for (let modal of potentialModals) {
        if (modal.classList.contains("hidden")) continue;

        if (
            modal.offsetWidth > 0 &&
            modal.offsetHeight > 0 &&
            modal.getClientRects().length > 0
        ) {
            if (!modal.classList.contains("sidebar-backdrop")) {
                return true;
            }
        }
    }
    return false;
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        const forms = modal.querySelectorAll("form");
        forms.forEach((form) => form.reset());

        modal.dispatchEvent(
            new CustomEvent("modal-closed", {
                bubbles: true,
                detail: { modalId },
            }),
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

function autoRefresh(delay = 1500) {
    setTimeout(() => {
        window.location.reload();
    }, delay);
}

class FormDirtyMonitor {
    constructor(formId, submitBtnId) {
        this.form = document.getElementById(formId);
        this.submitBtn = document.getElementById(submitBtnId);
        this.initialData = null;
        this.observer = null;

        if (!this.form || !this.submitBtn) {
            console.warn(
                `FormDirtyMonitor: Form '${formId}' or Button '${submitBtnId}' not found.`,
            );
            return;
        }

        if (!window.formDirtyMonitors) {
            window.formDirtyMonitors = {};
        }
        window.formDirtyMonitors[formId] = this;

        this.init();
    }

    init() {
        this.initialData = this.getFormData(this.form);

        this.toggleSubmitButton(true);

        this.form.addEventListener("input", () => this.check());
        this.form.addEventListener("change", () => this.check());

        this.observer = new MutationObserver(() => this.check());
        this.observer.observe(this.form, {
            childList: true,
            subtree: true,
            attributes: false,
        });
    }

    getFormData(form) {
        const formData = new FormData(form);
        const data = {};

        const checkboxes = form.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach((cb) => {
            const name = cb.name;
            if (name && !cb.checked) {
                if (!data[name + "_unchecked"]) {
                    data[name + "_unchecked"] = [];
                }
                if (Array.isArray(data[name + "_unchecked"])) {
                    data[name + "_unchecked"].push(cb.value || "unchecked");
                }
            }
        });

        for (let [key, value] of formData.entries()) {
            if (data[key] !== undefined) {
                if (!Array.isArray(data[key])) {
                    data[key] = [data[key]];
                }
                data[key].push(value);
            } else {
                data[key] = value;
            }
        }
        return JSON.stringify(data);
    }

    check() {
        const currentData = this.getFormData(this.form);
        const isDirty = currentData !== this.initialData;
        this.toggleSubmitButton(!isDirty);
    }

    toggleSubmitButton(disabled) {
        if (this.submitBtn) {
            this.submitBtn.disabled = disabled;
            if (disabled) {
                this.submitBtn.classList.add(
                    "opacity-50",
                    "cursor-not-allowed",
                );
            } else {
                this.submitBtn.classList.remove(
                    "opacity-50",
                    "cursor-not-allowed",
                );
            }
        }
    }

    destroy() {
        if (this.observer) {
            this.observer.disconnect();
        }
    }
}

const originalFetch = window.fetch;
window.fetch = function (url, options = {}) {
    let finalUrl = url;
    if (typeof url === "string" && !url.startsWith("http")) {
        finalUrl = `${window.APP_URL}${url.startsWith("/") ? "" : "/"}${url}`;
    }

    options.headers = {
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
        ...(options.headers || {}),
    };

    const method = (options.method || "GET").toUpperCase();
    if (method !== "GET" && !options.headers["X-CSRF-TOKEN"]) {
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) options.headers["X-CSRF-TOKEN"] = token.content;
    }

    return originalFetch(finalUrl, options);
};
