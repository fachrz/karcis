/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('startbootstrap-sb-admin-2/js/sb-admin-2');
require('jquery-ui/ui/widgets/datepicker');

//form validation
var validate = require("validate.js");


/*Third Party Login*/
let hello = require('hellojs/dist/hello.all.js');

hello.init({
    google: '681159452564-ubi884ne5o0hiur6r1kldm64idm3ilk8',
});

$('.tpl-button').click(function () {
    var account_type = $(this).attr('account-type');
    hello(account_type).login({
        scope: 'email'
    });
    tpaauthentication(account_type);
});


/**
 * Airports
 */

$('.airports-update').click(function () {
    var id_airports = $(this).attr('data-send');
    axios.post('/admin/pesawatairports/datafetching', {
        id_airports: id_airports
    }).then((response) => {
        $('#id-airport').val(response.data.id_airport);
        $('#airport-name').val(response.data.airport_name);
        $('#location').val(response.data.location);
        $('#province').val(response.data.province);
    });
});

/**
 * Aircrafts
 */

$('.aircrafts-update').click(function () {
    var aircraft_registry = $(this).attr('data-send');
    axios.post('/admin/pesawataircrafts/datafetching', {
        aircraft_registry: aircraft_registry
    }).then((response) => {
        var airlines = response.data.airlines;
        $('#aircraft-registry').val(response.data.aircraft.aircraft_registry);

        var areaOption = "<option value='' disabled>---Select Airlines---</option>";

        for (let i = 0; i < airlines.length; i++) {

            areaOption += '<option value="' + airlines[i].airline_id + '">' + airlines[i].airline_name + '</option>'

        }
        $("#airline-id").html(areaOption);
        $("#airline-id").val(response.data.aircraft.airline_id);
        $('#nationality').val(response.data.aircraft.nationality);
        $('#aircraft-model').val(response.data.aircraft.aircraft_model);
    });
});

/**
 * schedules 
 */

//ajax
$('#airline-insert').change(function () {
    var airline_selected = $(this).children("option:selected").val();
    axios.post('/admin/pesawatschedules/requiredfetching', {
        airline_id: airline_selected
    }).then((response) => {
        var aircrafts = response.data.aircrafts_data;

        var areaOption = "<option value='' disabled>---Select Aircrafts Reg.---</option>";

        for (let i = 0; i < aircrafts.length; i++) {

            areaOption += '<option value="' + aircrafts[i].aircraft_registry + '">' + aircrafts[i].aircraft_registry + '</option>'

        }
        $("#aircraft-insert").html(areaOption);

        var flights = response.data.flights_data;

        var flightsOption = "<option value='' disabled>---Select Flight Number.---</option>";

        for (let i = 0; i < flights.length; i++) {

            flightsOption += '<option value="' + flights[i].flight_number + '">' + flights[i].flight_number + '</option>'

        }
        $("#flight-insert").html(flightsOption);
    });
})

$('.schedules-update').click(function () {
    var id_schedule = $(this).attr('data-send');
    axios.post('/admin/pesawatschedules/datafetching', {
        id_schedule : id_schedule,
    }).then((response) => {
        console.log(response);
        var aircraft = response.data.airline.aircrafts_data;
        $('#airline-update').val(response.data.schedule.pesawat_aircrafts.airline_id);

        var areaOption = "<option value='' disabled>---Select Aircrafts Reg.---</option>";

        for (let i = 0; i < aircraft.length; i++) {

            areaOption += '<option value="' + aircraft[i].aircraft_registry + '">' + aircraft[i].aircraft_registry + '</option>'

        }
        $("#aircraft-update").html(areaOption);

        var flights = response.data.airline.flights_data;

        var flightsOption = "<option value='' disabled>---Select Flight Number.---</option>";

        for (let i = 0; i < flights.length; i++) {

            flightsOption += '<option value="' + flights[i].flight_number + '">' + flights[i].flight_number + '</option>'

        }
        $("#flight-update").html(flightsOption);

        $('#id-schedule').val(response.data.schedule.id_schedule);
        $('#aircraft-update').val(response.data.schedule.pesawat_aircrafts.aircraft_registry);
        $('#flight-update').val(response.data.schedule.flight_number);
        $('#flight-update').val(response.data.schedule.flight_number);
        $('#economyupdate').val(response.data.schedule.economy_quota);
        $('#premeconomyupdate').val(response.data.schedule.premeconomy_quota);
        $('#bussinessupdate').val(response.data.schedule.bussiness_quota);
        $('#firstupdate').val(response.data.schedule.first_quota);
        $('#departure-update').val(response.data.schedule.departure_date);
    });

})

$('#airline-update').change(function () {
    var airline_selected = $(this).children("option:selected").val();
    axios.post('/admin/pesawatschedules/requiredfetching', {
        airline_id: airline_selected
    }).then((response) => {
        var aircrafts = response.data.aircrafts_data;

        var areaOption = "<option value='' disabled>---Select Aircrafts Reg.---</option>";

        for (let i = 0; i < aircrafts.length; i++) {

            areaOption += '<option value="' + aircrafts[i].aircraft_registry + '">' + aircrafts[i].aircraft_registry + '</option>'

        }
        $("#aircraft-update").html(areaOption);

        var flights = response.data.flights_data;

        var flightsOption = "<option value='' disabled>---Select Flight Number.---</option>";

        for (let i = 0; i < flights.length; i++) {

            flightsOption += '<option value="' + flights[i].flight_number + '">' + flights[i].flight_number + '</option>'

        }
        $("#flight-update").html(flightsOption);
    });
})

