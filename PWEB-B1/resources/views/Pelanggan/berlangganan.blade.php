<!DOCTYPE html>
<html>
<head>
    <title>Reponik | Berlangganan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h2>Berlangganan RePonik - Rp 80.000</h2>
    <button id="pay-button">Bayar Sekarang</button>

    <!-- Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            fetch('{{ route("berlangganan.create") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                console.log("Snap Token dari server:", data.snap_token);

                // Pastikan snap terdefinisi
                if (typeof snap === 'undefined') {
                    alert("Midtrans Snap tidak tersedia. Pastikan script snap.js dimuat.");
                    return;
                }

                // Tampilkan popup pembayaran
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        // Setelah pembayaran berhasil, kirim data ke server
                        fetch('{{ route("berlangganan.store") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                order_id: result.order_id,
                                biaya: 80000
                            })
                        }).then(() => {
                            alert('Berlangganan berhasil!');
                            window.location.reload();
                        });
                    },
                    onPending: function(result) {
                        alert("Menunggu pembayaran selesai");
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal!");
                    },
                    onClose: function() {
                        alert('Kamu menutup popup tanpa menyelesaikan pembayaran.');
                    }
                });
            })
            .catch(error => {
                console.error("Terjadi error:", error);
                alert("Gagal memulai pembayaran. Silakan coba lagi.");
            });
        });
    </script>
</body>
</html>
