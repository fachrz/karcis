$('.pesawat-btn-info').click(function (){
    var id_tiket = $(this).attr('data-send');

    axios.post('/admin/detailtickets', {
        id_ticket: id_tiket
    }).then((response) => {
        var datatiket = response.data.dataTiket
        $('#id-ticketinfo').html(datatiket.id_ticket);
        $('#id-schedule').html(datatiket.id_schedule);
        $('#seat-class').html(datatiket.seat_class);
        $('#karcis-point').html(toCurrency(datatiket.karcis_point));
        $('#price').html("Rp. " + toCurrency(datatiket.price) + ",00");
        $('#economy-quota').html(datatiket.economy_quota);
        $('#premeconomy-quota').html(datatiket.premeconomy_quota);
        $('#bussiness-quota').html(datatiket.bussiness_quota);
        $('#first-quota').html(datatiket.first_quota);
        
    });
})

$('.kereta-btn-info').click(function (){
    var id_tiket = $(this).attr('data-send');

    axios.post('/admin/keretadetailtickets', {
        id_ticket: id_tiket
    }).then((response) => {
        var datatiket = response.data.dataTiket
        $('#id-ticketinfo').html(datatiket.id_ticket);
        $('#id-schedule').html(datatiket.id_schedule);
        $('#seat-class').html(datatiket.seat_class);
        $('#price').html("Rp. " + toCurrency(datatiket.price) + ",00");
        $('#economy-quota').html(datatiket.economy_quota);
        $('#bussiness-quota').html(datatiket.bussiness_quota);
        $('#executive-quota').html(datatiket.executive_quota);
        
    });
})


function toCurrency(angka)
{
    var reverse = angka.toString().split('').reverse().join(''),
    ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');

    return ribuan;
}

$('.update-admin').click(function (){
    var username = $(this).attr('data-send');

    axios.post('/admin/adminaccount/getedit', {
        username: username
    }).then((response) => {
        var admindata = response.data.adminData
        $('#update-username').val(admindata.username);
        $('#update-admin-name').val(admindata.admin_name);
        $('#update-privileges').val(admindata.level);
        
    });
}) 

$('#ticketsInsert').click(function () {
    axios.get('/admin/getidtickets', {
    }).then((response) => {
        $('#id-ticket').val(response.data.id_ticket);
    });
})


$('#keretaticketsinsert').click(function () {
    console.log('test');
    axios.get('/admin/getkeretaidtickets', {
    }).then((response) => {
        $('#id-ticket').val(response.data.id_ticket);
    });
})

/* Get Airport data */
$('.airportUpdate').click(function () {
    var idAirport = $(this).attr('data-href')
    axios.get('/admin/pesawatairports/getairport', {
        params: {
            id_airport: idAirport
        }
    }).then((response) => {
        $('#id-airport').val(response.data.id_airport);
        $('#airport-name').val(response.data.airport_name);
        $('#location').val(response.data.location);
        $('#province').val(response.data.province);
    });
})
