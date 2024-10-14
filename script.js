function filterBelt() {
    const filterValue = document.getElementById('beltFilter').value;
    const rows = document.querySelectorAll('#fighterTable tbody tr');

    rows.forEach(row => {
        const beltRank = row.querySelector('.belt').textContent;
        if (filterValue === 'all' || beltRank === filterValue) {
            row.style.display = '';  // Show the row
        } else {
            row.style.display = 'none';  // Hide the row
        }
    });
}
