@extends('mobile.layouts.app')

@section('content')
    @include("mobile.partials.restorans.restoran-info")
    <div class="divider mt-1 mb-1"></div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
       {{-- <li class="nav-item">
            <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-selected="true">
                Все товары
            </a>
        </li>--}}
        @foreach($menu_categories as $key=>$category)
            <li class="nav-item">
                <a class="nav-link {{$key==0?"active":""}}" id="{{$category->alias}}-tab" data-toggle="tab" href="#{{$category->alias}}"
                   role="tab" aria-selected="false">
                    {{$category->name}}
                </a>
            </li>
        @endforeach

    </ul>


    <div class="tab-content" id="myTabContent">

        @foreach($restoran->categories->all() as $key=>$cat)


            <div class="tab-pane fade {{$key==0?"active show":""}}" id="{{$cat->alias}}" role="tabpanel">
                <div class="row">
                @foreach($cat->getFilteredMenu($restoran->id) as $product)
                    <!-- Start Single Banner -->
                        <div class="col-6">
                            <mobile-product-item :product="{{$product}}"></mobile-product-item>
                        </div>

                    @endforeach
                </div>
            </div>


        @endforeach
    </div>
    <div class="divider mt-2 mb-2"></div>
    @include("mobile.partials.main.section_title",[ "title"=>"Категории", "muted"=>"Еще больше категорий", "link"=>route('mobile.tags-cloud')])


    @include("mobile.partials.main.button_carousel")

    <div class="divider mb-3 "></div>

    @include("mobile.partials.main.section_title",[ "title"=>"Рестораны", "muted"=>"Еще больше еды", "link"=>route('mobile.restorans')])

    @include("mobile.partials.main.post_carousel")

    @include("mobile.partials.bottom_menu",["active"=>0])
@endsection
