<!-- item list -->
<div class="itemList">
    <div class="row">
    @foreach($random_menus as $product)
        <div class="col-6">
            <mobile-product-item :product="{{$product}}"></mobile-product-item>
        </div>

    @endforeach
    </div>
</div>
<!-- * item list -->
