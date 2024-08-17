<div class="table-responsive">
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Business Process</th>
                <th>Value</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Date</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->business_process }}</td>
                    <td>{{ $item->value }}</td>
                    <td>{{ $item->product }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->date }}</td>
                    <td>
                        @if ($item->file_path)
                            <a href="{{ Storage::url($item->file_path) }}" target="_blank">View File</a>
                        @else
                            No File
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
