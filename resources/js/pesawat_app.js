/*Search Functions*/
$(document).on('click', function(e){
    var getWidgetName = $(e.target).attr('widget-name');
    var targetId = $(e.target).attr('id');
    var quirk = $(e.target).attr('quirk');

    $('#passenger-class').click(function () { 
        $(this).data('clicked', true);
    })
    if ( e.target.matches('[widget-type=krc-dropdown]')) {
        if ($('.krc-dropdown').hasClass('visible')) {
            $('.krc-dropdown').removeClass('visible');
        }else if (quirk == 'destination-search') {
            $('#'+targetId).keyup(function(){
              var getText = $(this).val().toLowerCase();
              $(getWidgetName+' .result-list').filter(function(){
                    $(this).toggle($(this).text().toLowerCase().indexOf(getText) > -1)
                    if (getText == '') {
                        $('.krc-dropdown').removeClass('visible');
                    }else{ 
                        $('.krc-dropdown' + getWidgetName).addClass('visible');
                    }
              });
            });
            $(getWidgetName+' .result-list').click(function() {
                var airport_code = $(this).find('.airport-code').text(),
                    airport_name = $(this).find('.airport-name').text();

                $('#'+targetId).val(airport_name+" ("+airport_code+")");    
                if (getWidgetName == '#to-destination') {
                    formdata.arrival = airport_code
                }else if(getWidgetName == '#from-destination'){
                    formdata.departure = airport_code;
                }
            });
        }else{
            $('.krc-dropdown' + getWidgetName).addClass('visible');
        }
    }else if ($('#passenger-class').data('clicked')) {
        $(this).addClass('visible');
        $('#passenger-class').data('clicked', false);
    }else if(!e.target.matches('[widget-type=krc-dropdown]')){
        $('.krc-dropdown').removeClass('visible');
    }
});

// Passenger & Cabin Class
$("#passclass-submit").click(function () {
    var adult = $("#adult").val(),
        child = $("#child").val(),
        baby = $("#baby").val(),
        cabinclass = $("#cabinclassoption").children("option:selected").val();
    formdata.adult = adult;
    formdata.child = child;
    formdata.baby = baby;
    formdata.cabinclass = cabinclass.toLowerCase();
    var passenger = Number(adult) + Number(child) + Number(baby);
    $('#krc-pass-class').val(passenger + ", " + cabinclass);
    $('#passenger-class').removeClass('visible');
});

