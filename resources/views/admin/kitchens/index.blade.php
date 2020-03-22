@extends('layouts.admin')

@section("content")

    <div class="container">
        @include("admin.partials.messages")

        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>Кухня</h1>
                <form method="post" action="{{ route('kitchens.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <input type="text" class="form-control" placeholder="Название кухни" name="name" value=""
                                   required>
                        </div>
                        <div class="col-sm-12 col-md-5">
                            <input type="text" class="form-control" placeholder="URL картинки" name="img" value=""
                                   required>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <button class="btn btn-primary">Добавить</button>
                        </div>
                    </div>
                </form>
                @isset($kitchens)
                    <table class="table mt-2">

                        <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Навание</th>
                            <th scope="col">Картинка</th>
                            <th scope="col">Отображение</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($kitchens as $key => $kitchen)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>
                                    {{$kitchen->name}}
                                </td>
                                <td>

                                    {{$kitchen->img}}
                                </td>
                                <td>
                                    <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary">
                                        <input class="c-switch-input" type="checkbox"
                                               name="is_active" {{$kitchen->view?"checked":""}}>
                                        <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                    </label>
                                </td>

                                <td>
                                    <form action="{{ route('kitchens.destroy', $kitchen->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-link" type="submit"><i class="fas fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    {{ $kitchens->links() }}
                @endisset
            </div>
        </div>
    </div>
@endsection
