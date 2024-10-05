@if (session()->has('fail'))
    <div class="alert alert-danger alert-dismissible fade show p-5" role="alert">
        <p class="text-center" style="font-size: 50px">{{ session('barcode') }}</p>
        <p class="text-center" style="font-size: 50px">{{ session('fail') }}</p>
        <p class="text-center" id="timer"></p>
        {{-- <button type="button" class="close " data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button> --}}
    </div>
@endif
