import * as bootstrap from "bootstrap";
import Swal from "sweetalert2";
import ApexCharts from "apexcharts";
window.bootstrap = bootstrap;

// === Toast setup ===
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});

// === SweetAlert modal setup ===
const Swal2 = Swal.mixin({
    customClass: {
        confirmButton: "btn btn-danger me-2",
        cancelButton: "btn btn-light",
    },
    buttonsStyling: false,
});

// document.addEventListener("redirect-with-delay", function (event) {
//     const url = event.detail.url;
//     const delay = event.detail.delay ?? 2000;

//     setTimeout(() => {
//         window.location.href = url;
//     }, delay);
// });

document.addEventListener("livewire:init", () => {
    // formatRupiah();
    // 🔁 Reinit Select2 setiap navigasi / morph
    Livewire.hook("morph.updated", () => initAllSelect2());
    document.addEventListener("livewire:navigated", () => initAllSelect2());
    document.addEventListener("livewire:load", () => initAllSelect2());

    // === Toast Global Events ===
    Livewire.on("success-login", (data) => {
        Toast.fire({
            icon: "success",
            title: `${data.message} ${data.name}`,
        });
        setTimeout(() => (window.location.href = "/dashboard"), 2000);
    });

    // Redirect or navigasi after update
    Livewire.on("redirect-with-delay", ({ url, delay }) => {
        setTimeout(() => {
            Livewire.navigate(url); // SPA, tanpa reload
        }, delay || 2000);
    });

    // Fungsi Download animasi excel
    // ==============================================
    // Livewire.on("export-start", () => {
    //     Swal.fire({
    //         title: "Sedang memproses...",
    //         text: "Mohon tunggu",
    //         allowOutsideClick: false,
    //         didOpen: () => Swal.showLoading(),
    //     });
    // });

    // Livewire.on("export-done", () => {
    //     Swal.close();
    // });

    // Livewire.on("download-file", (fileUrl) => {
    //     const a = document.createElement("a");
    //     a.href = fileUrl;
    //     a.download = fileUrl.split("/").pop();
    //     document.body.appendChild(a);
    //     a.click();
    //     a.remove();
    // });
    // ==================================================

    Livewire.on("success-add-data", (data) =>
        Toast.fire({ icon: "success", title: data.message })
    );

    Livewire.on("success-delete-data", (data) =>
        Toast.fire({ icon: "success", title: data.message })
    );

    Livewire.on("succes-change-data", (data) => {
        Toast.fire({
            icon: "success",
            title: data.message,
            timer: 2000, // durasi tampil
            timerProgressBar: true, // optional bar animasi waktu
        });
    });

    Livewire.on("succes-change", (data) =>
        Toast.fire({ icon: "success", title: data.message })
    );

    Livewire.on("failed-delete-data", (data) =>
        Toast.fire({ icon: "error", title: data.message })
    );

    Livewire.on("failed-add-data", (data) =>
        Toast.fire({ icon: "error", title: data.message })
    );

    // Event dari Livewire untuk reset Select2
    Livewire.on("reset-select2", () => {
        $(".select2").each(function () {
            $(this).val(null).trigger("change");
        });
    });

    // Livewire.dispatch("edit-rap", {
    //     id: data["id"],
    // });

    // === SweetAlert confirmations ===
    const confirmDelete = (title, footer, dispatchEvent, id) => {
        Swal2.fire({
            icon: "question",
            title,
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Hapus Permanen",
            footer,
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch(dispatchEvent, { id });
            }
        });
    };

    //sweetalert data hapus OPD
    Livewire.on("confirm-delete-data-opd", (data) => {
        Swal2.fire({
            icon: "question",
            title:
                "Yakin ingin hapus permanen Data OPD <strong class='text-primary'>" +
                data["nama_opd"] +
                "</strong> ?",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Hapus Permanen",
            footer: '<strong class="text-warning">Data OPD yang di hapus tidak akan bisa dikembalikan!</strong>',
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch("delete-data-opd", {
                    id: data["id"],
                });
            }
        });
    });

    //sweetalert data hapus Operator
    Livewire.on("confirm-delete-data-operator", (data) => {
        Swal2.fire({
            icon: "question",
            title:
                "Yakin ingin menghapus <strong class='text-primary'>" +
                data["name"] +
                "</strong> ?" +
                "Dari Operator",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Hapus Permanen",
            footer: '<strong class="text-warning">Data Operator yang di hapus tidak akan bisa dikembalikan!</strong>',
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch("delete-data-operator", {
                    id: data["id"],
                });
            }
        });
    });

    //sweetalert data hapus Pagu OPD
    Livewire.on("confirm-delete-data-paguOPD", (data) => {
        Swal2.fire({
            icon: "question",
            title:
                "Yakin ingin menghapus pagu <strong class='text-primary'>" +
                data["opd"]["kode_opd"] +
                "</strong> ?",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Hapus Permanen",
            footer: '<strong class="text-warning">Data Pagu yang di hapus tidak akan bisa dikembalikan!</strong>',
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch("delete-data-paguOPD", {
                    id: data["id"],
                });
            }
        });
    });

    //sweetalert data hapus Pagu Induk
    Livewire.on("confirm-delete-data-paguInduk", (data) => {
        Swal2.fire({
            icon: "question",
            title:
                "Yakin ingin menghapus pagu <strong class='text-primary'>" +
                data["tahun_pagu"] +
                "</strong> ?",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Hapus Permanen",
            footer: '<strong class="text-warning">Data Pagu yang di hapus tidak akan bisa dikembalikan!</strong>',
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch("delete-data-paguInduk", {
                    id: data["id"],
                });
            }
        });
    });

    //sweetalert data hapus subKegiatan
    Livewire.on("confirm-delete-data-subKegiatan", (data) => {
        Swal2.fire({
            icon: "question",
            title:
                "Yakin ingin menghapus sub kegiatan <strong class='text-primary'>" +
                data["kode_klasifikasi"] +
                "</strong> ?",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Hapus Permanen",
            footer: '<strong class="text-warning">Data sub kegiatan yang di hapus tidak akan bisa dikembalikan!</strong>',
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch("delete-data-subKegiatan", {
                    id: data["id"],
                });
            }
        });
    });

    //sweetalert data RAP
    Livewire.on("confirm-delete-data-RAPBG", (data) => {
        Swal2.fire({
            icon: "question",
            title:
                "Yakin ingin menghapus RAP <strong class='text-primary'>" +
                data["kode_klasifikasi"] +
                "</strong> ?",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Hapus Permanen",
            footer: '<strong class="text-warning">Data RAP yang di hapus tidak akan bisa dikembalikan!</strong>',
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch("delete-data-RAPBG", {
                    id: data["id"],
                });
            }
        });
    });
    //sweetalert data RAP
    Livewire.on("confirm-delete-data-RAPSG", (data) => {
        Swal2.fire({
            icon: "question",
            title:
                "Yakin ingin menghapus RAP <strong class='text-primary'>" +
                data["kode_klasifikasi"] +
                "</strong> ?",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Hapus Permanen",
            footer: '<strong class="text-warning">Data RAP yang di hapus tidak akan bisa dikembalikan!</strong>',
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch("delete-data-RAPSG", {
                    id: data["id"],
                });
            }
        });
    });
    //sweetalert data RAP
    Livewire.on("confirm-delete-data-RAPDTI", (data) => {
        Swal2.fire({
            icon: "question",
            title:
                "Yakin ingin menghapus RAP <strong class='text-primary'>" +
                data["kode_klasifikasi"] +
                "</strong> ?",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya, Hapus Permanen",
            footer: '<strong class="text-warning">Data RAP yang di hapus tidak akan bisa dikembalikan!</strong>',
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch("delete-data-RAPDTI", {
                    id: data["id"],
                });
            }
        });
    });

    // === Inisialisasi semua Select2 ===
    function initAllSelect2() {
        // Pastikan jQuery + Select2 sudah siap
        if (typeof $ === "undefined" || typeof $.fn.select2 === "undefined") {
            console.warn("Select2 belum siap. Skip initAllSelect2().");
            return;
        }

        const $selectSK = $("#selectSubKegiatan");
        const subKegiatanUrl = $selectSK.data("url");

        const $selectAK = $("#selectActivitasUtama");
        const aktivitasUtamaUrl = $selectAK.data("url");

        initSelect2(
            "#selectSubKegiatan",
            "subKegiatanChanged",
            subKegiatanUrl,
            "sub_kegiatan"
        );
        initSelect2(
            "#selectActivitasUtama",
            "activitasUtamaChanged",
            aktivitasUtamaUrl,
            "aktivitas_utama"
        );
    }

    // === Fungsi generik Select2 ===
    function initSelect2(
        selector,
        eventName,
        ajaxUrl = null,
        textField = null
    ) {
        const $select = $(selector);
        if ($select.length === 0) return;

        // 💡 Aman: hanya destroy kalau memang sudah ada instance Select2
        if ($select.data("select2")) {
            $select.off("change.select2");
            $select.select2("destroy");
        }

        // Tunggu DOM stabil dulu
        setTimeout(() => {
            const config = {
                width: "100%",
                allowClear: true,
            };

            if (ajaxUrl) {
                config.ajax = {
                    url: ajaxUrl,
                    dataType: "json",
                    delay: 300,
                    data: (params) => ({ q: params.term }),
                    processResults: (data) => ({
                        results: data.map((item) => ({
                            id: item.id,
                            text: textField ? item[textField] : item.text,
                        })),
                    }),
                };
                config.minimumInputLength = 2;
            }

            // Inisialisasi aman
            $select.select2(config);

            $select.on("change.select2", function () {
                const value = $(this).val();
                console.log(`${selector} changed:`, value);
                Livewire.dispatch(eventName, { id: value });
            });
        }, 300);
    }

    // function formatRupiah() {
    //     document.addEventListener("DOMContentLoaded", function () {
    //         const rupiahInputs = document.querySelectorAll(".format-rupiah");
    //         rupiahInputs.forEach(function (input) {
    //             input.addEventListener("input", function (e) {
    //                 let value = e.target.value;

    //                 // Hapus semua karakter selain angka
    //                 value = value.replace(/\D/g, "");

    //                 // Format dengan titik pemisah ribuan
    //                 value = new Intl.NumberFormat("id-ID").format(value);

    //                 e.target.value = value;
    //             });
    //         });
    //     });
    // }
});
