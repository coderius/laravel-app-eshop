<div data-partner="{{$partner->id}}" class="d-flex flex-column align-items-center partner-info-wrap">
<ul class="list-group list-group-horizontal">
  <li class="list-group-item" style="width: 140px;"><b>Логин</b></li>
  <li class="list-group-item" style="width: 250px;"><span class="text-success">{{$partner->login}}</span></li>
</ul>
<ul class="list-group list-group-horizontal">
  <li class="list-group-item" style="width: 140px"><b>Email</b></li>
  <li class="list-group-item" style="width: 250px;"><span class="text-success">{{$partner->email}}</span></li>
</ul>
<ul class="list-group list-group-horizontal">
  <li class="list-group-item" style="width: 140px"><b>Телефон</b></li>
  <li class="list-group-item" style="width: 250px;">
    <input type="text" name="phone" id="partner-phone" class="text-success" value="{{$partner->phone}}"></input>
    <br><br>
    <p><button data-id="partner-phone" data-route="{{ route('change-partner-info') }}" class="btn btn-primary btn-sm">
        Редактировать
        <span class="spinner-border spinner-border-sm visually-hidden" role="status" aria-hidden="true"></span>
    </button></p>
    </li>
</ul>
<ul class="list-group list-group-horizontal">
  <li class="list-group-item" style="width: 140px"><b>Телефон (с телеграм)</b></li>
  <li class="list-group-item" style="width: 250px;">
    <input type="text" name="telegram_phone" id="partner-telegram_phone" class="text-success" value="{{$partner->telegram_phone}}"></input>
    <br><br>
    <p><button data-id="partner-telegram_phone" data-route="{{ route('change-partner-info') }}" class="btn btn-primary btn-sm">
        Редактировать
        <span class="spinner-border spinner-border-sm visually-hidden" role="status" aria-hidden="true"></span>
    </button></p>
    </li>
</ul>
<ul class="list-group list-group-horizontal">
  <li class="list-group-item" style="width: 140px"><b>Телефон (с viber)</b></li>
  <li class="list-group-item" style="width: 250px;">
    <input type="text" name="viber_phone" id="partner-viber_phone" class="text-success" value="{{$partner->viber_phone}}"></input>
    <br><br>
    <p><button data-id="partner-viber_phone" data-route="{{ route('change-partner-info') }}" class="btn btn-primary btn-sm">
        Редактировать
        <span class="spinner-border spinner-border-sm visually-hidden" role="status" aria-hidden="true"></span>
    </button></p>
    </li>
</ul>
</div>

@push('scripts')
$(function() {

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    var $partnerInfoWrap = $(".partner-info-wrap");
    $partnerInfoWrap.find("button").click(function(e){
        var _self = $(this);
        $(this).prop("disabled", true);
        $(this).find('.spinner-border').removeClass('visually-hidden');

        var route = $(this).attr('data-route');
        var $id = $(this).attr('data-id');
        var inpName = $("#" + $id).attr('name');
        var inpVal = $("#" + $id).val();
        console.log(inpVal);
        var data = {
            partnerId: $partnerInfoWrap.attr('data-partner'),
            name: inpName,
            value: inpVal
        };
       //console.log($(this).attr('data-id'));

       $.ajax({
                type: 'POST',
                url: route,
                data: data,
            }).done(function (data) {
                if(data.status == 'success'){
                    _self.prop("disabled", false);
                    _self.find('.spinner-border').addClass('visually-hidden');
                }
                
                
            })
            .fail(function (e) {
                console.log(e)
            });



    });


});


@endpush
