@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">من</label>
                                <input type="date" value="{{ \Carbon\Carbon::now()->subMonth()->toDateString() }}"
                                    onchange="list_parcel()" id="from_date" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">الى</label>
                                <input type="date" value="{{ \Carbon\Carbon::now()->toDateString() }}"
                                    onchange="list_parcel()" id="to_date" class="form-control">
                            </div>
                        </div>
                        @if (auth()->user()->user_role == 'admin')
                            <div class="col">
                                <div class="form-group">
                                    <label for="">المستخدم</label>
                                    <select onchange="list_parcel()" name="user_id" id="user_id"
                                        class="form-control select2bs4">
                                        <option value="">الكل</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col">
                            <div class="form-group">
                                <label for="no_parcel_process">طرورد ليس لها عمليات</label>
                                <input type="checkbox" value="1" onchange="list_parcel()" id="no_parcel_process">
                            </div>
                            <form action="{{ route('report.report_excel') }}" method="post">
                                @csrf
                                <input type="hidden" id="from_date_form" name="from_date">
                                <input type="hidden" id="to_date_form" name="to_date">
                                <button type="submit" class="btn btn-success btn-sm">تصدير الى اكسيل</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="report_list">

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
            list_parcel();
        })

        function list_parcel() {
            $('#from_date_form').val($('#from_date').val());
            $('#to_date_form').val($('#to_date').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('report.report_list') }}",
                type: 'POST',
                data: {
                    from_date: $('#from_date').val(),
                    to_date: $('#to_date').val(),
                    no_parcel_process: $('#no_parcel_process').is(':checked'),
                    user_id: $('#user_id').val(),
                },
                success: function(response) {
                    $('#report_list').html(response.view);
                },
                error: function(e) {

                }
            });
        }
    </script>
@endsection
