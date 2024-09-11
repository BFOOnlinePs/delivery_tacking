@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('parcel.create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">الباركود</label>
                                    <input type="text" name="barcode" class="form-control">
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
@endsection