fetch('chart-data.php')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('itemChart').getContext('2d');
        const labels = data.map(item => item.entry_date);
        const quantities = data.map(item => item.total_quantity);

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Barang Masuk',
                    data: quantities,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching data:', error));
