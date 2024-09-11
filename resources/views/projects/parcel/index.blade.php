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
                                        <a class="btn btn-dark btn-sm" href="">تحصيل</a>
                                        <a class="btn btn-dark btn-sm" href="">تبديل</a>
                                        <a class="btn btn-dark btn-sm" href="">ارجاع</a>
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