@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('message.fail_message')
            @include('message.success_message')
            @include('message.warning_message')
        </div>
    </div>
    @include('projects.parcel.menu')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="row">
                    <div class="col-md-12">
                        <form tabindex="1" action="{{ route('parcel.create_parcel_process') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="returned" name="status_process">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="text-center">ارجاع طرد</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">الباركود</label>
                                            <input type="text" id="barcode" name="barcode" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-danger">ارجاع طرد</button>
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
                                                    <td>{{ $key->parcel->barcode }}</td>
                                                    <td>{{ $key->parcel->notes }}</td>
                                                    <td>
                                                        ارجاع
                                                    </td>
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
