@extends('dashboard_template.index')

@section('content')
<div class="container">
    <div class="ranking-header mb-4">
        <h2 class="display-4 animated fadeInDown">Peringkat Kuis</h2>
        
        <div class="form-group">
            <label for="mapel-select" class="font-weight-bold">Pilih Mata Pelajaran:</label>
            <select id="mapel-select" class="form-control custom-select animated fadeIn">
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const mapelSelect = document.getElementById('mapel-select');
        const rankingTable = document.getElementById('ranking-table');

        // Load data for the first mapel on page load
        const firstMapelId = mapelSelect.options[0]?.value;
        if (firstMapelId) {
            loadRankingData(firstMapelId);
        }

        mapelSelect.addEventListener('change', (event) => {
            const mapelId = event.target.value;

            if (mapelId) {
                loadRankingData(mapelId);
            } else {
                rankingTable.innerHTML = '<p class="text-center">Pilih mata pelajaran untuk melihat peringkat.</p>';
            }
        });

        async function loadRankingData(mapelId) {
            try {
                const response = await fetch(`/peringkat/${mapelId}`);
                const data = await response.json();

                rankingTable.innerHTML = generateRankingTable(data);
            } catch (error) {
                console.error('Error fetching ranking data:', error);
            }
        }

        function generateRankingTable(data) {
            if (data.length === 0) {
                return '<p class="text-center">Belum ada data peringkat untuk mata pelajaran ini.</p>';
            }

            let tableHTML = `
                <div class="ranking-list">
            `;

            data.forEach((item, index) => {
                const score = item.nilai;
                const progressColor = getProgressColor(score);
                const podiumClass = getPodiumClass(index);
                const icon = getPodiumIcon(index);

                tableHTML += `
                    <div class="ranking-item ${podiumClass} animated fadeInUp" style="animation-delay: ${index * 0.1}s;">
                        <div class="ranking-number">${index + 1}</div>
                        <div class="ranking-details">
                            <h5 class="ranking-name">${item.siswa.nama} ${icon}</h5>
                            <span class="ranking-score ">${score}</span>
                            <div class="ranking-score-container">
                                
                                <div class="ranking-score-bar" style="width: ${score}%; background-color: ${progressColor};"></div>
                            </div>
                        </div>
                    </div>
                `;
            });

            tableHTML += '</div>';
            return tableHTML;
        }

        function getProgressColor(score) {
            if (score > 80) return '#4caf50'; // Green for high scores
            if (score > 50) return '#ffeb3b'; // Yellow for medium scores
            return '#f44336'; // Red for low scores
        }

        function getPodiumClass(index) {
            if (index === 0) return 'gold';
            if (index === 1) return 'silver';
            if (index === 2) return 'bronze';
            return '';
        }

        function getPodiumIcon(index) {
            if (index === 0) return '<i class="fas fa-medal" style="color:#ffd700; margin-left: 10px;"></i>'; // Gold medal icon
            if (index === 1) return '<i class="fas fa-medal" style="color:#c0c0c0; margin-left: 10px;"></i>'; // Silver medal icon
            if (index === 2) return '<i class="fas fa-medal" style="color:#cd7f32; margin-left: 10px;"></i>'; // Bronze medal icon
            return '';
        }
    });
</script>

<style>
    .container {
        background-color: #fafafa;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .ranking-header h2 {
        color: #333;
        font-weight: 700;
        border-bottom: 3px solid #fd1a1a;
        padding-bottom: 10px;
    }

    .form-group label {
        font-size: 1.2rem;
        color: #333;
    }

    .custom-select {
        font-size: 1rem;
        border-radius: 30px;
        border: 2px solid #fd1a1a;
        background-color: #fff;
        color: #333;
        transition: border-color 0.3s ease;
    }

    .custom-select:focus {
        border-color: #fd1a1a;
        box-shadow: none;
    }

    .ranking-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .ranking-item {
        display: flex;
        align-items: center;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
        justify-content: space-between;
    }

    .ranking-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fd1a1a;
        width: 50px;
        text-align: center;
    }

    .ranking-details {
        flex: 1;
        margin-left: 10px;
        display: flex;
        justify-content: space-between;
        /* align-items: center; */
    }

    .ranking-name {
        font-size: 1.2rem;
        margin: 0;
        color: #333;
        display: flex;
        align-items: center;
    }

    .ranking-score-container {
        display: flex;
        align-items: center;
        width: 150px;
        position: relative;
        padding-left: 10px; /* Adjust padding to move the score to the left */
    }

    .ranking-score-bar {
        height: 20px;
        border-radius: 20px;
        background-color: #e0e0e0;
        position: absolute;
        top: 6px;
        left: 0;
        margin-bottom: 1000px;
    }
    

    .ranking-score {
        font-size: 1.2rem;
        color: #333;
        margin-left: 70%;
        /* z-index: 1; */
        position: relative;
    }

    /* Podium Colors */
    .gold {
        border-left: 5px solid #ffd700;
    }

    .silver {
        border-left: 5px solid #c0c0c0;
    }

    .bronze {
        border-left: 5px solid #cd7f32;
    }

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

    .text-center {
        color: #fd1a1a;
    }
</style>
@endsection
