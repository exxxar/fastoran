<div class="sectionTitle mb-2">
    <div class="text-muted">{{$muted}}</div>
    <div class="title">
        <h1>{!! $title !!}</h1>
        @isset($link)
        <a href="{!! $link !!}">Посмотреть всё</a>
        @endisset
    </div>
    @isset($lead)
        <div class="lead">
          {{$lead}}
        </div>
    @endisset
</div>
