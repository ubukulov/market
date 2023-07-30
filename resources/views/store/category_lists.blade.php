<div class="mt-5">
    <table id="cat_table" class="table table-striped table-bordered">
        <thead>
        <th>#</th>
        <th>Категория</th>
        <th>Маркетплейс</th>
        <th>Маржа</th>
        <th>Дата</th>
        </thead>

        <tbody>
            @foreach($listCategoryMarginsByMarket as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->cat_name }}</td>
                    <td>
                        <img src="/uploads/admin/{{ $item->market_logo }}" alt="">
                    </td>
                    <td>
                        {{ $item->margin }}
                    </td>
                    <td>
                        {{ $item->created_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
