@if (session()->has('warning'))
    <div class="alert alert-warning alert-dismissible fade show p-5" role="alert">
        <p class="text-center" style="font-size: 50px">{{ session('warning') }}</p>
        <form action="{{ route('parcel.confirm_add_parcel_process') }}" class="text-center" method="POST">
            @csrf
            <input type="hidden" name="barcode" value="{{ session('barcode') }}">
            <input type="hidden" name="status_process" value="{{ session('status_process') }}">
            <button type="submit" class="btn btn-primary">نعم، أضف الباركود</button>
            <a href="{{ route('parcel.add_collection_page') }}" class="btn btn-danger">إلغاء</a>
        </form>
    </div>
@endif
