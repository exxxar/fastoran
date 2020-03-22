<div class="l-filtres">
    <div class="container">
        <form action="rest-list.php" method="GET" class="l-filtres-form">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <!-- <input type="text" class="form-control" placeholder="Донецк"> -->
                    <select class="dropdown">
                        <option value="" class="label" selected>Город</option>
                        <option value="1" selected="selected">Донецк</option>

                    </select>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">

                    <select class="dropdown" name="reg">
                        <option value="0" class="label" >Выберите район</option>
                        <option value="22"  class="label" >Червоногвардейский</option>
                        <option value="17"  class="label" >Пролетарский</option>
                        <option value="21"  class="label" >Петровский</option>
                        <option value="15"  class="label" >Ленинский</option>
                        <option value="18"  class="label" >Куйбышевский</option>
                        <option value="19"  class="label" >Кировский</option>
                        <option value="20"  class="label" >Киевский</option>
                        <option value="14"  class="label" >Калининский</option>
                        <option value="13"  class="label" >Ворошиловский</option>
                        <option value="16"  class="label" >Будёновский</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <button type="submit" class="btn btn-warning find_rest">Найти рестораны</button>
                </div>
            </div>
        </form>
    </div>
</div>
