@extends('dashboard_template.index')

@section('content')
<div class="container">
    <div class="ranking-header mb-4">
        <h2 class="display-4 animated fadeInDown">Peringkat Kuis</h2>
        
        <div class="form-group">
            <label for="mapel-select" class="font-weight-bold">Pilih Mata Pelajaran:</label>
            <select id="mapel-select" class="form-control custom-select animated fadeIn">
                <option value="">Pilih Mata Pelajaran</option>
                @foreach($mapels as $mapel)
                    <option value="{{ $mapel->id }}">{{ $mapel->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div id="ranking-table" class="mt-4 animated fadeInUp">
        <!-- Tabel Peringkat akan diisi melalui JavaScript -->
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const mapelSelect = document.getElementById('mapel-select');
        const rankingTable = document.getElementById('ranking-table');

        mapelSelect.addEventListener('change', async (event) => {
            const mapelId = event.target.value;

            if (mapelId) {
                try {
                    const response = await fetch(`/peringkat/${mapelId}`);
                    const data = await response.json();

                    rankingTable.innerHTML = generateRankingTable(data);
                } catch (error) {
                    console.error('Error fetching ranking data:', error);
                }
            } else {
                rankingTable.innerHTML = '<p class="text-center">Pilih mata pelajaran untuk melihat peringkat.</p>';
            }
        });

        function generateRankingTable(data) {
            if (data.length === 0) {
                return '<p class="text-center">Belum ada data peringkat untuk mata pelajaran ini.</p>';
            }

            let tableHTML = `
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr class="animated fadeInUp">
                            <th class="text-center">Rank</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            data.forEach((item, index) => {
                tableHTML += `
                    <tr class="animated fadeInUp" style="animation-delay: ${index * 0.1}s;">
                        <td class="text-center">${index + 1}</td>
                        <td class="text-center">${item.siswa.nama}</td>
                        <td class="text-center">${item.nilai}</td>
                    </tr>
                `;
            });

            tableHTML += '</tbody></table>';
            return tableHTML;
        }
    });
</script>

<style>
    /* Background Image */
  

    .container {
        background-color: rgba(0, 0, 0, 0.8);
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animated {
        animation-duration: 0.8s;
        animation-fill-mode: both;
    }

    .fadeInDown {
        animation-name: fadeInDown;
    }

    .fadeInUp {
        animation-name: fadeInUp;
    }

    /* Custom Styles */
    .ranking-header h2 {
        color: #ff4500;
        font-weight: 700;
        letter-spacing: 2px;
        border-bottom: 3px solid #ff6347;
        padding-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
    }

    .form-group label {
        font-size: 1.2rem;
        color: #ff6347;
    }

    th {
        color: white !important;
    }

    .custom-select {
        font-size: 1rem;
        border-radius: 30px;
        border: 2px solid #ff6347;
        background-color: #2b2b2b;
        color: #ffffff;
        transition: border-color 0.3s ease;
    }

    .custom-select:focus {
        border-color: #ff4500;
        box-shadow: none;
    }

    .table {
        background-color: #2b2b2b;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.8);
    }

    .table th, .table td {
        padding: 1rem;
        font-size: 1rem;
        color: #ffffff;
    }

    .table th {
        background-color: #ff4500;
        font-weight: 700;
        text-transform: uppercase;
        border-bottom: 2px solid #ff6347;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #333333;
    }

    .table-hover tbody tr:hover {
        background-color: #444444;
    }

    /* Additional Customizations */
    h2, .form-group label, .custom-select, .table th, .table td {
        transition: color 0.3s ease, background-color 0.3s ease;
    }

  

    .text-center {
        color: #ff4500;
    }
</style>
@endsection
