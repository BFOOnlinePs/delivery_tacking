@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-dark btn-sm" href="{{ route('parcel.add') }}">اضافة طرد</a>
                    <button class="btn btn-success btn-sm" data-toggle='modal' data-target="#collection_modal">تحصيل
                        اكسيل</button>
                    <a class="btn btn-success btn-sm" href="{{ route('parcel.add') }}">استرداد اكسيل</a>
                    <a class="btn btn-success btn-sm" href="{{ route('parcel.add') }}">ترجيع اكسيل</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>الباركود</th>
                                <th>ملاحظات</th>
                                <th>نوع الطرد</th>
                                <th>تاريخ الاضافة</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key)
                                <tr>
                                    <td>{{ $key->barcode }}</td>
                                    <td>{{ $key->notes }}</td>
                                    <td>{{ $key->status }}</td>
                                    <td>{{ $key->insert_at }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm m-1"
                                            onclick="create_parcel_process_ajax({{ $key }} , 'collection')">تحصيل</a>
                                            <button class="btn btn-warning btn-sm m-1"
                                                onclick="create_parcel_process_ajax({{ $key }} , 'switch')">تبديل</a>
                                                <button class="btn btn-danger btn-sm m-1"
                                                    onclick="create_parcel_process_ajax({{ $key }} , 'returned')">ارجاع</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('projects.parcel.modals.collection_modal')
@endsection
@section('script')
    <script>
        function create_parcel_process_ajax(data, status_process) {
            if (confirm("هل انت متاكد من اضافة البيانات ؟")) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('parcel.create_parcel_process_ajax') }}",
                    data: {
                        status_process: status_process,
                        barcode: data.barcode,
                        parcel_id: data.id,
                    },
                    type: 'Post',
                    dataType: 'json',
                    success: function(result) {
                        alert('asd');
                    },
                    error(e) {
                        console.log(e.message);
                    }
                });
            }
        }

        $('#collection_form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('parcel.collection_excel') }}", // Update this to your actual route
                type: 'POST',
                data: formData,
                contentType: false, // Important for file uploads
                processData: false, // Important for file uploads
                success: function(response) {
                    alert('تم تحميل الملف بنجاح');
                    displayImportedDataInModal(response.data, 'تحصيل');
                },
                error: function(e) {
                    console.log(e.message);
                    alert('حدث خطأ أثناء تحميل الملف');
                }
            });
        });

        function displayImportedDataInModal(data, type) {
            let tableBody = '';
            data.forEach(function(row) {
                tableBody += `<tr>
            <td>${row}</td>
            <td>${type}</td>
            <td>
                <button class='btn btn-dark btn-sm'>اضافة على اية حال</button>    
            </td>
        </tr>`;
            });

            // عرض البيانات في جدول داخل modal
            $('#excel_data_table tbody').html(tableBody);
            $('#excel_data_table').show(); // عرض الجدول إذا كان مخفيًا
        }
    </script>
@endsection
