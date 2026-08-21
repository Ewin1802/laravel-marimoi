/**
 * ==========================================================
 * Marimoi Cafe ADMIN
 * app.js
 * ==========================================================
 */

document.addEventListener("DOMContentLoaded", function () {

    initSidebar();
    initDropdown();
    initModal();

});

/* ==========================================================
   SIDEBAR
========================================================== */

function initSidebar() {

    const toggle = document.getElementById("sidebarToggle");
    const sidebar = document.querySelector(".sidebar");

    if (!toggle || !sidebar) return;

    if (localStorage.getItem("sidebar") === "collapse") {
        document.body.classList.add("sidebar-collapse");
    }

    toggle.addEventListener("click", function () {

        if (window.innerWidth <= 768) {

            sidebar.classList.toggle("show");
            return;

        }

        document.body.classList.toggle("sidebar-collapse");

        if (document.body.classList.contains("sidebar-collapse")) {
            localStorage.setItem("sidebar", "collapse");
        } else {
            localStorage.removeItem("sidebar");
        }

    });

}

/* ==========================================================
   DROPDOWN
========================================================== */

function initDropdown() {

    document.querySelectorAll(".dropdown-toggle").forEach(button => {

        button.addEventListener("click", function (e) {

            e.stopPropagation();

            document.querySelectorAll(".dropdown").forEach(dropdown => {

                if (dropdown !== this.parentElement) {
                    dropdown.classList.remove("active");
                }

            });

            this.parentElement.classList.toggle("active");

        });

    });

    document.addEventListener("click", function () {

        document.querySelectorAll(".dropdown").forEach(dropdown => {

            dropdown.classList.remove("active");

        });

    });

}

/* ==========================================================
   MODAL
========================================================== */

function initModal() {

    document.querySelectorAll("[data-modal]").forEach(button => {

        button.addEventListener("click", function () {

            const modal = document.getElementById(this.dataset.modal);

            if (modal) {
                modal.classList.add("show");
            }

        });

    });

    document.querySelectorAll(".modal-close").forEach(button => {

        button.addEventListener("click", function () {

            this.closest(".modal").classList.remove("show");

        });

    });

    document.querySelectorAll(".modal-overlay").forEach(overlay => {

        overlay.addEventListener("click", function () {

            this.parentElement.classList.remove("show");

        });

    });

    document.addEventListener("keydown", function (e) {

        if (e.key === "Escape") {

            document.querySelectorAll(".modal.show").forEach(modal => {

                modal.classList.remove("show");

            });

        }

    });

}

/* ==========================================================
   TOAST
========================================================== */

function showToast(type, title, message) {

    const container = document.querySelector(".toast-container");

    if (!container) return;

    const toast = document.createElement("div");

    toast.className = `toast toast-${type}`;

    toast.innerHTML = `
        <div class="toast-body">
            <div class="toast-title">${title}</div>
            <div class="toast-text">${message}</div>
        </div>

        <button class="toast-close">
            <i data-lucide="x"></i>
        </button>
    `;

    container.appendChild(toast);

    if (window.lucide) {
        lucide.createIcons();
    }

    toast.querySelector(".toast-close").addEventListener("click", function () {

        hideToast(toast);

    });

    setTimeout(function () {

        hideToast(toast);

    }, 4000);

}

function hideToast(toast) {

    if (!toast) return;

    toast.classList.add("hide");

    setTimeout(function () {

        toast.remove();

    }, 300);

}

/* ==========================================================
   LOADING
========================================================== */

function showLoading() {

    const loading = document.querySelector(".loading");

    if (!loading) return;

    loading.classList.add("show");

}

function hideLoading() {

    const loading = document.querySelector(".loading");

    if (!loading) return;

    loading.classList.remove("show");

}

/* ==========================================================
   UTILITIES
========================================================== */

function confirmDelete(message = "Yakin ingin menghapus data ini?") {

    return confirm(message);

}

function refreshIcons() {

    if (window.lucide) {
        lucide.createIcons();
    }

}

document.addEventListener("DOMContentLoaded", function () {

    if (document.querySelector("#dashboardChart")) {

        const options = {

            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                }
            },

            stroke: {
                curve: 'smooth',
                width: 3
            },

            dataLabels: {
                enabled: false
            },

            series: [{

                name: 'Pengunjung',

                data: [31, 40, 28, 51, 42, 109, 100]

            }],

            xaxis: {

                categories: [
                    'Sen',
                    'Sel',
                    'Rab',
                    'Kam',
                    'Jum',
                    'Sab',
                    'Min'
                ]

            },

            colors: ['#10B981']

        };

        new ApexCharts(
            document.querySelector("#dashboardChart"),
            options
        ).render();

    }

});
