@isset($kitchenId)
    <rest-list :kitchen="{{$kitchenId}}"></rest-list>
@else
    <rest-list></rest-list>
@endisset
