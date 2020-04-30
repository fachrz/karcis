function tabs(id) {
    $(".nav-item").removeClass("krc-order-item-active");
    var elId = $('#'+id);
    if (id == 'kereta') {
        elId.addClass('krc-order-item-active');
        var url = window.location.href,
        arr=url.split('/');
        if (arr['3'] != 'kereta') {
            window.location = '/kereta';
        }
    }else if(id == 'pesawat'){
        elId.addClass('krc-order-item-active');
        var url = window.location.href,
        arr=url.split('/');
        if (arr['3'] != '') {
            window.location = '/'; 
        }
        
    }
}

$('.departure-section').hover(
    function () {
        $('#departure-price').addClass('d-none');
        $('.departure-edit').removeClass('d-none');
    },function() {
        $('#departure-price').removeClass('d-none');
        $('.departure-edit').addClass('d-none');
    }
)