/**
 * AirFlights
 */
    
    
$('#airline-flights').change(function () {
    var airline_selected = $(this).children("option:selected").val();
    axios.post('/admin/pesawatflights/requiredfetching', {
        airline_id: airline_selected
    }).then((response) => {
        console.log(response);

        $('#iata-code-insert').val(response.data.iata_code)
    });
})

/**
 * Function Here
 */

function getKarcisPoint(){
    axios.get('/webapi/karcispoint').then((response) => {
        $('#karcis_point').html(response.data.karcis_point+' KRCP');
    });
}

function tpaauthentication(account_type) {
    hello.on('auth.login', function (auth) {
        hello(account_type).api('me').then(function (data) {
            axios.post('/login/tpa', {
                thumbnail: data.thumbnail,
                first_name: data.first_name,
                last_name: data.last_name,
                email: data.email,
                login_type: auth.network
            }).then((response) => {
                var account_type = String(response.data.account_type);
                account_type = account_type.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                    return letter.toUpperCase();
                });
                if (response.data.msg_code == '0sc4p25') {
                    window.location = '/';
                }else if(response.data.msg_code == '0sc8v17'){
                    window.location = '/';
                }else{
                    alert(response.data.message);
                    window.location = '/login';
                }   
            });
        });
    });
}

/**
 * Run Function Below
 */
getKarcisPoint()


/**
 * Register Form
 * 
 */
document.getElementById("register-form").addEventListener("submit", function(e){
    var email, password, firstName, lastName, noTelp, confirmPassword;

    email = document.getElementById('email').value;
    password = document.getElementById('password').value;
    firstName = document.getElementById('first-name').value;
    lastName = document.getElementById('last-name').value;
    noTelp = document.getElementById('no-telp').value;
    confirmPassword = document.getElementById('confirm-password').value;

    var validation = validate({
        email: email,
        password: password,
        confirm_password: confirmPassword,
        first_name: firstName,
        last_name: lastName,
        no_telepon: noTelp
    }, {
        email: {
            presence: {allowEmpty: false, message: "Email tidak boleh kosong"},
            email: {message: "tidak valid"}
        },
        password: {
            presence: {allowEmpty: false, message: "Password tidak boleh kosong"}
        },
        confirm_password: {
            presence: {allowEmpty: false, message: "Konfirmasi Password tidak boleh kosong"},
            equality: {
                attribute: "password",
                message: "Password tidak sama"
            }
        },
        first_name: {
            presence: {allowEmpty: false, message: "Nama Depan tidak boleh kosong"}
        },
        last_name: {
            presence: true
        },
        no_telepon: {
            presence: {allowEmpty: false, message: "No Telepon tidak boleh kosong"}
        }
    }, {
        fullMessages: false
    });

    if (validation) {
        document.getElementById("email-error").innerHTML = validation.email !== undefined ? validation.email[0]: "";
        document.getElementById("password-error").innerHTML = validation.password !== undefined ? validation.password[0]: "";
        document.getElementById("confirmpassword-error").innerHTML = validation.confirm_password !== undefined ? validation.confirm_password[0]: "";
        document.getElementById("firstname-error").innerHTML = validation.first_name !== undefined ? validation.first_name[0]: "";
        document.getElementById("lastname-error").innerHTML = validation.last_name !== undefined ? validation.last_name[0]: "";
        document.getElementById("notelp-error").innerHTML = validation.no_telepon !== undefined ? validation.no_telepon[0]: "";

        e.preventDefault();
    }
})

//no-telp numeric only
document.getElementById("no-telp").addEventListener('keypress', (e) => {
    if (isNaN(e.key)) {
        e.preventDefault();
    }
});

/**
 * Password Form Validation
 * 
 */
document.getElementById("password").addEventListener('keyup', (e) => {
    var passwordVal = document.getElementById("password").value;
    var confirmPassVal = document.getElementById("confirm-password").value;
    var confirmPassError = document.getElementById("confirmpassword-error");
    var passMatchValidation = passwordMatchValidation(passwordVal, confirmPassVal);

    if (passMatchValidation) {
        confirmPassError.innerHTML = passMatchValidation.confirm_password !== undefined ? passMatchValidation.confirm_password[0]: "";
    }else{
        confirmPassError.innerHTML = "";
    }
});

//confirm password
document.getElementById("confirm-password").addEventListener('keyup', (e) => {
    var passwordVal = document.getElementById("password").value;
    var confirmPassVal = document.getElementById("confirm-password").value;
    var confirmPassError = document.getElementById("confirmpassword-error");
    var passMatchValidation = passwordMatchValidation(passwordVal, confirmPassVal)

    if (passMatchValidation) {
        confirmPassError.innerHTML = passMatchValidation.confirm_password !== undefined ? passMatchValidation.confirm_password[0]: "";
    }else{
        confirmPassError.innerHTML = "";
    }
});

function passwordMatchValidation(password, confirmPassword){
    var validation = validate({
        password: password,
        confirm_password: confirmPassword
    }, {
        confirm_password: {
            equality: {
                attribute: "password",
                message: "Password tidak sama"
            }
        },
    }, {
        fullMessages: false
    });

    return validation;
}






