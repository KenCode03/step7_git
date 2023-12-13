            <table id="fav-table" class="table table-bordered border">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>メーカー名</th>
                    </tr>
                </thead>
                <tbody id='products'>
                @foreach( $products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td><img style=" max-height:100px;" src="{{ route('product.getfile',['id'=>$product->id]) }}"></td>
                        <td>{{$product->product_name}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->stock}}</td>
                        <td>{{$product->company->company_name}}</td>

                        <td class="ps-5">
                            <a class="btn btn-warning mt-3 ps-4 pe-4" href="{{route('product.show',['id'=>$product->id])}}">詳細</a>
                            <button data-product-id="{{$product->id}}" class="destroy btn btn-danger mt-3 ps-4 pe-4 ms-3" type="button">削除</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>