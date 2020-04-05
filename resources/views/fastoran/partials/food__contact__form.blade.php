<a name="contacts"></a>
<section class="food__contact__form bg--white section-padding--lg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="contact__form__wrap">
                    <h2>Свяжись с нами</h2>
                    <div class="contact__form__inner">
                        <form action="{{route("wish")}}" method="post">
                            @csrf
                            <div class="single-contact-form">
                                <div
                                    class="contact-box name d-flex flex-wrap flex-md-nowrap flex-lg-nowrap justify-content-between">
                                    <input type="text" name="name" placeholder="Ваше Ф.И.О.">
                                    <input type="email" name="email" placeholder="Ваша почта">
                                    <input type="text" name="phone" placeholder="Номер телефона">
                                </div>
                            </div>
                            <div class="single-contact-form">
                                <div class="contact-box message">
                                    <textarea name="message" placeholder="Текст сообщения *"></textarea>
                                </div>
                            </div>
                            <div class="contact-btn">
                                <button type="submit" class="food__btn">Отправить</button>
                            </div>
                        </form>
                    </div>
                    <div class="form-output">
                        @if ($message = Session::get('message'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ $message }}
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
