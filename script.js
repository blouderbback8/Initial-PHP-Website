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

function searchFighter() {
    const input = document.getElementById('searchBar').value.toLowerCase();
    const rows = document.querySelectorAll('#fighterTable tbody tr');

    rows.forEach(row => {
        const name = row.cells[1].textContent.toLowerCase(); // Adjust index if needed
        row.style.display = name.includes(input) ? '' : 'none';
    });
}

function filterBelt() {
    const filterValue = document.getElementById('beltFilter').value;
    const rows = document.querySelectorAll('#fighterTable tbody tr');

    rows.forEach(row => {
        const beltRank = row.querySelector('.belt').textContent;
        row.style.display = (filterValue === 'all' || beltRank === filterValue) ? '' : 'none';
    });
}

function filterByAge() {
    const ageInput = document.getElementById('ageFilter').value;
    const rows = document.querySelectorAll('#fighterTable tbody tr');

    rows.forEach(row => {
        const age = row.cells[3].textContent; // Assuming age is in the 4th column
        row.style.display = (ageInput === '' || age == ageInput) ? '' : 'none';
    });
}


