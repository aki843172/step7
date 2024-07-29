@foreach ($products as $product)
    <tr data-id="{{ $product->id }}">
        <td>{{ $product->id }}</td>
        <td>{{ $product->product_name }}</td>
        <td><img src="{{ $product->img_path }}" alt="{{ $product->product_name }}" style="max-width: 200px;"></td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->stock }}</td>
        <td>{{ $product->company->company_name }}</td>
        <td>
            <a href="{{ route('products.show', $product->id) }}" class="detail-button">詳細</a>
        </td>
        <td>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST"  class="delete-form" data-id="{{ $product->id }}"onsubmit="return confirm('本当にこの商品を削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button">削除</button>
            </form>
        </td>
    </tr>
@endforeach