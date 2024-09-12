@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-dark btn-sm" href="{{ route('parcel.add') }}">اضافة طرد</a>
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
                                        <button class="btn btn-dark btn-sm" onclick="create_parcel_process_ajax({{ $key }} , 'collection')">تحصيل</a>
                                        <button class="btn btn-dark btn-sm" onclick="create_parcel_process_ajax({{ $key }} , 'switch')">تبديل</a>
                                        <button class="btn btn-dark btn-sm" onclick="create_parcel_process_ajax({{ $key }} , 'returned')">ارجاع</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function create_parcel_process_ajax(data , status_process){
            if(confirm("هل انت متاكد من اضافة البيانات ؟"))
            {
                $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : "{{ route('parcel.create_parcel_process_ajax') }}",
                data : {
                    status_process: status_process,
                    barcode: data.barcode,
                    parcel_id: data.id,
                },
                type : 'Post',
                dataType : 'json',
                success : function(result){
                    alert('asd');
                },
                error(e){
                    console.log(e.message);
                }
            });
            }
        }
    </script>
@endsection