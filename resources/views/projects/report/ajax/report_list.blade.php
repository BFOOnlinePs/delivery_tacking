<table class="table table-sm table-hover table-bordered text-center">
    <thead class="bg-secondary">
        <tr>
            <th>الباركود</th>
            <th style="width: 10%">تحصيل</th>
            <th style="width: 10%">ترجيع</th>
            <th style="width: 10%">تبديل</th>
            <th class="text-cneter" style="width: 5%"></th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="5" class="text-center">لا يوجد بيانات</td>
            </tr>
        @else
            @foreach ($data as $key)
                <tr>
                    <td @if ($key->parcel_process->isEmpty()) class="bg-light text-left pl-3" @endif class="text-left">
                        {{ $key->barcode }}</td>
                    <td>
                        @foreach ($key->parcel_process as $item)
                            @if ($item->status_process == 'collection')
                                <span class="badge badge-success w-100">{{ $item->insert_at ?? '' }}</span>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach ($key->parcel_process as $item)
                            @if ($item->status_process == 'returned')
                                <span class="badge badge-danger w-100">{{ $item->insert_at ?? '' }}</span>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach ($key->parcel_process as $item)
                            @if ($item->status_process == 'switch')
                                <span class="badge badge-warning w-100">{{ $item->insert_at ?? '' }}</span>
                            @endif
                        @endforeach
                    </td>
                    <td class="justify-content-center align-content-center">
                        <i class="fa fa-info text-info" data-toggle="tooltip" data-placement="top"
                            title="{{ $key->notes }}"></i>
                    </td>

                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
