<div>

    <flux:session>{{ $title }}</flux:session>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="rounded p-4 md:col-span-2 bg-white dark:bg-neutral-700">
            <div class="">
                <div class="mb-4  font-semibold">Pemindaian QR Driver</div>
                <div id="reader" class=" rounded-lg"></div>
                <div class="mt-4 flex gap-4">
                    <flux:input wire:model.live='token' placeholder="Tempelkan token_qr driver disini (opsional)">
                    </flux:input>
                    <flux:button as href="{{ route('stiker.create', ['token'=>$token]) }}">Validate</flux:button>
                </div>
            </div>
        </div>
        <div class="rounded p-4 bg-white dark:bg-neutral-700">
            <div class="font-semibold">Hasil</div>
            @if ($this->driver && $token)
                <div class="mt-4">
                    <div class="grid grid-cols-2 border-b pb-2 mb-2">
                        <div class="">Field</div>
                        <div class="">Nilai</div>
                    </div>
                    <div class="grid grid-cols-2 border-b pb-2 mb-2">
                        <div class="">id_driver</div>
                        <div class="">{{ $driver->id_driver }}</div>
                    </div>
                    <div class="grid grid-cols-2 border-b pb-2 mb-2">
                        <div class="">nama</div>
                        <div class="">{{ $driver->user->name }}</div>
                    </div>
                    <div class="grid grid-cols-2 border-b pb-2 mb-2">
                        <div class="">membership_no</div>
                        <div class="">{{ $driver->membership_no }}</div>
                    </div>
                    <div class="grid grid-cols-2 border-b pb-2 mb-2">
                        <div class="">status_keanggotaan</div>
                        <div class="">{{ $driver->status ? 'aktif' : 'non-aktif' }}</div>
                    </div>
                </div>
            @elseif($this->driver === null && $token)
                <div class="mt-4 text-red-600">Driver tidak ditemukan</div>
            @endif
        </div>
    </div>

    <div class="h-48">

    </div>

</div>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function initializeScanner() {
        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code matched = ${decodedText}`, decodedResult);
            @this.set('token', decodedText);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: 250 // Adjusted size for better performance on mobile
            });
        html5QrcodeScanner.render(onScanSuccess);
    }

    document.addEventListener('livewire:navigated', () => {
        initializeScanner();
    })
</script>
