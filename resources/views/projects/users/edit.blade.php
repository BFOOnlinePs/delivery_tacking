@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('users.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $data->id }}" name="id">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">الاسم</label>
                                    <input type="text" value="{{ $data->name }}" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">الايميل</label>
                                    <input type="email" value="{{ $data->email }}" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">كلمة المرور</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-sm btn-success">تعديل المستخدم</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection