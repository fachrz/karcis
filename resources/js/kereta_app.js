/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import 'jquery-ui/ui/widgets/datepicker.js';

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
                var station_name = $(this).find('.station-name').text(),
                station_code = $(this).find('.station-code').text();
                $('#'+targetId).val(station_name+" ("+station_code+")");    
                if (getWidgetName == '#to-destination') {
                    formdata.arrival = station_code
                }else if(getWidgetName == '#from-destination'){
                    formdata.departure = station_code;
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
    formdata.cabinclass = cabinclass;
    var passenger = Number(adult) + Number(baby);

    $('#krc-pass-class').val(passenger + ", " + cabinclass);
    $('#passenger-class').removeClass('visible');
})

// Date Picker
var dateToday = new Date();
$("#datepicker").datepicker({
    numberOfMonths: 2,
    minDate: dateToday,
    maxDate: "+1y",
    dateFormat: "D, d M yy",
    altFormat: "yy-mm-dd",
    altField: "#alt-date",
});
$("#datepicker").datepicker({ dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());


//Form Data Here
var formdata = {
    'departure' : '',
    'arrival' : '',
    'adult': 1,
    'child' : 0,
    'baby': 0,
    'cabinclass' : 'economy',
}

//search button clicked
$(".krc-search-button").click(function() {
    var d = formdata.departure,
        a = formdata.arrival,
        c = $('#alt-date').val(),
        e = formdata.adult,
        h = formdata.baby,
        v = formdata.cabinclass;
        
    var urlparam = {
        'd' : d,
        'a' : a,
        'dd' : c,
        'adult': e,
        'baby' : h,
        'class': v,
    }
    var str = jQuery.param(urlparam);
    window.location.href='/kereta-api/cari?'+str;
})

// setup csrf token in headers with ajaxSetup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

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
        'baby': urlstring.searchParams.get('baby'),
    }
    $.ajax({
        method: 'POST',
        url: '/keretachooseorder',
        data: {
            "idTiket": id_tiket,
            "passenger": passenger
        },
        success: function (response) {
            if (response.status == "succeed") {
                window.location.href = '/cart/kereta/' + response.key;
            } else { 
                console.log("system terkendala");
            }
        }
    });
});

/**
 * Order Proses
 * 
 */
$(".order-button").click(function () {
   
   const pass_type = [], 
         pass_title = [],
         pass_fullname = [],
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
       var getval = $(this, '.pass-fullname').val();
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
       axios.post('/keretaorder', {
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
           window.location.href = '/keretasendmail/'+order_key+"/"+order_id;

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

})