<button type="button" aria-label="Отправка сообщения в тех-поддержку"> class="btn btn-food btn-fixed text-white" data-toggle="modal" data-target="#contactModalBox"
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
               <contact-form></contact-form>
            </div>
        </div>
    </div>
</div>
