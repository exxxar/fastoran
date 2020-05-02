<!-- item list -->
<div class="itemList">

    @foreach($random_menus as $product)
        <mobile-product-item-v2 :product="{{$product}}"></mobile-product-item-v2>
    @endforeach
</div>
<!-- * item list -->