// Date Picker
var dateToday = new Date();
$("#departure").datepicker({
    numberOfMonths: 2,
    minDate: dateToday,
    maxDate: "+1y",
    dateFormat: "D, d M yy",
    altFormat: "yy-mm-dd",
    altField: "#alt-date-departure",
});
$("#departure").datepicker({ dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());

// Date Picker
var dateToday = new Date();
$("#return").datepicker({
    numberOfMonths: 2,
    minDate: dateToday,
    maxDate: "+1y",
    dateFormat: "D, d M yy",
    altFormat: "yy-mm-dd",
    altField: "#alt-date-return",
});
$("#return").datepicker({ dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());

//Form Data Here
var formdata = {
    'departure' : '',
    'arrival' : '',
    'adult': 1,
    'child' : 0,
    'baby': 0,
    'cabinclass' : 'economy',
}
$('#return-input-checkbox').click(function () {
    $('#return-input-checbox').prop('checked', true)
    if ($('#return-input-checkbox').is(':checked')) {
        $('#return').prop('disabled', false);
        formdata.returndate = ''
    }else{
        $('#return').prop('disabled', true)
        delete formdata.returndate
    }
})

// setup csrf token in headers with ajaxSetup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//search button clicked
$(".krc-search-button").click(function() {
    
    var d = formdata.departure,
        a = formdata.arrival,
        c = $('#alt-date-departure').val(), 
        e = formdata.adult,
        f = formdata.child,
        h = formdata.baby,
        v = formdata.cabinclass;

    var flights = {
        'd' : d,
        'a' : a,
    }
    var date= {
        'dd' : c,   
    }
    var etc = {
        'adult': e,
        'child': f,
        'baby' : h,
        'class': v,
    }


    if ('returndate' in formdata) {
        formdata.returndate = $('#alt-date-return').val()
        date.rd = formdata.returndate;
    }

    var param = Object.assign(flights, date, etc);
    
    var str = jQuery.param(param);
    window.location.href='/flight/search?'+str;
})

function removedchoosedticket(tipe) {
    $.ajax({
        method: 'GET',
        url: '/webapi/removechoosedticket',
        success: function (response) {
            if (tipe == 'change') {
                location.reload()
            }
        }
    });
}
$('#departure-change').click(function () {
    removedchoosedticket('change');
})

if (!document.URL.includes('/flight/search')) {
    removedchoosedticket()
}else{
    var url = window.location.href;
    var urlstring = new URL(url);
    var datatiket = {
        'departure' : urlstring.searchParams.get('d'),
        'arrival' : urlstring.searchParams.get('a'),
        'departuredate' : urlstring.searchParams.get('dd'),
        'class' : urlstring.searchParams.get('class')
    }
    var passenger = {
        'adult': urlstring.searchParams.get('adult'),
        'child': urlstring.searchParams.get('child'),
        'baby': urlstring.searchParams.get('baby'),
    }
    var returnDate = urlstring.searchParams.get('rd');

    getChooseticket();
}

if (document.URL.includes('/cart/flight')) {
    whetherVoucherClaimed();
}

function getChooseticket()
{
    $.ajax({
        method: 'GET',
        url: '/webapi/getchoosedticket',
        success: function (response) {
            if (response.departure_ticket != null) {
                $('.departure-section').removeClass('d-none');
                $('#departure-price').html(response.departure_ticket.price);
                $('#departure-from-to #from').html(response.departure_ticket.from);
                $('#departure-from-to #to').html(response.departure_ticket.to);
                $('#depature-date').html(response.departure_ticket.date);
                $('.krc-departure-airline-img').attr('src', response.departure_ticket.airline)
                $('.return-section').removeClass('d-none');
                $('.return-section').html('Pilih Penerbangan Pulang');
            }else{
                $('.departure-section').removeClass('d-none');
                $('.departure-section').html('Pilih Penerbangan Berangkat');
            }

        }
    });
}

const capitalize = (s) => {
    if (typeof s !== 'string') return ''
    return s.charAt(0).toUpperCase() + s.slice(1)
}
  

//Choose Button
$(".choose-button").click(function () {
    var url = window.location.href;
    var urlstring = new URL(url);
    var id_tiket = $(this).attr('data-href');
    var datatiket = {
        'departure' : urlstring.searchParams.get('d'),
        'arrival' : urlstring.searchParams.get('a'),
        'departuredate' : urlstring.searchParams.get('dd'),
        'class' : urlstring.searchParams.get('class')
    }
    var passenger = {
        'adult': urlstring.searchParams.get('adult'),
        'child': urlstring.searchParams.get('child'),
        'baby': urlstring.searchParams.get('baby'),
    }
    var returnDate = urlstring.searchParams.get('rd');
    if (returnDate != null) {
        $.ajax({
            method: 'POST',
            data : {
                "idTiket": id_tiket
            },
            url: '/webapi/setchooseticket',
            success: function (response) {
                if (response.message == true) {
                    $.ajax({
                        method: 'POST',
                        url: '/chooseorder',
                        data: {
                            "passenger": passenger
                        },
                        success: function (response) {
                            
                            if (response.status == "succeed") {
                                window.location.href = '/cart/flight/' + response.key;
                            } else { 
                                console.log("system terkendala");
                            }
                        }
                    });
                }else{
                    getChooseticket();
                    location.reload();
                }
                
            }
        });
    }else{
        $.ajax({
            method: 'POST',
            url: '/chooseorder',
            data: {
                "idTiket": id_tiket,
                "passenger": passenger
            },
            success: function (response) {
                if (response.status == "succeed") {
                    window.location.href = '/cart/flight/' + response.key;
                } else { 
                    console.log("system terkendala");
                }
            }
        });
    }
});

/**
 *  Proses Data
 *  Get all data from the form
 */
$(".order-button").click(function () {
    
    const pass_type = [], 
          pass_title = [];
    var   pass_fullname = [],
          pass_state = [];
    var url = window.location.href,
        cust_fullname = $('#cust-fullname').val(),
        cust_email = $('#cust-email').val(),
        orderkey = url.split("/")[5];

    $('.pass-type').each(function () {
        var getval = $(this).val();
        pass_type.push(getval);
    })
    $('.pass-title').each(function () {
        var getval = $(this, 'option:selected').val();
        pass_title.push(getval);
    })
    $('.pass-fullname').each(function () {
        var getval = $(this).val();
        pass_fullname.push(getval);
    })
    $('.pass-citizenship').each(function () {
        var getval = $(this, 'option:selected').val();
        pass_state.push(getval);
    });

    if (jQuery.inArray('default', pass_title) != -1) {
        alert('Isi kolom titel dengan benar !!');
    }else if(jQuery.inArray('default', pass_state) != -1){
        alert('Isi kolom kewarganegaraan dengan benar !!');
    }else{
        axios.post('/order', {
            orderKey: orderkey, 
            cust_fullname : cust_fullname,
            cust_email : cust_email,
            pass_type: pass_type,
            pass_title : pass_title,
            pass_fullname: pass_fullname,
            pass_state: pass_state
        }).then((response) => {
             
            var order_id = response.data.order_id,
            order_key = response.data.order_key;
            window.location.href = '/sendmail/'+order_key+"/"+order_id;

        }).catch(function(error){
            var statusCode = error.response.status;
            if (statusCode == 422) {
                alert('sepertinya kamu berusaha merubah resource.\nsetelah kamu mengeklik OK, halaman ini akan di muat ulang');
                location.reload();
            }else if(statusCode == 406){
                alert('Permintaan kamu di tolak!! \n Halaman ini akan dimuat ulang');
                location.reload();
            }

        });
    }
    
    
   
});

$('.voucher-claim').click(function(){

    var getvouchercond = $(this).html();
    var url = window.location.href;
    var voucher_id = $(this).attr('data-id');
    var orderkey = url.split("/")[5];

    if (getvouchercond.toLowerCase() == 'claimed') {
        var voucherconfirm = confirm("Anda yakin tidak ingin menggunakan voucher ini ?")
        if (voucherconfirm == true) {
            axios.post('/webapi/voucherclaim', {
                orderKey : orderkey,
                voucherId: voucher_id,
            }).then((response) => { 
                if (response.data.msg_code == '3er2r13') {
                    alert('Point Tidak Mencukupi');
                }else if(response.data.msg_code == '4sc1e28'){
                    whetherVoucherClaimed(); 
                }else{
                    whetherVoucherClaimed();
                }
            });
        }
    }else{
        
        var voucherconfirm = confirm("Anda yakin ingin menggunakan voucher ini ?")
        if (voucherconfirm == true) {
            axios.post('/webapi/voucherclaim', {
                orderKey : orderkey,
                voucherId: voucher_id,
            }).then((response) => {
                if (response.data.msg_code == '3er2r13') {
                    alert('Point Tidak Mencukupi');
                }else if(response.data.msg_code == '4sc1e28'){
                    whetherVoucherClaimed(); 
                }else{
                    whetherVoucherClaimed();
                }
            });
        }
    }

    
})

/* Function Here */
function getKarcisPoint()
{
    axios.get('/webapi/karcispoint').then((response) => {
        $('#karcis_point').html(response.data.karcis_point+' KRCP');
    });
}

function toCurrency(angka)
{
    var reverse = angka.toString().split('').reverse().join(''),
    ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');

    return ribuan;
}

function whetherVoucherClaimed()
{
    var url = window.location.href;
    var orderkey = url.split("/")[5];

    axios.post('/webapi/checkvoucherclaimed', {
        orderKey : orderkey
    }).then((response) => {
        var whetherClaimed = response.data.msg_code,
        totalPrice = response.data.totalPrice;
        if (whetherClaimed == '4sc1e39') {
            priceAfterVoucher(totalPrice);
        }else if(whetherClaimed = '4er1e39'){
            priceBeforeVoucher(totalPrice);
        }
    });
}

function priceBeforeVoucher(totalPrice){
    $('#voucher-used > .pd-total-price').html("");
    $('#total-price > .pd-total-price').css('text-decoration', 'none').removeClass('total-price-removed');
    $('#voucher-used').addClass('d-none');
    $('#pd-total-price > .pd-total-price').append("Rp. "+toCurrency(totalPrice)+",00");
    $('.voucher-claim').html('Claim');
}
function priceAfterVoucher(totalPrice)
{
    $('#total-price > .pd-total-price').css('text-decoration', 'line-through').addClass('total-price-removed');
    $('#voucher-used').removeClass('d-none');
    $('#voucher-used > .pd-total-price').append("Rp. "+toCurrency(totalPrice)+",00");
    $('.voucher-claim').html('Claimed');

} 

/* Run Function Here */
getKarcisPoint();