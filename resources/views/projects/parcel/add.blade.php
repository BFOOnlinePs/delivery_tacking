@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('message.fail_message')
            @include('message.success_message')
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="row">
                    <div class="col-md-12">
                        <form tabindex="1" action="{{ route('parcel.create') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">الباركود</label>
                                            <input type="text" id="barcode" name="barcode" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">الملاحظات</label>
                                            <textarea name="notes" id="" cols="30" rows="3" class="form-control"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-success">اضافة الطرد</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table text-left table-sm table-striped table-bordered">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>الباركود</th>
                                            <th>ملاحظات</th>
                                            <th style="width: 80px">نوع الطرد</th>
                                            <th style="width: 160px">تاريخ الاضافة</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data->isEmpty())
                                            <tr>
                                                <td colspan="5"></td>
                                            </tr>
                                        @else
                                            @foreach ($data as $key)
                                                <tr>
                                                    <td>{{ $key->barcode }}</td>
                                                    <td>{{ $key->notes }}</td>
                                                    <td>{{ $key->status }}</td>
                                                    <td>{{ $key->insert_at }}</td>
                                                    <td>
                                                        <a href="{{ route('parcel.delete', ['id' => $key->id]) }}"
                                                            class="text-danger"><span class="fa fa-trash"></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#barcode').focus();

            var timer = 3;
            var countdown = setInterval(function() {
                $('#timer').html(
                    `سوف يتم اخفاء هذه الرسالة خلال <span style="font-size: 40px">${timer}</span> ثانية`
                );
                timer--;

                if (timer < 0) {
                    clearInterval(countdown);
                    $('.alert').fadeOut('fast');
                }
            }, 1000);
        })
    </script>
@endsection
