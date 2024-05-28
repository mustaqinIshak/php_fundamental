<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Input Data Barang</h2>
        <form action="input.php" method="post">
            <div class="form-group">
                <label for="item_name">Nama Barang</label>
                <input type="text" class="form-control" id="item_name" name="item_name" required>
            </div>
            <div class="form-group">
                <label for="quantity">Jumlah</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="form-group">
                <label for="entry_date">Tanggal Masuk</label>
                <input type="date" class="form-control" id="entry_date" name="entry_date" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="container mt-5">
        <h2>Data Barang</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Tanggal Masuk</th>
                </tr>
            </thead>
            <tbody id="barangTableBody">
                <!-- Data akan dimuat di sini menggunakan JavaScript -->
            </tbody>
        </table>

        <h2>Grafik Data Barang Masuk Per Hari</h2>
        <canvas id="barangChart"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.getElementById('barangTableBody');
            const ctx = document.getElementById('barangChart').getContext('2d');

            fetch('chart-data.php')
                .then(response => response.json())
                .then(data => {
                    // Menampilkan data dalam tabel
                    data.forEach(entry => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${entry.id}</td>
                            <td>${entry.item_name}</td>
                            <td>${entry.quantity}</td>
                            <td>${entry.entry_date}</td>
                        `;
                        tableBody.appendChild(row);
                    });

                    const labels = [...new Set(data.map(entry => entry.entry_date))];
                    const values = labels.map(label => {
                        return data.filter(entry => entry.entry_date === label)
                                   .reduce((sum, entry) => sum + parseInt(entry.quantity), 0);
                    });

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Barang Masuk',
                                data: values,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
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
                });
        });
    </script>
</body>
</html>
