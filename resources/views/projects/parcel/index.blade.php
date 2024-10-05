@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-dark btn-sm" href="{{ route('parcel.add') }}">اضافة طرد</a>
                    <button type="button" class="btn btn-success btn-sm" data-toggle='modal'
                        data-target="#collection_modal">تحصيل
                        اكسيل</button>
                    <button type="button" class="btn btn-success btn-sm" data-toggle='modal'
                        data-target="#switch_modal">استرداد
                        اكسيل</button>
                    <button type="button" class="btn btn-success btn-sm" data-toggle='modal'
                        data-target="#returned_modal">ترجيع
                        اكسيل</button>
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
    @include('projects.parcel.modals.returned_modal')
    @include('projects.parcel.modals.switch_modal')
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
                        parcel_id: data.id ?? data.process_id,
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
                url: "{{ route('parcel.collection_excel') }}", // تأكد من أن هذا المسار صحيح
                type: 'POST',
                data: formData,
                contentType: false, // مهم لتحميل الملفات
                processData: false, // مهم لتحميل الملفات
                success: function(response) {
                    alert('تم تحميل الملف بنجاح');

                    // عرض البيانات الجديدة
                    displayImportedDataInModal(response.new_records, 'تمت إضافته بنجاح', 'collection');

                    // عرض البيانات الموجودة مسبقًا
                    displayImportedDataInModal(response.existing_barcodes, 'موجود مسبقاً',
                        'collection');

                    // عرض الاستثناءات
                    displayImportedDataInModal(response.exception_records,
                        'باركود غير موجود في النظام', 'collection');
                },
                error: function(e) {
                    console.log(e.message);
                    alert('حدث خطأ أثناء تحميل الملف');
                }
            });
        });

        $('#returned_form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('parcel.returned_excel') }}", // تأكد من أن هذا المسار صحيح
                type: 'POST',
                data: formData,
                contentType: false, // مهم لتحميل الملفات
                processData: false, // مهم لتحميل الملفات
                success: function(response) {
                    alert('تم تحميل الملف بنجاح');

                    // عرض البيانات الجديدة
                    displayImportedDataInModal(response.new_records, 'تمت إضافته بنجاح', 'returned');

                    // عرض البيانات الموجودة مسبقًا
                    displayImportedDataInModal(response.existing_barcodes, 'موجود مسبقاً',
                        'returned');

                    // عرض الاستثناءات
                    displayImportedDataInModal(response.exception_records,
                        'باركود غير موجود في النظام', 'returned');
                },
                error: function(e) {
                    console.log(e.message);
                    alert('حدث خطأ أثناء تحميل الملف');
                }
            });
        });

        $('#switch_form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('parcel.switch_excel') }}", // تأكد من أن هذا المسار صحيح
                type: 'POST',
                data: formData,
                contentType: false, // مهم لتحميل الملفات
                processData: false, // مهم لتحميل الملفات
                success: function(response) {
                    alert('تم تحميل الملف بنجاح');

                    // عرض البيانات الجديدة
                    displayImportedDataInModal(response.new_records, 'تمت إضافته بنجاح', 'switch');

                    // عرض البيانات الموجودة مسبقًا
                    displayImportedDataInModal(response.existing_barcodes, 'موجود مسبقاً',
                        'switch');

                    // عرض الاستثناءات
                    displayImportedDataInModal(response.exception_records,
                        'باركود غير موجود في النظام', 'switch');
                },
                error: function(e) {
                    console.log(e.message);
                    alert('حدث خطأ أثناء تحميل الملف');
                }
            });
        });

        function displayImportedDataInModal(data, message, type) {
            let tableBody = '';

            data.forEach(function(row) {
                let barcode = row.barcode; // Access the barcode
                let processId = row.process_id; // Access the process ID

                tableBody += `<tr>
            <td>${barcode}</td>
            <td>${message}</td>
            <td>
                ${message === 'موجود مسبقاً' ? 
                    `<button type='button' class='btn btn-dark btn-sm' onclick='create_parcel_process_ajax({ barcode: "${row.barcode}", id: ${row.process_id} }, "${type}")'>اضافة على اية حال</button>` : 
                    '—'}
            </td>
        </tr>`;
            });

            // عرض البيانات في جدول داخل الـ modal
            $(`#excel_data_table_${type} tbody`).append(tableBody); // إلحاق البيانات الجديدة
            $('#excel_data_table_' + type).show(); // عرض الجدول إذا كان مخفيًا
        }
    </script>
@endsection
