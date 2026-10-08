document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById("searchInput");
    const dataTable = document.getElementById("dataTable");

    // Jika halaman tidak memiliki search atau tabel,
    // hentikan script agar tidak error.
    if (!searchInput || !dataTable) {
        return;
    }

    const rows = dataTable.querySelectorAll("tbody tr");

    searchInput.addEventListener("keyup", function () {

        const keyword = this.value.toLowerCase().trim();

        rows.forEach(function (row) {

            const text = row.innerText.toLowerCase();

            if (text.includes(keyword)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }

        });

    });

});