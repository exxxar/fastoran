<div class="row">
    @foreach($products as $product)
        <div class="col-6">
            <mobile-product-item :product="{{$product}}"></mobile-product-item>
        </div>
    @endforeach

</div>


