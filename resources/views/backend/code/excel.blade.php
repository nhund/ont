<table>
    <thead>
        <tr>
            <th>Serial</th>
            <th>Code</th>
            <th>Giá</th>
            <th>Ngày hết hạn</th>
        </tr>
    </thead>
    <tbody>
        @if($codes)
            @foreach($codes as $co)
                <tr>
                    <td><span>{{ $co['serial'] }}</span></td>
                    <td><span>{{ $co['code'] }}</span></td>
                    <td><span>{{ $co['price'] }}</span></td>
                    <td><span>@if($co['end_date']) {{ date('d/m/Y', $co['end_date']) }} @else Không thời hạn @endif</span></td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>