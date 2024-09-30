<div class="modal fade" id="collection_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="collection_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">تحصيل اكسيل</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اضافة ملف اكسيل</label>
                                <input type="file" name="collection_excel" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- جدول لعرض البيانات المستوردة -->
                    <table id="excel_data_table" class="table table-sm" style="display:none;">
                        <thead>
                            <tr>
                                <th>الباركود</th>
                                <th>نوع الطرد</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- البيانات ستتم إضافتها هنا بواسطة جافا سكريبت -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-success">رفع الملف</button>
                </div>
            </form>
        </div>
    </div>
</div>
