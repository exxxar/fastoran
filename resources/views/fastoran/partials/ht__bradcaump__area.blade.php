<div class="ht__bradcaump__area bg-image--20"
     style="background-image:url({{$img??'https://fastoran.com/images/bg/18.jpg'}})">
    <div class="ht__bradcaump__wrap d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">{{$title}}</h2>
                        <nav class="bradcaump-inner mt-4">
                            <a class="breadcrumb-item" href="{{url('/')}}">Главная</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-long-arrow-right"></i></span>
                            <span class="breadcrumb-item active">{{$title}}</span>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt--40">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form action="{{route("search")}}" method="post"
                          class="search-form row">
                        @csrf

                        <div class="col-sm-4 col-md-4 col-lg-5 mb-2"><input type="text" class="form-control" name="food_name"
                                                     placeholder="Введите название блюда"></div>
                        <div class="col-sm-4 col-md-4 col-lg-5 mb-2"><input name="rest_name" class="form-control" type="text"
                                                     placeholder="Введите название ресторана"></div>
                        <div class="col-sm-4 col-md-4 col-lg-2">
                            <button type="submit" class="btn btn-link btn-food ">Найти</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
