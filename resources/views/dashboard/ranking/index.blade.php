@extends('dashboard_template.index')

@section('title-page')
    Peringkat Kuis
@endsection

@section('content')
<div class="container">
    <div class="ranking-header mb-4">
        <h2>Peringkat Kuis</h2>
        
        <div class="form-group">
            <label for="mapel-select">Pilih Mata Pelajaran:</label>
            <select id="mapel-select" class="form-control">
                <option value="">Pilih Mata Pelajaran</option>
                @foreach($mapels as $mapel)
                    <option value="{{ $mapel->id }}">{{ $mapel->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div id="ranking-table" class="mt-4">
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
                rankingTable.innerHTML = '<p>Pilih mata pelajaran untuk melihat peringkat.</p>';
            }
        });

        function generateRankingTable(data) {
            if (data.length === 0) {
                return '<p>Belum ada data peringkat untuk mata pelajaran ini.</p>';
            }

            let tableHTML = `
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Nama</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            data.forEach((item, index) => {
                tableHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.siswa.nama}</td>
                        <td>${item.nilai}</td>
                    </tr>
                `;
            });

            tableHTML += '</tbody></table>';
            return tableHTML;
        }
    });
</script>

<style>
    .ranking-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .table {
        width: 100%;
        margin-top: 1rem;
        border-collapse: collapse;
    }

    .table th, .table td {
        border: 1px solid #ddd;
        padding: 0.75rem;
        text-align: center;
    }

    .table th {
        background-color: #f8f9fa;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }
</style>
@endsection
