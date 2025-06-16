@extends('layout.admin.app')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="container mx-auto p-6">

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-gray-500">Total Pemasukan</h2>
            <p class="text-2xl font-bold text-green-600">Rp{{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white shadow rounded-xl p-4">
            <h2 class="text-gray-500">Total Order</h2>
            <p class="text-2xl font-bold text-blue-600">{{ $totalOrder }}</p>
        </div>
    </div>

    {{-- Grafik Transaksi per Bulan --}}
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">Grafik Transaksi per Bulan ({{ now()->year }})</h3>
        <canvas id="transaksiChart" height="100"></canvas>
    </div>

    {{-- Filter & Summary Transaksi Bulanan --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Ringkasan Transaksi Bulanan</h3>
            <form method="GET">
                <select name="bulan" onchange="this.form.submit()" class="border rounded px-2 py-1">
                    @foreach ($bulanList as $index => $namaBulan)
                        <option value="{{ $index + 1 }}" {{ request('bulan') == $index + 1 ? 'selected' : '' }}>
                            {{ $namaBulan }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <table class="w-full table-auto text-left">
            <thead>
                <tr>
                    <th class="border-b p-2">Tanggal</th>
                    <th class="border-b p-2">Total Rupiah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksiPerTanggal->filter(fn($t) => Carbon\Carbon::parse($t->tanggal)->month == (request('bulan') ?? now()->month)) as $transaksi)
                    <tr>
                        <td class="border-b p-2">{{ $transaksi->tanggal }}</td>
                        <td class="border-b p-2">Rp{{ number_format($transaksi->total_rupiah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('transaksiChart').getContext('2d');
    const transaksiChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($bulanList) !!},
            datasets: [{
                label: 'Total Pemasukan (Rp)',
                data: {!! json_encode($dataGrafik) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endsection

