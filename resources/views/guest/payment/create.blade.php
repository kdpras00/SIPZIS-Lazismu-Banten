@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Bayar Zakat</h2>

    <form id="payment-form">
        @csrf
        <div class="mb-3">
            <label>Jenis Zakat</label>
            <select name="zakat_type_id" class="form-control" required>
                <option value="1">Zakat Fitrah</option>
                <option value="2">Zakat Mal</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Nominal</label>
            <input type="number" name="paid_amount" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Bayar via Midtrans</button>
    </form>
</div>

{{-- Midtrans Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" 
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.getElementById('payment-form').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("{{ route('guest.payment.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": formData.get('_token')
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    window.location.href = "/guest/payment/success/" + data.payment_code;
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran...");
                },
                onError: function(result) {
                    alert("Pembayaran gagal.");
                }
            });
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(err => console.error(err));
});
</script>
@endsection
