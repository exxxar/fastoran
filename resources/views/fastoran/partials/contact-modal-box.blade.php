<button type="button" class="btn btn-primary btn-fixed" data-toggle="modal" data-target="#contactModalBox"
        data-whatever="@mdo"><i class="fas fa-envelope-open-text"></i></button>

<div class="modal fade" id="contactModalBox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog custom-modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title" id="exampleModalLabel">Свяжись с нами</h5>
                <form action="{{route("wish")}}" method="post">
                    @csrf
                    <div class="single-contact-form row">
                        <div class="col-md-6 mb-2">
                            <input type="text" name="name" class="form-control" placeholder="Ваше Ф.И.О.">
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" name="phone" class="form-control" placeholder="Номер телефона">
                        </div>
                        <div class="col-md-12 mb-2">
                            <input type="text" name="email" class="form-control" placeholder="Ваша почта">
                        </div>
                    </div>
                    <div class="single-contact-form row">
                        <div class="col-md-12">
                            <textarea name="message" class="form-control" placeholder="Текст сообщения *"></textarea>
                        </div>
                    </div>
                    <div class="contact-btn">
                        <button type="submit" class="food__btn" style="width: 100%">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
