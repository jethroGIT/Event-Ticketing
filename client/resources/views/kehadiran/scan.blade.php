

@section('content')
<!-- Contoh integrasi scanner sederhana -->
<script src="https://unpkg.com/html5-qrcode"></script>
<div id="reader" width="600px"></div>
@endsection

@section('ExtraJS')
<script>
    function onScanSuccess(qrCodeMessage) {
        // Kirim ke API
        fetch('/validate-qr', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ qr_token: qrCodeMessage }),
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            console.log(data);
        });
    }

    new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 }).render(onScanSuccess);
</script>
