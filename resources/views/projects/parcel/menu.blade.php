<div class="row">
    <a href="{{ route('parcel.add') }}" class="col-md-3">
        <div class="info-box shadow">
            <span class="info-box-icon bg-success"><i class="fa fa-qrcode"></i></span>
            <div class="info-box-content justify-content-center align-content-center">
                <span class="info-box-number">اضافة طرد</span>
            </div>

        </div>
    </a>
    <a href="{{ route('parcel.add_collection_page') }}" class="col-md-3">
        <div class="info-box shadow">
            <span class="info-box-icon bg-info"><i class="fa fa-box"></i></span>
            <div class="info-box-content justify-content-center align-content-center">
                <span class="info-box-number">تحصيل طرد</span>
            </div>

        </div>
    </a>
    <a href="{{ route('parcel.add_return_page') }}" class="col-md-3">
        <div class="info-box shadow">
            <span class="info-box-icon bg-danger"><i class="fa fa-arrow-left"></i></span>
            <div class="info-box-content justify-content-center align-content-center">
                <span class="info-box-number">ارجاع طرد</span>
            </div>
        </div>
    </a>
    <a href="{{ route('parcel.add_switch_page') }}" class="col-md-3">
        <div class="info-box shadow">
            <span class="info-box-icon bg-warning"><i class='fa fa-search'></i></span>
            <div class="info-box-content justify-content-center align-content-center">
                <span class="info-box-number">تبديل طرد</span>
            </div>
        </div>
    </a>
</div>
