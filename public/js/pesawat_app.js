!function(e){var a={};function t(r){if(a[r])return a[r].exports;var n=a[r]={i:r,l:!1,exports:{}};return e[r].call(n.exports,n,n.exports,t),n.l=!0,n.exports}t.m=e,t.c=a,t.d=function(e,a,r){t.o(e,a)||Object.defineProperty(e,a,{enumerable:!0,get:r})},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},t.t=function(e,a){if(1&a&&(e=t(e)),8&a)return e;if(4&a&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(t.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&a&&"string"!=typeof e)for(var n in e)t.d(r,n,function(a){return e[a]}.bind(null,n));return r},t.n=function(e){var a=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(a,"a",a),a},t.o=function(e,a){return Object.prototype.hasOwnProperty.call(e,a)},t.p="/",t(t.s=37)}({116:function(e,a){},37:function(e,a,t){t(38),t(51),t(90),t(92),e.exports=t(116)},38:function(e,a){$(document).on("click",(function(e){var a=$(e.target).attr("widget-name"),t=$(e.target).attr("id"),n=$(e.target).attr("quirk");$("#passenger-class").click((function(){$(this).data("clicked",!0)})),e.target.matches("[widget-type=krc-dropdown]")?$(".krc-dropdown").hasClass("visible")?$(".krc-dropdown").removeClass("visible"):"destination-search"==n?($("#"+t).keyup((function(){var e=$(this).val().toLowerCase();$(a+" .result-list").filter((function(){$(this).toggle($(this).text().toLowerCase().indexOf(e)>-1),""==e?$(".krc-dropdown").removeClass("visible"):$(".krc-dropdown"+a).addClass("visible")}))})),$(a+" .result-list").click((function(){var e=$(this).find(".airport-code").text(),n=$(this).find(".airport-name").text();$("#"+t).val(n+" ("+e+")"),"#to-destination"==a?r.arrival=e:"#from-destination"==a&&(r.departure=e)}))):$(".krc-dropdown"+a).addClass("visible"):$("#passenger-class").data("clicked")?($(this).addClass("visible"),$("#passenger-class").data("clicked",!1)):e.target.matches("[widget-type=krc-dropdown]")||$(".krc-dropdown").removeClass("visible")})),$("#passclass-submit").click((function(){var e=$("#adult").val(),a=$("#child").val(),t=$("#baby").val(),n=$("#cabinclassoption").children("option:selected").val();r.adult=e,r.child=a,r.baby=t,r.cabinclass=n.toLowerCase();var i=Number(e)+Number(a)+Number(t);$("#krc-pass-class").val(i+", "+n),$("#passenger-class").removeClass("visible")}));var t=new Date;$("#departure").datepicker({numberOfMonths:2,minDate:t,maxDate:"+1y",dateFormat:"D, d M yy",altFormat:"yy-mm-dd",altField:"#alt-date-departure"}),$("#departure").datepicker({dateFormat:"yy-mm-dd"}).datepicker("setDate",new Date);t=new Date;$("#return").datepicker({numberOfMonths:2,minDate:t,maxDate:"+1y",dateFormat:"D, d M yy",altFormat:"yy-mm-dd",altField:"#alt-date-return"}),$("#return").datepicker({dateFormat:"yy-mm-dd"}).datepicker("setDate",new Date);var r={departure:"",arrival:"",adult:1,child:0,baby:0,cabinclass:"economy"};function n(e){$.ajax({method:"GET",url:"/webapi/removechoosedticket",success:function(a){"change"==e&&location.reload()}})}if($("#return-input-checkbox").click((function(){$("#return-input-checbox").prop("checked",!0),$("#return-input-checkbox").is(":checked")?($("#return").prop("disabled",!1),r.returndate=""):($("#return").prop("disabled",!0),delete r.returndate)})),$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$(".krc-search-button").click((function(){var e={d:r.departure,a:r.arrival},a={dd:$("#alt-date-departure").val()},t={adult:r.adult,child:r.child,baby:r.baby,class:r.cabinclass};"returndate"in r&&(r.returndate=$("#alt-date-return").val(),a.rd=r.returndate);var n=Object.assign(e,a,t),i=jQuery.param(n);window.location.href="/flight/search?"+i})),$("#departure-change").click((function(){n("change")})),document.URL.includes("/flight/search")){var i=window.location.href,o=new URL(i);o.searchParams.get("d"),o.searchParams.get("a"),o.searchParams.get("dd"),o.searchParams.get("class"),o.searchParams.get("adult"),o.searchParams.get("child"),o.searchParams.get("baby"),o.searchParams.get("rd");c()}else n();function c(){$.ajax({method:"GET",url:"/webapi/getchoosedticket",success:function(e){null!=e.departure_ticket?($(".departure-section").removeClass("d-none"),$("#departure-price").html(e.departure_ticket.price),$("#departure-from-to #from").html(e.departure_ticket.from),$("#departure-from-to #to").html(e.departure_ticket.to),$("#depature-date").html(e.departure_ticket.date),$(".krc-departure-airline-img").attr("src",e.departure_ticket.airline),$(".return-section").removeClass("d-none"),$(".return-section").html("Pilih Penerbangan Pulang")):($(".departure-section").removeClass("d-none"),$(".departure-section").html("Pilih Penerbangan Berangkat"))}})}document.URL.includes("/cart/flight")&&d();function s(e){var a=e.toString().split("").reverse().join("").match(/\d{1,3}/g);return a=a.join(".").split("").reverse().join("")}function d(){var e=window.location.href.split("/")[5];axios.post("/webapi/checkvoucherclaimed",{orderKey:e}).then((function(e){var a=e.data.msg_code,t=e.data.totalPrice;"4sc1e39"==a?function(e){$("#total-price > .pd-total-price").css("text-decoration","line-through").addClass("total-price-removed"),$("#voucher-used").removeClass("d-none"),$("#voucher-used > .pd-total-price").append("Rp. "+s(e)+",00"),$(".voucher-claim").html("Claimed")}(t):(a="4er1e39")&&function(e){$("#voucher-used > .pd-total-price").html(""),$("#total-price > .pd-total-price").css("text-decoration","none").removeClass("total-price-removed"),$("#voucher-used").addClass("d-none"),$("#pd-total-price > .pd-total-price").append("Rp. "+s(e)+",00"),$(".voucher-claim").html("Claim")}(t)}))}$(".choose-button").click((function(){var e=window.location.href,a=new URL(e),t=$(this).attr("data-href"),r=(a.searchParams.get("d"),a.searchParams.get("a"),a.searchParams.get("dd"),a.searchParams.get("class"),{adult:a.searchParams.get("adult"),child:a.searchParams.get("child"),baby:a.searchParams.get("baby")});null!=a.searchParams.get("rd")?$.ajax({method:"POST",data:{idTiket:t},url:"/webapi/setchooseticket",success:function(e){1==e.message?$.ajax({method:"POST",url:"/chooseorder",data:{passenger:r},success:function(e){"succeed"==e.status?window.location.href="/cart/flight/"+e.key:console.log("system terkendala")}}):(c(),location.reload())}}):$.ajax({method:"POST",url:"/chooseorder",data:{idTiket:t,passenger:r},success:function(e){"succeed"==e.status?window.location.href="/cart/flight/"+e.key:console.log("system terkendala")}})})),$(".order-button").click((function(){var e=[],a=[],t=[],r=[],n=window.location.href,i=$("#cust-fullname").val(),o=$("#cust-email").val(),c=n.split("/")[5];$(".pass-type").each((function(){var a=$(this).val();e.push(a)})),$(".pass-title").each((function(){var e=$(this,"option:selected").val();a.push(e)})),$(".pass-fullname").each((function(){var e=$(this).val();t.push(e)})),$(".pass-citizenship").each((function(){var e=$(this,"option:selected").val();r.push(e)})),-1!=jQuery.inArray("default",a)?alert("Isi kolom titel dengan benar !!"):-1!=jQuery.inArray("default",r)?alert("Isi kolom kewarganegaraan dengan benar !!"):axios.post("/order",{orderKey:c,cust_fullname:i,cust_email:o,pass_type:e,pass_title:a,pass_fullname:t,pass_state:r}).then((function(e){var a=e.data.order_id,t=e.data.order_key;window.location.href="/sendmail/"+t+"/"+a})).catch((function(e){var a=e.response.status;422==a?(alert("sepertinya kamu berusaha merubah resource.\nsetelah kamu mengeklik OK, halaman ini akan di muat ulang"),location.reload()):406==a&&(alert("Permintaan kamu di tolak!! \n Halaman ini akan dimuat ulang"),location.reload())}))})),$(".voucher-claim").click((function(){var e=$(this).html(),a=window.location.href,t=$(this).attr("data-id"),r=a.split("/")[5];"claimed"==e.toLowerCase()?1==confirm("Anda yakin tidak ingin menggunakan voucher ini ?")&&axios.post("/webapi/voucherclaim",{orderKey:r,voucherId:t}).then((function(e){"3er2r13"==e.data.msg_code?alert("Point Tidak Mencukupi"):(e.data.msg_code,d())})):1==confirm("Anda yakin ingin menggunakan voucher ini ?")&&axios.post("/webapi/voucherclaim",{orderKey:r,voucherId:t}).then((function(e){"3er2r13"==e.data.msg_code?alert("Point Tidak Mencukupi"):(e.data.msg_code,d())}))})),axios.get("/webapi/karcispoint").then((function(e){$("#karcis_point").html(e.data.karcis_point+" KRCP")}))},51:function(e,a){},90:function(e,a){},92:function(e,a){}});