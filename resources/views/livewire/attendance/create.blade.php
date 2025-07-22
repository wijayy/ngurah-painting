<div>
    <flux:session>Driver Comes With Customer</flux:session>
    <div class="rounded p-4 bg-white dark:bg-neutral-700">
        {{-- <div class="lg:text-xl">Sticker Number : {{ $sticker }}</div> --}}
        <div class="w-full lg:w-1/4 space-y-4">
            <flux:input wire:model.live='sticker' type="number" :label="'Nomor Stiker'" required></flux:input>
        </div>
        <div class="w-full lg:w-1/4">
            <flux:input wire:model.live='amount' type="number" :label="'Jumlah Customer'" required></flux:input>
        </div>

        <input type="hidden" id="nomor_stiker" value="{{ $sticker }}">
        <input type="hidden" id="jumlah_customer" value="{{ $amount }}">
        <video id="preview" class="mt-4" style="width:300px"></video>

        <button onclick="Livewire.emit('qrScanned', 'test-token')">Tes Emit</button>
    </div>
</div>

@push('scripts')
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script>
        console.log('1');
        document.addEventListener('DOMContentLoaded', function () {
            console.log('2');
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            scanner.addListener('scan', function (token) {
                console.log("Scanned token: " + token);

                token = token.split('/').pop();

                // Ambil data dari input hidden atau data Livewire (contoh)
                const stickerNumber = document.getElementById("nomor_stiker").value;
                const amount = document.getElementById("jumlah_customer").value;

                // Redirect ke controller dengan query parameter
                const url = `scan?nomor_stiker=${stickerNumber}&jumlah_customer=${amount}&token=${token}`;
                window.location.href = url;
            });
            console.log('4');

            Instascan.Camera.getCameras().then(function (cameras) {
                console.log('5');
                if (cameras.length > 0) {
                    console.log('6');
                    console.log('cameras found.');
                    scanner.start(cameras[0]); // Kamera depan
                    // Untuk kamera belakang: scanner.start(cameras[1]);
                } else {
                    console.log('7');
                    console.error('No cameras found.');
                }
            }).catch(function (e) {
                console.log('8');
                console.error(e);
            });
        });

    </script>
@endpush
