@extends('dashboard_template.index')

@section('title-page')
    Peringkat Kuis Siswa
@endsection

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
        color: #343a40;
        font-weight: 700;
        letter-spacing: 1px;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
    }

    .form-group label {
        font-size: 1.2rem;
        color: #007bff;
    }

    th {
        color: white !important;
    }

    .custom-select {
        font-size: 1rem;
        border-radius: 30px;
        border: 2px solid #007bff;
        transition: border-color 0.3s ease;
    }


    
    .custom-select:focus {
        border-color: #0056b3;
        box-shadow: none;
    }

    .table {
        background-color: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
    }

    .table th, .table td {
        padding: 1rem;
        font-size: 1rem;
    }

    .table th {
        background-color: #007bff;
        color: #ffffff;
        font-weight: 700;
        text-transform: uppercase;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-hover tbody tr:hover {
        background-color: #e9ecef;
    }
</style>
@endsection
