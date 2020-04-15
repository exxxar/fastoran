<div class="accountbox-wrapper is-visible">
    <div class="body-overlay"></div>
    <div class="accountbox text-left">
        <ul class="nav accountbox__filters" id="myTab" role="tablist">
            <li>
                <a class="active" id="log-tab" data-toggle="tab" href="#log" role="tab" aria-controls="log"
                   aria-selected="true">Войти в ЛК</a>
            </li>
        </ul>
        <div class="accountbox__inner tab-content" id="myTabContent">
            <div class="accountbox__login tab-pane fade show active" id="log" role="tabpanel" aria-labelledby="log-tab">
                <form action="{{route("login")}}" method="post">
                    @csrf
                    <div class="single-input">
                        <input class="form-control" name="email" type="text" placeholder="Телефон или email">
                    </div>
                    <div class="single-input">
                        <input class="form-control" type="password" placeholder="Код из СМС">
                    </div>
                    <div class="single-input">
                        <button type="submit" class="food__btn"><span>Войти</span></button>
                    </div>

                </form>
            </div>

            <span class="accountbox-close-button"><i class="zmdi zmdi-close"></i></span>
        </div>
    </div>
</div>
