<form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <select name="category_id" class="form-control">
        @foreach ($categories as $category)
            <option @if ($category_id == $product->category_id) selected @endif value="{{ $category->id }}">{{ $category->name }}
            </option>
        @endforeach
    </select>
    <input class="form-control" type="text" name="name" value="{{ $product->name }}">
    <input class="form-control" type="text" name="content" value="{{ $product->content }}">
    <select name="gender" class="form-control">
        <option @if ($product->gender == 0) selected @endif value="0">Erkek</option>
        <option @if ($product->gender == 1) selected @endif value="1">Kız</option>
    </select>
    @if ($product->image != null)
        <img src="{{ $product->image }}" width="100" height="100">
    @endif
    <input class="form-control" type="file" name="image" value="{{ $product->image }}">
</form>
<tr>
    <th>barcode</th>
    <th>size</th>
    <th>price</th>
    <th>piece</th>
    <th>EDİT</th>
    <th>DELETE</th>
</tr>
<tr>
    @foreach ($product->product_detail as $detail)
        <td>{{ $detail->barcode }}</td>
        <td>{{ $detail->size }}</td>
        <td>{{ $detail->price }}</td>
        <td>{{ $detail->piece }}</td>
        <td><a href="{{ route('admin.productDetail.edit', $detail->id) }}" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i></a></td>
        <td>
            <form action="{{ route('admin.productDetail.destroy', $detail->id) }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
            </form>
        </td>
    @endforeach
</tr>
