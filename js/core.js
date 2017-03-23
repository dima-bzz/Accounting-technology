$(document).ready(function() {


var ACTIONPATH=MyHOSTNAME+"actions.php";

var lang = [];
if (($.cookie('lang_cookie') !== '') && ($.cookie('lang_cookie') !== undefined)){
  lang = $.cookie('lang_cookie');
}
if (($.cookie('lang_cookie') === '') || ($.cookie('lang_cookie') === undefined)){
  lang = 'ru';
}
var userid = $.cookie('authhash_usid');


function ispath(p1) {
var url = window.location.href;
var zzz=false;
if (url.search(p1) >= 0) {
    zzz=true;
}
return zzz;
};
// console.log(cookieorgid);
// $(function(){
//   var opts = { language: lang_l, pathPrefix: MyHOSTNAME + "lang/" };
//   opts.callback = function(data, defaultCallback) {
//     // console.log(data);
//     defaultCallback(data);
//   }
//   $.localize("lang", opts);
// });
window.check_er = {login: false, email: false, account: false, save: false, user_name: false};
$('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});

function get_lang_param(par) {
    var result="";
    var zcode="";
    var url = "lang/lang-" + lang + ".json";

if (url.search("inc") >= 0) {
zcode="../";
}

var data = $.parseJSON(
  $.ajax({
    datatype: "json",
    url: url,
    async: false,
    cache: false,
    success: function(html){
      if (typeof (html[par]) !== 'undefined'){
                  result = html[par];
                    }
                    else if (typeof (html[par]) === 'undefined') {
                      result = "undefined";
                    }
                  }
              }).responseText
);
return (result);

};
function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
function my_select(){
  $(".my_select").chosen({
    disable_search_threshold: 10,
    no_results_text: get_lang_param('Chosen_empty'),
    search_contains: true,
    allow_single_deselect: true
  });
};

function my_select2(){
  $(".my_select2").chosen({
    disable_search_threshold: 10,
    search_contains: true,
    no_results_text: get_lang_param('Chosen_empty'),
  });
};
my_select();
my_select2();

$("#dtpost_report").datepicker({
orientation: "top left",
format: 'yyyy',
autoclose: true,
language: lang,
clearBtn: true,
minViewMode: 2,
});

function check_ip(){
  $('#ip').focus(function(){
    $('#ip_grp').addClass('has-error');
  })
  $('#ip').blur(function(){
    $('#ip_grp').removeClass('has-error');
  })
  $('#ip').keyup(function(){
    var val = $(this).val();
    var ip = new RegExp('\\b(?:\\d{1,3}\\.){3}\\d{3}\\b');

    // console.log(ip.test(val));
    if (ip.test(val)){
      $('#ip_grp').removeClass('has-error');
    }
    else {
      $('#ip_grp').addClass('has-error');
    }
  })
}
// function check_users_documents(){
//   var check = '';
// $('#permit_users_documents').blur(function(){
// if (check === false){
//   this.value = '';
// }
//   $('#users_documents_grp').removeClass('has-error');
// })
// $('#permit_users_documents').keyup(function(){
//   var val = $(this).val();
//   var documents = new RegExp(/^[0-9,]+[0-9]$/);
//   this.value = this.value.replace(/[^0-9,]/g,',');
//   check = documents.test(val);
//   // console.log(doc_test);
//   if (check){
//     $('#users_documents_grp').removeClass('has-error');
//   }
//   else {
//     $('#users_documents_grp').addClass('has-error');
//   }
// })
// }
// check_users_documents();
// function check_users_news(){
//   var check = '';
// $('#permit_users_news').blur(function(){
// if (check === false){
//   this.value = '';
// }
//   $('#users_news_grp').removeClass('has-error');
// })
// $('#permit_users_news').keyup(function(){
//   var val = $(this).val();
//   var news = new RegExp(/^[0-9,]+[0-9]$/);
//   this.value = this.value.replace(/[^0-9,]/g,',');
//   check = news.test(val);
//   // console.log(doc_test);
//   if (check){
//     $('#users_news_grp').removeClass('has-error');
//   }
//   else {
//     $('#users_news_grp').addClass('has-error');
//   }
// })
// }
// check_users_news();
// function check_users_cont(){
//   var check = '';
// $('#permit_users_cont').blur(function(){
// if (check === false){
//   this.value = '';
// }
//   $('#users_cont_grp').removeClass('has-error');
// })
// $('#permit_users_cont').keyup(function(){
//   var val = $(this).val();
//   var cont = new RegExp(/^[0-9,]+[0-9]$/);
//   this.value = this.value.replace(/[^0-9,]/g,',');
//   check = cont.test(val);
//   // console.log(doc_test);
//   if (check){
//     $('#users_cont_grp').removeClass('has-error');
//   }
//   else {
//     $('#users_cont_grp').addClass('has-error');
//   }
// })
// }
// check_users_cont();
// function check_users_req(){
//   var check = '';
// $('#permit_users_req').blur(function(){
// if (check === false){
//   this.value = '';
// }
//   $('#users_req_grp').removeClass('has-error');
// })
// $('#permit_users_req').keyup(function(){
//   var val = $(this).val();
//   var req = new RegExp(/^[0-9,]+[0-9]$/);
//   this.value = this.value.replace(/[^0-9,]/g,',');
//   check = req.test(val);
//   // console.log(doc_test);
//   if (check){
//     $('#users_req_grp').removeClass('has-error');
//   }
//   else {
//     $('#users_req_grp').addClass('has-error');
//   }
// })
// }
// check_users_req();
// function check_users_knt(){
//   var check = '';
// $('#permit_users_knt').blur(function(){
// if (check === false){
//   this.value = '';
// }
//   $('#users_knt_grp').removeClass('has-error');
// })
// $('#permit_users_knt').keyup(function(){
//   var val = $(this).val();
//   var knt = new RegExp(/^[0-9,]+[0-9]$/);
//   this.value = this.value.replace(/[^0-9,]/g,',');
//   check = knt.test(val);
//   // console.log(doc_test);
//   if (check){
//     $('#users_knt_grp').removeClass('has-error');
//   }
//   else {
//     $('#users_knt_grp').addClass('has-error');
//   }
// })
// }
// check_users_knt();
  function check_approve(){
     $.post( ACTIONPATH,{ mode: "approve" },function( data ) {
  if (data !== '0'){
$( "#ap" ).hide().empty().append( data ).fadeIn(500);
$( "#ap2" ).empty().append( data );
}
else {
  $( "#ap" ).fadeOut(500);
  $( "#ap2" ).empty().removeAttr( 'style' );
}
});
};
function check_approve_users(){
   $.post( ACTIONPATH,{ mode: "approve_users" },function( data ) {
     $("#count_update").html(data);
});
};

// $("#inf").find('br').first().remove();
if ($("#inf").find("br").length){
  $("#inf").find("br").first().remove();
  $("#inf").find("hr").removeAttr("hidden");
}
// Для фотогалереи
// $(".fancybox").fancybox();
// *****Новый год*****
currentMonth = new Date().getMonth() + 1;
// console.log(currentMonth);
if ((currentMonth == 12) || (currentMonth == 11)){
function NewYear()
{
  today = new Date();
  currentYear = today.getFullYear();
  newYear = new Date(currentYear + 1, 0, 1, 0, 0, 0);
  seconds = ((newYear.getTime() - today.getTime())/1000);

  days = 0; hours = 0; minutes = 0;
  oneMinute = 60;
  oneHour = 60 * oneMinute;
  oneDay = oneHour * 24;
  if (seconds / oneDay > 0) {
  days = parseInt(seconds / oneDay);
  seconds -= days * oneDay;
  }
  if (seconds / oneHour > 0) {
  hours = parseInt(seconds / oneHour);
  seconds -= hours * oneHour;
  }

  if (seconds / oneMinute > 0) {
  minutes = parseInt(seconds / oneMinute);
  seconds -= minutes * oneMinute;
  }
  dayname = "";
  minutname = "";
  hoursname = "";
  beforeNewYear = "";
  secondsname = "";
  if (days>4&&days<21){
    if (lang == 'ru'){
    dayname = "дней";
  }
  if (lang == 'en'){
  dayname = "days";
}
  }
  else if (days == 1 || days == 21 || days == 31 || days == 41 || days == 51) {
    if (lang == 'ru'){
    dayname = "день";
  }
  if (lang == 'en'){
  dayname = "day";
}
  }
  else if (days == 2 || days == 3 || days == 4 || days == 22 || days == 23 || days == 24 || days == 32 || days == 33 || days == 34 || days == 42 || days == 43 || days == 44 || days == 52 || days == 53 || days == 54) {
    if (lang == 'ru'){
    dayname = "дня";
  }
  if (lang == 'en'){
  dayname = "day";
}
  }
  else {
    if (lang == 'ru'){
    dayname = "дней";
  }
  if (lang == 'en'){
  dayname = "days";
}
  }
  if (hours>4&&hours<21){
    if (lang == 'ru'){
    hoursname = "часов";
  }
  if (lang == 'en'){
  hoursname = "hours";
}
  }
  else if (hours == 1 || hours == 21) {
    if (lang == 'ru'){
    hoursname = "час";
  }
  if (lang == 'en'){
  hoursname = "hour";
}
  }
  else if (hours == 2 || hours == 3 || hours == 4 || hours == 22 || hours == 23 || hours == 24) {
    if (lang == 'ru'){
    hoursname = "часа";
  }
  if (lang == 'en'){
  hoursname = "hours";
}
  }
  else {
    if (lang == 'ru'){
    hoursname = "часов";
  }
  if (lang == 'en'){
  hoursname = "hours";
}
  }
  if (minutes>4&&minutes<21){
    if (lang == 'ru'){
    minutname = "минут";
  }
  if (lang == 'en'){
  minutname = "minutes";
}
  }
  else if (minutes == 1 || minutes == 21 || minutes == 31 || minutes == 41 || minutes == 51) {
    if (lang == 'ru'){
    minutname = "минута";
  }
  if (lang == 'en'){
  minutname = "minute";
}
  }
  else if (minutes == 2 || minutes == 3 || minutes == 4 || minutes == 22 || minutes == 23 || minutes == 24 || minutes == 32 || minutes == 33 || minutes == 34 || minutes == 42 || minutes == 43 || minutes == 44 || minutes == 52 || minutes == 53 || minutes == 54) {
    if (lang == 'ru'){
    minutname = "минуты";
  }
  if (lang == 'en'){
  minutname = "minutes";
}
  }
  else {
    if (lang == 'ru'){
    minutname = "минут";
  }
  if (lang == 'en'){
  minutname = "minutes";
}
  }
 if (lang == 'ru'){
   beforeNewYear = "До Нового Года осталось";
   secondsname = "секунд";
 }
 if (lang == 'en'){
   beforeNewYear = "Before the New Year remains";
   secondsname = "seconds";
 }
  $("#time").empty().append('<br><font color="rgb(49,203,86)"><b>'+ beforeNewYear + ' - ' + days + ' ' + dayname +' ' + hours + ' ' + hoursname + ' ' + minutes + ' ' + minutname + ' ' + parseInt(seconds) + ' ' + secondsname + ' :)</b></font><br>');
};
NewYear();
setInterval(NewYear,1000);
}
// *****Генератор имен пользователей******
    // function str_rand() {
    //     var result       = '';
    //     var words        = 'qwertyuiopasdfghjklzxcvbnm';
    //     var max_position = words.length - 1;
    //         for( i = 0; i < 8; ++i ) {
    //             position = Math.floor ( Math.random() * max_position );
    //             result = result + words.substring(position, position + 1);
    //         }
    //     return result;
    // }
    function str_rand(){
        var rndType = Math.floor(Math.random() * 3) + 1;
        var nickname = "";
        var h_fnpre = new Array("Te", "Ni", "Nila", "Andro", "Androma", "Sha", "Ara", "Ma", "Mana", "La", "Landa", "Do", "Dori", "Pe", "Peri", "Conju", "Co", "Fo", "Fordre", "Da", "Dala", "Ke", "Kele", "Gra", "Grani", "Jo", "Sa", "Mala", "Ga", "Gavi", "Gavinra", "Mo", "Morlu", "Aga", "Agama", "Ba", "Balla", "Ballado", "Za", "Ari", "Ariu", "Au", "Auri", "Bra", "Ka", "Bu", "Buza", "Coi", "Bo", "Mu", "Muni", "Tho", "Thorga", "Ke", "Gri", "Bu", "Buri", "Hu", "Hugi", "Tho", "Thordi", "Ba", "Bandi", "Ga", "Bea", "Beaze", "Mo", "Modi", "Ma", "Malo", "Gholbi", "Gho", "Da", "Dagda", "Nua", "Nuada", "Oghma", "Ce", "Centri", "Cere", "Ce", "Ka", "Kathri", "Ado", "Adora", "Mora", "Mo", "Fe", "Felo", "Ana", "Anara", "Kera", "Mave", "Dela", "Mira", "Theta", "Tygra", "Adrie", "Diana", "Alsa", "Mari", "Shali", "Sira", "Sai", "Saithi", "Mala", "Kiri", "Ana", "Anaya", "Felha", "Drela", "Corda", "Nalme", "Na", "Um", "Ian", "Opi", "Lai", "Ygg", "Mne", "Ishn", "Kula", "Yuni", "To", "Toja", "Ni", "Niko", "Ka", "Kaji", "Mi", "Mika", "Sa", "Samu", "Aki", "Akino", "Ma", "Mazu", "Yo", "Yozshu", "Da", "Dai", "Ki", "Kiga", "Ara", "Arashi", "Mo", "Moogu", "Ju", "Ga", "Garda", "Ne", "Ka", "Ma", "Ba", "Go", "Kaga", "Na", "Mo", "Kazra", "Kazi", "Fe", "Fenri", "Ma", "Tygo", "Ta", "Du", "Ka", "Ke", "Mu", "Gro", "Me", "Mala", "Tau", "Te", "Tu", "Mau", "Zu", "Zulki", "JoJo", "Sha", "Shaka", "Shakti", "Me", "Mezi", "Mezti", "Vo", "Do", "Du", "Di", "Vu", "Vi", "Dou", "Ga", "Gu", "Fae", "Fau", "Go", "Golti", "Vudo", "Voodoo", "Zolo", "Zulu", "Bra", "Net", "Flame", "Arcane", "Light", "Mage", "Spell", "Rex", "Dawn", "Dark", "Red", "Truth", "Might", "True", "Bright", "Pure", "Fearless", "Dire", "Blue", "White", "Black", "Rain", "Doom", "Rune", "Sword", "Force", "Axe", "Stone", "Iron", "Broad", "Stern", "Thunder", "Frost", "Rock", "Doom", "Blud", "Blood", "Stone", "Steel", "Golden", "Gold", "Silver", "White", "Black", "Gravel", "Sharp", "Star", "Night", "Moon", "Chill", "Whisper", "White", "Black", "Saber", "Snow", "Rain", "Dark", "Light", "Wind", "Iron", "Blade", "Shadow", "Flame", "Sin", "Pain", "Hell", "Wrath", "Rage", "Blood", "Terror");
        var h_fnsuf = new Array("", "nn", "las", "", "math", "th", "", "ath", "zar", "ril", "ris", "rus", "jurus", "dred", "rdred", "lar", "len", "nis", "rn", "ge", "lak", "nrad", "rad", "lune", "kus", "mand", "gamand", "llador", "dor", "dar", "nadar", "rius", "nius", "zius", "tius", "sius", "wield", "helm", "zan", "tus", "bor", "nin", "rgas", "gas", "lv", "kelv", "gelv", "rim", "sida", "ginn", "grinn", "nn", "huginn", "rdin", "ndis", "bandis", "gar", "zel", "di", "ron", "rne", "lbine", "gda", "ghma", "ntrius", "dwyn", "wyn", "swyn", "thris", "dora", "lore", "nara", "ra", "las", "gra", "riel", "lsa", "rin", "lis", "this", "lace", "ri", "naya", "rana", "lhala", "lanim", "rdana", "lmeena", "meena", "fym", "fyn", "hara", "jora", "kora", "jind", "kasa", "muro", "nos", "kinos", "zuru", "zshura", "shura", "ra", "sho", "gami", "mi", "shicage", "cage", "gul", "bei", "dal", "gal", "zil", "gis", "le", "rr", "gar", "gor", "grel", "rg", "gore", "zragore", "nris", "sar", "risar", "rn", "gore", "m", "rn", "t", "ll", "k", "lar", "r", "taur", "taxe", "lkis", "labar", "bar", "jas", "lrajas", "lmaran", "ran", "kazahn", "zahn", "hn", "lar", "tilar", "ktilar", "zilkree", "kree", "lkree", "jin", "jinn", "shakar", "jar", "ramar", "kus", "sida", "worm", "seeker", "caster", "binder", "weaver", "singer", "font", "hammer", "redeemer", "bearer", "bringer", "defender", "conjuror", "eye", "staff", "flame", "fire", "shaper", "breaker", "cliff", "worm", "hammer", "brew", "beard", "fire", "forge", "stone", "smith", "fist", "pick", "skin", "smasher", "crusher", "worker", "shaper", "song", "shade", "singer", "ray", "wind", "fang", "dragon", "mane", "scar", "moon", "wood", "raven", "wing", "hunter", "warden", "stalker", "grove", "walker", "master", "blade", "fury", "weaver", "terror", "dweller", "killer", "seeker", "bourne", "bringer", "runner", "brand", "wrath");
            var fnprefix1 = Math.floor(Math.random() * 122);
            var fnsuffix1 = Math.floor(Math.random() * 91);
            firstName = h_fnpre[fnprefix1] + h_fnsuf[fnsuffix1];
            nickname = firstName;
        return nickname;
    }
// *****Календарь*****
$("#calendar").fullCalendar({
  columnFormat: 'dddd',
  header: {
    center: 'title',
    left: 'prev,next today',
    right: ''
  },
  weekNumbers: true,
  height: 600,
  eventLimit:true,
  selectable: true,

  dayClick: function(date) {

      //  alert('Clicked on: ' + date.format("YYYY-MM-DD HH:mm:ss"));
       window.dialog_event_add = new BootstrapDialog({
               title: get_lang_param("Event_add"),
               message: function(dialogRef) {
     var $message = $('<div></div>');
     var data = $.ajax({
     url: ACTIONPATH,
     type: 'POST',
     data: "mode=dialog_event_add",
     context: {
         theDialogWeAreUsing: dialogRef
     },
     success: function(content) {
     this.theDialogWeAreUsing.setMessage(content);
     }
     });
     return $message;
     },
               nl2br: false,
               closable: true,
               draggable: true,
               closeByBackdrop: false,
               closeByKeyboard: false,
               onshown: function(){
                 $(function(){
                   var ec = $("#color-event").attr("val");
                   var ect = $("#color-event-text").attr("val");
                   $("#color-event").val(ec);
                   $("#color-event-text").val(ect);
                   $("#color-event").colorpicker({
                     color: ec
                   }).on('changeColor', function(e){
                     $('.events')[0].style.backgroundColor = e.color.toHex();
                     $(this).val(e.color.toHex());
                   })
                   $("#color-event-text").colorpicker({
                     color: ect
                   }).on('changeColor', function(e){
                     $('.events')[0].style.color = e.color.toHex();
                     $(this).val(e.color.toHex());
                   })
                 });
                 my_select();
                $("#event_start").val(date.format("DD.MM.YYYY"));
                $("#event_end").val(date.format("DD.MM.YYYY"));
                $("#datepicker").datepicker({
                 format: 'dd.mm.yyyy',
                 autoclose: true,
                 language: lang,
                 todayBtn: "linked",
                 clearBtn: false,
                 todayHighlight: true
                 });
                 $("#event_end").change(function(){
                   if ($(this).val().length > 8){
                     $('#event_end').popover('hide');
                     $('#event_date').removeClass('has-error');
                   }
                   else {
                   $('#event_date').addClass('has-error');
                   }
                 });
                 $("#event_start").change(function(){
                   if ($(this).val().length > 8){
                     $('#event_start').popover('hide');
                     $('#event_date').removeClass('has-error');
                   }
                   else {
                   $('#event_date').addClass('has-error');
                   }
                 });
               $('#event_name').keyup(function(){
                 if ($(this).val().length > 0){
                   $('#event_grp').removeClass('has-error');
                 }
               });
             }
           });
           dialog_event_add.realize();
           dialog_event_add.open();
   },
   eventClick: function(calEvent, jsEvent, view, date) {
     if ((calEvent.description !== 'birthday') && (calEvent.description !== 'antivirus')){
     window.edit_event_id = calEvent.id_us_ev;
     window.dialog_event_edit = new BootstrapDialog({
             title: get_lang_param("Event_edit"),
             message: function(dialogRef) {
   var $message = $('<div></div>');
   var data = $.ajax({
   url: ACTIONPATH,
   type: 'POST',
   data: "mode=dialog_event_edit_del" +
   "&id=" + edit_event_id,
   context: {
       theDialogWeAreUsing: dialogRef
   },
   success: function(content) {
   this.theDialogWeAreUsing.setMessage(content);
   }
   });
   return $message;
   },
             nl2br: false,
             closable: true,
             draggable: true,
             closeByBackdrop: false,
             closeByKeyboard: false,
             onshown: function(){
               $(function(){
                 var ec = $("#color-event").attr("val");
                 var ect = $("#color-event-text").attr("val");
                 $("#color-event").val(ec);
                 $("#color-event-text").val(ect);
                 $("#color-event").colorpicker({
                   color: ec
                 }).on('changeColor', function(e){
                   $('.events')[0].style.backgroundColor = e.color.toHex();
                   $(this).val(e.color.toHex());
                 })
                 $("#color-event-text").colorpicker({
                   color: ect
                 }).on('changeColor', function(e){
                   $('.events')[0].style.color = e.color.toHex();
                   $(this).val(e.color.toHex());
                 })
               });
               my_select();
               $("#datepicker").datepicker({
                format: 'dd.mm.yyyy',
                autoclose: true,
                language: lang,
                todayBtn: "linked",
                clearBtn: false,
                todayHighlight: true
                });
                $("#event_end").change(function(){
                  if ($(this).val().length > 8){
                    $('#event_end').popover('hide');
                    $('#event_date').removeClass('has-error');
                  }
                  else {
                  $('#event_date').addClass('has-error');
                  }
                });
                $("#evencookie_eq").change(function(){
                  if ($(this).val().length > 8){
                    $('#event_start').popover('hide');
                    $('#event_date').removeClass('has-error');
                  }
                  else {
                  $('#event_date').addClass('has-error');
                  }
                });
             $('#event_name').keyup(function(){
               if ($(this).val().length > 0){
                 $('#event_grp').removeClass('has-error');
               }
             });
           }
         });
         dialog_event_edit.realize();
         dialog_event_edit.open();
   }
 },
 editable: true,
 eventDrop: function(event, delta, revertFunc) {

    //  alert(event.title + " was dropped on " + event.start.format());
    if ((event.description == 'birthday') || (event.description == 'antivirus')){
      revertFunc();
    }
    if ((event.description !== 'birthday') && (event.description !== 'antivirus')){
    //  window.drag_description = event.description;
     window.drag_id = event.id_us_ev;
     window.drag_event_start = event.start.format();
     window.drag_event_end = event.end.format();
     window.dialog_drag = new BootstrapDialog({
             title: get_lang_param("Event_drop"),
             message: get_lang_param("Event_info"),
             type: BootstrapDialog.TYPE_WARNING,
             cssClass: 'del-dialog',
             closable: false,
             draggable: true,
             closeByBackdrop: false,
             closeByKeyboard: false,
             buttons:[
               {
                 id: "drag_cancel",
                 label: get_lang_param("Btn_close"),
                 action: function(){
                        revertFunc();
                        dialog_drag.close();
                 }
               },
               {
               id: "drag_ok",
               label: get_lang_param("Btn_Ok"),
               cssClass: "btn-primary",
             }
           ],
           });
           dialog_drag.realize();
           dialog_drag.open();
         }

 },
  displayEventTime: false,
// events:[
//   {
//   title: '123',
//   start: '2016-02-29 00:00:00',
//   end: '2016-02-29 23:59:00',
//   // allDay:true
// },
// {
// title: '123',
// start: '2016-03-29 00:00:00',
// end: '2016-03-29 23:59:00',
// // allDay:true
// },
// {
// title: '123',
// start: '2017-03-29 00:00:00',
// end: '2017-03-29 23:59:00',
// // allDay:true
// },
// ],
eventRender: function(event, element, view){
  if (event.description == 'birthday'){
  element.find('.fc-title').prepend('<i class=\"fa fa-birthday-cake\"></i>&nbsp;');
}
if (event.description == 'antivirus'){
element.find('.fc-title').prepend('<i class=\"fa fa-key\"></i>&nbsp;');
}
},
eventSources: [
          {
            url: ACTIONPATH,
            type: 'POST', // Send post data
            data: {
              mode: 'calendar_birthday'
            },
          },
          {
            url: ACTIONPATH,
            type: 'POST', // Send post data
            data: {
              mode: 'calendar_antivirus'
            },
            color: '#f4c2c2',
            textColor: '#333'
        },
        {
          url: ACTIONPATH,
          type: 'POST', // Send post data
          data: {
            mode: 'calendar_users_event'
          },
          // color: '#b8e77d',
          // textColor: '#333'
      }
      ],
        eventMouseover: function(calEvent, jsEvent) {
            if (calEvent.description == 'birthday'){
            var tooltip = '<div class="tooltipevent fc-event" style="position:absolute;z-index:10001;">' + '&nbsp;' + calEvent.title + '&nbsp;' + '</div>';
          }
          if (calEvent.description == 'antivirus'){
            var tooltip = '<div class="tooltipevent fc-event_anti" style="position:absolute;z-index:10001;">' + '&nbsp;' + calEvent.title + '&nbsp;' + '</div>';

          }
          if (calEvent.description == 'users_event'){
            var tooltip = '<div class="tooltipevent fc-event_users" style="position:absolute;z-index:10001;background-color:'+calEvent.color+';border:1px solid '+calEvent.color+';color:'+calEvent.textColor+';">' + '&nbsp;' + calEvent.title + '&nbsp;' + '</div>';

          }
            $("body").append(tooltip);
            $(this).mouseover(function(e) {
                $(this).css('z-index', 10000);
                $('.tooltipevent').fadeIn('500');
                $('.tooltipevent').fadeTo('10', 1.9);
            }).mousemove(function(e) {
                $('.tooltipevent').css('top', e.pageY + 10);
                $('.tooltipevent').css('left', e.pageX + 20);
            });
        },

        eventMouseout: function(calEvent, jsEvent) {
            $(this).css('z-index', 8);
            $('.tooltipevent').remove();
        },
});
$('.fc-prev-button').click(function(){
  var b = $('#calendar').fullCalendar('getDate');
  var day = b.format('YYYY-MM-DD');
  $.cookie('date',day);
});
$('.fc-today-button').click(function(){
  var b = $('#calendar').fullCalendar('getDate');
  var day = b.format('YYYY-MM-DD');
  $.cookie('date',day);
});

$('.fc-next-button').click(function(){
   var b = $('#calendar').fullCalendar('getDate');
   var day = b.format('YYYY-MM-DD');
    $.cookie('date',day);
});
// ***** Перемещение события *****
$('body').on('click', 'button#drag_ok', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=drag_event" +
        "&id="+drag_id +
        "&event_start=" + drag_event_start +
        "&event_end=" + drag_event_end,
        success: function() {
          dialog_drag.close();
          $("#calendar").fullCalendar( 'refetchEvents' );
        }
        });
});


// ***** Добавление события в календарь ******
$('body').on('click', 'button#event_add', function(event) {
          event.preventDefault();

          var valid_event_add_edit = function(){
          var valid_result = false;
          if ($('#event_name').val().length == '0'){
            $('#event_name').popover('show');
            $('#event_grp').addClass('has-error');
            setTimeout(function(){$("#event_name").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#event_start').val().length == '0'){
            $('#event_start').popover('show');
            $('#event_date').addClass('has-error');
            setTimeout(function(){$("#event_start").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#event_end').val().length == '0'){
            $('#event_end').popover('show');
            $('#event_date').addClass('has-error');
            setTimeout(function(){$("#event_end").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };

        if (valid_event_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=event_add"+
        "&event_name=" +encodeURIComponent($("#event_name").val())+
        "&event_start=" +encodeURIComponent($("#event_start").val())+
        "&event_end=" +encodeURIComponent($("#event_end").val())+
        "&remind=" +encodeURIComponent($("#remind").val())+
        "&event_repeat=" +encodeURIComponent($("#event_repeat").val())+
        "&color-event=" +encodeURIComponent($("#color-event").val())+
        "&color-event-text=" +encodeURIComponent($("#color-event-text").val())+
        "&comment=" +encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_event_add.close();
          $("#calendar").fullCalendar( 'refetchEvents' );
        }
        });
      }
});

// ***** Редактирование события в календарь ******
$('body').on('click', 'button#event_edit', function(event) {
          event.preventDefault();

          var valid_event_add_edit = function(){
          var valid_result = false;
          if ($('#event_name').val().length == '0'){
            $('#event_name').popover('show');
            $('#event_grp').addClass('has-error');
            setTimeout(function(){$("#event_name").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#event_start').val().length == '0'){
            $('#event_start').popover('show');
            $('#event_date').addClass('has-error');
            setTimeout(function(){$("#event_start").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#event_end').val().length == '0'){
            $('#event_end').popover('show');
            $('#event_date').addClass('has-error');
            setTimeout(function(){$("#event_end").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };

        if (valid_event_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=event_edit"+
        "&id=" + edit_event_id +
        "&event_name=" +encodeURIComponent($("#event_name").val())+
        "&event_start=" +encodeURIComponent($("#event_start").val())+
        "&event_end=" +encodeURIComponent($("#event_end").val())+
        "&remind=" +encodeURIComponent($("#remind").val())+
        "&event_repeat=" +encodeURIComponent($("#event_repeat").val())+
        "&color-event=" +encodeURIComponent($("#color-event").val())+
        "&color-event-text=" +encodeURIComponent($("#color-event-text").val())+
        "&comment=" +encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_event_edit.close();
          $("#calendar").fullCalendar( 'refetchEvents' );
        }
        });
      }
});

// ***** Удаление События *****
$('body').on('click', 'button#event_del', function(event) {
          event.preventDefault();
          window.dialog_event_del = new BootstrapDialog({
                  title: get_lang_param("Event_delete"),
                  message: get_lang_param("Info_del3"),
                  type: BootstrapDialog.TYPE_DANGER,
                  cssClass: 'del-dialog',
                  closable: true,
                  draggable: true,
                  closeByBackdrop: false,
                  closeByKeyboard: false,
                  buttons:[{
                    id: "event_delete",
                    label: get_lang_param("Delete"),
                    cssClass: " btn-danger",
                  }],
                });
          dialog_event_del.open();
$('body').on('click', 'button#event_delete', function(event) {
        event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=event_del"+
        "&id=" + edit_event_id,
        success: function() {
          dialog_event_del.close();
          dialog_event_edit.close();
          $("#calendar").fullCalendar( 'refetchEvents' );
        }
        });
        });
});
// ******автокомплит******
$('body').on('click', 'button#users_online', function(event) {
  $('#search_box').empty().val('');
  $('#results').html('');
  $('#search_box').text('online');
  $('#search_box').trigger('keyup').focus().change();
  $(this).tooltip('hide').blur();
});
$('body').on('click', 'button#users_offline', function(event) {
  $('#search_box').empty().val('');
  $('#results').html('');
  $('#search_box').text('offline');
  $('#search_box').trigger('keyup').focus().change();
  $(this).tooltip('hide').blur();
});
$('body').on('click', 'button#input_empty', function(event) {
  $('#search_box').empty().val('');
  $('#results').html('');
  $(this).tooltip('hide').blur();
});
 $('#search_box').typeahead({
	 items: 100,
	 minLength: 1,
     source: function(query, process){
 			$.ajax ({
 			// 	url: 'server/common/show_contact.php',
			url: ACTIONPATH,
 				type: 'POST',
 				data:'mode=show&query=' + query,
 				dataType:'JSON',
 				async: false,
 				success: function(data){
 				// 	console.log(data);
 					process(data);

 				}

 			});
 		},
    highlighter: function(item) {
        var parts = item.split('#'),
          html = '<div>' + parts[0] + parts[1] + '</div>';

        var query = this.query;
            if(!query) {
                return '<div> ' + item + '</div>';
            }
        var reEscQuery = query.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
        var reQuery = new RegExp('(' + reEscQuery + ')', "gi");
        var jElem = $(html);
        var textNodes = $(jElem.find('*')).add(jElem).contents().filter(function() {
          return this.nodeType === 3;
        });
        textNodes.replaceWith(function() {
          return $(this).text().replace(reQuery, '<strong>$1</strong>');
        });

        return jElem.html();
      },
    updater: function(item){
      var name = item.split('#')[1];
      $("#search_box").val(name);
      search_result_contact('click');
      return name;
    }
 });
 // ******показ результата******
function search_result_contact() {
// получаем то, что написал пользователь
var searchString    = $("#search_box").val();
// формируем строку запроса
var data            = 'mode=search&search='+ searchString;
// console.log(searchString);
// если searchString не пустая
if(searchString) {
// делаем ajax запрос
$.ajax({
		type: "POST",
		url: ACTIONPATH,
		data: data,
		beforeSend: function(html) { // запустится до вызова запроса
				$("#results").html('');
				$("#searchresults").show();
				$(".word").html(searchString);
	 },
	 success: function(html){ // запустится после получения результатов
				$("#results").show();
				$("#results").append(html);
	}
});
}
return false;
};

$('.search_button').keydown(function(e) { //******очищаем поле и выходные данные******
if (e.keyCode === 8)
{
	$(this).empty().val('');
	$('#results').html('');
}
});

// ***** Автокомплит invoice *****
function inv_typehead(){
  $('#invoice').typeahead({
  items: 100,
  minLength: 1,

    source: function(query, process){
     $.ajax ({
     url: ACTIONPATH,
       type: 'POST',
       data:'mode=invoice_show&query=' + query,
       dataType:'JSON',
       async: false,
       success: function(data){
         process(data);
       }

     });
   },
   afterSelect: function(item){
     var invoice = item.split(" от ");
     $("#invoice").val(invoice[0]);
     $("#invoice_date").val(invoice[1]);
   }
})
}
// ***** Автокомплит параметров *****
function eq_param_typehead(){
  $("input[name='eq_param_gr_"+total_input+"']").typeahead({
  items: 100,
  minLength: 1,
    source: function(query, process){
     $.ajax ({
     url: ACTIONPATH,
       type: 'POST',
       data:'mode=eqparam_show&query=' + query,
       dataType:'JSON',
       async: false,
       success: function(data){
         process(data);
          // console.log(data);
       }

     });
   }
})
}
function eq_param_typehead_edit(){
  $("#eq_param_gr").typeahead({
  items: 100,
  minLength: 1,
    source: function(query, process){
     $.ajax ({
     url: ACTIONPATH,
       type: 'POST',
       data:'mode=eqparam_show&query=' + query,
       dataType:'JSON',
       async: false,
       success: function(data){
         process(data);
        //  console.log(data);
       }

     });
   }
})
}
// ***** Фото ТМЦ *****
function equipment_photo(){
  d = new Date();
  $.ajax ({
  url: ACTIONPATH,
    type: 'POST',
    data:'mode=equipment_photo&id=' + eq_one_id,
    async: false,
    success: function(data){
      if ((data !== '') && (data !== 'noimage.png')){
        var data_end = data + "?" + d.getTime();
      $('#photoid').hide().empty().append('<img src="images/equipment/'+ data_end +'"style=\"border-radius:10px; border:1px solid #aaa;\">').fadeIn(500);
    }
    else{
      $('#photoid').fadeOut(500);
    }
    }
  });
}
// ***** Обновления активности *****
function check_update(){
  $.ajax({
  type: "POST",
  url: ACTIONPATH,
  data: "mode=check_update"
})
}
setInterval(function(){
    check_update();
    check_approve_users();
},5000);
// ******Сохранение настроек******
$('body').on('click', 'button#conf_edit_main', function(event) {
        event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=conf_edit_main"+
        "&name_of_firm="+encodeURIComponent($("input#name_of_firm").val())+
        "&title_header="+encodeURIComponent($("input#title_header").val())+
        "&hostname="+encodeURIComponent($("input#hostname").val())+
        "&mail="+encodeURIComponent($("input#mail").val())+
        "&first_login="+encodeURIComponent($("#first_login").val()) +
        "&file_types="+encodeURIComponent($("#file_types").val())+
        "&file_types_img="+encodeURIComponent($("#file_types_img").val())+
        "&file_size="+encodeURIComponent($("#file_size").val()*1024*1024) +
        "&permit_users_knt="+encodeURIComponent($("#permit_users_knt").val()) +
        "&permit_users_req="+encodeURIComponent($("#permit_users_req").val()) +
        "&permit_users_cont="+encodeURIComponent($("#permit_users_cont").val()) +
        "&permit_users_documents="+encodeURIComponent($("#permit_users_documents").val())+
        "&permit_users_news="+encodeURIComponent($("#permit_users_news").val())+
        "&permit_users_license="+encodeURIComponent($("#permit_users_license").val())+
        "&default_org="+encodeURIComponent($("#default_org").val())+
        "&what_cartridge="+encodeURIComponent($("#what_cartridge").val())+
        "&what_print_test="+encodeURIComponent($("#what_print_test").val())+
        "&what_license="+encodeURIComponent($("#what_license").val())+
        "&home_text="+encodeURIComponent($("#home_text").val()),
        success: function(html) {
        $.cookie('cookieorgid',$("#default_org").val());
        $("#conf_edit_main").blur();
        $("#conf_edit_main_res").hide().html(html).fadeIn(500);
        setTimeout(function() {$('#conf_edit_main_res').children('.alert').fadeOut(500);}, 3000);
        }
        });
});

// ******Тестирование настроек почты******

$('body').on('click', 'button#conf_test_mail', function(event) {
 event.preventDefault();
 $.ajax({
 type: "POST",
 url: ACTIONPATH,
 data: "mode=conf_edit_mail"+
 "&mail_active="+encodeURIComponent($("#mail_active").val())+
 "&host="+encodeURIComponent($("#host").val())+
 "&port="+encodeURIComponent($("#port").val())+
 "&auth="+encodeURIComponent($("#auth").val())+
 "&auth_type="+encodeURIComponent($("#auth_type").val())+
 "&username="+encodeURIComponent($("#username").val())+
 "&password="+encodeURIComponent($("#password").val())+
 "&from="+encodeURIComponent($("#from").val())+
 "&type="+encodeURIComponent($("#mail_type").val()),
 success: function(html) {

 $("#conf_edit_mail_res").hide().html(html).fadeIn(500);
 setTimeout(function() {$('#conf_edit_mail_res').children('.alert').fadeOut(500);}, 3000);
 $.ajax({
 type: "POST",
 url: ACTIONPATH,
 data: "mode=conf_test_mail",
 success: function(html) {
  $('#conf_test_mail_res').html(html);
 }
 });


 }
 });



 });

// ******Сохранение настроек почты******
$('body').on('click', 'button#conf_edit_mail', function(event) {
event.preventDefault();
$.ajax({
type: "POST",
url: ACTIONPATH,
data: "mode=conf_edit_mail"+
"&mail_active="+encodeURIComponent($("#mail_active").val())+
"&host="+encodeURIComponent($("#host").val())+
"&port="+encodeURIComponent($("#port").val())+
"&auth="+encodeURIComponent($("#auth").val())+
"&auth_type="+encodeURIComponent($("#auth_type").val())+
"&username="+encodeURIComponent($("#username").val())+
"&password="+encodeURIComponent($("#password").val())+
"&from="+encodeURIComponent($("#from").val())+
"&type="+encodeURIComponent($("#mail_type").val()),
success: function(html) {
$("#conf_edit_mail_res").hide().html(html).fadeIn(500);
setTimeout(function() {$('#conf_edit_mail_res').children('.alert').fadeOut(500);}, 3000);
}
});
});

// ******Добавление ТМЦ******
function img_equipment(){
var options =
{
    thumbBox: '.thumbBox2',
    spinner: '.spinner2',
    imgSrc: Equipment_img
}
window.cropper = $('.imageBox2').cropbox(options);
$('#file').on('change', function(){
  var fileExtension = file_types_img;
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) !== -1){
    var reader = new FileReader();
    reader.onload = function(e) {
        options.imgSrc = e.target.result;
        cropper = $('.imageBox2').cropbox(options);
    }
    reader.readAsDataURL(this.files[0]);
    this.files = [];
    check_er.save = true;
  }
  else {
    BootstrapDialog.alert({
    title: get_lang_param("Er_title"),
    message: get_lang_param("Er_msg_type")  + '(' +file_types_img +')',
    type: BootstrapDialog.TYPE_WARNING,
    draggable: true,
    callback: function() {
      $('#file').val(null);
      }
    });
  }
})
$('#btnZoomIn').on('click', function(){
    cropper.zoomIn();
})
$('#btnZoomOut').on('click', function(){
    cropper.zoomOut();
})
$('#btnRotate').on('click', function(){
    cropper.rotate();
})
$('#btn_file').on('click', function(){
    $('#file').click();
})
}
$('body').on('click', 'button#equipment_add', function(event) {
          event.preventDefault();
          if (check_er.save == true){
          var data_img = cropper.getDataURL();
        }
        else{
          var data_img = '';
        }
          var valid_add_edit = function(){
          var valid_result = false;
          if ($('#suserid').val().length == '0'){
            $('#suserid_p').popover('show');
            $('#org_places_user').addClass('has-error');
            setTimeout(function(){$("#suserid_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#sorgid').val().length == '0'){
            $('#sorgid_p').popover('show');
            $('#org_places_user').addClass('has-error');
            setTimeout(function(){$("#sorgid_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#splaces').val().length == '0'){
            $('#splaces_p').popover('show');
            $('#org_places_user').addClass('has-error');
            setTimeout(function(){$("#splaces_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#snomeid').val().length == '0'){
            $('#snomeid_add_p').popover('show');
            $('#what').addClass('has-error');
            setTimeout(function(){$("#snomeid_add_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#svendid').val().length == '0'){
            $('#svendid_add_p').popover('show');
            $('#what').addClass('has-error');
            setTimeout(function(){$("#svendid_add_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#sgroupname').val().length == '0'){
            $('#sgroupname_add_p').popover('show');
            $('#what').addClass('has-error');
            setTimeout(function(){$("#sgroupname_add_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#dtpost').val().length == '0'){
            $('#dtpost').popover('show');
            $('#dtpost_add_grp').addClass('has-error');
            setTimeout(function(){$("#dtpost").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=equipment_add"+
        "&img=" + data_img +
        "&dtpost="+encodeURIComponent($("#dtpost").val())+
        "&sorgid="+encodeURIComponent($("#sorgid").val())+
        "&splaces="+encodeURIComponent($("#splaces").val())+
        "&suserid="+encodeURIComponent($("#suserid").val())+
        "&sernum="+encodeURIComponent($("#sernum").val())+
        "&ip="+encodeURIComponent($("#ip").val())+
        "&kntid="+encodeURIComponent($("#kntid").val())+
        "&snomeid="+encodeURIComponent($("#snomeid").val())+
        "&invnum="+encodeURIComponent($("#invnum").val())+
        "&os="+encodeURIComponent($("#os").prop('checked'))+
        "&bum="+encodeURIComponent($("#bum").prop('checked'))+
        "&dtendgar="+encodeURIComponent($("#dtendgar").val())+
        "&buhname="+encodeURIComponent($("#buhname").val())+
        "&cost="+encodeURIComponent($("#cost").val())+
        "&currentcost="+encodeURIComponent($("#currentcost").val())+
        "&invoice="+encodeURIComponent($("#invoice").val())+
        "&invoice_date="+encodeURIComponent($("#invoice_date").val())+
        "&mode_eq="+encodeURIComponent($("#mode_eq").prop('checked'))+
        "&eq_util="+encodeURIComponent($("#eq_util").prop('checked'))+
        "&eq_sale="+encodeURIComponent($("#eq_sale").prop('checked'))+
        "&comment="+encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_add.close();
          table_eq.ajax.reload();
          check_er.save = false;
        }
        });
        }
});

// ***** Редактирование ТМЦ *****
$('body').on('click', 'a#img_del_equipment', function(event) {
    event.preventDefault();
    d = new Date();
    // $('#img_show img').removeAttr('src').fadeOut(100);
    // $('#img_show img').attr('src', 'images/equipment/noimage.png').fadeIn(500);
    $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=delete_equipment_img"+
            "&id="+eq_one_id,
        success: function(){
          $.ajax({
            type: "POST",
            url: ACTIONPATH,
            data: "mode=show_img_eq" +
            "&id="+eq_one_id,
            success: function(data){
              $('#img_show img').removeAttr('src').fadeOut(100);
              $('#img_show img').attr("src", "images/equipment/" + data + "?"+d.getTime()).fadeIn(500);
              $('.imageBox2').css('background-image','url('+ MyHOSTNAME + 'images/equipment/' + data + '?' + d.getTime() +  ')');
            }
          });
        }
    });
  });
$('body').on('click', 'button#equipment_edit', function(event) {
          event.preventDefault();
          if (check_er.save == true){
          var data_img = cropper.getDataURL();
        }
        else{
          var data_img = '';
        }
          var valid_add_edit = function(){
          var valid_result = false;
          if ($('#snomeid').val().length == '0'){
            $('#snomeid_edit_p').popover('show');
            $('#what').addClass('has-error');
            setTimeout(function(){$("#snomeid_edit_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#svendid').val().length == '0'){
            $('#svendid_edit_p').popover('show');
            $('#what').addClass('has-error');
            setTimeout(function(){$("#svendid_edit_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#sgroupname').val().length == '0'){
            $('#sgroupname_edit_p').popover('show');
            $('#what').addClass('has-error');
            setTimeout(function(){$("#sgroupname_edit_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#dtpost').val().length == '0'){
            $('#dtpost').popover('show');
            $('#dtpost_edit_grp').addClass('has-error');
            setTimeout(function(){$("#dtpost").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=equipment_edit"+
        "&id=" + arrList +
        "&img=" + data_img +
        "&dtpost="+encodeURIComponent($("#dtpost").val())+
        "&sernum="+encodeURIComponent($("#sernum").val())+
        "&ip="+encodeURIComponent($("#ip").val())+
        "&kntid="+encodeURIComponent($("#kntid").val())+
        "&snomeid="+encodeURIComponent($("#snomeid").val())+
        "&invnum="+encodeURIComponent($("#invnum").val())+
        "&os="+encodeURIComponent($("#os").prop('checked'))+
        "&bum="+encodeURIComponent($("#bum").prop('checked'))+
        "&dtendgar="+encodeURIComponent($("#dtendgar").val())+
        "&buhname="+encodeURIComponent($("#buhname").val())+
        "&cost="+encodeURIComponent($("#cost").val())+
        "&currentcost="+encodeURIComponent($("#currentcost").val())+
        "&invoice="+encodeURIComponent($("#invoice").val())+
        "&invoice_date="+encodeURIComponent($("#invoice_date").val())+
        "&mode_eq="+encodeURIComponent($("#mode_eq").prop('checked'))+
        "&eq_util="+encodeURIComponent($("#eq_util").prop('checked'))+
        "&eq_sale="+encodeURIComponent($("#eq_sale").prop('checked'))+
        "&comment="+encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_edit.close();
          table_eq.ajax.reload(null, false);
          arrList=[];
          check_er.save = false;
        }
        });
        }
});

// ***** Перемещение ТМЦ *****
$('body').on('click', 'button#equipment_move', function(event) {
          event.preventDefault();

          var valid_move = function(){
          var valid_result = false;
          if ($('#sorgid').val().length == '0'){
            $('#org_move').popover('show');
            $('#org_to').addClass('has-error');
            setTimeout(function(){$("#org_move").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#splaces').val().length == '0'){
            $('#places_move').popover('show');
            $('#places_to').addClass('has-error');
            setTimeout(function(){$("#places_move").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#suserid').val().length == '0'){
            $('#mat_move').popover('show');
            $('#mat_to').addClass('has-error');
            setTimeout(function(){$("#mat_move").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_move() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=equipment_move"+
        "&id=" + arrList +
        "&sorgid="+encodeURIComponent($("#sorgid").val())+
        "&splaces="+encodeURIComponent($("#splaces").val())+
        "&suserid="+encodeURIComponent($("#suserid").val())+
        "&comment="+encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_move.close();
          table_eq.ajax.reload(null, false);
          table_eq_move.clear().draw();
          table_eq_repair.clear().draw();
          table_eq_param.clear().draw();
          arrList=[];
        }
        });
        }
});

// ****** Копирование ТМЦ ******
$('body').on('click', 'button#equipment_copy', function(event) {
          event.preventDefault();

          var valid_copy = function(){
          var valid_result = false;
          if ($('#sorgid').val().length == '0'){
            $('#org_copy').popover('show');
            $('#org_copy_to').addClass('has-error');
            setTimeout(function(){$("#org_copy").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#splaces').val().length == '0'){
            $('#places_copy').popover('show');
            $('#places_copy_to').addClass('has-error');
            setTimeout(function(){$("#places_copy").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#suserid').val().length == '0'){
            $('#mat_copy').popover('show');
            $('#mat_copy_to').addClass('has-error');
            setTimeout(function(){$("#mat_copy").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_copy() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=equipment_copy"+
        "&id=" + arrList +
        "&nomcopy="+encodeURIComponent($("#nomcopy").val())+
        "&sorgid="+encodeURIComponent($("#sorgid").val())+
        "&splaces="+encodeURIComponent($("#splaces").val())+
        "&suserid="+encodeURIComponent($("#suserid").val())+
        "&buhname="+encodeURIComponent($("#buhname").val()),
        success: function() {
          dialog_copy.close();
          table_eq.ajax.reload(null, false);
          table_eq_move.clear().draw();
          table_eq_repair.clear().draw();
          table_eq_param.clear().draw();
          arrList=[];
        }
        });
        }
});

// ***** Удаление ТМЦ *****
$('body').on('click', 'button#equipment_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=equipment_delete"+
        "&id=" + arrList,
        success: function() {
          dialog_del.close();
          table_eq.ajax.reload(null, false);
          table_eq_move.clear().draw();
          table_eq_repair.clear().draw();
          table_eq_param.clear().draw();
          arrList=[];
          check_approve();
        }
        });
});

// ****** Ремонт ТМЦ *****
$('body').on('click', 'button#equipment_repair', function(event) {
          event.preventDefault();

          var valid_repair = function(){
          var valid_result = false;
          if ($('#kntid').val().length == '0'){
            $('#kntid_p').popover('show');
            $('#knt_grp').addClass('has-error');
            setTimeout(function(){$("#kntid_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#dt').val().length == '0'){
            $('#dt').popover('show');
            $('#dt_grp').addClass('has-error');
            setTimeout(function(){$("#dt").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_repair() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=equipment_repair"+
        "&id=" + arrList +
        "&kntid=" +encodeURIComponent($("#kntid").val())+
        "&status=" +encodeURIComponent($("#status").val())+
        "&dt=" +encodeURIComponent($("#dt").val())+
        "&dtend=" +encodeURIComponent($("#dtend").val())+
        "&cst=" +encodeURIComponent($("#cst").val())+
        "&comment=" +encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_repair.close();
          table_eq.ajax.reload(null, false);
          table_eq_move.clear().draw();
          table_eq_repair.clear().draw();
          table_eq_param.clear().draw();
          arrList=[];
        }
        });
      }
});

// ****** Редактирование ремонта ТМЦ *****
$('body').on('click', 'button#equipment_repair_edit', function(event) {
          event.preventDefault();

          var valid_repair_edit = function(){
          var valid_result = false;
          if ($('#kntid').val().length == '0'){
            $('#kntid_p').popover('show');
            $('#knt_grp').addClass('has-error');
            setTimeout(function(){$("#kntid_p").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_repair_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=equipment_repair_edit"+
        "&id=" + id_repair_edit +
        "&kntid=" +encodeURIComponent($("#kntid").val())+
        "&status=" +encodeURIComponent($("#status").val())+
        "&dt=" +encodeURIComponent($("#dt").val())+
        "&dtend=" +encodeURIComponent($("#dtend").val())+
        "&cst=" +encodeURIComponent($("#cst").val())+
        "&comment=" +encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_repair_edit.close();
          table_eq_repair.ajax.reload(null, false);
        }
        });
      }
});

// ****** Удаления ремонта ТМЦ *****
$('body').on('click', 'button#equipment_repair_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=equipment_repair_delete"+
        "&id=" + id_repair_delete +
        "&eqid=" +arrList,
        success: function() {
          dialog_repair_del.close();
          table_eq_repair.ajax.reload(null, false);
          table_eq.ajax.reload(null, false);
          arrList=[];
        }
        });
});

// ****** Редактирование перемещения ТМЦ *****
$('body').on('click', 'button#equipment_move_edit', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=equipment_move_edit"+
        "&id=" + id_move_edit +
        "&comment=" +encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_move_edit.close();
          table_eq_move.ajax.reload(null, false);
        }
        });
});

// ****** Удаления перемещения ТМЦ *****
$('body').on('click', 'button#equipment_move_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=equipment_move_delete"+
        "&id=" + id_move_delete,
        success: function() {
          dialog_move_del.close();
          table_eq_move.ajax.reload(null, false);
          table_eq.ajax.reload(null, false);
          arrList=[];
        }
        });
});

// ***** Добавление лицензий ******
$('body').on('click', 'button#license_add', function(event) {
          event.preventDefault();

          var valid_license_add_edit = function(){
          var valid_result = false;
          if ($('#usersid').val().length == '0'){
            $('#usersid_add_p').popover('show');
            $('#usersid_li_add_grp').addClass('has-error');
            setTimeout(function(){$("#usersid_add_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#eqid').val().length == '0'){
            $('#eqid_add_p').popover('show');
            $('#eqid_li_add_grp').addClass('has-error');
            setTimeout(function(){$("#eqid_add_p").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_license_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=license_add"+
        "&usersid=" +encodeURIComponent($("#usersid").val())+
        "&eqid=" +encodeURIComponent($("#eqid").val())+
        "&antivirus=" +encodeURIComponent($("#antivirus").val())+
        "&office=" +encodeURIComponent($("#office").val())+
        "&system=" +encodeURIComponent($("#system").val())+
        "&organti=" +encodeURIComponent($("#organti").val())+
        "&antiname=" +encodeURIComponent($("#antiname").val())+
        "&visio=" +encodeURIComponent($("#visio").prop('checked'))+
        "&adobe=" +encodeURIComponent($("#adobe").prop('checked'))+
        "&winrar=" +encodeURIComponent($("#winrar").prop('checked'))+
        "&visual=" +encodeURIComponent($("#visual").prop('checked'))+
        "&lingvo=" +encodeURIComponent($("#lingvo").prop('checked'))+
        "&comment=" +encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_license_add.close();
          table_license.ajax.reload();
          arrList_li=[];
        }
        });
      }
});

// ***** Редактирование лицензий ******
$('body').on('click', 'button#license_edit', function(event) {
          event.preventDefault();

          var valid_license_add_edit = function(){
          var valid_result = false;
          if ($('#usersid').val().length == '0'){
            $('#usersid_edit_p').popover('show');
            $('#usersid_li_edit_grp').addClass('has-error');
            setTimeout(function(){$("#usersid_edit_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#eqid').val().length == '0'){
            $('#eqid_edit_p').popover('show');
            $('#eqid_li_edit_grp').addClass('has-error');
            setTimeout(function(){$("#eqid_edit_p").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_license_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=license_edit"+
        "&id=" + arrList_li +
        "&usersid=" +encodeURIComponent($("#usersid").val())+
        "&eqid=" +encodeURIComponent($("#eqid").val())+
        "&antivirus=" +encodeURIComponent($("#antivirus").val())+
        "&office=" +encodeURIComponent($("#office").val())+
        "&system=" +encodeURIComponent($("#system").val())+
        "&organti=" +encodeURIComponent($("#organti").val())+
        "&antiname=" +encodeURIComponent($("#antiname").val())+
        "&visio=" +encodeURIComponent($("#visio").prop('checked'))+
        "&adobe=" +encodeURIComponent($("#adobe").prop('checked'))+
        "&winrar=" +encodeURIComponent($("#winrar").prop('checked'))+
        "&visual=" +encodeURIComponent($("#visual").prop('checked'))+
        "&lingvo=" +encodeURIComponent($("#lingvo").prop('checked'))+
        "&comment=" +encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_license_edit.close();
          table_license.ajax.reload(null, false);
          arrList_li=[];
        }
        });
      }
});

// ****** Удаления лицензий *****
$('body').on('click', 'button#license_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=license_delete"+
        "&id=" + arrList_li,
        success: function() {
          dialog_license_del.close();
          table_license.ajax.reload(null, false);
          arrList_li=[];
        }
        });
});

// ***** Редактирование поля антивирус ******
$('body').on('click', 'button#edit_anti', function(event) {
          event.preventDefault();

          var valid_antivirus_edit = function(){
          var valid_result = false;
          if ($('#organti').val().length == '0'){
            $('#organti_p').popover('show');
            $('#organti_grp').addClass('has-error');
            setTimeout(function(){$("#organti_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#antiname').val().length == '0'){
            $('#antiname_p').popover('show');
            $('#antiname_grp').addClass('has-error');
            setTimeout(function(){$("#antiname_p").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_antivirus_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=antivirus_edit"+
        "&id=" + arrList_li +
        "&organti=" +encodeURIComponent($("#organti").val())+
        "&antiname=" +encodeURIComponent($("#antiname").val())+
        "&antivirus=" +encodeURIComponent($("#antivirus").val()),
        success: function() {
          dialog_antivirus.close();
          table_license.ajax.reload(null, false);
          arrList_li=[];
        }
        });
      }
});

// ***** Добавление картриджей ******
$('body').on('click', 'button#cartridge_add', function(event) {
          event.preventDefault();

          var valid_cartridge_add_edit = function(){
          var valid_result = false;
          if ($('#nomeid').val().length == '0'){
            $('#nomeid_add_p').popover('show');
            $('#nomeid_add_grp').addClass('has-error');
            setTimeout(function(){$("#nomeid_add_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#placesid').val().length == '0'){
            $('#placesid_add_p').popover('show');
            $('#placesid_add_grp').addClass('has-error');
            setTimeout(function(){$("#placesid_add_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#orgid').val().length == '0'){
            $('#orgid_add_p').popover('show');
            $('#orgid_add_grp').addClass('has-error');
            setTimeout(function(){$("#orgid_add_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#userid').val().length == '0'){
            $('#userid_add_p').popover('show');
            $('#userid_add_grp').addClass('has-error');
            setTimeout(function(){$("#userid_add_p").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_cartridge_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=cartridge_add"+
        "&nomeid=" +encodeURIComponent($("#nomeid").val())+
        "&orgid=" +encodeURIComponent($("#orgid").val())+
        "&placesid=" +encodeURIComponent($("#placesid").val())+
        "&userid=" +encodeURIComponent($("#userid").val())+
        "&namek=" +encodeURIComponent($("#namek").val())+
        "&coll=" +encodeURIComponent($("#coll").val())+
        "&newk=" +encodeURIComponent($("#newk").prop('checked'))+
        "&zapr=" +encodeURIComponent($("#zapr").prop('checked')),
        success: function() {
          dialog_cartridge_add.close();
          table_cartridge.ajax.reload();
        }
        });
      }
});

// ***** Редактирование картриджей ******
$('body').on('click', 'button#cartridge_edit', function(event) {
          event.preventDefault();

          var valid_cartridge_add_edit = function(){
          var valid_result = false;
          if ($('#nomeid').val().length == '0'){
            $('#nomeid_add_p').popover('show');
            $('#nomeid_add_grp').addClass('has-error');
            setTimeout(function(){$("#nomeid_add_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#placesid').val().length == '0'){
            $('#placesid_add_p').popover('show');
            $('#placesid_add_grp').addClass('has-error');
            setTimeout(function(){$("#placesid_add_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#orgid').val().length == '0'){
            $('#orgid_add_p').popover('show');
            $('#orgid_add_grp').addClass('has-error');
            setTimeout(function(){$("#orgid_add_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#userid').val().length == '0'){
            $('#userid_add_p').popover('show');
            $('#userid_add_grp').addClass('has-error');
            setTimeout(function(){$("#userid_add_p").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_cartridge_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=cartridge_edit"+
        "&id=" +eq_one_id +
        "&nomeid=" +encodeURIComponent($("#nomeid").val())+
        "&orgid=" +encodeURIComponent($("#orgid").val())+
        "&placesid=" +encodeURIComponent($("#placesid").val())+
        "&userid=" +encodeURIComponent($("#userid").val())+
        "&namek=" +encodeURIComponent($("#namek").val())+
        "&coll=" +encodeURIComponent($("#coll").val())+
        "&newk=" +encodeURIComponent($("#newk").prop('checked'))+
        "&zapr=" +encodeURIComponent($("#zapr").prop('checked')),
        success: function() {
          dialog_cartridge_edit.close();
          table_cartridge.ajax.reload(null, false);
        }
        });
      }
});

// ****** Выдача картриджей ******
$('body').on('click', 'button#cartridge_out', function(event) {
          event.preventDefault();

          var valid_cartridge_out = function(){
          var valid_result = false;
          if ($('#userid').val().length == '0'){
            $('#cartridge_poluchatel_p').popover('show');
            $('#cartridge_poluchatel_grp').addClass('has-error');
            setTimeout(function(){$("#cartridge_poluchatel_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#coll2').val().length == '0'){
            $('#coll2').popover('show');
            $('#coll_grp').addClass('has-error');
            setTimeout(function(){$("#coll2").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_cartridge_out() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=cartridge_out"+
        "&id=" + eq_one_id +
        "&userid=" +encodeURIComponent($("#userid").val())+
        "&coll2=" +encodeURIComponent($("#coll2").val())+
        "&comment=" +encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_cartridge_out.close();
          table_cartridge.ajax.reload(null, false);
          table_cartridge_uchet.clear().draw();
          eq_one_id=[];
        }
        });
      }
});

// ***** Быстрое редактирование картриджей *****
$('body').on('click', 'button#cartridge_fast', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=cartridge_fast_edit"+
        "&id=" + id_fast_edit +
        "&coll=" +encodeURIComponent($("#coll").val())+
        "&newk=" +encodeURIComponent($("#newk").prop('checked'))+
        "&zapr=" +encodeURIComponent($("#zapr").prop('checked'))+
        "&comment=" +encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_cartridge_fast_edit.close();
          table_cartridge.ajax.reload(null, false);
          eq_one_id=[];
        }
        });
});

// ***** Удаления картриджей *****
$('body').on('click', 'button#cartridge_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=cartridge_delete"+
        "&id=" + id_del,
        success: function() {
          dialog_cartridge_del.close();
          table_cartridge.ajax.reload(null, false);
          eq_one_id=[];
          check_approve();
        }
        });
});

// ***** Удаления из истории выдачи *****
$('body').on('click', 'button#cartridge_uchet_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=cartridge_uchet_delete"+
        "&id=" + id_uchet,
        success: function() {
          dialog_cartridge_uchet_del.close();
          table_cartridge_uchet.ajax.reload(null, false);
          uchet_one_id=[];
        }
        });
});

// ***** Удаления организации *****
$('body').on('click', 'button#org_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=org_delete"+
        "&id=" + id_org_delete,
        success: function() {
          dialog_org_del.close();
          table_org.ajax.reload(null, false);
          check_approve();
        }
        });
});

// ****** Добавление организации ******
$('body').on('click', 'button#add_org', function(event) {
          event.preventDefault();

          var valid_org_add_edit = function(){
          var valid_result = false;
          if ($('#org').val().length == '0'){
            $('#org').popover('show');
            $('#org_add_grp').addClass('has-error');
            setTimeout(function(){$("#org").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_org_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=org_add"+
        "&name=" +encodeURIComponent($("#org").val()),
        success: function() {
          dialog_org_add.close();
          table_org.ajax.reload();
        }
        });
      }
});

// ****** Редактирование организации ******
$('body').on('click', 'button#edit_org', function(event) {
          event.preventDefault();

          var valid_org_add_edit = function(){
          var valid_result = false;
          if ($('#org').val().length == '0'){
            $('#org').popover('show');
            $('#org_add_grp').addClass('has-error');
            setTimeout(function(){$("#org").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_org_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=org_edit"+
        "&id=" + id_org_edit +
        "&name=" +encodeURIComponent($("#org").val()),
        success: function() {
          dialog_org_edit.close();
          table_org.ajax.reload(null, false);
        }
        });
      }
});

// ***** Полное удаление *****
$('body').on('click', 'button#dell_all', function(event) {
          event.preventDefault();
          $("#before_delete").empty();
          // $("#infoblock").html('');
          $("#delete_ok").empty();
          $.ajax({
          type: "POST",
          url: ACTIONPATH,
          data: "mode=delete_all",
          success: function(html) {
            $("#infoblock").empty().append(html);
            check_approve();
          }
})
});

// ***** Отмена удаления *****
$('body').on('click', 'button#otmena', function(event) {
          event.preventDefault();
          var id=$(this).attr('id_del');
          var name=$(this).attr('name');
          $.ajax({
          type: "POST",
          url: ACTIONPATH,
          data: "mode=otmena_delete" +
          "&id=" + encodeURIComponent(id) +
          "&name=" + encodeURIComponent(name),
          success: function(html) {
            $('[data-toggle="tooltip"]').tooltip('hide');
            // $("#before_delete").html('');
            $("#delete_ok").empty();
            $("#before_delete").empty().append(html);
            check_approve();
          }
})
});

// ***** Обновление удаления *****
$('body').on('click', 'button#delete_update', function(event) {
          event.preventDefault();
          $.ajax({
          type: "POST",
          url: ACTIONPATH,
          data: "mode=otmena_delete",
          success: function(html) {
            $("#infoblock").empty();
            $("#before_delete").append(html);
          }
})
});

// ***** Удаления помещения *****
$('body').on('click', 'button#places_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=places_delete"+
        "&id=" + id_places_delete,
        success: function() {
          dialog_places_del.close();
          table_places.ajax.reload(null, false);
          table_places_sub.clear().draw();
          eq_one_id=[];
          check_approve();
        }
        });
});

// ****** Добавление помещения ******
$('body').on('click', 'button#add_places', function(event) {
          event.preventDefault();

          var valid_places_add_edit = function(){
          var valid_result = false;
          if ($('#places').val().length == '0'){
            $('#places').popover('show');
            $('#places_add_grp').addClass('has-error');
            setTimeout(function(){$("#places").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_places_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=places_add"+
        "&name=" + encodeURIComponent($("#places").val())+
        "&comment=" + encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_places_add.close();
          table_places.ajax.reload();
        }
        });
      }
});

// ****** Редактирование помещения ******
$('body').on('click', 'button#edit_places', function(event) {
          event.preventDefault();

          var valid_places_add_edit = function(){
          var valid_result = false;
          if ($('#places').val().length == '0'){
            $('#places').popover('show');
            $('#places_add_grp').addClass('has-error');
            setTimeout(function(){$("#places").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_places_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=places_edit"+
        "&id=" + id_places_edit +
        "&name=" +encodeURIComponent($("#places").val())+
        "&comment=" + encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_places_edit.close();
          table_places.ajax.reload(null, false);
          table_places_sub.clear().draw();
          eq_one_id=[];
        }
        });
      }
});
// Проверка логина и email
function check_user_name(){
  // check_er.user_name = false;
  $("input#user_name").keyup(function() {
    if($(this).val().length > 0) {
      $.ajax({
      type: "POST",
      dataType: "json",
      url: ACTIONPATH,
      data: "mode=check_user_name"+
      "&user_name="+$(this).val(),
      success: function(html) {
      $.each(html, function(i, item) {
      if (item.check_user_name_status === true) {
      $("#user_name_grp").removeClass('has-error').addClass('has-success');
      check_er.user_name = false;

      }
      else if (item.check_user_name_status === false) {
      $('#user_name').popover('show');
      $("#user_name_grp").removeClass('has-success').addClass('has-error');
      setTimeout(function(){$("#user_name").popover('hide');},2000);
      check_er.user_name = true;
      }
      }
      );
     }

      });
    }

});
// $("#user_name_gen").click(function() {
//   console.log(this.value);
    // check_er.user_name = false;
  //   $.ajax({
  //   type: "POST",
  //   dataType: "json",
  //   url: ACTIONPATH,
  //   data: "mode=check_user_name"+
  //   "&user_name="+$(this).val(),
  //   success: function(html) {
  //   $.each(html, function(i, item) {
  //   if (item.check_user_name_status === true) {
  //   $("#user_name_grp").removeClass('has-error').addClass('has-success');
  //   check_er.user_name = false;
   //
  //   }
  //   else if (item.check_user_name_status === false) {
  //     $('#user_name').popover('show');
  //     $("#user_name_grp").removeClass('has-success').addClass('has-error');
  //     setTimeout(function(){$("#user_name").popover('hide');},2000);
  //     check_er.user_name = true;
  //   }
  //   }
  //   );
  //  }
   //
  //   });

// });
}
function check_login(){
  $("input#login").keyup(function() {
  if($(this).val().length >= 3) {

      $("#login_grp").removeClass('has-error').addClass('has-success');
      check_er.login = false;
      $.ajax({
      type: "POST",
      dataType: "json",
      url: ACTIONPATH,
      data: "mode=check_login"+
      "&login="+$(this).val(),
      success: function(html) {
      $.each(html, function(i, item) {
      if (item.check_login_status === true) {
      $("#login_grp").removeClass('has-error').addClass('has-success');
      check_er.login = false;

      }
      else if (item.check_login_status === false) {
      $("#login_grp").removeClass('has-success').addClass('has-error');
      check_er.login = true;
      }
      }
      );
     }

      });
} else {

    $("#login_grp").removeClass('has-success').addClass('has-error');
    check_er.login = true;

}

});
}

function check_email(){
  $('#email').keyup(function(){
    var val = $(this).val();
    // var email = new RegExp("^[0-9a-zA-Z]([-.w]*[0-9a-zA-Z])+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$");
    var email = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
    if (email.test(val)){
      $('#email_grp').removeClass('has-error').addClass('has-success');
      check_er.email = false
    }
    else {
      $('#email_grp').removeClass('has-success').addClass('has-error');
      check_er.email = true;
    }
  })
}
// Проверка аккаунта при выключении его на наличе ТМЦ
function check_account(){
  $("#on_off").change(function() {
    if ($(this).val() == '0'){
      $.ajax({
      type: "POST",
      dataType: "json",
      url: ACTIONPATH,
      data: "mode=check_account"+
      "&login=" + id_users_edit,
      success: function(html) {
      $.each(html, function(i, item) {
      if (item.check_account_status === true) {
      $("#account_grp").removeClass('has-error');
      check_er.account = false;
      }
      else if (item.check_account_status === false) {
      $("#account_grp").addClass('has-error');
      $('#on_off').prop('selectedIndex', 1).trigger("chosen:updated");
      $('#on_off_p').popover('show');
      setTimeout(function(){$("#on_off_p").popover('hide');},2000);
      check_er.account = true;
      }
      }
      );
     }

      });
    }
});
}
// ****** Добавление пользователя ******
$('body').on('click', 'button#add_users', function(event) {
          event.preventDefault();
          var er = check_er.login || check_er.email || check_er.user_name;
          var permit_menu = "";
          if ($("#permit_menu").val() != null){
            permit_menu = $("#permit_menu").val();
          }
          var valid_users_add_edit = function(){
          var valid_result = false;
          if ($('#login').val().length < '3'){
            $('#login').popover('show');
            $('#login_grp').addClass('has-error');
            setTimeout(function(){$("#login").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#pass').val().length < '3'){
            $('#pass').popover('show');
            $('#pass_add_grp').addClass('has-error');
            setTimeout(function(){$("#pass").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#fio').val().length < '3'){
            $('#fio').popover('show');
            $('#fio_add_grp').addClass('has-error');
            setTimeout(function(){$("#fio").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#email').val().length < '1'){
            $('#email').popover('show');
            $('#email_grp').addClass('has-error');
            setTimeout(function(){$("#email").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };
          if (check_er.user_name == true){
            $('#user_name').popover('show');
            setTimeout(function(){$("#user_name").popover('hide');},2000);
          }

        if ((valid_users_add_edit() == false) && (er == false)){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=users_add"+
        "&login=" + encodeURIComponent($("#login").val())+
        "&pass=" + encodeURIComponent($("#pass").val())+
        "&fio=" + encodeURIComponent($("#fio").val())+
        "&email=" + encodeURIComponent($("#email").val())+
        "&priv=" + encodeURIComponent($("#priv").val())+
        "&permit_menu=" + permit_menu+
        "&dostup=" + encodeURIComponent($("#dostup").val())+
        "&user_name=" + encodeURIComponent($("#user_name").val())+
        "&lang=" + encodeURIComponent($("#lang").val()),
        success: function() {
          dialog_users_add.close();
          table_users.ajax.reload();
        }
        });
      }
});

// ****** Редактирование пользователя ******
$('body').on('click', 'button#edit_users', function(event) {
          event.preventDefault();
          var er = check_er.login || check_er.email || check_er.account || check_er.user_name;
          var permit_menu = "";
          if ($("#permit_menu").val() != null){
            permit_menu = $("#permit_menu").val();
          }
          var valid_users_add_edit = function(){
          var valid_result = false;
          if ($('#login').val().length < '3'){
            $('#login').popover('show');
            $('#login_add_grp').addClass('has-error');
            setTimeout(function(){$("#login").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#pass').val().length < '3'){
            $('#pass').popover('show');
            $('#pass_add_grp').addClass('has-error');
            setTimeout(function(){$("#pass").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#fio').val().length < '3'){
            $('#fio').popover('show');
            $('#fio_add_grp').addClass('has-error');
            setTimeout(function(){$("#fio").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };
          if (check_er.account == true){
            $('#on_off_p').popover('show');
            setTimeout(function(){$("#on_off_p").popover('hide');},2000);
          }
          if (check_er.user_name == true){
            $('#user_name').popover('show');
            setTimeout(function(){$("#user_name").popover('hide');},2000);
          }
        if ((valid_users_add_edit() == false) && (er == false)){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=users_edit"+
        "&id=" + id_users_edit +
        "&login=" + encodeURIComponent($("#login").val())+
        "&pass=" + encodeURIComponent($("#pass").val())+
        "&fio=" + encodeURIComponent($("#fio").val())+
        "&email=" + encodeURIComponent($("#email").val())+
        "&priv=" + encodeURIComponent($("#priv").val())+
        "&permit_menu=" + permit_menu +
        "&dostup=" + encodeURIComponent($("#dostup").val())+
        "&user_name=" + encodeURIComponent($("#user_name").val())+
        "&on_off=" + encodeURIComponent($("#on_off").val())+
        "&lang=" + encodeURIComponent($("#lang").val()),
        success: function() {
          dialog_users_edit.close();
          table_users.ajax.reload(null, false);
          $.cookie('lang_cookie',$("#lang").val());
        }
        });
      }
});

// ***** Удаления пользователя *****
$('body').on('click', 'button#users_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=users_delete"+
        "&id=" + id_users_delete,
        success: function() {
          dialog_users_del.close();
          table_users.ajax.reload(null, false);
          check_approve();
        }
        });
});

// ***** Редкатирование профеля *****
function img_users(){
var options =
{
    thumbBox: '.thumbBox',
    spinner: '.spinner',
    imgSrc: Avatar
}
window.cropper = $('.imageBox').cropbox(options);
$('#file').on('change', function(){
  var fileExtension = file_types_img;
  if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) !== -1){
    var reader = new FileReader();
    reader.onload = function(e) {
        options.imgSrc = e.target.result;
        cropper = $('.imageBox').cropbox(options);
    }
    reader.readAsDataURL(this.files[0]);
    this.files = [];
    check_er.save = true;
  }
  else {
    BootstrapDialog.alert({
    title: get_lang_param("Er_title"),
    message: get_lang_param("Er_msg_type")  + '(' + file_types_img +')',
    type: BootstrapDialog.TYPE_WARNING,
    draggable: true,
    callback: function() {
      $('#file').val(null);
      }
    });
  }
})
$('#btnZoomIn').on('click', function(){
    cropper.zoomIn();
})
$('#btnZoomOut').on('click', function(){
    cropper.zoomOut();
})
$('#btnRotate').on('click', function(){
    cropper.rotate();
})
$('#btn_file').on('click', function(){
    $('#file').click();
})
}
$('body').on('click', 'button#edit_profile', function(event) {
          event.preventDefault();
          d = new Date();
          if (check_er.save == true){
          var data_img = cropper.getDataURL();
        }
        else{
          var data_img = '';
        }
          // console.log(data_img);
        var valid_email = function(){
        var valid_result = false;
        if ($('#email').val().length < '1'){
          $('#email').popover('show');
          $('#email_grp').addClass('has-error');
          setTimeout(function(){$("#email").popover('hide');},2000);
          valid_result = true;
        }
        return valid_result;
        };

if ((valid_email() == false) && (check_er.email == false)){
$.ajax({
    type: 'POST',
    url: ACTIONPATH,
    data: 'mode=edit_profile_users' +
    '&id=' + id_users_profile +
    '&img=' + data_img +
    "&placesid=" + encodeURIComponent($("#placesid").val())+
    "&birthday=" + encodeURIComponent($("#birthday").val())+
    "&work_number=" + encodeURIComponent($("#work_number").val())+
    "&email=" + encodeURIComponent($("#email").val())+
    "&post=" + encodeURIComponent($("#post").val())+
    "&mobile=" + encodeURIComponent($("#mobile").val())+
    "&emaildop=" + encodeURIComponent($("#emaildop").val()),
    success: function() {
      dialog_users_profile.close();
      table_users.ajax.reload(null, false);
      $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=show_img" +
        "&id="+id_users_profile,
        success: function(data){
          $('li img').attr("src", "images/avatar/" + data + "?"+d.getTime());
        }
      });
      check_er.save = false;
        }
    })
  }
});
$('body').on('click', 'a#img_del_users', function(event) {
    event.preventDefault();
    d = new Date();
    $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=delete_profile_img"+
            "&id="+id_users_profile,
        success: function(){
          $.ajax({
            type: "POST",
            url: ACTIONPATH,
            data: "mode=show_img" +
            "&id="+id_users_profile,
            success: function(data){
              $('#img_show img').removeAttr('src').fadeOut(100);
              $('#img_show img').attr("src", "images/avatar/" + data + "?"+d.getTime()).fadeIn(500);
              $('.imageBox').css('background-image','url('+ MyHOSTNAME + 'images/avatar/' + data + '?' + d.getTime() + ')');
            }
          });
        }
    });
  });
// ***** Редкатирование профеля где контакты*****
$('body').on('click', 'button#edit_profile_cont', function(event) {
          event.preventDefault();
          d = new Date();
          if (check_er.save == true){
          var data_img = cropper.getDataURL();
        }
        else{
          var data_img = '';
        }
        if (Admin === true){
          var pl = encodeURIComponent($("#placesid").val());
        }
        else {
          var pl = '';
        }
        var valid_email = function(){
        var valid_result = false;
        if ($('#email').val().length < '1'){
          $('#email').popover('show');
          $('#email_grp').addClass('has-error');
          setTimeout(function(){$("#email").popover('hide');},2000);
          valid_result = true;
        }
        return valid_result;
        };
if ((valid_email() == false) && (check_er.email == false)){
$.ajax({
    type: 'POST',
    url: ACTIONPATH,
    data: 'mode=edit_profile_users' +
    '&id=' + array_cont +
    '&img=' + data_img +
    "&placesid=" + pl+
    "&birthday=" + encodeURIComponent($("#birthday").val())+
    "&work_number=" + encodeURIComponent($("#work_number").val())+
    "&email=" + encodeURIComponent($("#email").val())+
    "&post=" + encodeURIComponent($("#post").val())+
    "&mobile=" + encodeURIComponent($("#mobile").val())+
    "&emaildop=" + encodeURIComponent($("#emaildop").val()),
    success: function() {
      dialog_users_profile.close();
      table_contact.ajax.reload(null, false);
      $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=show_img" +
        "&id="+array_cont,
        success: function(data){
          $('li img').attr("src", "images/avatar/" + data + "?"+d.getTime());
        }
      });
      array_cont = [];
      check_er.save = false;
            }
      })
    }
});
$('body').on('click', 'a#img_del_users_cont', function(event) {
    event.preventDefault();
    d = new Date();
    $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=delete_profile_img"+
            "&id="+array_cont,
        success: function(){
          $.ajax({
            type: "POST",
            url: ACTIONPATH,
            data: "mode=show_img" +
            "&id="+array_cont,
            success: function(data){
              $('#img_show img').removeAttr('src').fadeOut(100);
              $('#img_show img').attr("src", "images/avatar/" + data + "?"+d.getTime()).fadeIn(500);
              $('.imageBox').css('background-image','url('+ MyHOSTNAME + 'images/avatar/' + data + '?' + d.getTime() + ')');
            }
          });
        }
    });
  });

// ***** Удаления производителя *****
$('body').on('click', 'button#vendors_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=vendors_delete"+
        "&id=" + id_vendors_delete,
        success: function() {
          dialog_vendors_del.close();
          table_vendors.ajax.reload(null, false);
          check_approve();
        }
        });
});

// ****** Добавление производителя ******
$('body').on('click', 'button#add_vendors', function(event) {
          event.preventDefault();

          var valid_vendors_add_edit = function(){
          var valid_result = false;
          if ($('#vendors').val().length == '0'){
            $('#vendors').popover('show');
            $('#vendors_grp').addClass('has-error');
            setTimeout(function(){$("#vendors").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_vendors_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=vendors_add"+
        "&vendors=" + encodeURIComponent($("#vendors").val())+
        "&comment=" + encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_vendors_add.close();
          table_vendors.ajax.reload();
        }
        });
      }
});

// ****** Редактирование производителя ******
$('body').on('click', 'button#edit_vendors', function(event) {
          event.preventDefault();

          var valid_vendors_add_edit = function(){
          var valid_result = false;
          if ($('#vendors').val().length == '0'){
            $('#vendors').popover('show');
            $('#vendors_grp').addClass('has-error');
            setTimeout(function(){$("#vendors").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_vendors_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=vendors_edit"+
        "&id=" + id_vendors_edit +
        "&vendors=" +encodeURIComponent($("#vendors").val())+
        "&comment=" + encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_vendors_edit.close();
          table_vendors.ajax.reload(null, false);
        }
        });
      }
});

// ***** Удаления группы номенклатуры *****
$('body').on('click', 'button#group_nome_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=group_nome_delete"+
        "&id=" + id_group_nome_delete,
        success: function() {
          dialog_group_nome_del.close();
          table_group_nome.ajax.reload(null, false);
          check_approve();
        }
        });
});

// ****** Добавление группы номенклатру ******
$('body').on('click', 'button#add_group_nome', function(event) {
          event.preventDefault();

          var valid_group_nome_add_edit = function(){
          var valid_result = false;
          if ($('#group').val().length == '0'){
            $('#group').popover('show');
            $('#group_grp').addClass('has-error');
            setTimeout(function(){$("#group").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_group_nome_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=group_nome_add"+
        "&group=" + encodeURIComponent($("#group").val())+
        "&comment=" + encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_group_nome_add.close();
          table_group_nome.ajax.reload();
        }
        });
      }
});

// ****** Редактирование группы номенклатуры ******
$('body').on('click', 'button#edit_group_nome', function(event) {
          event.preventDefault();

          var valid_group_nome_add_edit = function(){
          var valid_result = false;
          if ($('#group').val().length == '0'){
            $('#group').popover('show');
            $('#group_grp').addClass('has-error');
            setTimeout(function(){$("#group").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_group_nome_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=group_nome_edit"+
        "&id=" + id_group_nome_edit +
        "&group=" +encodeURIComponent($("#group").val())+
        "&comment=" + encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_group_nome_edit.close();
          table_group_nome.ajax.reload(null, false);
        }
        });
      }
});
// ***** Удаления номенклатуры *****
$('body').on('click', 'button#nome_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=nome_delete"+
        "&id=" + id_nome_delete,
        success: function() {
          dialog_nome_del.close();
          table_nome.ajax.reload(null, false);
          check_approve();
        }
        });
});

// ****** Добавление номенклатуры******
$('body').on('click', 'button#add_nome', function(event) {
          event.preventDefault();

          var valid_nome_add_edit = function(){
          var valid_result = false;
          if ($('#vendorid').val().length == '0'){
            $('#vendors_p').popover('show');
            $('#vendors_grp').addClass('has-error');
            setTimeout(function(){$("#vendors_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#groupid').val().length == '0'){
            $('#group_p').popover('show');
            $('#group_grp').addClass('has-error');
            setTimeout(function(){$("#group_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#namenome').val().length == '0'){
            $('#namenome').popover('show');
            $('#namenome_grp').addClass('has-error');
            setTimeout(function(){$("#namenome").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_nome_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=nome_add"+
        "&vendorid=" +encodeURIComponent($("#vendorid").val())+
        "&namenome=" +encodeURIComponent($("#namenome").val())+
        "&groupid=" + encodeURIComponent($("#groupid").val()),
        success: function() {
          dialog_nome_add.close();
          table_nome.ajax.reload();
        }
        });
      }
});

// ****** Редактирование номенклатуры ******
$('body').on('click', 'button#edit_nome', function(event) {
          event.preventDefault();

          var valid_nome_add_edit = function(){
          var valid_result = false;
          if ($('#vendorid').val().length == '0'){
            $('#vendors_p').popover('show');
            $('#vendors_grp').addClass('has-error');
            setTimeout(function(){$("#vendors_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#groupid').val().length == '0'){
            $('#group_p').popover('show');
            $('#group_grp').addClass('has-error');
            setTimeout(function(){$("#group_p").popover('hide');},2000);
            valid_result = true;
          }
          if ($('#namenome').val().length == '0'){
            $('#namenome').popover('show');
            $('#namenome_grp').addClass('has-error');
            setTimeout(function(){$("#namenome").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };


        if (valid_nome_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=nome_edit"+
        "&id=" + id_nome_edit +
        "&vendorid=" +encodeURIComponent($("#vendorid").val())+
        "&namenome=" +encodeURIComponent($("#namenome").val())+
        "&groupid=" + encodeURIComponent($("#groupid").val()),
        success: function() {
          dialog_nome_edit.close();
          table_nome.ajax.reload(null, false);
        }
        });
      }
});
// ***** Редактирование профиля самим пользователем ******
$('body').on('click', 'a#img_del', function(event) {
      event.preventDefault();
      d = new Date();
      $.ajax({
          type: "POST",
          url: ACTIONPATH,
          data: "mode=delete_profile_img_to_user"+
              "&id="+encodeURIComponent($("#edit_profile_user").attr('value')),
          success: function(html) {
              $.ajax({
                type: "POST",
                url: ACTIONPATH,
                data: "mode=show_img" +
                "&id="+encodeURIComponent($("#edit_profile_user").attr('value')),
                success: function(data){
                  $('#img_show img').removeAttr('src').fadeOut(100);
                  $('#img_show img').attr("src", "images/avatar/" + data + "?"+d.getTime()).fadeIn(500);
                  $('li img').attr("src", "images/avatar/" + data + "?"+d.getTime());
                  $('.imageBox').css('background-image','url('+ MyHOSTNAME + 'images/avatar/' + data + '?' + d.getTime() + ')');
                }
              });
              $("#m_info").hide().html(html).fadeIn(500);
          }
    });
});

$('body').on('click', 'button#edit_profile_user', function(event) {
    event.preventDefault();
    d = new Date();
    if (check_er.save == true){
    var data_img = cropper.getDataURL();
  }
  else{
    var data_img = '';
  }

    $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=edit_profile_to_user"+
            "&img=" +data_img +
            "&login="+encodeURIComponent($("#login").val())+
            "&mail="+encodeURIComponent($("#mail").val())+
            "&mail_d="+encodeURIComponent($("#mail_d").val())+
            "&lang="+encodeURIComponent($("select#lang").val())+
            "&id="+encodeURIComponent($("#edit_profile_user").attr('value')),
        success: function(html) {

            $.ajax({
              type: "POST",
              url: ACTIONPATH,
              data: "mode=show_img" +
              "&id="+encodeURIComponent($("#edit_profile_user").attr('value')),
              success: function(data){
                $('#change_img').hide();
                $('#img_show').hide().fadeIn(500);
                $('#img_show img').attr("src", "images/avatar/" + data + "?"+d.getTime());
                $('li img').attr("src", "images/avatar/" + data + "?"+d.getTime());
                $('.imageBox').css({'background-image':'url('+ MyHOSTNAME + 'images/avatar/' + data + '?' + d.getTime() + ')', 'background-size' : '154px 154px', 'background-position' : '-1px -1px'});
              }
            });
            $("#m_info").hide().html(html).fadeIn(500);
            $.cookie('lang_cookie',$("select#lang").val());
            check_er.save = false;
        }
    });
});
$('body').on('click', 'button#ch_img', function(event) {
    event.preventDefault();
    $('#img_show').hide();
    $('#change_img').fadeIn(500);
  });
$('body').on('click', 'button#edit_profile_pass', function(event) {
    event.preventDefault();

    $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=edit_profile_pass"+
            "&old_pass="+encodeURIComponent($("#old_pass").val())+
            "&new_pass="+encodeURIComponent($("#new_pass").val())+
            "&new_pass2="+encodeURIComponent($("#new_pass2").val())+
            "&id="+encodeURIComponent($("#edit_profile_user").attr('value')),
        success: function(html) {
            $("#p_info").hide().html(html).fadeIn(500);
        }
    });
});
// ***** Удаления файла из реквизитов *****
$('body').on('click', 'button#requisites_file_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=requisites_file_delete"+
        "&id=" + arrList_req,
        success: function() {
          dialog_requisites_files_del.close();
          table_requisites_files.ajax.reload(null, false);
          arrList_req = [];
        }
        });
});
// ****** Добавление реквизитов ******
$('body').on('click', 'button#add_requisites', function(event) {
          event.preventDefault();

          var valid_requisites_add_edit = function(){
          var valid_result = false;
          if ($('#name_org').val().length == '0'){
            $('#name_org').popover('show');
            $('#name_org_grp').addClass('has-error');
            setTimeout(function(){$("#name_org").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };

        if (valid_requisites_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=requisites_add"+
        "&name=" +encodeURIComponent($("#name_org").val())+
        "&inn=" +encodeURIComponent($("#inn").val())+
        "&kpp=" +encodeURIComponent($("#kpp").val())+
        "&index=" +encodeURIComponent($("#index").val())+
        "&tel=" +encodeURIComponent($("#tel").val())+
        "&address=" + encodeURIComponent($("#address").val()),
        success: function() {
          dialog_requisites_add.close();
          table_requisites.ajax.reload();
        }
        });
      }
});
// ****** Редактирование реквизитов ******
$('body').on('click', 'button#edit_requisites', function(event) {
          event.preventDefault();

          var valid_requisites_add_edit = function(){
          var valid_result = false;
          if ($('#name_org').val().length == '0'){
            $('#name_org').popover('show');
            $('#name_org_grp').addClass('has-error');
            setTimeout(function(){$("#name_org").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };

        if (valid_requisites_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=requisites_edit"+
        "&id=" + eq_one_id +
        "&name=" +encodeURIComponent($("#name_org").val())+
        "&inn=" +encodeURIComponent($("#inn").val())+
        "&kpp=" +encodeURIComponent($("#kpp").val())+
        "&index=" +encodeURIComponent($("#index").val())+
        "&tel=" +encodeURIComponent($("#tel").val())+
        "&address=" + encodeURIComponent($("#address").val()),
        success: function() {
          dialog_requisites_edit.close();
          table_requisites.ajax.reload(null, false);
        }
        });
      }
});
// ***** Удаления реквизитов *****
$('body').on('click', 'button#requisites_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=requisites_delete"+
        "&id=" + eq_one_id,
        success: function() {
          dialog_requisites_del.close();
          table_requisites.ajax.reload(null, false);
          check_approve();
        }
        });
});
// ***** Удаления файла из реквизитов *****
$('body').on('click', 'button#knt_file_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=knt_file_delete"+
        "&id=" + arrList_knt,
        success: function() {
          dialog_knt_files_del.close();
          table_knt_files.ajax.reload(null, false);
          arrList_knt = [];
        }
        });
});
// ****** Добавление реквизитов ******
$('body').on('click', 'button#add_knt', function(event) {
          event.preventDefault();

          var valid_knt_add_edit = function(){
          var valid_result = false;
          if ($('#name_knt').val().length == '0'){
            $('#name_knt').popover('show');
            $('#name_knt_grp').addClass('has-error');
            setTimeout(function(){$("#name_knt").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };

        if (valid_knt_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=knt_add"+
        "&name=" +encodeURIComponent($("#name_knt").val())+
        "&inn=" +encodeURIComponent($("#inn_knt").val())+
        "&kpp=" +encodeURIComponent($("#kpp_knt").val())+
        "&comment=" + encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_knt_add.close();
          table_knt.ajax.reload();
        }
        });
      }
});
// ****** Редактирование реквизитов ******
$('body').on('click', 'button#edit_knt', function(event) {
          event.preventDefault();

          var valid_knt_add_edit = function(){
          var valid_result = false;
          if ($('#name_knt').val().length == '0'){
            $('#name_knt').popover('show');
            $('#name_knt_grp').addClass('has-error');
            setTimeout(function(){$("#name_knt").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };

        if (valid_knt_add_edit() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=knt_edit"+
        "&id=" + eq_one_id +
        "&name=" +encodeURIComponent($("#name_knt").val())+
        "&inn=" +encodeURIComponent($("#inn_knt").val())+
        "&kpp=" +encodeURIComponent($("#kpp_knt").val())+
        "&comment=" + encodeURIComponent($("#comment").val()),
        success: function() {
          dialog_knt_edit.close();
          table_knt.ajax.reload(null, false);
        }
        });
      }
});
// ***** Удаления контрагентов *****
$('body').on('click', 'button#knt_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=knt_delete"+
        "&id=" + eq_one_id,
        success: function() {
          dialog_knt_del.close();
          table_knt.ajax.reload(null, false);
          check_approve();
        }
        });
});
// ****** Добавление параметров ******
$('body').on('click', 'button#add_param', function(event) {
  event.preventDefault();
  // console.log(total_input);
  var postdata = $('#myForm_eq_param_add').serialize();

  var valid_param_add = function(){
  var valid_result = false;
  for (var i = 1; i <= total_input; i++) {
  if ($("input[name='eq_param_gr_"+i+"']").val().length == '0'){
    $("input[name='eq_param_gr_"+i+"']").popover('show');
    $('#eq_param_gr_grp_'+i+'').addClass('has-error');
    (function(i){setTimeout(function(){$("input[name='eq_param_gr_"+i+"']").popover('hide');},2000)})(i);
    valid_result = true;
  }
  if ($("input[name='eq_param_name_"+i+"']").val().length == '0'){
    $("input[name='eq_param_name_"+i+"']").popover('show');
    $('#eq_param_name_grp_'+i+'').addClass('has-error');
    (function(i){setTimeout(function(){$("input[name='eq_param_name_"+i+"']").popover('hide');},2000)})(i);
    valid_result = true;
  }
}
  return valid_result;
  };


if ((valid_param_add() == false) && (total_input != 0)){
  $.ajax({
    type: "POST",
    url: ACTIONPATH,
    data: postdata +
    "&mode=eq_param_add"+
    "&total_input=" + total_input +
    "&id=" + arrList,
    success: function(response){
        dialog_eq_param_add.close();
        table_eq_param.ajax.reload();
    }
  })
}
});
// ****** Редактирование парамтров ******
$('body').on('click', 'button#edit_param', function(event) {
  event.preventDefault();

  var valid_param_edit = function(){
  var valid_result = false;
  if ($("#eq_param_gr").val().length == '0'){
    $("#eq_param_gr").popover('show');
    $('#eq_param_gr_grp').addClass('has-error');
    setTimeout(function(){$("#eq_param_gr").popover('hide');},2000);
    valid_result = true;
  }
  if ($("#eq_param_name").val().length == '0'){
    $("#eq_param_name").popover('show');
    $("#eq_param_name_grp").addClass('has-error');
    setTimeout(function(){$("#eq_param_name").popover('hide');},2000);
    valid_result = true;
  }
  return valid_result;
  };

  if (valid_param_edit() == false){
    $.ajax({
      type: "POST",
      url: ACTIONPATH,
      data: "mode=eq_param_edit"+
      "&id=" +id_param_edit +
      "&eq_param_gr=" + encodeURIComponent($("#eq_param_gr").val()) +
      "&eq_param_name=" + encodeURIComponent($("#eq_param_name").val()) +
      "&eq_param_comment=" + encodeURIComponent($("#eq_param_comment").val()),
      success: function(response){
        dialog_param_edit.close();
        table_eq_param.ajax.reload();
      }
    })
  }
});
// ***** Удаления параметров *****
$('body').on('click', 'button#equipment_param_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=param_delete"+
        "&id=" + id_param_delete,
        success: function() {
          dialog_param_del.close();
          table_eq_param.ajax.reload(null, false);
        }
        });
});
// ***** Редактирование колличества лицензий антивируса *****
$('body').on('click', 'button#edit_anti_col', function(event) {
          event.preventDefault();
          var valid_license_col = function(){
          var valid_result = false;
          if ($("#org_name").val().length == '0'){
            $("#org_name_p").popover('show');
            $('#org_name_grp').addClass('has-error');
            setTimeout(function(){$("#org_name_p").popover('hide');},2000);
            valid_result = true;
          }
          return valid_result;
          };

          if (valid_license_col() == false){
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=antivirus_col_update"+
        "&id=" + encodeURIComponent($("#org_name").val()) +
        "&antivirus_col=" + encodeURIComponent($("#anti_col").val()),
        success: function() {
          dialog_license_col.close();
          table_license.ajax.reload(null, false);
        }
        });
      }
});
// ***** Удаления файла из документов *****
$('body').on('click', 'button#documents_delete', function(event) {
          event.preventDefault();
        $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=documents_file_delete"+
        "&id=" + arrList_documents,
        success: function() {
          dialog_documents_files_del.close();
          table_documents.ajax.reload(null, false);
          arrList_documents = [];
        }
        });
});
// ***** Новости *****
// ***** Показать новость *****
$('body').on('click', 'button#create_new_news', function(event) {
    event.preventDefault();

    $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=create_news",
        success: function(html) {

            $("#news_content").hide().html(html).fadeIn(500);
            $("#create_new_news").hide();
            $("#page_number").hide();

            $('#summernote_news').summernote({
                height: 300,
                focus: true,
                toolbar: [
    // [groupName, [list of button]]
    ['ur',['undo','redo']],
    // ['st',['style']],
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['index', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize','fontname']],
    ['color', ['color']],
    ['table',['table']],
    ['hr',['hr']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['link', ['link']],
    ['view',['fullscreen','codeview','help']],
  ],
              lang: lang
            });

        }
    });

});
// ***** Сохранить новость *****
$('body').on('click', 'button#do_create_news', function(event) {
    event.preventDefault();
    var sHTML = $('#summernote_news').summernote('code');

    var t=$("#t").val();
    var data = { 'mode' : 'do_create_news', 't' : t, 'msg' : sHTML };

    var error_code=0;

    if ($("#t").val().length == 0 ) { error_code=1;
      BootstrapDialog.alert({
      title: get_lang_param("Er_title"),
      message: get_lang_param("Er_msg5"),
      type: BootstrapDialog.TYPE_WARNING,
      draggable: true
      });
    }

    if (error_code == 0) {
        $.ajax({
            type: "POST",
            url: ACTIONPATH,
            data: data,
            success: function(html) {


                window.location = MyHOSTNAME+"news";

            }
        });
    }
});
// ***** Редактировать новость *****
$('body').on('click', 'button#edit_news', function(event) {
    event.preventDefault();
    var hn=$(this).val();

    $.ajax({
        type: "POST",
        url: ACTIONPATH,
        data: "mode=edit_news"+
            "&hn="+encodeURIComponent(hn),
        success: function(html) {
            $("#news_content").html(html);
            $("#create_new_news").hide();
            $("#page_number").hide();
            $('#summernote_news').summernote({
                height: 300,
                focus: true,
                toolbar: [
    // [groupName, [list of button]]
    ['ur',['undo','redo']],
    // ['st',['style']],
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['index', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize','fontname']],
    ['color', ['color']],
    ['table',['table']],
    ['hr',['hr']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['link', ['link']],
    ['view',['fullscreen','codeview','help']]
  ],
              lang: lang
            });
        }
    });
});
// ***** Сохранение редактирования *****
$('body').on('click', 'button#do_save_news', function(event) {
    event.preventDefault();
    var sHTML = $('#summernote_news').summernote('code');
    var hn = $(this).val();
    var t=$("#t").val();
    var data = { 'mode' : 'do_save_news', 't' : t, 'msg' : sHTML, 'hn': hn };

    var error_code=0;

    if ($("#t").val().length == 0 ) { error_code=1;
      BootstrapDialog.alert({
      title: get_lang_param("Er_title"),
      message: get_lang_param("Er_msg5"),
      type: BootstrapDialog.TYPE_WARNING,
      draggable: true
      });
    }

    if (error_code == 0) {
        $.ajax({
            type: "POST",
            url: ACTIONPATH,
            data: data,
            success: function(html) {


                window.location = MyHOSTNAME+"news";

            }
        });
    }
});
// ***** Загрузка содержимого *****
var options_n = {
    currentPage: $("#cur_page").val(),
    totalPages: $("#total_pages").val(),
    bootstrapMajorVersion: 3,
    size: "small",
    itemContainerClass: function (type, page, current) {
        return (page === current) ? "active" : "pointer-cursor";
        console.log(currentPage);
        console.log(totalPages);

    },
    onPageClicked: function(e,originalEvent,type,page){
        var current=$("#curent_page").attr('value');

        if (page != current) {

            $("#curent_page").attr('value', page);

            $("#spinner").fadeIn(500);

                $.ajax({
                    type: "POST",
                    url:ACTIONPATH,
                    data: "mode=list_news"+
                        "&page="+encodeURIComponent(page),
                    success: function(html){
                      $("#spinner").hide();
                      $("#news_content").hide().html(html).fadeIn(500);
                    }
                });
        }


    }

}
$('#news_p').bootstrapPaginator(options_n);
if (ispath('news') ) {

        $.ajax({
            type: "POST",
            url: ACTIONPATH,
            data: "mode=list_news" +
            '&page=1',
            success: function(html) {
              $("#spinner").hide();
              $("#news_content").hide().html(html).fadeIn(500);
            }
        });
    };
// ***** Назад кнопка в новостях *****
    $('body').on('click', 'a#go_back', function(event) {
        event.preventDefault();
    history.back(1);
});
// ***** Удаление новостей *****
$('body').on('click', 'button#del_news', function(event) {
    event.preventDefault();
    var hn=$(this).val();
    window.dialog_news_del = new BootstrapDialog({
            title: get_lang_param("News_del"),
            message: get_lang_param("Del_news_info"),
            type: BootstrapDialog.TYPE_WARNING,
            cssClass: 'del-dialog',
            closable: false,
            draggable: true,
            closeByBackdrop: false,
            closeByKeyboard: false,
            buttons:[
              {
                id: "news_del_cancel",
                label: get_lang_param("Btn_no"),
                action: function(){
                       dialog_news_del.close();
                }
              },
              {
              id: "news_del_ok",
              label: get_lang_param("Btn_yes"),
              cssClass: "btn-primary",
            }
          ],
          });
          dialog_news_del.realize();
          dialog_news_del.open();
$('body').on('click', 'button#news_del_ok', function(event) {
 $.ajax({
            type: "POST",
            url: ACTIONPATH,
            data: "mode=del_news"+
                "&hn="+hn,
            success: function(html) {
              dialog_news_del.close();
                $.ajax({
                    type: "POST",
                    url: ACTIONPATH,
                    data: "mode=list_news" +
                    '&page=1',
                    success: function(html) {
                        $("#news_content").hide().html(html).fadeIn(500);
                    }
                });

            }
        });
      });
    });
// ***** Новости на главной *****
  var previous = $("#previous_d").val();
  if (previous === 'disabled'){
  $(".previous").addClass("disabled");
  $("a#previous").prop("disabled", true);
  }
  $(".next").addClass("disabled");
  $("a#next").prop("disabled", true);
$('body').on('click', 'a#previous', function(event) {
  event.preventDefault();
  $.ajax({
             type: "POST",
             url: ACTIONPATH,
             data: "mode=news_list_content_previous"+
                 "&dt_p="+encodeURIComponent($("#news_dt").val()),
             success: function(html) {
               $("#news_home_content").hide().html(html).fadeIn(500);
               $(".next").removeClass("disabled");
               $("a#next").prop("disabled", false);
               var previous = $("#previous_d").val();
               if (previous === 'disabled'){
                 $(".previous").addClass("disabled");
                 $("a#previous").prop("disabled", true);
               }
             }
         });
});
$('body').on('click', 'a#next', function(event) {
  event.preventDefault();
  $.ajax({
             type: "POST",
             url: ACTIONPATH,
             data: "mode=news_list_content_next"+
                 "&dt_n="+encodeURIComponent($("#news_dt").val()),
             success: function(html) {
               $("#news_home_content").hide().html(html).fadeIn(500);
               $(".previous").removeClass("disabled");
               $("a#previous").prop("disabled", false);
               var next = $("#next_d").val();
               if (next === 'disabled'){
                 $(".next").addClass("disabled");
                 $("a#next").prop("disabled", true);
               }
             }
         });
});
// $("#bdel").click(function(){
// $("#infoblock").load("controller/server/delete/delete.php");
// return false;
// });
 //        $('#equipment_add').on('shown.bs.modal', function(){
 //        $(".my_select", this).chosen({
 //        disable_search_threshold: 10,
 //        no_results_text: "Ничего не найдено",
 //        search_contains: true,
 //        allow_single_deselect: true
 //        });
 //        $(".my_select2", this).chosen({
 //        disable_search_threshold: 10,
 //        search_contains: true,
 //        no_results_text: "Ничего не найдено",
 //        });
 //        if ($("#equipment_add #suserid").val() == ''){
 //          $('button#equipment_add').addClass('disabled');
 //        }else {
 //          $('button#equipment_add').removeClass('disabled');
 //        }
 //        $("#ip").mask("999.999.999.999", {placeholder: " "});
 //        setTimeout(function() {
 //          $('#myForm_add').validator('validate');
 //        }, 100);
 //      });
 //      $('#equipment_add').on('hide.bs.modal', function () {
 //      $(this).find('form')[0].reset();
 //      $('#myForm_add').validator('destroy');
 // });

//  $('#equipment_edit').on('shown.bs.modal', function(){
//  $(".my_select", this).chosen({
//  disable_search_threshold: 10,
//  no_results_text: "Ничего не найдено",
//  search_contains: true,
//  allow_single_deselect: true
//  });
//  $(".my_select2", this).chosen({
//  disable_search_threshold: 10,
//  search_contains: true,
//  no_results_text: "Ничего не найдено",
//  });
//  $("#ip").mask("999.999.999.999", {placeholder: " "});
//  setTimeout(function() {
// $('#myForm_add').validator('validate');
// }, 100);
// });
// $('#equipment_edit').on('hide.bs.modal', function () {
// $(this).find('form')[0].reset();
// $('#myForm_edit').validator('destroy');
// });
// ******ТМЦ под ответсвенностью на главной странице******
var table_eq_mat = $('#eq_mat').DataTable({
  "aServerSide": true,
  "ajax":{
    "url":  ACTIONPATH,
    "type": "POST",
    "data":{mode: "eq_mat"}
  },
	"pading":false,
"deferRender":true,
"scrollY": 210,
"scrollCollapse": true,
"scroller":true,
"stateSave":true,
"searching":false,
"bLengthChange": false,
"select":{
	"style": "os"
},
"responsive": {
  details: {
    // type: 'column',
    // target: 'tr',
renderer: function ( api, rowIdx ) {
// Select hidden columns for the given row
var data_header = api.cells( rowIdx, ':hidden' ).eq(0).map( function ( cell ) {
var header = $( api.column( cell.column ).header() );
  return '<th class=\"center_header\">'+
            header.text()+':&nbsp;'+
        '</th> ';
}).toArray().join('');
var data = api.cells( rowIdx, ':hidden' ).eq(0).map( function ( cell ) {
var header = $( api.column( cell.column ).header() );
  var data2 =[];
  if (api.cell( cell ).data() === true){
    data2 = "<input checked type='checkbox' disabled='disabled' />";
  }
  else if (api.cell( cell ).data() === false){
    data2 = "<input type='checkbox' disabled='disabled' />";
  }
  else {
    data2 = api.cell( cell ).data();
  }
  return  '<td class=\"data_responsive center_table\">'+
              data2 +
          '</td>';
} ).toArray().join('');
return data ?
  $('<table class="table table-striped table-bordered nowrap" cellspacing="0" width="100%" />').append( '<thead><tr>'+data_header+'</tr></thead><tr>' + data + '</tr>' ) :
  false;
}
}
        },
"aoColumns": [
      { "bSearchable": false },
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      {"mRender": render_checkbox, "className": "center_table" },
      {"mRender": render_checkbox, "className": "center_table" },
      null
    ],

"language": {
            "url": MyHOSTNAME + "lang/lang-" + lang + ".json"
        }
        });
        table_eq_mat.on('select', function(e, dt, type, indexes ){
               var data = table_eq_mat.row( indexes ).data();
                eq_one_id = data[0];
                table_eq_move_show.ajax.reload();
           })

           $('#eq_mat tbody').on( 'dblclick','td', function () {
             var d = $(this).attr({
               'id':'select_copy',
               'data-container':'body',
               'data-toggle':'popover',
               'data-placement':'bottom',
               'data-html': 'true',
               'data-content':get_lang_param("Copy_to_clipboard")
             });
             var ch_copy = selectText('select_copy');
             //console.log(ch_copy);
             if (ch_copy == true){
             document.execCommand("copy");
             $("#select_copy").popover('show')
             // Copy_to_clipboard_dialog.open()
             setTimeout(function(){
                 $("#select_copy").popover('destroy');
                 // Copy_to_clipboard_dialog.close()
                 $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
               },800);
               }
           } );
// ******Таблица ТМЦ******
var table_eq = $('#equipment_table').DataTable({
"aServerSide": true,
"ajax":{
    "url":  ACTIONPATH,
    "type": "POST",
    "data":{
      mode: "eq"
    },
},
"pading":false,
"pagingType": "full_numbers",
"deferRender":true,
// "scrollY": 350,
// "scrollX":true,
// "scrollCollapse": true,
// "scroller":true,
"sScrollX": "100%",
"sScrollXInner": "100%",
"stateSave":true,
"responsive":false,
"bAutoWidth": true,
"searching":true,
"bLengthChange": true,
"select":{
	"style": "multi"
},
// "scroller": {
//             loadingIndicator: false
//         },
// "responsive": {
//   details: {
//     type: 'column',
//     // target: 'tr',
// renderer: function ( api, rowIdx ) {
// // Select hidden columns for the given row
// var data = api.cells( rowIdx, ':hidden' ).eq(0).map( function ( cell ) {
//   var header = $( api.column( cell.column ).header() );
//   console.log(data);
//
//   return '<tr>'+
//           '<th>'+
//               header.text()+':&nbsp;'+
//           '</th> '+
//           // '<tr>'+
//           '<td>'+
//               api.cell( cell ).data()+
//           '</td>'+
//       '</tr>';
// } ).toArray().join('');
// return data ?
//   $('<table/>').append( data ) :
//   false;
// }
// }
//         },
"aaSorting" : [[1,"asc"]],
fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
    $('[data-toggle="tooltip"]', nRow).tooltip({container: 'body', html:true});
                    if ( aData[0] == 'not_active' )
                    {
                        $(nRow).css({'background-color': '#d9534f', 'color': '#fff'});
                    }
                    if ( aData[19] == true )
                    {
                        $(nRow).css({'background-color': '#5bc0de', 'color': '#fff'});
                    }
                    if ($.cookie('cookie_eq_util') == '1'){
                    $(nRow).addClass('users_not_active');
                    }
                    if ($.cookie('cookie_eq_sale') == '1'){
                    $(nRow).addClass('users_not_active');
                    }
                  },
stateLoadCallback: function(){
  $.ajax({
    url:  ACTIONPATH,
    type: "POST",
    data:"mode=select_org",
    success: function(data){
      $('#equipment_table_filter').prepend(data + '&nbsp;');
      my_select();
      // ***** Обновление организации *****
      $("#org_equipment").on("change",function(){
        // console.log(this.value);
        $.cookie('cookieorgid',this.value);
        table_eq.ajax.reload();
        table_eq_move.clear().draw();
        table_eq_repair.clear().draw();
        table_eq_param.clear().draw();
        $('#photoid').fadeOut(500);
      });
    }
  });
},
drawCallback: function(){
  if (Admin !== true ){
    table_eq.buttons('.Action_b_eq').remove();
    table_eq.buttons('.Eq_delete_bt').remove();
}
},
"aoColumns": [
      { "bSearchable": false,"bSortable":false, "visible": false, "className": "center_table","mRender": render_active },
      { "bSearchable": false, "visible": false },
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      { "visible": false },
      { "visible": false },
      { "visible": false },
      { "visible": false },
      { "visible": false },
      { "bSearchable": false, "mRender": render_checkbox, "visible": false, "className": "center_table"  },
      { "bSearchable": false, "mRender": render_checkbox, "visible": false, "className": "center_table" },
      { "bSearchable": false, "mRender": render_checkbox, "visible": false, "className": "center_table" },
      { "bSearchable": false, "mRender": render_checkbox, "visible": false, "className": "center_table" },
      { "visible": false },
      { "visible": false },
      { "visible": false }
    ],

"sDom": "<'row'<'col-sm-4'l><'col-sm-8'f'><'col-sm-12'B>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "buttons": [
          {
                  extend: 'collection',
                  className: 'Action_b_eq',
                  text: function(a){return a.i18n("Action_b","Action button")},
                  autoClose: true,
                  "buttons":[
            {
                text: function(a){return a.i18n("Add","Add")},
                action: function ( e, dt, node, config ) {
                  window.dialog_add = new BootstrapDialog({
                          title: get_lang_param("Equipment_add"),
                          message: function(dialogRef) {
                var $message = $('<div></div>');
                var data = $.ajax({
                url: ACTIONPATH,
                type: 'POST',
                data: "mode=dialog_equipment_add",
                context: {
                    theDialogWeAreUsing: dialogRef
                },
                success: function(content) {
                this.theDialogWeAreUsing.setMessage(content);
                }
                });
                return $message;
                },
                          nl2br: false,
                          cssClass: 'add-edit-dialog',
                          closable: true,
                          draggable: true,
                          closeByBackdrop: false,
                          closeByKeyboard: false,
                            onshown: function(){
                              $("#eq_util").on('click', function(){
                                  if ($(this).prop("checked")){
                                    $("#eq_sale").attr('disabled', true);
                                  } else {
                                    $("#eq_sale").attr('disabled', false);
                                  }
                              })
                              $("#eq_sale").on('click', function(){
                                if ($(this).prop("checked")){
                                  $("#eq_util").attr('disabled', true);
                                } else {
                                  $("#eq_util").attr('disabled', false);
                                }
                              })
                            my_select();
                            my_select2();
                            img_equipment();
                            inv_typehead();
                            $("#ip").mask("999.999.999.999", {placeholder: " "});
                            check_ip();
                          //   $('#invoice').on('keyup',function(e) {
                          //     var code = e.which;
                          //   if (code === 32 && this.value.indexOf('от') === -1 && this.value.length > 0 && this.value.indexOf(" ") != 0)
                          //   {
                          //     $(this).val(this.value + 'от ' + $("#dtpost").val());
                          //   }
                          // });
                          $("#invoice_date").datepicker({
                          format: 'dd.mm.yyyy',
                          autoclose: true,
                          language: lang,
                          todayBtn: "linked",
                          clearBtn: false,
                          todayHighlight: true
                          });
                            $("#dtpost").datepicker({
                            format: 'dd.mm.yyyy',
                            autoclose: true,
                            language: lang,
                            todayBtn: "linked",
                            clearBtn: false,
                            todayHighlight: true
                            });
                            $("#dtpost").change(function(){
                              if ($(this).val().length > 8){
                                $('#dtpost').popover('hide');
                                $('#dtpost_add_grp').removeClass('has-error');
                              }
                              else {
                              $('#dtpost_add_grp').addClass('has-error');
                              }
                            });
                  var rem_add = {ers: false, ero: false, erp: false, ern:false, erg: false, erv:false};

                          $('#suserid').change(function(){
                            if ($(this).val().length > 0){
                              rem_add.ers = true;
                              oup();
                            }
                          });
                          $('#sorgid').change(function(){
                            if ($(this).val().length > 0){
                              rem_add.ero = true;
                              oup();
                            }
                          });
                          $('#splaces').change(function(){
                            if ($(this).val().length > 0){
                              rem_add.erp = true;
                              oup();
                            }
                          });
                          $('#snomeid').change(function(){
                            if ($(this).val().length > 0){
                              rem_add.ern = true;
                              what_r();
                            }
                          });
                          $('#sgroupname').change(function(){
                            if ($(this).val().length > 0){
                              GetArrayGroup_vendor();
                              rem_add.erg = true;
                              what_r();
                            }
                          });
                          function GetArrayGroup_vendor() {
                            $.ajax({
                                url: ACTIONPATH,
                                async: false,
                                type: 'POST',
                                data: 'mode=ven'+
                                  '&groupid=' + $("#sgroupname").val(),
                                success: function(res){
                                  $("#svendid").html(res);
                                  $("select#svendid").trigger("chosen:updated");
                                }

                            })
                          }
                          $('#svendid').change(function(){
                            if ($(this).val().length > 0){
                              GetArrayVendor_nome();
                              rem_add.erv = true;
                              what_r();
                            }
                          });
                          function GetArrayVendor_nome() {
                            $.ajax({
                              url: ACTIONPATH,
                              async: false,
                              type: 'POST',
                              data: 'mode=nome' +
                              '&groupid=' + $("#sgroupname").val() +
                              '&vendorid=' + $("#svendid").val(),
                              success: function(res){
                                $("#snomeid").html(res);
                                $("select#snomeid").trigger("chosen:updated");
                              }
                            });
                          }
                          function oup(){
                            if((rem_add.ers == true)&&(rem_add.ero == true)&&(rem_add.erp == true)){
                              $('#org_places_user').removeClass('has-error');
                            }
                          }
                          function what_r(){
                            if((rem_add.ern == true)&&(rem_add.erg == true)&&(rem_add.erv == true)){
                              $('#what').removeClass('has-error');
                            }
                          }
                        },
                        onhidden: function(){
                          table_eq.rows().deselect();
                          $('#photoid').fadeOut(500);
                          arrList=[];
                          eq_one_id=[];
                        }
                      });
                  dialog_add.open();
                }
            },
            {
                text: function(a){return a.i18n("Edit","Edit")},
                action: function ( e, dt, node, config ) {
                  var $rows = table_eq.$('tr.selected');
                    if ($rows.length == '1'){
                      window.dialog_edit = new BootstrapDialog({
                              title: get_lang_param("Equipment_edit"),
                              message: function(dialogRef) {
                    var $message = $('<div></div>');
                    var data = $.ajax({
                    url: ACTIONPATH,
                    type: 'POST',
                    data: "mode=dialog_equipment_edit" +
                    "&id=" + arrList,
                    context: {
                        theDialogWeAreUsing: dialogRef
                    },
                    success: function(content) {
                    this.theDialogWeAreUsing.setMessage(content);
                    }
                    });
                    return $message;
                    },
                              nl2br: false,
                              cssClass: 'add-edit-dialog',
                              closable: true,
                              draggable: true,
                              closeByBackdrop: false,
                              closeByKeyboard: false,
                              onshown: function(){
                                if ($("#eq_util").val() == 1){
                                  $("#eq_sale").attr('disabled', true);
                                }
                                if ($("#eq_sale").val() == 1){
                                  $("#eq_util").attr('disabled', true);
                                }
                                $("#eq_util").on('click', function(){
                                    if ($(this).prop("checked")){
                                      $("#eq_sale").attr('disabled', true);
                                    } else {
                                      $("#eq_sale").attr('disabled', false);
                                    }
                                })
                                $("#eq_sale").on('click', function(){
                                  if ($(this).prop("checked")){
                                    $("#eq_util").attr('disabled', true);
                                  } else {
                                    $("#eq_util").attr('disabled', false);
                                  }
                                })
                                my_select();
                                my_select2();
                                img_equipment();
                                inv_typehead();
                                $("#ip").mask("999.999.999.999", {placeholder: " "});
                                check_ip();
                              //   $('#invoice').on('keyup',function(e) {
                              //     var code = e.which;
                              //   if (code === 32 && this.value.indexOf('от') === -1 && this.value.length > 0 && this.value.indexOf(" ") != 0)
                              //   {
                              //     $(this).val(this.value + 'от ' + $("#dtpost").val());
                              //   }
                              // });
                              $("#invoice_date").datepicker({
                              format: 'dd.mm.yyyy',
                              autoclose: true,
                              language: lang,
                              todayBtn: "linked",
                              clearBtn: false,
                              todayHighlight: true
                              });
                                $("#dtpost").datepicker({
                                  format: 'dd.mm.yyyy',
                                  autoclose: true,
                                  language: lang,
                                  todayBtn: "linked",
                                  clearBtn: false,
                                  todayHighlight: true
                                });
                                $("#dtpost").change(function(){
                                  if ($(this).val().length > 8){
                                    $('#dtpost').popover('hide');
                                    $('#dtpost_edit_grp').removeClass('has-error');
                                  }
                                  else {
                                  $('#dtpost_edit_grp').addClass('has-error');
                                  }
                                });
                                var rem_edit = {ern:false, erg: false, erv:false};
                                $('#snomeid').change(function(){
                                  if ($(this).val().length > 0){
                                    rem_edit.ern = true;
                                    what_r_e();
                                  }
                                });
                                $('#sgroupname').change(function(){
                                  if ($(this).val().length > 0){
                                    GetArrayGroup_vendor();
                                    rem_edit.erg = true;
                                    what_r_e();
                                  }
                                });
                                function GetArrayGroup_vendor() {
                                  $.ajax({
                                      url: ACTIONPATH,
                                      async: false,
                                      type: 'POST',
                                      data: 'mode=ven'+
                                        '&groupid=' + $("#sgroupname").val(),
                                      success: function(res){
                                        $("#svendid").html(res);
                                        $("select#svendid").trigger("chosen:updated");
                                      }

                                  })
                                }
                                $('#svendid').change(function(){
                                  if ($(this).val().length > 0){
                                    GetArrayVendor_nome();
                                    rem_edit.erv = true;
                                    what_r_e();
                                  }
                                });
                                function GetArrayVendor_nome() {
                                  $.ajax({
                                    url: ACTIONPATH,
                                    async: false,
                                    type: 'POST',
                                    data: 'mode=nome' +
                                    '&groupid=' + $("#sgroupname").val() +
                                    '&vendorid=' + $("#svendid").val(),
                                    success: function(res){
                                      $("#snomeid").html(res);
                                      $("select#snomeid").trigger("chosen:updated");
                                    }
                                  });
                                }
                                function what_r_e(){
                                  if((rem_edit.ern == true)&&(rem_edit.erg == true)&&(rem_edit.erv == true)){
                                    $('#what').removeClass('has-error');
                                  }
                                }

                              },
                              onhidden: function(){
                                table_eq.rows().deselect();
                                $('#photoid').fadeOut(500);
                                arrList=[];
                                eq_one_id=[];
                              }
                      });
                    dialog_edit.open();
                    }
                    else if ($rows.length > '1') {
                      BootstrapDialog.alert({
                      title: get_lang_param("Er_title"),
                      message: get_lang_param("Er_msg1"),
                      type: BootstrapDialog.TYPE_WARNING,
                      draggable: true
                      });
                    }
                    else {
                      BootstrapDialog.alert({
                      title: get_lang_param("Er_title"),
                      message: get_lang_param("Er_msg2"),
                      type: BootstrapDialog.TYPE_WARNING,
                      draggable: true
                      });
                    }
                }
            },
            {
              text: function(a){return a.i18n("Move","Move")},
              action: function ( e, dt, node, config ) {
                var $rows = table_eq.$('tr.selected');
                  if ($rows.length > '0'){
                window.dialog_move = new BootstrapDialog({
                        title: get_lang_param("Equipment_move_title"),
                        message: function(dialogRef) {
              var $message = $('<div></div>');
              var data = $.ajax({
              url: ACTIONPATH,
              type: 'POST',
              data: "mode=dialog_move" +
              "&id=" + arrList,
              context: {
                  theDialogWeAreUsing: dialogRef
              },
              success: function(content) {
              this.theDialogWeAreUsing.setMessage(content);
              }
              });
              return $message;
              },
                        nl2br: false,
                        closable: true,
                        draggable: true,
                        closeByBackdrop: false,
                        closeByKeyboard: false,
                          onshown: function(){
                          my_select();
                          my_select2();

                        $('#suserid').change(function(){
                          if ($(this).val().length > 0){
                            $('#mat_to').removeClass('has-error');
                          }
                        });
                        $('#sorgid').change(function(){
                          if ($(this).val().length > 0){
                            $('#org_to').removeClass('has-error');
                          }
                        });
                        $('#splaces').change(function(){
                          if ($(this).val().length > 0){
                            $('#places_to').removeClass('has-error');
                          }
                        });
                      },
                      onhidden: function(){
                        table_eq.rows().deselect();
                        $('#photoid').fadeOut(500);
                        arrList=[];
                        eq_one_id=[];
                      }
                    });
                    dialog_move.realize();
                    dialog_move.open();
                  }
                  else {
                    BootstrapDialog.alert({
                    title: get_lang_param("Er_title"),
                    message: get_lang_param("Er_msg2"),
                    type: BootstrapDialog.TYPE_WARNING,
                    draggable: true
                    });
                  }
              }
            },
            {
              text: function(a){return a.i18n("Copy","Copy")},
              action: function ( e, dt, node, config ) {
                var $rows = table_eq.$('tr.selected');
                  if ($rows.length > '0'){
                window.dialog_copy = new BootstrapDialog({
                        title: get_lang_param("Equipment_copy"),
                        message: function(dialogRef) {
              var $message = $('<div></div>');
              var data = $.ajax({
              url: ACTIONPATH,
              type: 'POST',
              data: "mode=dialog_copy" +
              "&id=" + arrList,
              context: {
                  theDialogWeAreUsing: dialogRef
              },
              success: function(content) {
              this.theDialogWeAreUsing.setMessage(content);
              }
              });
              return $message;
              },
                        nl2br: false,
                        closable: true,
                        draggable: true,
                        closeByBackdrop: false,
                        closeByKeyboard: false,
                          onshown: function(){
                          my_select();
                          my_select2();
                        $('#suserid').change(function(){
                          if ($(this).val().length > 0){
                            $('#mat_copy_to').removeClass('has-error');
                          }
                        });
                        $('#sorgid').change(function(){
                          if ($(this).val().length > 0){
                            $('#org_copy_to').removeClass('has-error');
                          }
                        });
                        $('#splaces').change(function(){
                          if ($(this).val().length > 0){
                            $('#places_copy_to').removeClass('has-error');
                          }
                        });
                      },
                      onhidden: function(){
                        table_eq.rows().deselect();
                        $('#photoid').fadeOut(500);
                        arrList=[];
                        eq_one_id=[];
                      }
                    });
                    dialog_copy.realize();
                    dialog_copy.open();
                  }
                  else {
                    BootstrapDialog.alert({
                    title: get_lang_param("Er_title"),
                    message: get_lang_param("Er_msg2"),
                    type: BootstrapDialog.TYPE_WARNING,
                    draggable: true
                    });
                  }
              }

            },
            {
              text: function(a){return a.i18n("Delete","Delete")},
              action: function( e, dt, node, config ){
                var $rows = table_eq.$('tr.selected');
                  if ($rows.length > '0'){
                    window.dialog_del = new BootstrapDialog({
                            title: get_lang_param("Equipment_del"),
                            message: get_lang_param("Info_del"),
                            type: BootstrapDialog.TYPE_DANGER,
                            cssClass: 'del-dialog',
                            closable: true,
                            draggable: true,
                            closeByBackdrop: false,
                            closeByKeyboard: false,
                            buttons:[{
                              id: "equipment_delete",
                              label: get_lang_param("Delete"),
                              cssClass: " btn-danger",
                            }],
                            onhidden: function(){
                              table_eq.rows().deselect();
                              $('#photoid').fadeOut(500);
                              arrList=[];
                              eq_one_id=[];
                            }
                          });
                    dialog_del.open();
                  }
                  else {
                    BootstrapDialog.alert({
                    title: get_lang_param("Er_title"),
                    message: get_lang_param("Er_msg2"),
                    type: BootstrapDialog.TYPE_WARNING,
                    draggable: true
                    });
                  }
              }

            }
          ]
          },
            {
              text: function(a){return a.i18n("Repair","Repair")},
              className: 'Eq_delete_bt',
              action: function ( e, dt, node, config ) {
                var $rows = table_eq.$('tr.selected');
                  if ($rows.length == '1'){
                window.dialog_repair = new BootstrapDialog({
                        title: get_lang_param("Equipment_repair_title"),
                        message: function(dialogRef) {
              var $message = $('<div></div>');
              var data = $.ajax({
              url: ACTIONPATH,
              type: 'POST',
              data: "mode=dialog_repair" +
              "&id=" + arrList,
              context: {
                  theDialogWeAreUsing: dialogRef
              },
              success: function(content) {
              this.theDialogWeAreUsing.setMessage(content);
              }
              });
              return $message;
              },
                        nl2br: false,
                        closable: true,
                        draggable: true,
                        closeByBackdrop: false,
                        closeByKeyboard: false,
                          onshown: function(){
                          my_select();
                          my_select2();
                          $("#dt").datepicker({
                            format: 'dd.mm.yyyy',
                            autoclose: true,
                            language: lang,
                            todayBtn: "linked",
                            clearBtn: false,
                            todayHighlight: true
                          });
                          $("#dt").change(function(){
                            if ($(this).val().length > 8){
                              $('#dt').popover('hide');
                              $('#dt_grp').removeClass('has-error');
                            }
                            else {
                            $('#dt_grp').addClass('has-error');
                            }
                          });
                          $("#dtend").datepicker({
                            format: 'dd.mm.yyyy',
                            autoclose: true,
                            language: lang,
                            todayBtn: "linked",
                            clearBtn: false,
                            todayHighlight: true
                          });
                          $('#kntid').change(function(){
                            if ($(this).val().length > 0){
                              $('#knt_grp').removeClass('has-error');
                            }
                          });
                      },
                      onhidden: function(){
                        table_eq.rows().deselect();
                        $('#photoid').fadeOut(500);
                        arrList=[];
                        eq_one_id=[];
                      }
                    });
                    dialog_repair.realize();
                    dialog_repair.open();
                  }
                  else if ($rows.length > '1') {
                    BootstrapDialog.alert({
                    title: get_lang_param("Er_title"),
                    message: get_lang_param("Er_msg4"),
                    type: BootstrapDialog.TYPE_WARNING,
                    draggable: true
                    });
                  }
                  else {
                    BootstrapDialog.alert({
                    title: get_lang_param("Er_title"),
                    message: get_lang_param("Er_msg2"),
                    type: BootstrapDialog.TYPE_WARNING,
                    draggable: true
                    });
                  }
              }
          },
            {
              text: function(a){return a.i18n("Add_param","Add Param")},
              className: 'Eq_delete_bt',
              action: function ( e, dt, node, config ) {
                var $rows = table_eq.$('tr.selected');
                  if ($rows.length == '1'){
                    window.dialog_eq_param_add = new BootstrapDialog({
                            title: get_lang_param("Param_add"),
                            message: function(dialogRef) {
                  var $message = $('<div></div>');
                  var data = $.ajax({
                  url: ACTIONPATH,
                  type: 'POST',
                  data: "mode=dialog_eq_param_add",
                  context: {
                      theDialogWeAreUsing: dialogRef
                  },
                  success: function(content) {
                  this.theDialogWeAreUsing.setMessage(content);
                  }
                  });
                  return $message;
                  },
                            cssClass: 'param-dialog',
                            nl2br: false,
                            closable: true,
                            draggable: true,
                            closeByBackdrop: false,
                            closeByKeyboard: false,
                              onshown: function(){

              var max_fields      = 10; //Максимально кол-во добовляемых input
              var wrapper         = $(".input_fields_wrap");
              var add_button      = $("#add_input");

              window.total_input = 0;
              $(add_button).click(function(e){
                  e.preventDefault();
                  if(total_input < max_fields){
                      total_input++;
                      $.ajax({
                        type: "POST",
                        url: ACTIONPATH,
                        data: "mode=show_input" +
                        "&total_input=" + total_input,
                        success:function(html){
                          $(wrapper).append(html);
                          eq_param_typehead();
                          $('[data-toggle="tooltip"]').tooltip({container: 'body',html:true});
                          var g_del = total_input - 2;
                          if (g_del != -1){
                          $('.btn_del').eq(g_del).prop('disabled', true);
                        }
                          var k = total_input;
                          $("input[name='eq_param_gr_"+k+"']").keyup(function(){
                                      if($(this).val().length > 0) {
                                      $("input[name='eq_param_gr_"+k+"']").popover('hide');
                                      $("#eq_param_gr_grp_"+k+"").removeClass('has-error');
                                      }
                                      else {
                                      $("#eq_param_gr_grp_"+k+"").addClass('has-error');
                                      }
                                    });
                          $("input[name='eq_param_name_"+k+"']").keyup(function(){
                                      if($(this).val().length > 0) {
                                      $("input[name='eq_param_name_"+k+"']").popover('hide');
                                      $("#eq_param_name_grp_"+k+"").removeClass('has-error');
                                      }
                                      else {
                                      $("#eq_param_name_grp_"+k+"").addClass('has-error');
                                      }
                                  });
                        }
                      })

                      // $(wrapper).append('<div class="center_all"><input type="text" class="form-control input-sm" name="eq_param_gr['+total_input+']" id="eq_param_gr" data-provide="typeahead" autocomplete="off" placeholder="Параметр" style="width:230px;margin: 0 auto;"/><input type="text" class="form-control input-sm" name="eq_param_name['+total_input+']" placeholder="Наименование" style="width:230px;margin: 0 auto;"/><a href="#" class="remove_field">Remove</a></div>'); //add input box

                  }
                  if (total_input > 0){
                    $("#add_param").fadeIn(500);
                  }
                  $(add_button).blur();
              });


              $(wrapper).on("click","button#remove_field", function(e){
                  e.preventDefault();
                  $(this).parent('div').remove();
                  $('.tooltip').remove();
                  total_input--;
                  if (total_input == 0) {
                    $("#add_param").fadeOut(500);
                  }
                  var g_add = total_input - 1;
                  $('.btn_del').eq(g_add).prop('disabled', false);

              })

                              }
                  })
                  dialog_eq_param_add.open();
                  }
                  else if ($rows.length > '1') {
                    BootstrapDialog.alert({
                    title: get_lang_param("Er_title"),
                    message: get_lang_param("Er_msg3"),
                    type: BootstrapDialog.TYPE_WARNING,
                    draggable: true
                    });
                  }
                  else {
                    BootstrapDialog.alert({
                    title: get_lang_param("Er_title"),
                    message: get_lang_param("Er_msg2"),
                    type: BootstrapDialog.TYPE_WARNING,
                    draggable: true
                    });
                  }
              }
            },
      {
              extend: 'collection',
              text: function(a){return a.i18n("Save","Save")},
              autoClose: true,
              "buttons":[

            {
              extend: 'excelHtml5',
                text: function(a){return a.i18n("buttons.excel_visibli","Excel visibli")},
                  title: 'Data export',
                  exportOptions: {
                      columns: ':visible',
                      orthogonal: 'checkbox'
                    }
            },
            {
              extend: 'excelHtml5',
              text: function(a){return a.i18n("buttons.excel_all","Save all")},
              title: 'Data export',
              exportOptions:{
                orthogonal: 'checkbox'
              }
            },
            {
              extend: 'excelHtml5',
              text: function(a){return a.i18n("buttons.excel_visibli_selected","Excel Visibli Selected")},
              title: 'Data export',
              exportOptions: {
                  columns: ':visible',
                  orthogonal: 'checkbox',
                  modifier:{
                  selected: true
                  }
              }
            },
            {
              extend: 'excelHtml5',
              text: function(a){return a.i18n("buttons.excel_all_selected","Save All Selected")},
              title: 'Data export',
              exportOptions:{
                orthogonal: 'checkbox',
                modifier:{
                selected: true
                }
              }
            },
            {
              extend: 'pdfHtml5',
              text: function(a){return a.i18n("buttons.pdf_visibli","PDF visible")},
              download: 'open',
              orientation: 'landscape',
              pageSize: 'A3',
              title: 'Data export',
              exportOptions: {
                  columns: ':visible',
                  orthogonal: 'checkbox'
              }

            },
            {
              extend: 'pdfHtml5',
              text: function(a){return a.i18n("buttons.pdf_all","PDF all")},
              download: 'open',
              orientation: 'landscape',
              pageSize: 'A1',
              title: 'Data export',
              exportOptions:{
                orthogonal: 'checkbox'
              }
            },
            {
              extend: 'pdfHtml5',
              text: function(a){return a.i18n("buttons.pdf_visibli_selected","Pdf Visible Selected")},
              download: 'open',
              orientation: 'landscape',
              pageSize: 'A1',
              title: 'Data export',
              exportOptions: {
                  orthogonal: 'checkbox',
                  columns: ':visible',
                  modifier:{
                  selected: true
                  }
              }
            },
            {
              extend: 'pdfHtml5',
              text: function(a){return a.i18n("buttons.pdf_all_selected","Pdf All Selected")},
              download: 'open',
              orientation: 'landscape',
              pageSize: 'A1',
              title: 'Data export',
              exportOptions: {
                  orthogonal: 'checkbox',
                  modifier:{
                  selected: true
                  }
              }
            },
            {
            extend:'copyHtml5'
            },
        ]
      },
      {
            extend: 'collection',
            text: function(a){return a.i18n("Print","Print")},
            autoClose: true,
            "buttons":[
          {
            extend: 'print',
            text: function(a){return a.i18n("PrintAll","Print All")},
            exportOptions: {
                stripHtml: false,
                columns: ':visible'
            },
            customize:function(a) {
              $(a.document.body).find('th').addClass('center_header');
            }
          },
          {
            extend: 'print',
            text: function(a){return a.i18n("PrintSelected","Print Selected")},
            exportOptions: {
                stripHtml: false,
                modifier:{
                selected: true
                }
            },
            customize:function(a) {
              $(a.document.body).find('th').addClass('center_header');
            }
          }
            ]
      },
          {
            extend: 'colvis',
            autoClose: false,
            postfixButtons: [ 'colvisRestore' ]
            },
            {
                text: function(a){return a.i18n("Deselect","Deselect")},
                action: function () {
                    table_eq.rows().deselect();
                    $('#photoid').fadeOut(500);
                    arrList = [];
                    eq_one_id = [];
                }
            },
            {
            text: function(a){return a.i18n("Update","Update")},
            action: function () {
            table_eq.ajax.reload();
            table_eq_move.clear().draw();
            table_eq_repair.clear().draw();
            table_eq_param.clear().draw();
            $('#photoid').fadeOut(500);
            arrList = [];
            arrList_r = [];
            arrList_m = [];
            eq_one_id = [];
              }
            },
            {
            text: function(a){
              if ($.cookie('cookie_eq_util') == '0'){
              return a.i18n("Util","Util")
              }
              else {
                return a.i18n("Util_no","Util no")
              }
            },
            action: function () {
              if ($.cookie('cookie_eq_util') == '0'){
              this.text(function(a){return a.i18n("Util_no","Util no");});
              $.cookie('cookie_eq_util','1');
              table_eq.ajax.reload();
            }
            else {
              this.text(function(a){return a.i18n("Util","Util");});
              $.cookie('cookie_eq_util','0');
              table_eq.ajax.reload();
            }
              }
            },
            {
            text: function(a){
              if ($.cookie('cookie_eq_sale') == '0'){
              return a.i18n("Sale","Sale")
              }
              else {
                return a.i18n("Sale_no","Sale no")
              }
            },
            action: function () {
              if ($.cookie('cookie_eq_sale') == '0'){
              this.text(function(a){return a.i18n("Sale_no","Sale no");});
              $.cookie('cookie_eq_sale','1');
              table_eq.ajax.reload();
            }
            else {
              this.text(function(a){return a.i18n("Sale","Sale");});
              $.cookie('cookie_eq_sale','0');
              table_eq.ajax.reload();
            }
              }
            }
        ],
        "aocolumnDefs": [
            {
                "btargets": -1,
                "avisible": false
            },
            { "sType": 'de_date', "aTargets": [11,20] }
        ],
        "language": {
            "url": MyHOSTNAME + "lang/lang-" + lang +".json"
        }
        });

$('body').on('click', 'button#equipment_table_clear', function(event) {
                  event.preventDefault();
                  table_eq.search('').draw();
                  $("#equipment_table_clear").blur();
                });
                if (table_eq.search() !== ''){
                table_eq.search('').draw();
              }
function render_checkbox(data, type, full) {
  if (type === 'display'){
          var checked = "";
          if (data == true) { checked = 'checked'};
              data = "<input " + checked + " type='checkbox' disabled='disabled' />";
            }
  if (type === 'checkbox'){
      if (data == true){
          data = get_lang_param('Yes');
      }
      else {
          data = get_lang_param('No');
      }
  }
return data;

};
function render_tooltip(data, type, full) {
              return "<div data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" + data + "\"/>" + data;
};
function render_active(data, type, full) {
    var active = "";
          if (data == "active") { active = '<i class=\"text-success fa fa-check-circle fa-lg\"></i>'} else if (data == "not_active") { active = '<i class=\"btn-danger fa fa-trash-o fa-lg\"></i>'} else if (data == "repair") { active = '<i class=\"btn-info fa fa-gavel fa-lg\"></i>'} else if (data == "off") { active = '<i class=\"fa fa-close\"></i>'} else if (data == "util") { active = '<i class=\"fa fa-recycle\"></i>'} else if (data == "sale") { active = '<i class=\"fa fa-ruble\"></i>'};
              return active;
};
$('#equipment_table tbody').on( 'click', 'tr', function () {
  var data = table_eq.row( this ).data();
  if (data[0] === 'not_active'){
    if ( $(this).hasClass('selected') ) {
        $(this).addClass('row_active');
    }
    else {
        table_eq.$('tr.row_active').removeClass('row_active');
    }
  }
  if (data[0] === 'repair'){
    if ( $(this).hasClass('selected') ) {
        $(this).addClass('row_repair');
    }
    else {
        table_eq.$('tr.row_repair').removeClass('row_repair');
    }
  }
} );

// var Copy_to_clipboard_dialog = new BootstrapDialog({
//   title: get_lang_param("Copy_ok"),
//   message: get_lang_param("Copy_to_clipboard"),
//   type: BootstrapDialog.TYPE_SUCCESS,
//   draggable: false,
//   closable:false
// });

function selectText(containerid) {
  var check_copy=false;
    if (document.selection) {
        var range = document.body.createTextRange();
        range.moveToElementText(document.getElementById(containerid));
        document.selection.empty();
        range.select();
    } else if (window.getSelection) {
        var range = document.createRange();
        range.selectNodeContents(document.getElementById(containerid));
        var sel = window.getSelection();
        if (sel.empty){
          sel.empty();
          sel.addRange(range);
        } else if (sel.removeAllRanges){
        sel.removeAllRanges();
        sel.addRange(range);
      }
      if (window.getSelection().toString() != ""){
        check_copy = true;
      }

    }
    return check_copy;
};
$('#equipment_table tbody').on( 'dblclick','td', function () {

      var d = $(this).attr({
        'id':'select_copy',
        'data-container':'body',
        'data-toggle':'popover',
        'data-placement':'bottom',
        'data-html': 'true',
        'data-content':get_lang_param("Copy_to_clipboard")
      });
      var ch_copy = selectText('select_copy');
      //console.log(ch_copy);
      if (ch_copy == true){
      document.execCommand("copy");
      $("#select_copy").popover('show')
      // Copy_to_clipboard_dialog.open()
      setTimeout(function(){
          $("#select_copy").popover('destroy');
          // Copy_to_clipboard_dialog.close()
          $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
        },800);
        }
} );

var arrList = new Array();
var eq_one_id = [];
  table_eq.on('select', function(e, dt, type, indexes ){
       var data = table_eq.row( indexes ).data();
      //  var result = data[0].replace(/<[^>]+>/g,'');
        arrList.push(data[1]);
        eq_one_id = data[1];
        table_eq_move.ajax.reload();
        table_eq_repair.ajax.reload();
        table_eq_param.ajax.reload();
        equipment_photo();

   }).on( 'deselect', function ( e, dt, type, indexes ) {
      var data = table_eq.row( indexes ).data();
        arrList = $.grep(arrList, function(value){
          return value != data[1];
        })
      })

// ***** История перемещений *****
var table_eq_move = $('#equipment_move').DataTable({
  "aServerSide": true,
  "ajax":{
    "url":  ACTIONPATH,
    "type": "POST",
    "data":{
      "mode": "eq_table_move",
      "move_eqid": function(){return eq_one_id;}
    }
  },
	"pading":false,
"deferRender":true,
"responsive":false,
"scrollY": 200,
"sScrollX": "100%",
"sScrollXInner": "100%",
"scrollCollapse": true,
"scroller":true,
"stateSave":true,
"searching":false,
"bLengthChange": false,
"buttons" :false,
"select":{
	"style": "os"
},
"aaSorting" : [[1,"desc"]],
fnRowCallback: function( nRow ) {
  $('[data-toggle="tooltip"]', nRow).tooltip({container: 'body', html:true});
},
drawCallback: function(){
  if (Admin !== true ){
  table_eq_move.column( 11 ).visible( false );
  }
},
"aoColumns": [
            {"aTargets": [ 0 ],"visible": false,"bSortable": false},
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            {"bSearchable":false,"bSortable":false,"className": "center_table"}

        ],
"aoColumnDefs":[
        { "sType": 'de_datetime', "aTargets": 1 }
    ],
// "fnDrawCallback": function (){
//   if (Admin === false){
//     table_eq_move.buttons('.Edit_move').remove();
//     table_eq_move.buttons('.Delete_move').remove();
//     // table_eq_move.buttons().destroy();
//     // table_eq_move.button(0).remove();
// console.log(Admin);
//
//   }
// },
// "sDom" : "<'row'<'col-sm-12'f><'col-sm-12'B>r><'scroll-x't><'row'<'col-sm-6'i><'col-sm-6'p>>",
//         "buttons": [
//               {
//                 text: function(a){return a.i18n("Edit","Edit")},
//                 className: 'Edit_move',
//                 action: function ( e, dt, node, config ) {
//                   var $rows = table_eq_move.$('tr.selected');
//                     if ($rows.length > '0'){
//                   window.dialog_move_edit = new BootstrapDialog({
//                           title: get_lang_param("Equipment_move_title"),
//                           // message: $('<div></div>').load('inc/equipment.inc.php?step=move_edit&id=' + arrList_m),
//                           message: function(dialogRef) {
//                 var $message = $('<div></div>');
//                 var data = $.ajax({
//                 url: ACTIONPATH,
//                 type: 'POST',
//                 data: "mode=dialog_move_edit" +
//                 "&id=" + arrList_m,
//                 context: {
//                     theDialogWeAreUsing: dialogRef
//                 },
//                 success: function(content) {
//                 this.theDialogWeAreUsing.setMessage(content);
//                 }
//                 });
//                 return $message;
//                 },
//                           nl2br: false,
//                           closable: true,
//                           draggable: true,
//                           closeByBackdrop: false,
//                           closeByKeyboard: false,
//                         onhidden: function(){
//                           table_eq_move.rows().deselect();
//                           arrList_m=[];
//                         }
//                       });
//                       dialog_move_edit.realize();
//                       dialog_move_edit.open();
//                     }
//                     else {
//                       BootstrapDialog.alert({
//                       title: get_lang_param("Er_title"),
//                       message: get_lang_param("Er_msg2"),
//                       type: BootstrapDialog.TYPE_WARNING,
//                       draggable: true
//                       });
//                     }
//                 }
//             },
            // {
            //   text: function(a){return a.i18n("Delete","Delete")},
            //   className: 'Delete_move',
            //   action: function( e, dt, node, config ){
            //     var $rows = table_eq_move.$('tr.selected');
            //       if ($rows.length > '0'){
            //         window.dialog_move_del = new BootstrapDialog({
            //                 title: get_lang_param("Equipment_del_move"),
            //                 message: get_lang_param("Info_del"),
            //                 cssClass: 'del-dialog',
            //                 closable: true,
            //                 draggable: true,
            //                 closeByBackdrop: false,
            //                 closeByKeyboard: false,
            //                 buttons:[{
            //                   id: "equipment_move_delete",
            //                   label: get_lang_param("Delete"),
            //                   cssClass: "btn-sm btn-danger",
            //                 }],
            //                 onhidden: function(){
            //                   table_eq_move.rows().deselect();
            //                   arrList_m=[];
            //                 }
            //               });
            //         dialog_move_del.open();
            //       }
            //       else {
            //         BootstrapDialog.alert({
            //         title: get_lang_param("Er_title"),
            //         message: get_lang_param("Er_msg2"),
            //         type: BootstrapDialog.TYPE_WARNING,
            //         draggable: true
            //         });
            //       }
            //   }
            //
            // },
          // ],
"language": {
            "url": MyHOSTNAME + "lang/lang-" + lang +".json"
        }
        });
        $('#equipment_move tbody').on( 'dblclick','td', function () {
          var d = $(this).attr({
            'id':'select_copy',
            'data-container':'body',
            'data-toggle':'popover',
            'data-placement':'bottom',
            'data-html': 'true',
            'data-content':get_lang_param("Copy_to_clipboard")
          });
          var ch_copy = selectText('select_copy');
          //console.log(ch_copy);
          if (ch_copy == true){
          document.execCommand("copy");
          $("#select_copy").popover('show')
          // Copy_to_clipboard_dialog.open()
          setTimeout(function(){
              $("#select_copy").popover('destroy');
              // Copy_to_clipboard_dialog.close()
              $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
            },800);
            }
        } );
// Редактирование перемещений диалог
$('#equipment_move tbody').on( 'click', 'button#move_edit', function () {
        var data = table_eq_move.row( $(this).parents('tr') ).data();
        window.id_move_edit = data[0];
        window.dialog_move_edit = new BootstrapDialog({
                title: get_lang_param("Equipment_move_title"),
                message: function(dialogRef) {
      var $message = $('<div></div>');
      var data = $.ajax({
      url: ACTIONPATH,
      type: 'POST',
      data: "mode=dialog_move_edit" +
      "&id=" + id_move_edit,
      context: {
          theDialogWeAreUsing: dialogRef
      },
      success: function(content) {
      this.theDialogWeAreUsing.setMessage(content);
      }
      });
      return $message;
      },
                nl2br: false,
                closable: true,
                draggable: true,
                closeByBackdrop: false,
                closeByKeyboard: false,
            });
            dialog_move_edit.realize();
            dialog_move_edit.open();
});
// Удаление перемещений диалог
$('#equipment_move tbody').on( 'click', 'button#move_eq_delete', function () {
        var data = table_eq_move.row( $(this).parents('tr') ).data();
        window.id_move_delete = data[0];
        window.dialog_move_del = new BootstrapDialog({
                title: get_lang_param("Equipment_del_move"),
                message: get_lang_param("Info_del2"),
                type: BootstrapDialog.TYPE_DANGER,
                cssClass: 'del-dialog',
                closable: true,
                draggable: true,
                closeByBackdrop: false,
                closeByKeyboard: false,
                buttons:[{
                  id: "equipment_move_delete",
                  label: get_lang_param("Delete"),
                  cssClass: " btn-danger",
                }],
              });
        dialog_move_del.open();
});
// ***** История перемещений только просмотр *****
        var table_eq_move_show = $('#equipment_move_show').DataTable({
          "aServerSide": true,
          "ajax":{
            "url":  ACTIONPATH,
            "type": "POST",
            "data":{
              "mode": "eq_table_move",
              "move_eqid": function(){return eq_one_id;}
            }
          },
        	"pading":false,
        "deferRender":true,
        "responsive":false,
        "scrollY": 200,
        "sScrollX": "100%",
        "sScrollXInner": "100%",
        "scrollCollapse": true,
        "scroller":true,
        "stateSave":true,
        "searching":false,
        "bLengthChange": false,
        "buttons" :false,
        "select":{
        	"style": "os"
        },
        "aaSorting" : [[1,"desc"]],
        "aoColumns": [
                    {"aTargets": [ 0 ],"visible": false,"bSortable": false},
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null
                ],
        "aoColumnDefs":[
                        { "sType": 'de_datetime', "aTargets": 1 }
                    ],
        "language": {
                    "url": MyHOSTNAME + "lang/lang-" + lang +".json"
                }
                });
                $('#equipment_move_show tbody').on( 'dblclick','td', function () {
                  var d = $(this).attr({
                    'id':'select_copy',
                    'data-container':'body',
                    'data-toggle':'popover',
                    'data-placement':'bottom',
                    'data-html': 'true',
                    'data-content':get_lang_param("Copy_to_clipboard")
                  });
                  var ch_copy = selectText('select_copy');
                  //console.log(ch_copy);
                  if (ch_copy == true){
                  document.execCommand("copy");
                  $("#select_copy").popover('show')
                  // Copy_to_clipboard_dialog.open()
                  setTimeout(function(){
                      $("#select_copy").popover('destroy');
                      // Copy_to_clipboard_dialog.close()
                      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
                    },800);
                    }
                } );
// ***** История перемещений просмотр всего*****
var table_eq_move_show_all = $('#equipment_move_show_all').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "eq_table_move_show_all"
        }
},
"pading":false,
"pagingType": "full_numbers",
"deferRender":true,
"responsive":false,
"sScrollX": "100%",
"sScrollXInner": "100%",
"stateSave":true,
"searching":true,
"bLengthChange": true,
"select":{
"style": "os"
          },
"drawCallback": function ( settings ) {
  var api = this.api();
  var rows = api.rows( {page:'current'} ).nodes();
  var last=null;
  api.column(3, {page:'current'} ).data().each( function ( group, i ) {
    if ( last !== group ) {
      $(rows).eq( i ).before(
        '<tr class="group"><td colspan="11" class="group_text">'+group+'</td></tr>'
      );

      last = group;
    }
  } );
},
"aaSorting" : [[3,"asc"],[1,"desc"]],
"aoColumns": [
              {"visible":false,"bSearchable":false,"bSortable": false},
              null,
              null,
              null,
              null,
              null,
              null,
              null,
              null,
              null,
              null,
              null
            ],
"aoColumnDefs": [
                { "sType": 'de_datetime', "aTargets": 1 }
],
"sDom": "<'row'<'col-sm-2'l><'col-sm-4'B><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
  {
        extend: 'collection',
        text: function(a){return a.i18n("Print","Print")},
        autoClose: true,
        "buttons":[
      {
        extend: 'print',
        text: function(a){return a.i18n("PrintAll","Print All")},
        exportOptions: {
            stripHtml: false,
            columns: ':visible'
        },
        customize:function(a) {
          $(a.document.body).find('thead').remove();
          $(a.document.body).find('tbody').before('<thead><tr><th rowspan="2" class="center_header">'+ table_eq_move_show_all.i18n("Date","Date") + '</th><th rowspan="2" class="center_header">'+ table_eq_move_show_all.i18n("TMC","TMC") + '</th><th colspan="5" class="center_header">'+ table_eq_move_show_all.i18n("From","From") + '</th><th colspan="3" class="center_header">'+ table_eq_move_show_all.i18n("To","To") + '</th><th rowspan="2" class="center_header">'+ table_eq_move_show_all.i18n("Comment","Comment") + '</th></tr><tr><th rowspan="2" class="center_header">'+ table_eq_move_show_all.i18n("Orgname","Orgname") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Places","Places") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Matname","Matname") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Kntname","Kntname") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Invoice","Invoice") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Orgname","Orgname") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Places","Places") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Matname","Matname") + '</th></tr></thead>');
        }
      },
      {
        extend: 'print',
        text: function(a){return a.i18n("PrintSelected","Print Selected")},
        exportOptions: {
            stripHtml: false,
            modifier:{
            selected: true
          }
        },
        customize:function(a) {
          $(a.document.body).find('thead').remove();
          $(a.document.body).find('tbody').before('<thead><tr><th rowspan="2" class="center_header">'+ table_eq_move_show_all.i18n("Date","Date") + '</th><th rowspan="2" class="center_header">'+ table_eq_move_show_all.i18n("TMC","TMC") + '</th><th colspan="5" class="center_header">'+ table_eq_move_show_all.i18n("From","From") + '</th><th colspan="3" class="center_header">'+ table_eq_move_show_all.i18n("To","To") + '</th><th rowspan="2" class="center_header">'+ table_eq_move_show_all.i18n("Comment","Comment") + '</th></tr><tr><th rowspan="2" class="center_header">'+ table_eq_move_show_all.i18n("Orgname","Orgname") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Places","Places") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Matname","Matname") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Kntname","Kntname") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Invoice","Invoice") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Orgname","Orgname") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Places","Places") + '</th><th class="center_header">'+ table_eq_move_show_all.i18n("Matname","Matname") + '</th></tr></thead>');
        }
      }
        ]
  },
  {
  text: function(a){
    if ($.cookie('cookie_eq_util') == '0'){
    return a.i18n("Util","Util")
    }
    else {
      return a.i18n("Util_no","Util no")
    }
  },
  action: function () {
    if ($.cookie('cookie_eq_util') == '0'){
    this.text(function(a){return a.i18n("Util_no","Util no");});
    $.cookie('cookie_eq_util','1');
    table_eq_move_show_all.ajax.reload();
  }
  else {
    this.text(function(a){return a.i18n("Util","Util");});
    $.cookie('cookie_eq_util','0');
    table_eq_move_show_all.ajax.reload();
  }
    }
  },
  {
  text: function(a){
    if ($.cookie('cookie_eq_sale') == '0'){
    return a.i18n("Sale","Sale")
    }
    else {
      return a.i18n("Sale_no","Sale no")
    }
  },
  action: function () {
    if ($.cookie('cookie_eq_sale') == '0'){
    this.text(function(a){return a.i18n("Sale_no","Sale no");});
    $.cookie('cookie_eq_sale','1');
    table_eq_move_show_all.ajax.reload();
  }
  else {
    this.text(function(a){return a.i18n("Sale","Sale");});
    $.cookie('cookie_eq_sale','0');
    table_eq_move_show_all.ajax.reload();
  }
    }
  }
],
"language": {
            "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#equipment_move_show_all tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
$('#equipment_move_show_all tbody').on( 'click', 'tr.group', function () {
       var currentOrder = table_eq_move_show_all.order()[0];
       if ( currentOrder[0] === 3 && currentOrder[1] === 'asc' ) {
           table_eq_move_show_all.order( [ 3, 'desc' ] ).draw();
       }
       else {
           table_eq_move_show_all.order( [ 3, 'asc' ] ).draw();
       }
   } );
$('body').on('click', 'button#equipment_move_show_all_clear', function(event) {
                  event.preventDefault();
                  table_eq_move_show_all.search('').draw();
                  $("#equipment_move_show_all_clear").blur();
                });
                if (table_eq_move_show_all.search() !== ''){
                  table_eq_move_show_all.search('').draw();
                }

// ***** История ремонта *****
var table_eq_repair = $('#equipment_repair').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "eq_table_repair",
"repair_eqid": function(){return eq_one_id;}
    }
  },
"pading":false,
"deferRender":true,
"responsive":false,
"scrollY": 200,
"sScrollX": "100%",
"sScrollXInner": "100%",
"scrollCollapse": true,
"scroller":true,
"stateSave":true,
"searching":false,
"bLengthChange": false,
"select":{
    "style": "os"
        },
"aaSorting" : [[1,"desc"]],
fnRowCallback: function( nRow ) {
  $('[data-toggle="tooltip"]', nRow).tooltip({container: 'body', html:true});
},
drawCallback: function(){
  if (Admin !== true ){
  table_eq_repair.column( 7 ).visible( false );
  }
},
"aoColumns": [
              {"className": "center_table"},
              null,
              null,
              null,
              {"className": "center_table"},
              null,
              null,
              {"bSearchable":false,"bSortable":false,"className": "center_table"}
            ],
"aoColumnDefs":[
              { "sType": 'de_date', "aTargets": [1,2] }
],
// "sDom": "<'row'<'col-sm-12'f><'col-sm-12'B>r><'scroll-x't><'row'<'col-sm-6'i><'col-sm-6'p>>",
//         "buttons": [
//               {
//                 text: function(a){return a.i18n("Edit","Edit")},
//                 action: function ( e, dt, node, config ) {
//                   var $rows = table_eq_repair.$('tr.selected');
//                     if ($rows.length > '0'){
//                   window.dialog_repair_edit = new BootstrapDialog({
//                           title: get_lang_param("Equipment_repair_title"),
//                           message: function(dialogRef) {
//                 var $message = $('<div></div>');
//                 var data = $.ajax({
//                 url: ACTIONPATH,
//                 type: 'POST',
//                 data: "mode=dialog_repair_edit" +
//                 "&id=" + arrList_r,
//                 context: {
//                     theDialogWeAreUsing: dialogRef
//                 },
//                 success: function(content) {
//                 this.theDialogWeAreUsing.setMessage(content);
//                 }
//                 });
//                 return $message;
//                 },
//                           nl2br: false,
//                           // cssClass: 'repair-dialog',
//                           closable: true,
//                           draggable: true,
//                           closeByBackdrop: false,
//                           closeByKeyboard: false,
//                             onshown: function(){
//                             my_select();
//                             my_select2();
//                             $("#dt").datepicker({
//                               format: 'dd.mm.yyyy',
//                               autoclose: true,
//                               language: lang,
//                               todayBtn: "linked",
//                               clearBtn: false,
//                             });
//                             $("#dtend").datepicker({
//                               format: 'dd.mm.yyyy',
//                               autoclose: true,
//                               language: lang,
//                               todayBtn: "linked",
//                               clearBtn: false,
//                             });
//                             $('#kntid').change(function(){
//                               if ($(this).val().length > 0){
//                                 $('#knt_grp').removeClass('has-error');
//                               }
//                             });
//                         },
//                         onhidden: function(){
//                           table_eq_repair.rows().deselect();
//                           arrList_r=[];
//                         }
//                       });
//                       dialog_repair_edit.realize();
//                       dialog_repair_edit.open();
//                     }
//                     else {
//                       BootstrapDialog.alert({
//                       title: get_lang_param("Er_title"),
//                       message: get_lang_param("Er_msg2"),
//                       type: BootstrapDialog.TYPE_WARNING,
//                       draggable: true
//                       });
//                     }
//                 }
//             },
//             {
//               text: function(a){return a.i18n("Delete","Delete")},
//               action: function( e, dt, node, config ){
//                 var $rows = table_eq_repair.$('tr.selected');
//                   if ($rows.length > '0'){
//                     window.dialog_repair_del = new BootstrapDialog({
//                             title: get_lang_param("Equipment_del_repair"),
//                             message: get_lang_param("Info_del"),
//                             cssClass: 'del-dialog',
//                             closable: true,
//                             draggable: true,
//                             closeByBackdrop: false,
//                             closeByKeyboard: false,
//                             buttons:[{
//                               id: "equipment_repair_delete",
//                               label: get_lang_param("Delete"),
//                               cssClass: "btn-sm btn-danger",
//                             }],
//                             onhidden: function(){
//                               table_eq_repair.rows().deselect();
//                               arrList_r=[];
//                             }
//                           });
//                     dialog_repair_del.open();
//                   }
//                   else {
//                     BootstrapDialog.alert({
//                     title: get_lang_param("Er_title"),
//                     message: get_lang_param("Er_msg2"),
//                     type: BootstrapDialog.TYPE_WARNING,
//                     draggable: true
//                     });
//                   }
//               }
//
//             },
//           ],
"language": {
        "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#equipment_repair tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
//Редактирование ремонта диалог
$('#equipment_repair tbody').on( 'click', 'button#repair_edit', function () {
        var data = table_eq_repair.row( $(this).parents('tr') ).data();
        window.id_repair_edit = data[0];
        window.dialog_repair_edit = new BootstrapDialog({
                        title: get_lang_param("Equipment_repair_title"),
                        message: function(dialogRef) {
                        var $message = $('<div></div>');
                        var data = $.ajax({
                        url: ACTIONPATH,
                        type: 'POST',
                        data: "mode=dialog_repair_edit" +
                        "&id=" + id_repair_edit,
                        context: {
                            theDialogWeAreUsing: dialogRef
                        },
                        success: function(content) {
                        this.theDialogWeAreUsing.setMessage(content);
                        }
                        });
                        return $message;
                        },
                    nl2br: false,
                    closable: true,
                    draggable: true,
                    closeByBackdrop: false,
                    closeByKeyboard: false,
                    onshown: function(){
                    my_select();
                    my_select2();
                    $("#dt").datepicker({
                      format: 'dd.mm.yyyy',
                      autoclose: true,
                      language: lang,
                      todayBtn: "linked",
                      clearBtn: false,
                      todayHighlight: true
                    });
                    $("#dtend").datepicker({
                      format: 'dd.mm.yyyy',
                      autoclose: true,
                      language: lang,
                      todayBtn: "linked",
                      clearBtn: false,
                      todayHighlight: true
                      });
                      $('#kntid').change(function(){
                      if ($(this).val().length > 0){
                      $('#knt_grp').removeClass('has-error');
                          }
                      });
                        },
          });
    dialog_repair_edit.realize();
    dialog_repair_edit.open();
})
// Удаление ремонта диалог
$('#equipment_repair tbody').on( 'click', 'button#repair_eq_delete', function () {
        var data = table_eq_repair.row( $(this).parents('tr') ).data();
        window.id_repair_delete = data[0];
        window.dialog_repair_del = new BootstrapDialog({
        title: get_lang_param("Equipment_del_repair"),
        message: get_lang_param("Info_del2"),
        type: BootstrapDialog.TYPE_DANGER,
        cssClass: 'del-dialog',
        closable: true,
        draggable: true,
        closeByBackdrop: false,
        closeByKeyboard: false,
        buttons:[{
          id: "equipment_repair_delete",
          label: get_lang_param("Delete"),
          cssClass: " btn-danger",
        }],
      });
dialog_repair_del.open();
});
// var arrList_r = new Array();
//   table_eq_repair.on('select', function(e, dt, type, indexes ){
//        var data = table_eq_repair.row( indexes ).data();
//       //  var result = data[0].replace(/<[^>]+>/g,'');
//         arrList_r.push(data[0]);
//
// // console.log(arrList_r);
//    }).on( 'deselect', function ( e, dt, type, indexes ) {
//       var data = table_eq_repair.row( indexes ).data();
//         arrList_r = $.grep(arrList_r, function(value){
//           return value != data[0];
//         })
//     //  console.log(arrList);
//     //  console.log(eq_one_id);
//
//       })

      // var arrList_m = new Array();
      //   table_eq_move.on('select', function(e, dt, type, indexes ){
      //        var data = table_eq_move.row( indexes ).data();
      //       //  var result = data[0].replace(/<[^>]+>/g,'');
      //         arrList_m.push(data[0]);
      //
      // // console.log(arrList_m);
      //    }).on( 'deselect', function ( e, dt, type, indexes ) {
      //       var data = table_eq_move.row( indexes ).data();
      //         arrList_m = $.grep(arrList_m, function(value){
      //           return value != data[0];
      //         })
      //     //  console.log(arrList);
      //     //  console.log(eq_one_id);
      //
      //       })

// ***** Параметры имущества *****
var table_eq_param = $('#equipment_param').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "paramlist",
"id": function(){return eq_one_id;}
    }
  },
"pading":false,
"deferRender":true,
"responsive":false,
"scrollY": 200,
"scrollCollapse": true,
"scroller":true,
"stateSave":true,
"searching":false,
"bLengthChange": false,
"select":{
    "style": "os"
        },
"aaSorting" : [[1,"asc"]],
fnRowCallback: function( nRow ) {
  $('[data-toggle="tooltip"]', nRow).tooltip({container: 'body', html:true});
},
drawCallback: function(){
  if (Admin !== true ){
  table_eq_param.column( 4 ).visible( false );
  }
},
"aoColumns": [
              {"bSearchable":false},
              null,
              null,
              null,
              {"bSearchable":false,"bSortable":false,"className": "center_table"}
            ],
            "sDom": "<'row'<'col-sm-4'l><'col-sm-8'f'><'col-sm-12'B>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                    "buttons": [
                        {

                                extend: 'collection',
                                text: function(a){return a.i18n("Print","Print")},
                                autoClose: true,
                                "buttons":[
                              {
                                extend: 'print',
                                text: function(a){return a.i18n("PrintAll","Print All")},
                                exportOptions: {
                                    stripHtml: false,
                                    columns: ':visible'
                                },
                                customize:function(a) {
                                  $(a.document.body).find('th').addClass('center_header');
                                }
                              },
                              {
                                extend: 'print',
                                text: function(a){return a.i18n("PrintSelected","Print Selected")},
                                exportOptions: {
                                    stripHtml: false,
                                    modifier:{
                                    selected: true
                                    }
                                },
                                customize:function(a) {
                                  $(a.document.body).find('th').addClass('center_header');
                                }
                              }
                                ]
                          },
                          {
                            extend: 'colvis',
                            autoClose: false,
                            postfixButtons: [ 'colvisRestore' ]
                            },
                      ],
"language": {
        "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#equipment_param tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
//Редактирование параметра
$('#equipment_param tbody').on( 'click', 'button#param_edit', function () {
        var data = table_eq_param.row( $(this).parents('tr') ).data();
        window.id_param_edit = data[0];
        window.dialog_param_edit = new BootstrapDialog({
                        title: get_lang_param("Param_edit"),
                        message: function(dialogRef) {
                        var $message = $('<div></div>');
                        var data = $.ajax({
                        url: ACTIONPATH,
                        type: 'POST',
                        data: "mode=dialog_eq_param_edit" +
                        "&id=" + id_param_edit,
                        context: {
                            theDialogWeAreUsing: dialogRef
                        },
                        success: function(content) {
                        this.theDialogWeAreUsing.setMessage(content);
                        }
                        });
                        return $message;
                        },
                    cssClass: 'param-dialog',
                    nl2br: false,
                    closable: true,
                    draggable: true,
                    closeByBackdrop: false,
                    closeByKeyboard: false,
                    onshown: function(){
                      eq_param_typehead_edit();
                      $("#eq_param_gr").keyup(function(){
                      if($(this).val().length > 0) {
                      $('#eq_param_gr').popover('hide');
                      $('#eq_param_gr_grp').removeClass('has-error');
                      }
                      else {
                      $('#eq_param_gr_grp').addClass('has-error');
                      }
                      });
                      $("#eq_param_name").keyup(function(){
                      if($(this).val().length > 0) {
                      $('#eq_param_name').popover('hide');
                      $('#eq_param_name_grp').removeClass('has-error');
                      }
                      else {
                      $('#eq_param_name_grp').addClass('has-error');
                      }
                      });
                        },
          });
    // dialog_param_edit.realize();
    dialog_param_edit.open();
})
// Удаление параметра
$('#equipment_param tbody').on( 'click', 'button#param_del', function () {
        var data = table_eq_param.row( $(this).parents('tr') ).data();
        window.id_param_delete = data[0];
        window.dialog_param_del = new BootstrapDialog({
        title: get_lang_param("Param_del"),
        message: get_lang_param("Info_del2"),
        type: BootstrapDialog.TYPE_DANGER,
        cssClass: 'del-dialog',
        closable: true,
        draggable: true,
        closeByBackdrop: false,
        closeByKeyboard: false,
        buttons:[{
          id: "equipment_param_delete",
          label: get_lang_param("Delete"),
          cssClass: " btn-danger",
        }],
      });
dialog_param_del.open();
});

// ***** Проверка доступности ТМЦ *****
$("#test_ping").on('click', function(){

  $('#ping_show').show("slow");

  // var user = $("#suserid").val();
  // var org = $("#sorgid").val();
  // var places = $("#splaces").val();
if (! $.fn.DataTable.isDataTable('#ping')){
window.table_ping = $('#ping').DataTable({
  "aServerSide": true,
  "ajax":{
  "url":  ACTIONPATH,
  "type": "POST",
  "data":{
  "mode": "table_ping",
  "sorgid" : function(){return $("#sorgid").val();},
  "suserid" : function(){return $("#suserid").val();},
  "splaces" : function(){return $("#splaces").val();}
      }
    },
  "pading":false,
  "bDeferRender":true,
  "responsive":false,
  "bPaginate": false,
  "bAutoWidth": true,
  "stateSave":true,
  "searching":true,
  "bLengthChange": false,
  // "bDestroy": true,
  "select":{
      "style": "os"
          },
  "aaSorting" : [[1,"asc"]],
  "aoColumns": [
              {"bSearchable": false,"bSortable": false,"mRender": render_check_icon, "className": "center_table"},
              null,
              null,
              null,
              null,
              null
          ],
"aoColumnDefs":[
              { "sType": 'ip-address', "aTargets": 1 }
],
  "language": {
          "url": MyHOSTNAME + "lang/lang-" + lang +".json"
              }
  });
  $('#ping tbody').on( 'dblclick','td', function () {
    var d = $(this).attr({
      'id':'select_copy',
      'data-container':'body',
      'data-toggle':'popover',
      'data-placement':'bottom',
      'data-html': 'true',
      'data-content':get_lang_param("Copy_to_clipboard")
    });
    var ch_copy = selectText('select_copy');
    //console.log(ch_copy);
    if (ch_copy == true){
    document.execCommand("copy");
    $("#select_copy").popover('show')
    // Copy_to_clipboard_dialog.open()
    setTimeout(function(){
        $("#select_copy").popover('destroy');
        // Copy_to_clipboard_dialog.close()
        $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
      },800);
      }
  } );
  $('body').on('click', 'button#ping_clear', function(event) {
                    event.preventDefault();
                    table_ping.search('').draw();
                    $("#ping_clear").blur();
                  });
                  if (table_ping.search() !== ''){
                  table_ping.search('').draw();
                }
              }
              else {
                table_ping.ajax.reload();
              }
});

// ***** Проверка принтеров *****
$("#print_test").on('click', function(){

  $('#print_test_show').show("slow");
  $("#print_test").blur();
  $('#table_print_test').DataTable({
  "aServerSide": true,
  "ajax":{
  "url":  ACTIONPATH,
  "type": "POST",
  "data":{
  "mode": "print_test",
  "splaces" : function(){return $("#splaces").val();},
  "suserid" : function(){return $("#suserid").val();},
      }
    },
  "pading":false,
  "deferRender":true,
  "responsive":false,
  "bPaginate": true,
  "bAutoWidth": true,
  "stateSave":true,
  "sScrollX": "100%",
  "sScrollXInner": "100%",
  "scroller":true,
  "searching":true,
  "bLengthChange": false,
  "bDestroy": true,
  "select":{
      "style": "os"
          },
  "aaSorting" : [[1,"asc"]],
  "aoColumns": [
              {"bSearchable": false, "bSortable": false,"mRender": render_check_icon, "className": "center_table"},
              null,
              null,
              null,
              null,
              null,
              null,
              {"className": "center_table"},
              null,
              null
          ],
"aoColumnDefs":[
              { "sType": 'ip-address', "aTargets": 1 }
],
  "language": {
          "url": MyHOSTNAME + "lang/lang-" + lang +".json"
              }
  });
  $('#table_print_test tbody').on( 'dblclick','td', function () {
    var d = $(this).attr({
      'id':'select_copy',
      'data-container':'body',
      'data-toggle':'popover',
      'data-placement':'bottom',
      'data-html': 'true',
      'data-content':get_lang_param("Copy_to_clipboard")
    });
    var ch_copy = selectText('select_copy');
    //console.log(ch_copy);
    if (ch_copy == true){
    document.execCommand("copy");
    $("#select_copy").popover('show')
    // Copy_to_clipboard_dialog.open()
    setTimeout(function(){
        $("#select_copy").popover('destroy');
        // Copy_to_clipboard_dialog.close()
        $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
      },800);
      }
  } );
  $('body').on('click', 'button#table_print_test_clear', function(event) {
                    event.preventDefault();
                    $('#table_print_test').DataTable().search('').draw();
                    $("#table_print_test_clear").blur();
                  });
})

function render_check_icon(data, type, full) {
    var ping = "";
          if (data == true) { ping = '<i class=\"fa fa-check\"></i>'} else { ping = '<i class=\"fa fa-remove\"></i>'};
              return ping;
};

// ***** ТМЦ в кабинете *****
var table_eq_list = $('#eq_list').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "eq_list"
    }
  },
"pading":false,
"deferRender":true,
"responsive":false,
"scrollY": 300,
"sScrollX": "100%",
"sScrollXInner": "100%",
"scrollCollapse": true,
"scroller":true,
"stateSave":true,
"searching":false,
"bLengthChange": false,
"select":{
    "style": "os"
        },
"aaSorting" : [[7,"asc"]],
"aoColumns": [
            {"className": "center_table"},
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            {"mRender": render_checkbox, "className": "center_table"}
        ],
"language": {
        "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#eq_list tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
table_eq_list.on('select', function(e, dt, type, indexes ){
       var data = table_eq_list.row( indexes ).data();
        eq_one_id = data[0];
        table_eq_move_show.ajax.reload();
   })

// ***** Лицензии *****
var table_license = $('#table_license').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "license"
    }
  },
"pading":false,
"deferRender":true,
"responsive":false,
"sScrollX": "100%",
"sScrollXInner": "100%",
"iDisplayLength": 10,
"aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
"stateSave":true,
"searching":true,
"bLengthChange": true,
"select":{
    "style": "multi"
        },
"aaSorting" : [[0,"asc"]],
"drawCallback": function ( settings ) {
      var api = this.api();
      var rows = api.rows( {page:'current'} ).nodes();
      var last=null;
      api.column(0, {page:'current'} ).data().each( function ( group, i ) {
          if ( last !== group ) {
              $(rows).eq( i ).before(
                  '<tr class="group"><td colspan="15" class="group_text">'+group+'</td></tr>'
              );

              last = group;
          }
      } );
      $('tbody').find('.group').each(function (i,v) {
        //         var rowCount = $(this).nextUntil('.group').length;
        // $(this).find('td:first').append($('<span />', { 'class': 'group_text' }).append($('<b />', { 'text': ' ' + get_lang_param("Totale_install") +': ' + rowCount })));
            });
            if (Admin !== true ){
            table_license.buttons('.Action_b_license').remove();
            table_license.buttons('.License_delete_bt').remove();
          }
  },
"aoColumns": [
            {"visible":false},
            {"bSearchable":false,"className": "center_table"},
            null,
            {"visible":false},
            null,
            null,
            null,
            null,
            null,
            null,
            {"bSearchable":false,"mRender": render_checkbox, "className": "center_table"},
            {"bSearchable":false,"mRender": render_checkbox, "className": "center_table"},
            {"bSearchable":false,"mRender": render_checkbox, "className": "center_table"},
            {"bSearchable":false,"mRender": render_checkbox, "className": "center_table"},
            {"bSearchable":false,"mRender": render_checkbox, "className": "center_table"},
            null,
        ],
"aoColumnDefs":[
                { "sType": 'de_date', "aTargets": 8 }
],
"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f><'col-sm-12'B>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
        {
          extend: 'collection',
          className: 'Action_b_license',
          text: function(a){return a.i18n("Action_b","Action button")},
          autoClose: true,
          "buttons":[
          {
              text: function(a){return a.i18n("Add","Add")},
              // className: 'License_delete_bt',
              action: function ( e, dt, node, config ) {
                window.dialog_license_add = new BootstrapDialog({
                        title: get_lang_param("License_add"),
                        message: function(dialogRef) {
              var $message = $('<div></div>');
              var data = $.ajax({
              url: ACTIONPATH,
              type: 'POST',
              data: "mode=dialog_license_add",
              context: {
                  theDialogWeAreUsing: dialogRef
              },
              success: function(content) {
              this.theDialogWeAreUsing.setMessage(content);
              }
              });
              return $message;
              },
                        nl2br: false,
                        closable: true,
                        draggable: true,
                        closeByBackdrop: false,
                        closeByKeyboard: false,
                          onshown: function(){
                          my_select();
                          my_select2();
                          $("#antivirus").datepicker({
                            format: 'dd.mm.yyyy',
                            autoclose: true,
                            language: lang,
                            todayBtn: "linked",
                            clearBtn: false,
                            todayHighlight: true
                          });
                          $('#usersid').change(function(){
                            if ($(this).val().length > 0){
                              $('#usersid_li_add_grp').removeClass('has-error');
                              Getnome();
                            }
                          });
                          $('#eqid').change(function(){
                            if ($(this).val().length > 0){
                              $('#eqid_li_add_grp').removeClass('has-error');
                            }
                          });
                          function Getnome() {
                            $.ajax({
                                url: ACTIONPATH,
                                async: false,
                                type: 'POST',
                                data: 'mode=nome_lic'+
                                  '&usersid=' + $("#usersid").val(),
                                success: function(res){
                                  $("#eqid").html(res);
                                  $("#eqid").trigger("chosen:updated");
                                }

                            })
                          }
                      },
                      onhidden: function(){
                        table_license.rows().deselect();
                        arrList_li=[];
                      }
                    });
                    dialog_license_add.realize();
                    dialog_license_add.open();
              }

          },
          {
              text: function(a){return a.i18n("Edit","Edit")},
              // className: 'License_delete_bt',
              action: function ( e, dt, node, config ) {
                var $rows = table_license.$('tr.selected');
                  if ($rows.length == '1'){
                    window.dialog_license_edit = new BootstrapDialog({
                            title: get_lang_param("License_edit"),
                            message: function(dialogRef) {
                  var $message = $('<div></div>');
                  var data = $.ajax({
                  url: ACTIONPATH,
                  type: 'POST',
                  data: "mode=dialog_license_edit" +
                  "&id=" + arrList_li,
                  context: {
                      theDialogWeAreUsing: dialogRef
                  },
                  success: function(content) {
                  this.theDialogWeAreUsing.setMessage(content);
                  }
                  });
                  return $message;
                  },
                            nl2br: false,
                            closable: true,
                            draggable: true,
                            closeByBackdrop: false,
                            closeByKeyboard: false,
                            onshown: function(){
                              my_select();
                              my_select2();
                              $("#antivirus").datepicker({
                                format: 'dd.mm.yyyy',
                                autoclose: true,
                                language: lang,
                                todayBtn: "linked",
                                clearBtn: false,
                                todayHighlight: true
                              });
                              $('#usersid').change(function(){
                                if ($(this).val().length > 0){
                                  $('#usersid_li_edit_grp').removeClass('has-error');
                                  Getnome();
                                }
                              });
                              $('#eqid').change(function(){
                                if ($(this).val().length > 0){
                                  $('#eqid_li_edit_grp').removeClass('has-error');
                                }
                              });
                              function Getnome() {
                                $.ajax({
                                    url: ACTIONPATH,
                                    async: false,
                                    type: 'POST',
                                    data: 'mode=nome_lic'+
                                      '&usersid=' + $("#usersid").val(),
                                    success: function(res){
                                      $("#eqid").html(res);
                                	    $("#eqid").trigger("chosen:updated");
                                    }

                                })
                              }
                            },
                            onhidden: function(){
                              table_license.rows().deselect();
                              arrList_li=[];
                            }
                    });
                    dialog_license_edit.realize();
                  dialog_license_edit.open();
                }
                else if ($rows.length > '1') {
                  BootstrapDialog.alert({
                  title: get_lang_param("Er_title"),
                  message: get_lang_param("Er_msg1"),
                  type: BootstrapDialog.TYPE_WARNING,
                  draggable: true
                  });
                }
                else {
                  BootstrapDialog.alert({
                  title: get_lang_param("Er_title"),
                  message: get_lang_param("Er_msg2"),
                  type: BootstrapDialog.TYPE_WARNING,
                  draggable: true
                  });
                }
            }
        },
          {
              text: function(a){return a.i18n("License_antivirus_edit","License antivirus edit")},
              // className: 'License_delete_bt',
              action: function( e, dt, node, config ){
                var $rows = table_license.$('tr.selected');
                  if ($rows.length > '0'){
                    window.dialog_antivirus = new BootstrapDialog({
                            title: get_lang_param("Antivirus_edit"),
                            message: function(dialogRef) {
                            var $message = $('<div></div>');
                            var data = $.ajax({
                            url: ACTIONPATH,
                            type: 'POST',
                            data: "mode=dialog_antivirus_edit" +
                            "&id=" + arrList_li,
                            context: {
                            theDialogWeAreUsing: dialogRef
                            },
                            success: function(content) {
                            this.theDialogWeAreUsing.setMessage(content);
                            }
                            });
                            return $message;
                            },
                            nl2br: false,
                            closable: true,
                            draggable: true,
                            closeByBackdrop: false,
                            closeByKeyboard: false,
                            onshown: function(){
                              my_select();
                              my_select2();
                              $("#antivirus").datepicker({
                                format: 'dd.mm.yyyy',
                                autoclose: true,
                                language: lang,
                                todayBtn: "linked",
                                clearBtn: false,
                                todayHighlight: true
                              });
                              $('#organti').change(function(){
                                if ($(this).val().length > 0){
                                  $('#organti_grp').removeClass('has-error');
                                }
                              });
                              $('#antiname').change(function(){
                                if ($(this).val().length > 0){
                                  $('#antiname_grp').removeClass('has-error');
                                }
                              });
                            },
                            onhidden: function(){
                              table_license.rows().deselect();
                              arrList_li=[];
                            }
                          });
                          dialog_antivirus.realize();
                    dialog_antivirus.open();
                  }
                  else {
                    BootstrapDialog.alert({
                    title: get_lang_param("Er_title"),
                    message: get_lang_param("Er_msg2"),
                    type: BootstrapDialog.TYPE_WARNING,
                    draggable: true
                    });
                  }
                }
              },
              {
                text: function(a){return a.i18n("Delete","Delete")},
                // className: 'License_delete_bt',
                action: function( e, dt, node, config ){
                  var $rows = table_license.$('tr.selected');
                    if ($rows.length > '0'){
                      window.dialog_license_del = new BootstrapDialog({
                              title: get_lang_param("License_delete"),
                              message: get_lang_param("Info_del"),
                              type: BootstrapDialog.TYPE_DANGER,
                              cssClass: 'del-dialog',
                              closable: true,
                              draggable: true,
                              closeByBackdrop: false,
                              closeByKeyboard: false,
                              buttons:[{
                                id: "license_delete",
                                label: get_lang_param("Delete"),
                                cssClass: " btn-danger",
                              }],
                              onhidden: function(){
                                table_license.rows().deselect();
                                arrList_li=[];
                              }
                            });
                      dialog_license_del.open();
                    }
                    else {
                      BootstrapDialog.alert({
                      title: get_lang_param("Er_title"),
                      message: get_lang_param("Er_msg2"),
                      type: BootstrapDialog.TYPE_WARNING,
                      draggable: true
                      });
                    }
                }

              }
            ]
            },
            {
                text: function(a){return a.i18n("License_col","License col")},
                className: 'License_delete_bt',
                action: function( e, dt, node, config ){
                      window.dialog_license_col = new BootstrapDialog({
                              title: get_lang_param("License_col_title"),
                              message: function(dialogRef) {
                              var $message = $('<div></div>');
                              var data = $.ajax({
                              url: ACTIONPATH,
                              type: 'POST',
                              data: "mode=dialog_license_col",
                              context: {
                              theDialogWeAreUsing: dialogRef
                              },
                              success: function(content) {
                              this.theDialogWeAreUsing.setMessage(content);
                              }
                              });
                              return $message;
                              },
                              cssClass: 'license_col-dialog',
                              nl2br: false,
                              closable: true,
                              draggable: true,
                              closeByBackdrop: false,
                              closeByKeyboard: false,
                              onshown: function(){
                                my_select();
                                $('#org_name').change(function(){
                                  if ($(this).val().length > 0){
                                    $('#org_name_grp').removeClass('has-error');
                                  }
                                    var org_id = $(this).val();
                                    $.ajax({
                                      url: ACTIONPATH,
                                      type: 'POST',
                                      data: "mode=input_antivirus_col" +
                                      '&id=' + org_id,
                                      success: function(data){
                                        $("#anti_col").val(data);
                                      }
                                    })
                                });
                              },
                              onhidden: function(){
                                table_license.rows().deselect();
                                arrList_li=[];
                              }
                            });
                      dialog_license_col.open();
                }

              },
          {
                extend: 'collection',
                text: function(a){return a.i18n("Print","Print")},
                autoClose: true,
                "buttons":[
              {
                extend: 'print',
                text: function(a){return a.i18n("PrintAll","Print All")},
                exportOptions: {
                    stripHtml: false,
                    columns: ':visible'
                },
                customize:function(a) {
                  $(a.document.body).find('th').addClass('center_header');
                }
              },
              {
                extend: 'print',
                text: function(a){return a.i18n("PrintSelected","Print Selected")},
                exportOptions: {
                  stripHtml: false,
                    modifier:{
                    selected: true
                  }
                },
                customize:function(a) {
                  $(a.document.body).find('th').addClass('center_header');
                }
              }
                ]
          },
              {
                extend: 'colvis',
                autoClose: false,
                postfixButtons: [ 'colvisRestore' ],
                columns: ':not(:first-child)'
                },
                {
                text: function(a){return a.i18n("Update","Update")},
                action: function () {
                table_license.ajax.reload();
                  }
                },
                {
                    text: function(a){return a.i18n("Deselect","Deselect")},
                    action: function () {
                        table_license.rows().deselect();
                        arrList_li = [];
                    }
                },
                {
                text: function(a){
                  if ($.cookie('cookie_eq_util') == '0'){
                  return a.i18n("Util","Util")
                  }
                  else {
                    return a.i18n("Util_no","Util no")
                  }
                },
                action: function () {
                  if ($.cookie('cookie_eq_util') == '0'){
                  this.text(function(a){return a.i18n("Util_no","Util no");});
                  $.cookie('cookie_eq_util','1');
                  table_license.ajax.reload();
                }
                else {
                  this.text(function(a){return a.i18n("Util","Util");});
                  $.cookie('cookie_eq_util','0');
                  table_license.ajax.reload();
                }
                  }
                },
                {
                  text: function(a){
                    if ($.cookie('cookie_eq_sale') == '0'){
                      return a.i18n("Sale","Sale")
                    }
                    else {
                      return a.i18n("Sale_no","Sale no")
                    }
                  },
                  action: function () {
                    if ($.cookie('cookie_eq_sale') == '0'){
                      this.text(function(a){return a.i18n("Sale_no","Sale no");});
                      $.cookie('cookie_eq_sale','1');
                      table_license.ajax.reload();
                    }
                    else {
                      this.text(function(a){return a.i18n("Sale","Sale");});
                      $.cookie('cookie_eq_sale','0');
                      table_license.ajax.reload();
                    }
                  }
                }
        ],
"language": {
        "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#table_license tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
$('body').on('click', 'button#table_license_clear', function(event) {
                  event.preventDefault();
                  table_license.search('').draw();
                  $("#table_license_clear").blur();
                });
$('#table_license tbody').on( 'click', 'tr.group', function () {
       var currentOrder = table_license.order()[0];
       if ( currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
           table_license.order( [ 0, 'desc' ] ).draw();
       }
       else {
           table_license.order( [ 0, 'asc' ] ).draw();
       }
   } );
     var org_name = getUrlParameter('org');
     if (org_name != undefined){
     table_license.search(org_name).draw();
}
else {
if (table_license.search() !== ''){
  table_license.search('').draw();
}
}
   var arrList_li = new Array();
     table_license.on('select', function(e, dt, type, indexes ){
          var data = table_license.row( indexes ).data();
           arrList_li.push(data[1]);
      }).on( 'deselect', function ( e, dt, type, indexes ) {
         var data = table_license.row( indexes ).data();
           arrList_li = $.grep(arrList_li, function(value){
             return value != data[1];
           })
         })

// ***** Учет картриджей *****
var table_cartridge = $('#table_cartridge').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "cartridge"
    }
  },
"pading":false,
"deferRender":true,
"responsive":false,
"sScrollX": "100%",
"sScrollXInner": "100%",
"stateSave":true,
"searching":true,
"iDisplayLength": 10,
"aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
"bLengthChange": true,
"select":{
    "style": "os"
        },
"aaSorting" : [[2,"asc"]],
"drawCallback": function ( settings ) {
      var api = this.api();
      var rows = api.rows( {page:'current'} ).nodes();
      var last=null;

      api.column(2, {page:'current'} ).data().each( function ( group, i ) {
          if ( last !== group ) {
              $(rows).eq( i ).before(
                  '<tr class="group"><td colspan="11" class="group_text">'+group+'</td></tr>'

              );

              last = group;
          }
      } );

  },
  fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
      $('[data-toggle="tooltip"]', nRow).tooltip({container: 'body', html:true});
                  if ( aData[0] == 'not_active' )
                  {
                    $(nRow).css({'background-color': '#d9534f', 'color': '#fff'});
                  }
  },
  stateLoadCallback: function(){
    $.ajax({
    url:  ACTIONPATH,
    type: "POST",
    data:"mode=select_print",
    success: function(data){
    $('#table_cartridge_filter').prepend(data + '&nbsp;');
      my_select();
    $("#printid_fast").change(function(){
      var select_print = $("#printid_fast option:selected").text();
      table_cartridge.search(select_print).draw();
    });
  }
});
  },
"aoColumns": [
            {"bSearchable":false,"bSortable":false,"className": "center_table","mRender": render_active},
            {"bSearchable":false,"className": "center_table"},
            {"visible":false},
            null,
            null,
            null,
            null,
            {"bSearchable":false,"bSortable":false,"className": "center_table"},
            {"bSearchable":false,"bSortable":false,"mRender": render_checkbox, "className": "center_table"},
            {"bSearchable":false,"bSortable":false,"mRender": render_checkbox, "className": "center_table"},
            {"bSortable":false},
            {"bSortable":false,"className": "center_table"}
        ],
"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f><'col-sm-12'B>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
          {
              text: function(a){return a.i18n("Add","Add")},
              action: function ( e, dt, node, config ) {
                window.dialog_cartridge_add = new BootstrapDialog({
                        title: get_lang_param("Cartridge_add"),
                        message: function(dialogRef) {
              var $message = $('<div></div>');
              var data = $.ajax({
              url: ACTIONPATH,
              type: 'POST',
              data: "mode=dialog_cartridge_add",
              context: {
                  theDialogWeAreUsing: dialogRef
              },
              success: function(content) {
              this.theDialogWeAreUsing.setMessage(content);
              }
              });
              return $message;
              },
                        nl2br: false,
                        closable: true,
                        draggable: true,
                        closeByBackdrop: false,
                        closeByKeyboard: false,
                          onshown: function(){
                          my_select();
                          my_select2();
                          $('#userid').change(function(){
                            if ($(this).val().length > 0){
                              $('#userid_add_grp').removeClass('has-error');
                            }
                          });
                          $('#orgid').change(function(){
                            if ($(this).val().length > 0){
                              $('#orgid_add_grp').removeClass('has-error');
                            }
                          });
                          $('#placesid').change(function(){
                            if ($(this).val().length > 0){
                              $('#placesid_add_grp').removeClass('has-error');
                            }
                          });
                          $('#nomeid').change(function(){
                            if ($(this).val().length > 0){
                              $('#nomeid_add_grp').removeClass('has-error');
                            }
                          });
                      },
                      onhidden: function(){
                        table_cartridge.rows().deselect();
                        eq_one_id=[];
                      }
                    });
                    dialog_cartridge_add.realize();
                    dialog_cartridge_add.open();
              }

          },
          {
              text: function(a){return a.i18n("Edit","Edit")},
              action: function ( e, dt, node, config ) {
                var $rows = table_cartridge.$('tr.selected');
                  if ($rows.length == '1'){
                    window.dialog_cartridge_edit = new BootstrapDialog({
                            title: get_lang_param("Cartridge_edit"),
                            message: function(dialogRef) {
                  var $message = $('<div></div>');
                  var data = $.ajax({
                  url: ACTIONPATH,
                  type: 'POST',
                  data: "mode=dialog_cartridge_edit" +
                  "&id=" + eq_one_id,
                  context: {
                      theDialogWeAreUsing: dialogRef
                  },
                  success: function(content) {
                  this.theDialogWeAreUsing.setMessage(content);
                  }
                  });
                  return $message;
                  },
                            nl2br: false,
                            closable: true,
                            draggable: true,
                            closeByBackdrop: false,
                            closeByKeyboard: false,
                            onshown: function(){
                              my_select();
                              my_select2();
                              $('#userid').change(function(){
                                if ($(this).val().length > 0){
                                  $('#userid_edit_grp').removeClass('has-error');
                                }
                              });
                              $('#orgid').change(function(){
                                if ($(this).val().length > 0){
                                  $('#orgid_edit_grp').removeClass('has-error');
                                }
                              });
                              $('#placesid').change(function(){
                                if ($(this).val().length > 0){
                                  $('#placesid_edit_grp').removeClass('has-error');
                                }
                              });
                              $('#nomeid').change(function(){
                                if ($(this).val().length > 0){
                                  $('#nomeid_edit_grp').removeClass('has-error');
                                }
                              });
                            },
                            onhidden: function(){
                              table_cartridge.rows().deselect();
                              eq_one_id=[];
                            }
                    });
                    dialog_cartridge_edit.realize();
                  dialog_cartridge_edit.open();
                }
                else if ($rows.length > '1') {
                  BootstrapDialog.alert({
                  title: get_lang_param("Er_title"),
                  message: get_lang_param("Er_msg1"),
                  type: BootstrapDialog.TYPE_WARNING,
                  draggable: true
                  });
                }
                else {
                  BootstrapDialog.alert({
                  title: get_lang_param("Er_title"),
                  message: get_lang_param("Er_msg2"),
                  type: BootstrapDialog.TYPE_WARNING,
                  draggable: true
                  });
                }
            }
        },
          {
              text: function(a){return a.i18n("Cartridge_out","Cartridge out")},
              action: function( e, dt, node, config ){
                var $rows = table_cartridge.$('tr.selected');
                  if ($rows.length > '0'){
                    window.dialog_cartridge_out = new BootstrapDialog({
                            title: get_lang_param("Cartridge_out_title"),
                            message: function(dialogRef) {
                            var $message = $('<div></div>');
                            var data = $.ajax({
                            url: ACTIONPATH,
                            type: 'POST',
                            data: "mode=dialog_cartridge_out" +
                            "&id=" + eq_one_id,
                            context: {
                            theDialogWeAreUsing: dialogRef
                            },
                            success: function(content) {
                            this.theDialogWeAreUsing.setMessage(content);
                            }
                            });
                            return $message;
                            },
                            nl2br: false,
                            closable: true,
                            draggable: true,
                            closeByBackdrop: false,
                            closeByKeyboard: false,
                            onshown: function(){
                              my_select();
                              my_select2();
                              $('#userid').change(function(){
                                if ($(this).val().length > 0){
                                  $('#cartridge_poluchatel_grp').removeClass('has-error');
                                }
                              });
                              $("#coll2").keyup(function(){
                              if($(this).val().length > 0) {
                              $('#coll2').popover('hide');
                              $('#coll_grp').removeClass('has-error');
                              }
                              else {
                              $('#coll_grp').addClass('has-error');
                              }
                              });
                            },
                            onhidden: function(){
                              table_cartridge.rows().deselect();
                              eq_one_id=[];
                            }
                          });
                          dialog_cartridge_out.realize();
                    dialog_cartridge_out.open();
                  }
                  else {
                    BootstrapDialog.alert({
                    title: get_lang_param("Er_title"),
                    message: get_lang_param("Er_msg2"),
                    type: BootstrapDialog.TYPE_WARNING,
                    draggable: true
                    });
                  }
              }

            },
            // {
            //     text: function(a){return a.i18n("Cartridge_fast_edit","Cartridge fast edit")},
            //     action: function( e, dt, node, config ){
            //       var $rows = table_cartridge.$('tr.selected');
            //         if ($rows.length > '0'){
            //           window.dialog_cartridge_fast_edit = new BootstrapDialog({
            //                   title: get_lang_param("Cartridge_fast_edit_title"),
            //                   message: function(dialogRef) {
            //                   var $message = $('<div></div>');
            //                   var data = $.ajax({
            //                   url: ACTIONPATH,
            //                   type: 'POST',
            //                   data: "mode=dialog_cartridge_fast_edit" +
            //                   "&id=" + eq_one_id,
            //                   context: {
            //                   theDialogWeAreUsing: dialogRef
            //                   },
            //                   success: function(content) {
            //                   this.theDialogWeAreUsing.setMessage(content);
            //                   }
            //                   });
            //                   return $message;
            //                   },
            //                   nl2br: false,
            //                   closable: true,
            //                   draggable: true,
            //                   closeByBackdrop: false,
            //                   closeByKeyboard: false,
            //                   onshown: function(){
            //                     my_select();
            //                     my_select2();
            //                   },
            //                   onhidden: function(){
            //                     table_cartridge.rows().deselect();
            //                     eq_one_id=[];
            //                   }
            //                 });
            //                 dialog_cartridge_fast_edit.realize();
            //           dialog_cartridge_fast_edit.open();
            //         }
            //         else {
            //           BootstrapDialog.alert({
            //           title: get_lang_param("Er_title"),
            //           message: get_lang_param("Er_msg2"),
            //           type: BootstrapDialog.TYPE_WARNING,
            //           draggable: true
            //           });
            //         }
            //     }
            //
            //   },
          // {
          //   text: function(a){return a.i18n("Delete","Delete")},
          //   action: function( e, dt, node, config ){
          //     var $rows = table_cartridge.$('tr.selected');
          //       if ($rows.length > '0'){
          //         window.dialog_cartridge_del = new BootstrapDialog({
          //                 title: get_lang_param("License_delete"),
          //                 message: get_lang_param("Info_del"),
          //                 cssClass: 'del-dialog',
          //                 closable: true,
          //                 draggable: true,
          //                 closeByBackdrop: false,
          //                 closeByKeyboard: false,
          //                 buttons:[{
          //                   id: "cartridge_delete",
          //                   label: get_lang_param("Delete"),
          //                   cssClass: "btn-sm btn-danger",
          //                 }],
          //                 onhidden: function(){
          //                   table_cartridge.rows().deselect();
          //                   eq_one_id=[];
          //                 }
          //               });
          //         dialog_cartridge_del.open();
          //       }
          //       else {
          //         BootstrapDialog.alert({
          //         title: get_lang_param("Er_title"),
          //         message: get_lang_param("Er_msg2"),
          //         type: BootstrapDialog.TYPE_WARNING,
          //         draggable: true
          //         });
          //       }
          //   }
          //
          // },
          {
                extend: 'collection',
                text: function(a){return a.i18n("Print","Print")},
                autoClose: true,
                "buttons":[
              {
                extend: 'print',
                text: function(a){return a.i18n("PrintAll","Print All")},
                exportOptions: {
                    stripHtml: false,
                    columns: ':visible'
                },
                customize:function(a) {
                  $(a.document.body).find('th').addClass('center_header');
                }
              },
              {
                extend: 'print',
                text: function(a){return a.i18n("PrintSelected","Print Selected")},
                exportOptions: {
                    stripHtml: false,
                    modifier:{
                    selected: true
                    }
                },
                customize:function(a) {
                  $(a.document.body).find('th').addClass('center_header');
                }
              }
                ]
          },
              {
                extend: 'colvis',
                autoClose: false,
                postfixButtons: [ 'colvisRestore' ]
                },
                {
                text: function(a){return a.i18n("Update","Update")},
                action: function () {
                table_cartridge.ajax.reload();
                  }
                }
        ],
"language": {
        "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#table_cartridge tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
$('body').on('click', 'button#table_cartridge_clear', function(event) {
                  event.preventDefault();
                  table_cartridge.search('').draw();
                  $('#printid_fast').val('').trigger('chosen:updated');
                  $("#table_cartridge_clear").blur();
                });
                if (table_cartridge.search() !== ''){
                table_cartridge.search('').draw();
              }
// Быстрое редактирование картриджей диалог
$('#table_cartridge tbody').on( 'click', 'button#fast_edit', function () {
        var data = table_cartridge.row( $(this).parents('tr') ).data();
        window.id_fast_edit = data[1];
        window.dialog_cartridge_fast_edit = new BootstrapDialog({
                title: get_lang_param("Cartridge_fast_edit_title"),
                message: function(dialogRef) {
                var $message = $('<div></div>');
                var data = $.ajax({
                url: ACTIONPATH,
                type: 'POST',
                data: "mode=dialog_cartridge_fast_edit" +
                "&id=" + id_fast_edit,
                context: {
                theDialogWeAreUsing: dialogRef
                },
                success: function(content) {
                this.theDialogWeAreUsing.setMessage(content);
                }
                });
                return $message;
                },
                nl2br: false,
                closable: true,
                draggable: true,
                closeByBackdrop: false,
                closeByKeyboard: false,
                onshown: function(){
                  my_select();
                  my_select2();
                },
              });
              dialog_cartridge_fast_edit.realize();
        dialog_cartridge_fast_edit.open();
    } );
// Удаление картриджей диалог
$('#table_cartridge tbody').on( 'click', 'button#cart_delete', function () {
        var data = table_cartridge.row( $(this).parents('tr') ).data();
        window.id_del = data[1];
        window.dialog_cartridge_del = new BootstrapDialog({
                title: get_lang_param("License_delete"),
                message: get_lang_param("Info_del2"),
                type: BootstrapDialog.TYPE_DANGER,
                cssClass: 'del-dialog',
                closable: true,
                draggable: true,
                closeByBackdrop: false,
                closeByKeyboard: false,
                buttons:[{
                  id: "cartridge_delete",
                  label: get_lang_param("Delete"),
                  cssClass: " btn-danger",
                }],
              });
        dialog_cartridge_del.open();
});
$('#table_cartridge tbody').on( 'click', 'tr.group', function () {
       var currentOrder = table_cartridge.order()[0];
       if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
           table_cartridge.order( [ 2, 'desc' ] ).draw();
       }
       else {
           table_cartridge.order( [ 2, 'asc' ] ).draw();
       }
   } );
$('#table_cartridge tbody').on( 'click', 'tr', function () {
     var data = table_cartridge.row( this ).data();
     if (data[0] === 'not_active'){
       if ( $(this).hasClass('selected') ) {
           $(this).addClass('row_active');
       }
       else {
          table_cartridge.$('tr.row_active').removeClass('row_active');
       }
     }
   } );
  table_cartridge.on('select', function(e, dt, type, indexes ){
       var data = table_cartridge.row( indexes ).data();
        eq_one_id=data[1];
        table_cartridge_uchet.ajax.reload();
   })

// ***** История выдачи картриджей*****
var table_cartridge_uchet = $('#table_cartridge_uchet').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "cartridge_uchet",
"id": function(){return eq_one_id;}
       }
},
"pading":false,
"deferRender":true,
"responsive":false,
"scrollY": 200,
"scrollCollapse": true,
"scroller": true,
"sScrollX": "100%",
"sScrollXInner": "100%",
"stateSave":true,
"searching":false,
"bLengthChange": false,
"select":{
   "style": "os"
         },
fnRowCallback: function( nRow ) {
               $('[data-toggle="tooltip"]', nRow).tooltip({container: 'body', html:true});
             },
"aoColumns": [
                 {"className": "center_table"},
                 null,
                 null,
                 {"className": "center_table"},
                 null,
                 {"bSortable":false,"className": "center_table"}
               ],
"aoColumnDefs": [
                        { "sType": 'de_date', "aTargets": 1 }
                      ],
"sDom": "<'row'<'col-sm-8'B><'col-sm-4'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
     {
           extend: 'collection',
           text: function(a){return a.i18n("Print","Print")},
           autoClose: true,
           "buttons":[
         {
           extend: 'print',
           text: function(a){return a.i18n("PrintAll","Print All")},
           exportOptions: {
                stripHtml: false,
               columns: ':visible'
           },
           customize:function(a) {
             $(a.document.body).find('th').addClass('center_header');
           }
         },
         {
           extend: 'print',
           text: function(a){return a.i18n("PrintSelected","Print Selected")},
           exportOptions: {
                stripHtml: false,
               modifier:{
               selected: true
               }
           },
           customize:function(a) {
             $(a.document.body).find('th').addClass('center_header');
           }
         }
           ]
     },
    //  {
    //    text: function(a){return a.i18n("Delete","Delete")},
    //    action: function( e, dt, node, config ){
    //      var $rows = table_cartridge_uchet.$('tr.selected');
    //        if ($rows.length > '0'){
    //          window.dialog_cartridge_uchet_del = new BootstrapDialog({
    //                  title: get_lang_param("License_delete"),
    //                  message: get_lang_param("Info_del"),
    //                  cssClass: 'del-dialog',
    //                  closable: true,
    //                  draggable: true,
    //                  closeByBackdrop: false,
    //                  closeByKeyboard: false,
    //                  buttons:[{
    //                    id: "cartridge_uchet_delete",
    //                    label: get_lang_param("Delete"),
    //                    cssClass: "btn-sm btn-danger",
    //                  }],
    //                  onhidden: function(){
    //                    table_cartridge_uchet.rows().deselect();
    //                    uchet_one_id=[];
    //                  }
    //                });
    //          dialog_cartridge_uchet_del.open();
    //        }
    //        else {
    //          BootstrapDialog.alert({
    //          title: get_lang_param("Er_title"),
    //          message: get_lang_param("Er_msg2"),
    //          type: BootstrapDialog.TYPE_WARNING,
    //          draggable: true
    //          });
    //        }
    //    }
     //
    //  },
     {
     text: function(a){return a.i18n("Update","Update")},
     action: function () {
     table_cartridge_uchet.ajax.reload();
       }
     }
   ],
"language": {
               "url": MyHOSTNAME + "lang/lang-" + lang +".json"
               }
});
$('#table_cartridge_uchet tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
// Удаление из истории
$('#table_cartridge_uchet tbody').on( 'click', 'button#history_cart_delete', function () {
           var data = table_cartridge_uchet.row( $(this).parents('tr') ).data();
           window.id_uchet = data[0];
           window.dialog_cartridge_uchet_del = new BootstrapDialog({
                   title: get_lang_param("License_delete"),
                   message: get_lang_param("Info_del2"),
                   type: BootstrapDialog.TYPE_DANGER,
                   cssClass: 'del-dialog',
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   buttons:[{
                     id: "cartridge_uchet_delete",
                     label: get_lang_param("Delete"),
                     cssClass: " btn-danger",
                   }],
                   onhidden: function(){
                     table_cartridge_uchet.rows().deselect();
                     uchet_one_id=[];
                   }
                 });
           dialog_cartridge_uchet_del.open();
});

// ***** Накладная *****
$("#invoice_table").on('click', function(){
  $('#userid').change(function(){
    if ($(this).val().length > 0){
      $('#invoice_grp').removeClass('has-error');
  }
  });
if ($("#userid").val().length > 0){
$('#invoice_show').show("slow");
$("#invoice_table").blur();
// var userid = $("#userid").val();
// var userid2 = $("#userid2").val();
// var userid3 = $("#userid3").val();

if (! $.fn.DataTable.isDataTable('#invoice')){
window.table_invoice = $('#invoice').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "table_invoice",
"userid" : function(){return $("#userid").val();}
}
},
"pading":false,
"deferRender":true,
"responsive":false,
"bPaginate": false,
"bAutoWidth": true,
"stateSave":true,
"searching":true,
"bLengthChange": false,
// "bDestroy": true,
"select":{
        "style": "multi"
          },
"aoColumns": [
                  {"visible":false,"bSearchable":false},
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  {"bSearchable":false,"bSortable":false,"mRender": render_checkbox, "className": "center_table"},
                  {"bSearchable":false,"bSortable":false,"mRender": render_checkbox, "className": "center_table"},
                  null
              ],
"sDom": "<'row'<'col-sm-8'B><'col-sm-4'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
  {
          text: function(a){return a.i18n("Print_r","Print")},
          action: function( e, dt, node, config ){
            var $rows = table_invoice.$('tr.selected');
              if ($rows.length > '0'){
                var newWin = window.open();
                  $.ajax({
                    url: ACTIONPATH,
                    type: 'POST',
                    async: false,
                    data: "mode=invoice_print" +
                    "&id=" + arrList_inv +
                    "&userid=" + encodeURIComponent($("#userid").val()) +
                    "&userid2=" + encodeURIComponent($("#userid2").val()) +
                    "&userid3=" + encodeURIComponent($("#userid3").val()),
                    success: function(html) {
                      newWin.document.write(html);
                      // newWin.document.close();
                      // newWin.focus();
                      // newWin.print();
                      // newWin.close();
                    }
                  });
              }
            else {
              BootstrapDialog.alert({
              title: get_lang_param("Er_title"),
              message: get_lang_param("Er_msg2"),
              type: BootstrapDialog.TYPE_WARNING,
              draggable: true
              });
            }
          }
  },
  {
          extend: 'collection',
          text: function(a){return a.i18n("Save","Save")},
          autoClose: true,
          "buttons":[
        {
          extend: 'excelHtml5',
          title: 'Data export',
          exportOptions: {
              columns: ':visible',
              orthogonal: 'checkbox'
          }
        },
        {
          extend: 'pdfHtml5',
          download: 'open',
          orientation: 'landscape',
          pageSize: 'A3',
          title: 'Data export',
          exportOptions: {
              columns: ':visible',
              orthogonal: 'checkbox'
          }
        },
        {
        extend:'copyHtml5'
        },
    ]
  },
  {
    text: function(a){return a.i18n("Selectall","Select All")},
    action: function(){
    table_invoice.rows().select();
    arrList_inv=[];
    var data = table_invoice.rows('.selected').data()
    $.each(data, function(i, val){
      arrList_inv.push(val[0]);
    })
    }
  },
  {
      text: function(a){return a.i18n("Deselect","Deselect")},
      action: function () {
          table_invoice.rows().deselect();
          arrList_inv = [];
      }
  }
],
"language": {
              "url": MyHOSTNAME + "lang/lang-" + lang +".json"
                  }
      });
      $('#table_invoice tbody').on( 'dblclick','td', function () {
        var d = $(this).attr({
          'id':'select_copy',
          'data-container':'body',
          'data-toggle':'popover',
          'data-placement':'bottom',
          'data-html': 'true',
          'data-content':get_lang_param("Copy_to_clipboard")
        });
        var ch_copy = selectText('select_copy');
        //console.log(ch_copy);
        if (ch_copy == true){
        document.execCommand("copy");
        $("#select_copy").popover('show')
        // Copy_to_clipboard_dialog.open()
        setTimeout(function(){
            $("#select_copy").popover('destroy');
            // Copy_to_clipboard_dialog.close()
            $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
          },800);
          }
      } );
      var arrList_inv = new Array();
        table_invoice.on('select', function(e, dt, type, indexes ){
             var data = table_invoice.row( indexes ).data();
              arrList_inv.push(data[0]);
              // console.log(arrList_inv);
         }).on( 'deselect', function ( e, dt, type, indexes ) {
            var data = table_invoice.row( indexes ).data();
              arrList_inv = $.grep(arrList_inv, function(value){
                return value != data[0];
              })
            })
          }
          else {
            table_invoice.ajax.reload();
          }
          }
          else{
            $("#invoice_p").popover('show');
            $('#invoice_grp').addClass('has-error');
            setTimeout(function(){$("#invoice_p").popover('hide');},2000);
          }
});
// ***** Отчеты *****
// $('#us').on('click',function(){
//   document.getElementById('gr').disabled=(this.checked)?1:0;
// });
// $('#gr').on('click',function(){
//   document.getElementById('us').disabled=(this.checked)?1:0;
// });
$('#clear_user').on('click',function(){
  $("#userid").val('null').trigger("chosen:updated");
});
$('#clear_org').on('click',function(){
  $("#orgid").val('null').trigger("chosen:updated");
}); 
$('#clear_places').on('click',function(){
  $("#placesid").val('null').trigger("chosen:updated");
});
$('#clear_group').on('click',function(){
  $("#groupid").val('null').trigger("chosen:updated");
});   
$('#name_poisk').on('click',function(){
  // Clear();
  shtr.value='';
  buhn.value='';
  ser.value='';
  nakl.value='';
}).focus(function(){
  $(this).delay(13).carettToEnd();
});
$('#shtr').on('click',function(){
  // Clear();
  name_poisk.value='';
  buhn.value='';
  ser.value='';
  nakl.value='';
}).focus(function(){
  $(this).delay(13).carettToEnd().focus();
});
$('#ser').on('click',function(){
  // Clear();
  shtr.value='';
  buhn.value='';
  name_poisk.value='';
  nakl.value='';
}).focus(function(){
  $(this).delay(13).carettToEnd();
});
$('#buhn').on('click',function(){
  // Clear();
  shtr.value='';
  name_poisk.value='';
  ser.value='';
  nakl.value='';
}).focus(function(){
  $(this).delay(13).carettToEnd();
});
$('#nakl').on('click',function(){
  // Clear();
  shtr.value='';
  buhn.value='';
  ser.value='';
  name_poisk.value='';
}).focus(function(){
  $(this).delay(13).carettToEnd();
});    
  $('#view-source').on('click', function(event) {       
  event.preventDefault();
  if ($('.dop').css('display') == 'none'){
    $("i.fa-plus").removeClass("fa-plus").addClass("fa-minus");        
  }
  if ($('.dop').css('display') == 'block'){
    $("i.fa-minus").removeClass("fa-minus").addClass("fa-plus");        
  }
  // console.log($('.dop').is(":visible"));    
  $('.dop').toggle('slow');
  });
// function Clear() {
//     name_poisk.value=''
//     shtr.value='';
//     buhn.value='';
//     ser.value='';
//     nakl.value='';
// };
window.check_gr = {gr:false, us:false};
var arrList_shtr = new Array();
$("#report_table").on('click', function(){
            $('#report_show').show("slow");
            $('#report_move_show').show("slow");
            $("#report_table").blur();
            arrList_shtr = [];
// var sel_rep = $("#sel_rep").val();
// var userid_rep = $("#userid").val();
// var placesid = $("#placesid").val();
// var orgid = $("#orgid").val();
// var shtr = $("#shtr").val();
// var buhn = $("#buhn").val();
// var ser = $("#ser").val();
// var name_poisk = $("#name_poisk").val();
// var nakl = $("#nakl").val();
// var repair = $("#repair").prop('checked');
// var os = $("#os").prop('checked');
// var mode = $("#mode").prop('checked');
// var bum = $("#bum").prop('checked');
// console.log(userid_rep);
if (! $.fn.DataTable.isDataTable('#report')){
window.table_report = $('#report').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "table_report",
"sel_rep" : function(){return $("#sel_rep").val();},
"userid" : function(){return $("#userid").val();},
"placesid" : function(){return $("#placesid").val();},
"groupid" : function(){return $("#groupid").val();},
"orgid" : function(){return $("#orgid").val();},
"shtr" : function(){return $("#shtr").val();},
"buhn" : function(){return $("#buhn").val();},
"ser" : function(){return $("#ser").val();},
"name_poisk" : function(){return $("#name_poisk").val();},
"nakl" : function(){return $("#nakl").val();},
"repair" : function(){return $("#repair").prop('checked');},
"os" : function(){return $("#os").prop('checked');},
"mode_eq" : function(){return $("#mode").prop('checked');},
"bum" : function(){return $("#bum").prop('checked');},
"dtpost_report" : function(){return $("#dtpost_report").val();},
}
},
"pading":false,
"deferRender":true,
"responsive":false,
"bPaginate": false,
"scrollY": 400,
"sScrollX": "100%",
"sScrollXInner": "100%",
"scrollCollapse":true,
"scroll":true,
"bAutoWidth": true,
"stateSave":true,
"searching":true,
"bLengthChange": false,
// "bDestroy": true,
"select":{
        "style": "multi"
          },
"aaSorting" : [[10, 'asc']],
"drawCallback": function ( settings ) {
                if ($('#us').prop('checked') === true){
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
                api.column(10, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                $(rows).eq( i ).before(
                '<tr class="group"><td colspan="18" class="group_text">'+group+'</td></tr>'

              );
                last = group;
                }
            } );
          }
          else if ($('#gr').prop('checked') === true){
          var api = this.api();
          var rows = api.rows( {page:'current'} ).nodes();
          var last=null;
          api.column(3, {page:'current'} ).data().each( function ( group, i ) {
          if ( last !== group ) {
          $(rows).eq( i ).before(
          '<tr class="group"><td colspan="18" class="group_text">'+group+'</td></tr>'

        );
          last = group;
          }
      } );
    }
    },
    fnInitComplete: function() {
      $('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});
    },
"aoColumns": [
                  {"visible":false,"bSearchable":false},
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  {"visible":false},
                  {"bSearchable":false,"bSortable":false,"mRender": render_checkbox, "className": "center_table"},
                  {"bSearchable":false,"bSortable":false,"mRender": render_checkbox, "className": "center_table"},
                  {"bSearchable":false,"bSortable":false,"mRender": render_checkbox, "className": "center_table"},
                  null,
                  null,
                  {"visible":false}
              ],
"aoColumnDefs":[
              { "sType": 'de_date', "aTargets": 11 }
],
"sDom": "<'row'<'col-sm-12'f><'col-sm-12'B>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
  {
    text: function(a){return a.i18n("Grouping_group","Grouping Group")},
    action: function(){
      document.getElementById('gr').click();
    }
  },
  {
    text: function(a){return a.i18n("Grouping_users","Grouping Users")},
    action: function(){
      document.getElementById('us').click();
    }
  },
  {
    text: function(a){return a.i18n("Barcode_show","Barcode show")},
    action: function( e, dt, node, config ){
      var $rows = table_report.$('tr.selected');
        if ($rows.length > '0'){
          var newWin = window.open();
            $.ajax({
              url: ACTIONPATH,
              type: 'POST',
              async: false,
              data: "mode=shtrih_print" +
              "&id=" + arrList_shtr,
              success: function(html) {
                newWin.document.write(html);
                // newWin.document.close();
                // newWin.focus();
                // newWin.print();
                // newWin.close();
              }
            });
        }
      else {
        BootstrapDialog.alert({
        title: get_lang_param("Er_title"),
        message: get_lang_param("Er_msg2"),
        type: BootstrapDialog.TYPE_WARNING,
        draggable: true
        });
      }
    }
  },
  {
          extend: 'collection',
          text: function(a){return a.i18n("Save","Save")},
          autoClose: true,
          "buttons":[

        {
          extend: 'excelHtml5',
          text: function(a){return a.i18n("buttons.excel_visibli","Excel visibli")},
          title: 'Data export',
          exportOptions: {
              columns: ':visible',
              orthogonal: 'checkbox'
          }
        },
        {
          extend: 'excelHtml5',
          text: function(a){return a.i18n("buttons.excel_all","Save all")},
          title: 'Data export',
          exportOptions:{
            orthogonal: 'checkbox'
          }
        },
        {
          extend: 'excelHtml5',
          text: function(a){return a.i18n("buttons.excel_visibli_selected","Excel Visibli Selected")},
          title: 'Data export',
          exportOptions: {
              columns: ':visible',
              orthogonal: 'checkbox',
              modifier:{
              selected: true
              }
          }
        },
        {
          extend: 'excelHtml5',
          text: function(a){return a.i18n("buttons.excel_all_selected","Save All Selected")},
          title: 'Data export',
          exportOptions:{
            orthogonal: 'checkbox',
            modifier:{
            selected: true
            }
          }
        },
        {
          extend: 'pdfHtml5',
          text: function(a){return a.i18n("buttons.pdf_visibli","PDF visible")},
          download: 'open',
          orientation: 'landscape',
          pageSize: 'A3',
          title: 'Data export',
          exportOptions: {
              columns: ':visible',
              orthogonal: 'checkbox'
          }

        },
        {
          extend: 'pdfHtml5',
          text: function(a){return a.i18n("buttons.pdf_all","PDF all")},
          download: 'open',
          orientation: 'landscape',
          pageSize: 'A1',
          title: 'Data export',
          exportOptions:{
            orthogonal: 'checkbox'
          }
        },
        {
          extend: 'pdfHtml5',
          text: function(a){return a.i18n("buttons.pdf_visibli_selected","Pdf Visible Selected")},
          download: 'open',
          orientation: 'landscape',
          pageSize: 'A1',
          title: 'Data export',
          exportOptions: {
              orthogonal: 'checkbox',
              columns: ':visible',
              modifier:{
              selected: true
              }
          }
        },
        {
          extend: 'pdfHtml5',
          text: function(a){return a.i18n("buttons.pdf_all_selected","Pdf All Selected")},
          download: 'open',
          orientation: 'landscape',
          pageSize: 'A1',
          title: 'Data export',
          exportOptions: {
              orthogonal: 'checkbox',
              modifier:{
              selected: true
              }
          }
        },
        {
        extend:'copyHtml5'
        },
    ]
  },
  {
        extend: 'collection',
        text: function(a){return a.i18n("Print","Print")},
        autoClose: true,
        "buttons":[
      {
        extend: 'print',
        text: function(a){return a.i18n("PrintAll","Print All")},
        exportOptions: {
            stripHtml: false,
            columns: ':visible'
        },
        customize:function(a) {
          $(a.document.body).find('th').addClass('center_header');
        }
      },
      {
        extend: 'print',
        text: function(a){return a.i18n("PrintSelected","Print Selected")},
        exportOptions: {
            stripHtml: false,
            columns: ':visible',
            modifier:{
            selected: true
            }
        },
        customize:function(a) {
          $(a.document.body).find('th').addClass('center_header');
        }
      }
        ]
  },
  {
    extend: 'colvis',
    autoClose: false,
    postfixButtons: [ 'colvisRestore' ]
    },
    {
      text: function(a){return a.i18n("Selectall","Select All")},
      action: function(){
      table_report.rows().select();
      arrList_shtr=[];
      var data = table_report.rows('.selected').data()
      $.each(data, function(i, val){
        arrList_shtr.push(val[0]);
      })
      }
    },
  {
      text: function(a){return a.i18n("Deselect","Deselect")},
      action: function () {
          table_report.rows().deselect();
          arrList_shtr = [];
      }
  }
],
"language": {
              "url": MyHOSTNAME + "lang/lang-" + lang +".json"
                  }
      });
      $('#report tbody').on( 'dblclick','td', function () {
        var d = $(this).attr({
          'id':'select_copy',
          'data-container':'body',
          'data-toggle':'popover',
          'data-placement':'bottom',
          'data-html': 'true',
          'data-content':get_lang_param("Copy_to_clipboard")
        });
        var ch_copy = selectText('select_copy');
        //console.log(ch_copy);
        if (ch_copy == true){
        document.execCommand("copy");
        $("#select_copy").popover('show')
        // Copy_to_clipboard_dialog.open()
        setTimeout(function(){
            $("#select_copy").popover('destroy');
            // Copy_to_clipboard_dialog.close()
            $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
          },800);
          }
      } );
$('body').on('click', 'button#report_clear', function(event) {
                event.preventDefault();
                table_report.search('').draw();
                $("#report_clear").blur();
          });
          if (table_report.search() !== ''){
          table_report.search('').draw();
        }
      $('#us').on('click', function(){
        if ($(this).prop('checked') === true){
          table_report.order( [ 10, 'asc' ] ).draw();
          table_report.column( 10 ).visible( false );
          table_report.button(0).disable();
      }
      else{
        table_report.column( 10 ).visible( true );
        table_report.order( [ 10, 'asc' ] ).draw();
        table_report.button(0).enable();
      }
      });
      $('#gr').on('click', function(){
        if ($(this).prop('checked') === true){
          table_report.order( [ 3, 'asc' ] ).draw();
          table_report.column( 3 ).visible( false );
          table_report.button(1).disable();
      }
      else{
        table_report.column( 3 ).visible( true );
        table_report.order( [10, 'asc'] ).draw();
        table_report.button(1).enable();
      }
      });

$('#report tbody').on( 'click', 'tr.group', function () {
  if ($('#us').prop('checked') === true){
             var currentOrder = table_report.order()[0];
             console.log(currentOrder);
             if ( currentOrder[0] === 10 && currentOrder[1] === 'asc' ) {
                 table_report.order( [ 10, 'desc' ] ).draw();
             }
             else {
                 table_report.order( [ 10, 'asc' ] ).draw();
             }
           }
  else if ($('#gr').prop('checked') === true){
            var currentOrder = table_report.order()[0];
            console.log(currentOrder);
            if ( currentOrder[0] === 3 && currentOrder[1] === 'asc' ) {
            table_report.order( [ 3, 'desc' ] ).draw();
              }
            else {
            table_report.order( [ 3, 'asc' ] ).draw();
            }
            }
  } );
      // var arrList_shtr = new Array();
        table_report.on('select', function(e, dt, type, indexes ){
             var data = table_report.row( indexes ).data();
             eq_one_id = data[0];
             console.log(eq_one_id);
             arrList_shtr.push(data[0]);
            table_eq_move_show_rep.ajax.reload();
         }).on( 'deselect', function ( e, dt, type, indexes ) {
            var data = table_report.row( indexes ).data();
              arrList_shtr = $.grep(arrList_shtr, function(value){
                return value != data[0];
              })
            })
          }
          else {
            table_report.ajax.reload();
          }
if (! $.fn.DataTable.isDataTable('#report_move_show_rep')){
window.table_eq_move_show_rep = $('#report_move_show_rep').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "eq_table_move_rep",
"move_eqid": function(){return eq_one_id;}
}
},
"pading":false,
"deferRender":true,
"responsive":false,
"scrollY": 200,
"sScrollX": "100%",
"sScrollXInner": "100%",
"scrollCollapse": true,
"scroller":true,
"stateSave":true,
"searching":false,
"bLengthChange": false,
"buttons" :false,
// "bDestroy": true,
"select":{
    "style": "os"
    },
"aaSorting" : [[1,"desc"]],
"aoColumns": [
              {"aTargets": [ 0 ],"visible": false,"bSortable": false},
              null,
              null,
              null,
              null,
              null,
              null,
              null,
              null,
              null,
              null
],
"aoColumnDefs": [
                { "sType": 'de_datetime', "aTargets": 1 }
],
"language": {
              "url": MyHOSTNAME + "lang/lang-" + lang +".json"
          }
          });
          $('#table_eq_move_show_rep tbody').on( 'dblclick','td', function () {
            var d = $(this).attr({
              'id':'select_copy',
              'data-container':'body',
              'data-toggle':'popover',
              'data-placement':'bottom',
              'data-html': 'true',
              'data-content':get_lang_param("Copy_to_clipboard")
            });
            var ch_copy = selectText('select_copy');
            //console.log(ch_copy);
            if (ch_copy == true){
            document.execCommand("copy");
            $("#select_copy").popover('show')
            // Copy_to_clipboard_dialog.open()
            setTimeout(function(){
                $("#select_copy").popover('destroy');
                // Copy_to_clipboard_dialog.close()
                $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
              },800);
              }
          } );
        }
        else {
          table_eq_move_show_rep.clear().draw();
        }
});

// ***** Список организаций *****
var table_org = $('#table_org').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "org_table"
        }
},
"pading":false,
"deferRender":true,
"responsive":false,
"sScrollX": "100%",
"sScrollXInner": "100%",
"stateSave":true,
"searching":true,
"bLengthChange": true,
"select":{
"style": "os"
          },
fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
    $('[data-toggle="tooltip"]', nRow).tooltip({container: 'body', html:true});
                if ( aData[0] == 'not_active' )
                {
                  $(nRow).css({'background-color': '#d9534f', 'color': '#fff'});
                }
},
"aaSorting" : [[1, 'asc']],
"aoColumns": [
              {"bSortable":false,"bSearchable":false,"mRender": render_active,"className": "center_table"},
              {"className": "center_table"},
              null,
              {"bSearchable":false,"bSortable":false,"className": "center_table"}
            ],
"sDom": "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
{
  text: function(a){return a.i18n("Add","Add")},
  action: function ( e, dt, node, config ) {
    window.dialog_org_add = new BootstrapDialog({
            title: get_lang_param("Org_add"),
            message: function(dialogRef) {
  var $message = $('<div></div>');
  var data = $.ajax({
  url: ACTIONPATH,
  type: 'POST',
  data: "mode=dialog_org_add",
  context: {
      theDialogWeAreUsing: dialogRef
  },
  success: function(content) {
  this.theDialogWeAreUsing.setMessage(content);
  }
  });
  return $message;
  },
            nl2br: false,
            cssClass: 'org_add_edit-dialog',
            closable: true,
            draggable: true,
            closeByBackdrop: false,
            closeByKeyboard: false,
            onshown: function(){
              $("#org").keyup(function(){
              if($(this).val().length > 0) {
              $('#org').popover('hide');
              $('#org_add_grp').removeClass('has-error');
              }
              else {
              $('#org_add_grp').addClass('has-error');
              }
              });
            },
          onhidden: function(){
            table_org.rows().deselect();
          }
        });
        dialog_org_add.open();
  }
},
  {
  text: function(a){return a.i18n("Update","Update")},
  action: function () {
  table_org.ajax.reload();
    }
  }
],
"language": {
            "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#table_org tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
$('body').on('click', 'button#table_org_clear', function(event) {
                  event.preventDefault();
                  table_org.search('').draw();
                  $("#table_org_clear").blur();
                });
                if (table_org.search() !== ''){
                table_org.search('').draw();
              }
// Редактирование организации
$('#table_org tbody').on( 'click', 'button#org_edit', function () {
           var data = table_org.row( $(this).parents('tr') ).data();
           window.id_org_edit = data[1];
           window.dialog_org_edit = new BootstrapDialog({
                   title: get_lang_param("Org_edit"),
                   message: function(dialogRef) {
         var $message = $('<div></div>');
         var data = $.ajax({
         url: ACTIONPATH,
         type: 'POST',
         data: "mode=dialog_org_edit" +
         "&id=" + id_org_edit,
         context: {
             theDialogWeAreUsing: dialogRef
         },
         success: function(content) {
         this.theDialogWeAreUsing.setMessage(content);
         }
         });
         return $message;
         },
                   nl2br: false,
                   cssClass: 'org_add_edit-dialog',
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   onshown: function(){
                     $("#org").keyup(function(){
                     if($(this).val().length > 0) {
                     $('#org').popover('hide');
                     $('#org_edit_grp').removeClass('has-error');
                     }
                     else {
                     $('#org_edit_grp').addClass('has-error');
                     }
                     });
                   }
               });
               dialog_org_edit.open();
});
// Удаление организации
$('#table_org tbody').on( 'click', 'button#org_del', function () {
           var data = table_org.row( $(this).parents('tr') ).data();
           window.id_org_delete = data[1];
           window.dialog_org_del = new BootstrapDialog({
                   title: get_lang_param("License_delete"),
                   message: get_lang_param("Info_del2"),
                   type: BootstrapDialog.TYPE_DANGER,
                   cssClass: 'del-dialog',
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   buttons:[{
                     id: "org_delete",
                     label: get_lang_param("Delete"),
                     cssClass: "btn-danger",
                   }],
                 });
           dialog_org_del.open();
});
$('#table_org tbody').on( 'click', 'tr', function () {
  var data = table_org.row( this ).data();
  if (data[0] === 'not_active'){
    if ( $(this).hasClass('selected') ) {
        $(this).addClass('row_active');
    }
    else {
        table_org.$('tr.row_active').removeClass('row_active');
    }
  }
} );

// ***** Список помещений *****
var table_places = $('#table_places').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "places_table"
        }
},
"pading":false,
"pagingType": "full_numbers",
"deferRender":true,
"responsive":false,
"sScrollX": "100%",
"sScrollXInner": "100%",
"stateSave":true,
"searching":true,
"bLengthChange": true,
"iDisplayLength": 10,
"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
"select":{
"style": "os"
          },
fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
    $('[data-toggle="tooltip"]', nRow).tooltip({container: 'body', html:true});
                if ( aData[0] == 'not_active' )
                {
                  $(nRow).css({'background-color': '#d9534f', 'color': '#fff'});
                }
},
"aaSorting" : [[1, 'asc']],
"aoColumns": [
              {"bSortable":false,"bSearchable":false,"mRender": render_active,"className": "center_table"},
              {"className": "center_table"},
              null,
              null,
              {"bSearchable":false,"bSortable":false}
            ],
"sDom": "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
{
  text: function(a){return a.i18n("Add","Add")},
  action: function ( e, dt, node, config ) {
    window.dialog_places_add = new BootstrapDialog({
            title: get_lang_param("Places_add"),
            message: function(dialogRef) {
  var $message = $('<div></div>');
  var data = $.ajax({
  url: ACTIONPATH,
  type: 'POST',
  data: "mode=dialog_places_add",
  context: {
      theDialogWeAreUsing: dialogRef
  },
  success: function(content) {
  this.theDialogWeAreUsing.setMessage(content);
  }
  });
  return $message;
  },
            nl2br: false,
            cssClass: 'places_add_edit-dialog',
            closable: true,
            draggable: true,
            closeByBackdrop: false,
            closeByKeyboard: false,
            onshown: function(){
              $("#places").keyup(function(){
              if($(this).val().length > 0) {
              $('#places').popover('hide');
              $('#places_add_grp').removeClass('has-error');
              }
              else {
              $('#places_add_grp').addClass('has-error');
              }
              });
            },
          onhidden: function(){
            table_places.rows().deselect();
          }
        });
        dialog_places_add.open();
  }
},
  {
  text: function(a){return a.i18n("Update","Update")},
  action: function () {
  table_places.ajax.reload();
  table_places_sub.clear().draw();
  eq_one_id=[];
    }
  }
],
"language": {
            "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#table_places tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
$('body').on('click', 'button#table_places_clear', function(event) {
                  event.preventDefault();
                  table_places.search('').draw();
                  table_places_sub.clear().draw();
                  $("#table_places_clear").blur();
                });
                if (table_places.search() !== ''){
                table_places.search('').draw();
              }
// Редактирование помещения диалого
$('#table_places tbody').on( 'click', 'button#places_edit', function () {
           var data = table_places.row( $(this).parents('tr') ).data();
           window.id_places_edit = data[1];
           window.dialog_places_edit = new BootstrapDialog({
                   title: get_lang_param("Places_edit"),
                   message: function(dialogRef) {
         var $message = $('<div></div>');
         var data = $.ajax({
         url: ACTIONPATH,
         type: 'POST',
         data: "mode=dialog_places_edit" +
         "&id=" + id_places_edit,
         context: {
             theDialogWeAreUsing: dialogRef
         },
         success: function(content) {
         this.theDialogWeAreUsing.setMessage(content);
         }
         });
         return $message;
         },
                   nl2br: false,
                   cssClass: 'places_add_edit-dialog',
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   onshown: function(){
                     $("#places").keyup(function(){
                     if($(this).val().length > 0) {
                     $('#places').popover('hide');
                     $('#places_edit_grp').removeClass('has-error');
                     }
                     else {
                     $('#places_edit_grp').addClass('has-error');
                     }
                     });
                   }
               });
               dialog_places_edit.open();
});
// Удаление помещения диалог
$('#table_places tbody').on( 'click', 'button#places_del', function () {
           var data = table_places.row( $(this).parents('tr') ).data();
           window.id_places_delete = data[1];
           window.dialog_places_del = new BootstrapDialog({
                   title: get_lang_param("License_delete"),
                   message: get_lang_param("Info_del2"),
                   type: BootstrapDialog.TYPE_DANGER,
                   cssClass: 'del-dialog',
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   buttons:[{
                     id: "places_delete",
                     label: get_lang_param("Delete"),
                     cssClass: "btn-danger",
                   }],
                 });
           dialog_places_del.open();
});
$('#table_places tbody').on( 'click', 'tr', function () {
  var data = table_places.row( this ).data();
  if (data[0] === 'not_active'){
    if ( $(this).hasClass('selected') ) {
        $(this).addClass('row_active');
    }
    else {
        table_places.$('tr.row_active').removeClass('row_active');
    }
  }
} );
table_places.on('select', function(e, dt, type, indexes ){
     var data = table_places.row( indexes ).data();
      eq_one_id=data[1];
      table_places_sub.ajax.reload();
 })

// ***** Список кто сидит в помещении *****
var table_places_sub = $('#table_places_sub').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "places_sub_table",
"id": function(){return eq_one_id;}
        }
},
"pading":false,
"deferRender":true,
"responsive":false,
"scrollY": 200,
"sScrollX": "100%",
"sScrollXInner": "100%",
"scrollCollapse": true,
"scroller":true,
"stateSave":true,
"searching":false,
"bLengthChange": false,
"select":{
"style": "os"
          },
"aaSorting" : [[0, 'asc']],
"aoColumns": [
              {"className": "center_table"},
              null,
              {"bSortable":false}
            ],
"language": {
            "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#table_places_sub tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
// ***** Список пользователей *****
function toggleType() {
    var obj = document.getElementById('pass');
    if (obj.type == 'text') {
        obj.type = 'password';

    } else {
        obj.type = 'text';
    }
}
function changeClass() {
    var cl = document.getElementById('show');
    if (cl.className  == 'fa fa-eye') {
        cl.className = 'fa fa-eye-slash';
    } else {
        cl.className = 'fa fa-eye';
    }
}
function change(index) {

    $('#dostup')
        .prop('selectedIndex',index)
        .trigger("chosen:updated");

}
$('body').on('click', 'button#show_pass', function(event) {
                  event.preventDefault();
                  toggleType();
                  changeClass();
                  $("#show_pass").blur();
                });
/// Пользователи
var table_users = $('#table_users').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "users_table"
        }
},
"pading":false,
"pagingType": "full_numbers",
"deferRender":true,
"responsive":false,
"sScrollX": "100%",
"sScrollXInner": "100%",
"stateSave":true,
"searching":true,
"bAutoWidth": true,
"bLengthChange": true,
"iDisplayLength": 10,
"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
"select":{
"style": "os"
          },
fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
  $('[data-toggle="tooltip"]', nRow).tooltip({container: 'body', html:true});

                if ( aData[0] == 'not_active' )
                {
                  $(nRow).removeClass('users_not_active').addClass('not_active');
                }
                // console.log(aData);
                if ( $.cookie('on_off_cookie') == '0' )
                {
                  table_users.button(2).disable();
                  table_users.button(1).enable();
                  $(nRow).addClass('users_not_active');
                }
                if ( $.cookie('on_off_cookie') == '1' ){
                table_users.button(1).disable();
                table_users.button(2).enable();
              }
},
"aaSorting" : [[3, 'asc']],
"aoColumns": [
              {"bSortable":false,"bSearchable":false,"mRender": render_active,"className": "center_table"},
              {"className": "center_table"},
              null,
              null,
              null,
              null,
              null,
              null,
              null,
              null,
              {"bSearchable":false,"className": "center_table"},
              {"bSearchable":false,"bSortable":false}
            ],
"sDom": "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
{
  text: function(a){return a.i18n("Add","Add")},
  action: function ( e, dt, node, config ) {
    window.dialog_users_add = new BootstrapDialog({
            title: get_lang_param("Users_add"),
            message: function(dialogRef) {
  var $message = $('<div></div>');
  var data = $.ajax({
  url: ACTIONPATH,
  type: 'POST',
  data: "mode=dialog_users_add",
  context: {
      theDialogWeAreUsing: dialogRef
  },
  success: function(content) {
  this.theDialogWeAreUsing.setMessage(content);
  }
  });
  return $message;
  },
            nl2br: false,
            closable: true,
            draggable: true,
            closeByBackdrop: false,
            closeByKeyboard: false,
            onshown: function(){
              my_select();
              my_select2();
              check_login();
              if ($('select#priv').val() == '0'){
                $("#permit_menu").val(['3-1', '3-2', '3-5', '3-6', '3-7']);
                $("#permit_menu").trigger("chosen:updated");
              }
              $('select#priv').on('change', function(){
                if ($(this).val() == "1"){
                  $("#permit_menu").val('');
                  $("#permit_menu").trigger("chosen:updated");
                  $("#menu_sh").hide();
                }
                else if ($(this).val() == "0"){
                  $("#permit_menu").val(['3-1', '3-2', '3-5', '3-6', '3-7']);
                  $("#permit_menu").trigger("chosen:updated");
                  $("#menu_sh").show();
                }
                else if ($(this).val() == "2"){
                  $("#permit_menu").val(['1-1', '3-1', '3-2', '3-3', '3-4', '3-5', '3-6', '3-7']);
                  $("#permit_menu").trigger("chosen:updated");
                  $("#menu_sh").show();
                }
              });
              $('body').on('click', 'button#user_name_gen', function() {
                   var un = str_rand();
                  $("#user_name").val(un);
                  $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: ACTIONPATH,
                  data: "mode=check_user_name"+
                  "&user_name="+un,
                  success: function(html) {
                  $.each(html, function(i, item) {
                  if (item.check_user_name_status === true) {
                  $("#user_name_grp").removeClass('has-error').addClass('has-success');
                  check_er.user_name = false;

                  }
                  else if (item.check_user_name_status === false) {
                    $('#user_name').popover('show');
                    $("#user_name_grp").removeClass('has-success').addClass('has-error');
                    setTimeout(function(){$("#user_name").popover('hide');},2000);
                    check_er.user_name = true;
                  }
                  }
                  );
                 }

                  });
                })
                check_user_name();
              $("#pass").keyup(function(){
              if($(this).val().length >= 3) {
              $('#pass').popover('hide');
              $('#pass_add_grp').removeClass('has-error').addClass('has-success');
              }
              else {
              $('#pass_add_grp').addClass('has-error');
              }
              });
              $("#fio").keyup(function(){
              if($(this).val().length >= 3) {
              $('#fio').popover('hide');
              $('#fio_add_grp').removeClass('has-error').addClass('has-success');
              }
              else {
              $('#fio_add_grp').addClass('has-error');
              }
              });
              check_email();
            },
          onhidden: function(){
            table_users.rows().deselect();
          }
        });
        dialog_users_add.realize();
        dialog_users_add.open();
  }
},
{
text: function(a){return a.i18n("Active_ok","Active ok")},
action: function () {
  $.cookie('on_off_cookie','1');
  table_users.ajax.reload();
  }
},
{
text: function(a){return a.i18n("Active_no","Active no")},
action: function () {
  $.cookie('on_off_cookie','0');
  table_users.ajax.reload();
  }
},
  {
  text: function(a){return a.i18n("Update","Update")},
  action: function () {
  table_users.ajax.reload();
    }
  },
  {
          extend: 'collection',
          text: function(a){return a.i18n("Save","Save")},
          autoClose: true,
          "buttons":[

        {
          extend: 'excelHtml5',
          text: function(a){return a.i18n("buttons.excel","Excel")},
          title: 'Data export',
          exportOptions: {
              columns: ':visible',
              orthogonal: 'checkbox'
          }
        },
        {
          extend: 'pdfHtml5',
          text: function(a){return a.i18n("buttons.pdf","PDF")},
          download: 'open',
          orientation: 'landscape',
          pageSize: 'A4',
          title: 'Data export',
          exportOptions: {
              columns: ':visible',
              orthogonal: 'checkbox'
          }

        },
        {
        extend:'copyHtml5'
        },
    ]
  },
],
"language": {
            "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#table_users tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
$('body').on('click', 'button#table_users_clear', function(event) {
                  event.preventDefault();
                  table_users.search('').draw();
                  $("#table_users_clear").blur();
                });
                if (table_users.search() !== ''){
                table_users.search('').draw();
              }

// Редактирование пользователя
$('#table_users tbody').on( 'click', 'button#users_edit', function () {
           var data = table_users.row( $(this).parents('tr') ).data();
           window.id_users_edit = data[1];
           window.dialog_users_edit = new BootstrapDialog({
                   title: get_lang_param("Users_edit"),
                   message: function(dialogRef) {
         var $message = $('<div></div>');
         var data = $.ajax({
         url: ACTIONPATH,
         type: 'POST',
         data: "mode=dialog_users_edit" +
         "&id=" + id_users_edit,
         context: {
             theDialogWeAreUsing: dialogRef
         },
         success: function(content) {
         this.theDialogWeAreUsing.setMessage(content);
         }
         });
         return $message;
         },
                   nl2br: false,
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   onshown: function(){
                     my_select();
                     my_select2();
                     if ($('select#priv').val() == "1"){
                       $("#menu_sh").hide();
                     }
                     $('select#priv').on('change', function(){
                       if ($(this).val() == "1"){
                         $("#permit_menu").val('');
                         $("#permit_menu").trigger("chosen:updated");
                         $("#menu_sh").hide();
                       }
                       else if ($(this).val() == "0"){
                         $("#permit_menu").val(['3-1', '3-2', '3-5', '3-6', '3-7']);
                         $("#permit_menu").trigger("chosen:updated");
                         $("#menu_sh").show();
                       }
                       else if ($(this).val() == "2"){
                         $("#permit_menu").val(['1-1', '3-1', '3-2', '3-3', '3-4', '3-5', '3-6', '3-7']);
                         $("#permit_menu").trigger("chosen:updated");
                         $("#menu_sh").show();
                       }
                     });
                     $('#on_off').change(function(){
                       if (this.value == '1')  {
                         change(this.selectedIndex);
                       }
                       else if ((this.value == '0') && (($('#dostup').val())=='1')) {
                         change(this.selectedIndex);
                       }
                     })
                     check_login();
                     $('body').on('click', 'button#user_name_gen', function() {
                          var un = str_rand();
                         $("#user_name").val(un);
                         $.ajax({
                         type: "POST",
                         dataType: "json",
                         url: ACTIONPATH,
                         data: "mode=check_user_name"+
                         "&user_name="+un,
                         success: function(html) {
                         $.each(html, function(i, item) {
                         if (item.check_user_name_status === true) {
                         $("#user_name_grp").removeClass('has-error').addClass('has-success');
                         check_er.user_name = false;

                         }
                         else if (item.check_user_name_status === false) {
                           $('#user_name').popover('show');
                           $("#user_name_grp").removeClass('has-success').addClass('has-error');
                           setTimeout(function(){$("#user_name").popover('hide');},2000);
                           check_er.user_name = true;
                         }
                         }
                         );
                        }

                         });
                       })
                       check_user_name();
                     $("#pass").keyup(function(){
                     if($(this).val().length >= 3) {
                     $('#pass').popover('hide');
                     $('#pass_edit_grp').removeClass('has-error').addClass('has-success');
                     }
                     else {
                     $('#pass_edit_grp').addClass('has-error');
                     }
                     });
                     $("#fio").keyup(function(){
                     if($(this).val().length >= 3) {
                     $('#fio').popover('hide');
                     $('#fio_edit_grp').removeClass('has-error').addClass('has-success');
                     }
                     else {
                     $('#fio_edit_grp').addClass('has-error');
                     }
                     });
                     check_email();
                     check_account();
                   }
               });
               dialog_users_edit.realize();
               dialog_users_edit.open();
});
// Редактирование профеля пользователя
$('#table_users tbody').on( 'click', 'button#users_profile', function () {
           var data = table_users.row( $(this).parents('tr') ).data();
           window.id_users_profile = data[1];
           window.dialog_users_profile = new BootstrapDialog({
                   message: function(dialogRef) {
         var $message = $('<div></div>');
         var data = $.ajax({
         url: ACTIONPATH,
         type: 'POST',
         data: "mode=dialog_users_profile" +
         "&id=" + id_users_profile,
         context: {
             theDialogWeAreUsing: dialogRef
         },
         success: function(content) {
         this.theDialogWeAreUsing.setMessage(content);
         }
         });
         return $message;
         },
                   nl2br: false,
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   onshown: function(){
                     img_users();
                     my_select();
                     check_email();
                     $('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});
                     dialog_users_profile.setTitle(Fio);
                     $("#birthday").datepicker({
                       format: 'dd.mm.yyyy',
                       autoclose: true,
                       language: lang,
                       todayBtn: "linked",
                       clearBtn: false,
                     });
                     $("#mobile").mask("+7 (999) 999-99-99");
                   }
               });
               dialog_users_profile.realize();
               dialog_users_profile.open();
});
// Удаление пользователя
$('#table_users tbody').on( 'click', 'button#users_del', function () {
           var data = table_users.row( $(this).parents('tr') ).data();
           window.id_users_delete = data[1];
           window.dialog_users_del = new BootstrapDialog({
                   title: get_lang_param("Users_delete"),
                   message: get_lang_param("Info_del2"),
                   type: BootstrapDialog.TYPE_DANGER,
                   cssClass: 'del-dialog',
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   buttons:[{
                     id: "users_delete",
                     label: get_lang_param("Delete"),
                     cssClass: "btn-danger",
                   }],
                 });
           dialog_users_del.open();
});
$('#table_users tbody').on( 'click', 'tr', function () {
  var data = table_users.row( this ).data();
  if (data[0] === 'not_active'){
    if ( $(this).hasClass('selected') ) {
        $(this).addClass('row_active');
    }
    else {
        table_users.$('tr.row_active').removeClass('row_active');
    }
  }
  if ( $.cookie('on_off_cookie') == '0' ){
  if ($(this).is('.selected')){
    $(this).removeClass('users_not_active').addClass('row_active');
  }
  else{
    $(this).removeClass('row_active').addClass('users_not_active');
  }
}

});

// ***** Список контактов *****
var table_contact = $('#table_contact').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "contact_table"
        }
},
"pading":false,
"pagingType": "full_numbers",
"deferRender":true,
"responsive":false,
"sScrollX": "100%",
"sScrollXInner": "100%",
"stateSave":true,
"searching":true,
"bAutoWidth": true,
"bLengthChange": true,
"iDisplayLength": 10,
"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
"select":{
"style": "multi"
          },
"fnDrawCallback": function (nRow){
    $('[data-toggle="tooltip"]', nRow).tooltip({container: 'body', html:true});
  // if ((userid != 1) && (userid != 60) && (userid != 79)){
  if ((Admin !== true) && (permit_users_cont.indexOf(userid) == -1)){
    table_contact.buttons('.Edit_profile').remove();
    // table_eq_move.buttons().destroy();
    // table_eq_move.button(0).remove();
// console.log(Admin);

  }
},
"aaSorting" : [[2, 'asc']],
"aoColumns": [
              {"bSortable":false,"bSearchable":false,"visible":false},
              null,
              null,
              null,
              null,
              null,
              null
            ],
"aoColumnDefs":[
              { "sType": 'de_date', "aTargets": 6 }
],
"sDom": "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
{
  text: function(a){return a.i18n("Edit","Edit")},
  className: 'Edit_profile',
  action: function ( e, dt, node, config ) {
    var $rows = table_contact.$('tr.selected');
      if ($rows.length == '1'){
        window.dialog_users_profile = new BootstrapDialog({
                message: function(dialogRef) {
      var $message = $('<div></div>');
      var data = $.ajax({
      url: ACTIONPATH,
      type: 'POST',
      data: "mode=dialog_users_profile_cont" +
      "&id=" + array_cont,
      context: {
          theDialogWeAreUsing: dialogRef
      },
      success: function(content) {
      this.theDialogWeAreUsing.setMessage(content);
      }
      });
      return $message;
      },
                nl2br: false,
                closable: true,
                draggable: true,
                closeByBackdrop: false,
                closeByKeyboard: false,
                onshown: function(){
                  img_users();
                  my_select();
                  check_email();
                  $('[data-toggle="tooltip"]').tooltip({container: 'body', html:true});
                  dialog_users_profile.setTitle(Fio);
                  $("#birthday").datepicker({
                    format: 'dd.mm.yyyy',
                    autoclose: true,
                    language: lang,
                    todayBtn: "linked",
                    clearBtn: false,
                  });
                  $("#mobile").mask("+7 (999) 999-99-99");
                },
                onhidden: function(){
                  table_contact.rows().deselect();
                  array_cont=[];
                }
            });
            dialog_users_profile.realize();
            dialog_users_profile.open();
}
  else if ($rows.length > '1') {
    BootstrapDialog.alert({
    title: get_lang_param("Er_title"),
    message: get_lang_param("Er_msg1"),
    type: BootstrapDialog.TYPE_WARNING,
    draggable: true
    });
  }
  else {
    BootstrapDialog.alert({
    title: get_lang_param("Er_title"),
    message: get_lang_param("Er_msg2"),
    type: BootstrapDialog.TYPE_WARNING,
    draggable: true
    });
  }
  }
  },
{
        extend: 'collection',
        text: function(a){return a.i18n("Save","Save")},
        autoClose: true,
        "buttons":[

      {
        extend: 'excelHtml5',
        text: function(a){return a.i18n("buttons.excel","Excel")},
        title: 'Data export',
        exportOptions: {
            columns: ':visible',
            orthogonal: 'checkbox'
        }
      },
      {
        extend: 'pdfHtml5',
        text: function(a){return a.i18n("buttons.pdf","PDF")},
        download: 'open',
        orientation: 'landscape',
        pageSize: 'A4',
        title: 'Data export',
        exportOptions: {
            columns: ':visible',
            orthogonal: 'checkbox'
        }

      },
      {
      extend:'copyHtml5'
      },
  ]
},
{
      extend: 'collection',
      text: function(a){return a.i18n("Print","Print")},
      autoClose: true,
      "buttons":[
    {
      extend: 'print',
      text: function(a){return a.i18n("PrintAll","Print All")},
      exportOptions: {
          stripHtml: false,
          columns: ':visible'
      },
      customize:function(a) {
        $(a.document.body).find('th').addClass('center_header');
      }
    },
    {
      extend: 'print',
      text: function(a){return a.i18n("PrintSelected","Print Selected")},
      exportOptions: {
          stripHtml: false,
          modifier:{
          selected: true
          }
      },
      customize:function(a) {
        $(a.document.body).find('th').addClass('center_header');
      }
    },
    {
            text: function(a){return a.i18n("Print_contact","Print contact")},
            action: function( e, dt, node, config ){
                  var newWin = window.open();
                    $.ajax({
                      url: ACTIONPATH,
                      type: 'POST',
                      async: false,
                      data: "mode=contact_print",
                      success: function(html) {
                        newWin.document.write(html);
                        newWin.document.close();
                        newWin.focus();
                        newWin.print();
                        newWin.close();
                      }
                    });
            }
    },
      ]
},
  {
  text: function(a){return a.i18n("Update","Update")},
  action: function () {
  table_contact.ajax.reload();
    }
  },
  {
      text: function(a){return a.i18n("Deselect","Deselect")},
      action: function () {
          table_contact.rows().deselect();
          array_cont = [];
      }
  }
],
"language": {
            "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#table_contact tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
$('body').on('click', 'button#table_contact_clear', function(event) {
                  event.preventDefault();
                  table_contact.search('').draw();
                  $("#table_contact_clear").blur();
                });
                if (table_contact.search() !== ''){
                table_contact.search('').draw();
              }
var array_cont = new Array();
  table_contact.on('select', function(e, dt, type, indexes ){
    var data = table_contact.row( indexes ).data();
    array_cont.push(data[0]);
  }).on( 'deselect', function ( e, dt, type, indexes ) {
    var data = table_contact.row( indexes ).data();
    array_cont = $.grep(array_cont, function(value){
      return value != data[0];
    })
})

// ***** Список производителей *****
var table_vendors = $('#table_vendors').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "vendors_table"
        }
},
"pading":false,
"pagingType": "full_numbers",
"deferRender":true,
"responsive":false,
"sScrollX": "100%",
"sScrollXInner": "100%",
"stateSave":true,
"searching":true,
"bLengthChange": true,
"iDisplayLength": 10,
"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
"select":{
"style": "os"
          },
fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
    $('[data-toggle="tooltip"]', nRow).tooltip({container: 'body', html:true});
                if ( aData[0] == 'not_active' )
                {
                  $(nRow).css({'background-color': '#d9534f', 'color': '#fff'});
                }
},
"aaSorting" : [[2, 'asc']],
"aoColumns": [
              {"bSortable":false,"bSearchable":false,"mRender": render_active,"className": "center_table"},
              {"bSearchable":false,"className": "center_table"},
              null,
              null,
              {"bSearchable":false,"bSortable":false}
            ],
"sDom": "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
{
  text: function(a){return a.i18n("Add","Add")},
  action: function ( e, dt, node, config ) {
    window.dialog_vendors_add = new BootstrapDialog({
            title: get_lang_param("Vendors_add"),
            message: function(dialogRef) {
  var $message = $('<div></div>');
  var data = $.ajax({
  url: ACTIONPATH,
  type: 'POST',
  data: "mode=dialog_vendors_add",
  context: {
      theDialogWeAreUsing: dialogRef
  },
  success: function(content) {
  this.theDialogWeAreUsing.setMessage(content);
  }
  });
  return $message;
  },
            nl2br: false,
            cssClass: 'vendors_add_edit-dialog',
            closable: true,
            draggable: true,
            closeByBackdrop: false,
            closeByKeyboard: false,
            onshown: function(){
              $("#vendors").keyup(function(){
              if($(this).val().length > 0) {
              $('#vendors').popover('hide');
              $('#vendors_grp').removeClass('has-error');
              }
              else {
              $('#vendors_grp').addClass('has-error');
              }
              });
            },
          onhidden: function(){
            table_vendors.rows().deselect();
          }
        });
        dialog_vendors_add.open();
  }
},
  {
  text: function(a){return a.i18n("Update","Update")},
  action: function () {
  table_vendors.ajax.reload();
    }
  }
],
"language": {
            "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#table_vendors tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
$('body').on('click', 'button#table_vendors_clear', function(event) {
                  event.preventDefault();
                  table_vendors.search('').draw();
                  $("#table_vendors_clear").blur();
                });
                if (table_vendors.search() !== ''){
                  table_vendors.search('').draw();
                }
// Редактирование производителей диалог
$('#table_vendors tbody').on( 'click', 'button#vendors_edit', function () {
           var data = table_vendors.row( $(this).parents('tr') ).data();
           window.id_vendors_edit = data[1];
           window.dialog_vendors_edit = new BootstrapDialog({
                   title: get_lang_param("Vendors_edit"),
                   message: function(dialogRef) {
         var $message = $('<div></div>');
         var data = $.ajax({
         url: ACTIONPATH,
         type: 'POST',
         data: "mode=dialog_vendors_edit" +
         "&id=" + id_vendors_edit,
         context: {
             theDialogWeAreUsing: dialogRef
         },
         success: function(content) {
         this.theDialogWeAreUsing.setMessage(content);
         }
         });
         return $message;
         },
                   nl2br: false,
                   cssClass: 'vendors_add_edit-dialog',
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   onshown: function(){
                     $("#vendors").keyup(function(){
                     if($(this).val().length > 0) {
                     $('#vendors').popover('hide');
                     $('#vendors_grp').removeClass('has-error');
                     }
                     else {
                     $('#vendors_grp').addClass('has-error');
                     }
                     });
                   }
               });
               dialog_vendors_edit.open();
});
// Удаление производителей диалог
$('#table_vendors tbody').on( 'click', 'button#vendors_del', function () {
           var data = table_vendors.row( $(this).parents('tr') ).data();
           window.id_vendors_delete = data[1];
           window.dialog_vendors_del = new BootstrapDialog({
                   title: get_lang_param("License_delete"),
                   message: get_lang_param("Info_del2"),
                   type: BootstrapDialog.TYPE_DANGER,
                   cssClass: 'del-dialog',
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   buttons:[{
                     id: "vendors_delete",
                     label: get_lang_param("Delete"),
                     cssClass: "btn-danger",
                   }],
                 });
           dialog_vendors_del.open();
});
$('#table_vendors tbody').on( 'click', 'tr', function () {
  var data = table_vendors.row( this ).data();
  if (data[0] === 'not_active'){
    if ( $(this).hasClass('selected') ) {
        $(this).addClass('row_active');
    }
    else {
        table_vendors.$('tr.row_active').removeClass('row_active');
    }
  }
});

// ***** Список групп номенклатуры *****
var table_group_nome = $('#table_group_nome').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "group_nome_table"
        }
},
"pading":false,
"pagingType": "full_numbers",
"deferRender":true,
"responsive":false,
"sScrollX": "100%",
"sScrollXInner": "100%",
"stateSave":true,
"searching":true,
"bLengthChange": true,
"iDisplayLength": 10,
"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
"select":{
"style": "os"
          },
fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
    $('[data-toggle="tooltip"]', nRow).tooltip({container: 'body', html:true});
                if ( aData[0] == 'not_active' )
                {
                  $(nRow).css({'background-color': '#d9534f', 'color': '#fff'});
                }
},
"aaSorting" : [[2, 'asc']],
"aoColumns": [
              {"bSortable":false,"bSearchable":false,"mRender": render_active,"className": "center_table"},
              {"bSearchable":false,"className": "center_table"},
              null,
              null,
              {"bSearchable":false,"bSortable":false}
            ],
"sDom": "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
{
  text: function(a){return a.i18n("Add","Add")},
  action: function ( e, dt, node, config ) {
    window.dialog_group_nome_add = new BootstrapDialog({
            title: get_lang_param("Group_add"),
            message: function(dialogRef) {
  var $message = $('<div></div>');
  var data = $.ajax({
  url: ACTIONPATH,
  type: 'POST',
  data: "mode=dialog_group_nome_add",
  context: {
      theDialogWeAreUsing: dialogRef
  },
  success: function(content) {
  this.theDialogWeAreUsing.setMessage(content);
  }
  });
  return $message;
  },
            nl2br: false,
            cssClass: 'group_nome_add_edit-dialog',
            closable: true,
            draggable: true,
            closeByBackdrop: false,
            closeByKeyboard: false,
            onshown: function(){
              $("#vendors").keyup(function(){
              if($(this).val().length > 0) {
              $('#vendors').popover('hide');
              $('#vendors_grp').removeClass('has-error');
              }
              else {
              $('#vendors_grp').addClass('has-error');
              }
              });
            },
          onhidden: function(){
            table_group_nome.rows().deselect();
          }
        });
        dialog_group_nome_add.open();
  }
},
  {
  text: function(a){return a.i18n("Update","Update")},
  action: function () {
  table_group_nome.ajax.reload();
    }
  }
],
"language": {
            "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#table_group_nome tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
$('body').on('click', 'button#table_group_nome_clear', function(event) {
                  event.preventDefault();
                  table_group_nome.search('').draw();
                  $("#table_group_nome_clear").blur();
                });
                if (table_group_nome.search() !== ''){
                  table_group_nome.search('').draw();
                }
// Редактирование производителей диалог
$('#table_group_nome tbody').on( 'click', 'button#group_nome_edit', function () {
           var data = table_group_nome.row( $(this).parents('tr') ).data();
           window.id_group_nome_edit = data[1];
           window.dialog_group_nome_edit = new BootstrapDialog({
                   title: get_lang_param("Group_edit"),
                   message: function(dialogRef) {
         var $message = $('<div></div>');
         var data = $.ajax({
         url: ACTIONPATH,
         type: 'POST',
         data: "mode=dialog_group_nome_edit" +
         "&id=" + id_group_nome_edit,
         context: {
             theDialogWeAreUsing: dialogRef
         },
         success: function(content) {
         this.theDialogWeAreUsing.setMessage(content);
         }
         });
         return $message;
         },
                   nl2br: false,
                   cssClass: 'group_nome_add_edit-dialog',
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   onshown: function(){
                     $("#vendors").keyup(function(){
                     if($(this).val().length > 0) {
                     $('#vendors').popover('hide');
                     $('#vendors_grp').removeClass('has-error');
                     }
                     else {
                     $('#vendors_grp').addClass('has-error');
                     }
                     });
                   }
               });
               dialog_group_nome_edit.open();
});
// Удаление группы номенклатуры диалог
$('#table_group_nome tbody').on( 'click', 'button#group_nome_del', function () {
           var data = table_group_nome.row( $(this).parents('tr') ).data();
           window.id_group_nome_delete = data[1];
           window.dialog_group_nome_del = new BootstrapDialog({
                   title: get_lang_param("Group_delete"),
                   message: get_lang_param("Info_del2"),
                   type: BootstrapDialog.TYPE_DANGER,
                   cssClass: 'del-dialog',
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   buttons:[{
                     id: "group_nome_delete",
                     label: get_lang_param("Delete"),
                     cssClass: "btn-danger",
                   }],
                 });
           dialog_group_nome_del.open();
});
$('#table_group_nome tbody').on( 'click', 'tr', function () {
  var data = table_group_nome.row( this ).data();
  if (data[0] === 'not_active'){
    if ( $(this).hasClass('selected') ) {
        $(this).addClass('row_active');
    }
    else {
        table_group_nome.$('tr.row_active').removeClass('row_active');
    }
  }
});

// ***** Список номенклатуры *****
var table_nome = $('#table_nome').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "nome_table"
        }
},
"pading":false,
"pagingType": "full_numbers",
"deferRender":true,
"responsive":false,
"sScrollX": "100%",
"sScrollXInner": "100%",
"stateSave":true,
"searching":true,
"bLengthChange": true,
"iDisplayLength": 10,
"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
"select":{
"style": "os"
          },
fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
    $('[data-toggle="tooltip"]', nRow).tooltip({container: 'body', html:true});
                if ( aData[0] == 'not_active' )
                {
                  $(nRow).css({'background-color': '#d9534f', 'color': '#fff'});
                }
},
"aaSorting" : [[2, 'asc']],
"drawCallback": function ( settings ) {
      var api = this.api();
      var rows = api.rows( {page:'current'} ).nodes();
      var last=null;

      api.column(2, {page:'current'} ).data().each( function ( group, i ) {
          if ( last !== group ) {
              $(rows).eq( i ).before(
                  '<tr class="group"><td colspan="6" class="group_text">'+group+'</td></tr>'
              );

              last = group;
          }
      } );
  },
stateLoadCallback: function(){
  $.ajax({
  url:  ACTIONPATH,
  type: "POST",
  data:"mode=select_group",
  success: function(data){
    $('#table_nome_filter').prepend(data + '&nbsp;');
    my_select();
    $("#groupid_fast").change(function(){
      var select_nome = $("#groupid_fast option:selected").text();
      table_nome.search(select_nome).draw();
    });
}
});
},
"aoColumns": [
              {"bSortable":false,"bSearchable":false,"mRender": render_active,"className": "center_table"},
              {"className": "center_table"},
              null,
              null,
              null,
              {"bSearchable":false,"bSortable":false}
            ],
"sDom": "<'row'<'col-sm-2'l><'col-sm-4'B><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
{
  text: function(a){return a.i18n("Add","Add")},
  action: function ( e, dt, node, config ) {
    window.dialog_nome_add = new BootstrapDialog({
            title: get_lang_param("Nome_add"),
            message: function(dialogRef) {
  var $message = $('<div></div>');
  var data = $.ajax({
  url: ACTIONPATH,
  type: 'POST',
  data: "mode=dialog_nome_add",
  context: {
      theDialogWeAreUsing: dialogRef
  },
  success: function(content) {
  this.theDialogWeAreUsing.setMessage(content);
  }
  });
  return $message;
  },
            nl2br: false,
            closable: true,
            draggable: true,
            closeByBackdrop: false,
            closeByKeyboard: false,
            onshown: function(){
              my_select();
              $("#vendorid").change(function(){
              if($(this).val().length > 0) {
              $('#vendors_p').popover('hide');
              $('#vendors_grp').removeClass('has-error');
              }
              else {
              $('#vendors_grp').addClass('has-error');
              }
              });
              $("#groupid").change(function(){
              if($(this).val().length > 0) {
              $('#group_p').popover('hide');
              $('#group_grp').removeClass('has-error');
              }
              else {
              $('#group_grp').addClass('has-error');
              }
              });
              $("#namenome").keyup(function(){
              if($(this).val().length > 0) {
              $('#namenome').popover('hide');
              $('#namenome_grp').removeClass('has-error');
              }
              else {
              $('#namenome_grp').addClass('has-error');
              }
              });
            },
          onhidden: function(){
            table_nome.rows().deselect();
          }
        });
        dialog_nome_add.realize();
        dialog_nome_add.open();
  }
},
  {
  text: function(a){return a.i18n("Update","Update")},
  action: function () {
  table_nome.ajax.reload();
    }
  }
],
"language": {
            "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#table_nome tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
$('body').on('click', 'button#table_nome_clear', function(event) {
                  event.preventDefault();
                  table_nome.search('').draw();
                  $('#groupid_fast').val('').trigger('chosen:updated');
                  $("#table_nome_clear").blur();
                });
                if (table_nome.search() !== ''){
                table_nome.search('').draw();
              }
// Редактирование номенклатуры диалог
$('#table_nome tbody').on( 'click', 'button#nome_edit', function () {
           var data = table_nome.row( $(this).parents('tr') ).data();
           window.id_nome_edit = data[1];
           window.dialog_nome_edit = new BootstrapDialog({
                   title: get_lang_param("Nome_edit"),
                   message: function(dialogRef) {
         var $message = $('<div></div>');
         var data = $.ajax({
         url: ACTIONPATH,
         type: 'POST',
         data: "mode=dialog_nome_edit" +
         "&id=" + id_nome_edit,
         context: {
             theDialogWeAreUsing: dialogRef
         },
         success: function(content) {
         this.theDialogWeAreUsing.setMessage(content);
         }
         });
         return $message;
         },
                   nl2br: false,
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   onshown: function(){
                     my_select();
                     $("#vendorid").change(function(){
                     if($(this).val().length > 0) {
                     $('#vendors_p').popover('hide');
                     $('#vendors_grp').removeClass('has-error');
                     }
                     else {
                     $('#vendors_grp').addClass('has-error');
                     }
                     });
                     $("#groupid").change(function(){
                     if($(this).val().length > 0) {
                     $('#group_p').popover('hide');
                     $('#group_grp').removeClass('has-error');
                     }
                     else {
                     $('#group_grp').addClass('has-error');
                     }
                     });
                     $("#namenome").keyup(function(){
                     if($(this).val().length > 0) {
                     $('#namenome').popover('hide');
                     $('#namenome_grp').removeClass('has-error');
                     }
                     else {
                     $('#namenome_grp').addClass('has-error');
                     }
                     });
                   }
               });
               dialog_nome_edit.realize();
               dialog_nome_edit.open();
});
// Удаление номенклатуры диалог
$('#table_nome tbody').on( 'click', 'button#nome_del', function () {
           var data = table_nome.row( $(this).parents('tr') ).data();
           window.id_nome_delete = data[1];
           window.dialog_nome_del = new BootstrapDialog({
                   title: get_lang_param("License_delete"),
                   message: get_lang_param("Info_del2"),
                   type: BootstrapDialog.TYPE_DANGER,
                   cssClass: 'del-dialog',
                   closable: true,
                   draggable: true,
                   closeByBackdrop: false,
                   closeByKeyboard: false,
                   buttons:[{
                     id: "nome_delete",
                     label: get_lang_param("Delete"),
                     cssClass: "btn-danger",
                   }],
                 });
           dialog_nome_del.open();
});
$('#table_nome tbody').on( 'click', 'tr.group', function () {
       var currentOrder = table_nome.order()[0];
       if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
           table_nome.order( [ 2, 'desc' ] ).draw();
       }
       else {
           table_nome.order( [ 2, 'asc' ] ).draw();
       }
   } );
$('#table_nome tbody').on( 'click', 'tr', function () {
  var data = table_nome.row( this ).data();
  if (data[0] === 'not_active'){
    if ( $(this).hasClass('selected') ) {
        $(this).addClass('row_active');
    }
    else {
        table_nome.$('tr.row_active').removeClass('row_active');
    }
  }
} );

// ***** Список ревизитов *****
var table_requisites = $('#table_requisites').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "requisites_table"
        }
},
"pading":false,
"pagingType": "full_numbers",
"deferRender":true,
"responsive":false,
"sScrollX": "100%",
"sScrollXInner": "100%",
"stateSave":true,
"searching":true,
"bLengthChange": true,
"iDisplayLength": 10,
"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
"select":{
"style": "os"
          },
fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                if ( aData[0] == 'not_active' )
                {
                  $(nRow).css({'background-color': '#d9534f', 'color': '#fff'});
                }
                // if ((userid != 1) && (userid != 60) && (userid != 79) && (userid != 22)){
                if ((Admin !== true) && (permit_users_req.indexOf(userid) == -1)){
                  table_requisites.buttons().destroy();
            }
},
"aaSorting" : [[2, 'asc']],
"aoColumns": [
              {"bSortable":false,"bSearchable":false,"mRender": render_active,"className": "center_table"},
              {"className": "center_table","bSearchable":false,"visible":false},
              null,
              null,
              null,
              null,
              null,
              null
            ],
"sDom": "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
{
  text: function(a){return a.i18n("Add","Add")},
  action: function ( e, dt, node, config ) {
    window.dialog_requisites_add = new BootstrapDialog({
            title: get_lang_param("Requisites_add"),
            message: function(dialogRef) {
  var $message = $('<div></div>');
  var data = $.ajax({
  url: ACTIONPATH,
  type: 'POST',
  data: "mode=dialog_requisites_add",
  context: {
      theDialogWeAreUsing: dialogRef
  },
  success: function(content) {
  this.theDialogWeAreUsing.setMessage(content);
  }
  });
  return $message;
  },
            nl2br: false,
            closable: true,
            draggable: true,
            closeByBackdrop: false,
            closeByKeyboard: false,
            onshown: function(){
              $("#name_org").keyup(function(){
              if($(this).val().length > 3) {
              $('#name_org').popover('hide');
              $('#name_org_grp').removeClass('has-error');
              }
              else {
              $('#name_org_grp').addClass('has-error');
              }
              });
            },
          onhidden: function(){
            table_requisites.rows().deselect();
          }
        });
        dialog_requisites_add.realize();
        dialog_requisites_add.open();
  }
},
{
  text: function(a){return a.i18n("Edit","Edit")},
  action: function ( e, dt, node, config ) {
    window.dialog_requisites_edit = new BootstrapDialog({
            title: get_lang_param("Requisites_edit"),
            message: function(dialogRef) {
  var $message = $('<div></div>');
  var data = $.ajax({
  url: ACTIONPATH,
  type: 'POST',
  data: "mode=dialog_requisites_edit" +
  '&id=' + eq_one_id,
  context: {
      theDialogWeAreUsing: dialogRef
  },
  success: function(content) {
  this.theDialogWeAreUsing.setMessage(content);
  }
  });
  return $message;
  },
            nl2br: false,
            closable: true,
            draggable: true,
            closeByBackdrop: false,
            closeByKeyboard: false,
            onshown: function(){
              $("#name_org").keyup(function(){
              if($(this).val().length > 3) {
              $('#name_org').popover('hide');
              $('#name_org_grp').removeClass('has-error');
              }
              else {
              $('#name_org_grp').addClass('has-error');
              }
              });
            },
          onhidden: function(){
            table_requisites.rows().deselect();
          }
        });
        dialog_requisites_edit.realize();
        dialog_requisites_edit.open();
  }
},
{
    text:function(a){return a.i18n("Delete","Delete")},
    action: function ( e, dt, node, config ) {
      var $rows = table_requisites.$('tr.selected');
        if ($rows.length == '1'){
      window.dialog_requisites_del = new BootstrapDialog({
              title: get_lang_param("Requisites_delete"),
              message: get_lang_param("Info_del2"),
              type: BootstrapDialog.TYPE_DANGER,
              cssClass: 'del-dialog',
              closable: true,
              draggable: true,
              closeByBackdrop: false,
              closeByKeyboard: false,
              buttons:[{
                id: "requisites_delete",
                label: get_lang_param("Delete"),
                cssClass: "btn-danger",
              }],
            });
      dialog_requisites_del.open();
    }
    else {
      BootstrapDialog.alert({
      title: get_lang_param("Er_title"),
      message: get_lang_param("Er_msg2"),
      type: BootstrapDialog.TYPE_WARNING,
      draggable: true
      });
    }
  }
},
  {
  text: function(a){return a.i18n("Update","Update")},
  action: function () {
  table_requisites.ajax.reload();
    }
  }
],
"language": {
            "url": MyHOSTNAME + "lang/lang-" + lang +".json"
            }
});
$('#table_requisites tbody').on( 'dblclick','td', function () {
  var d = $(this).attr({
    'id':'select_copy',
    'data-container':'body',
    'data-toggle':'popover',
    'data-placement':'bottom',
    'data-html': 'true',
    'data-content':get_lang_param("Copy_to_clipboard")
  });
  var ch_copy = selectText('select_copy');
  //console.log(ch_copy);
  if (ch_copy == true){
  document.execCommand("copy");
  $("#select_copy").popover('show')
  // Copy_to_clipboard_dialog.open()
  setTimeout(function(){
      $("#select_copy").popover('destroy');
      // Copy_to_clipboard_dialog.close()
      $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
    },800);
    }
} );
$('body').on('click', 'button#table_requisites_clear', function(event) {
                  event.preventDefault();
                  table_requisites.search('').draw();
                  $("#table_requisites_clear").blur();
                });
                if (table_requisites.search() !== ''){
                table_requisites.search('').draw();
              }
table_requisites.on('select', function(e, dt, type, indexes ){
  var data = table_requisites.row( indexes ).data();
  eq_one_id=data[1];
  table_requisites_files.ajax.reload();
})

// ***** Список файлов реквизитов *****
var table_requisites_files = $('#table_requisites_files').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "requisites_files_table",
"id": function(){return eq_one_id;}
        }
},
"pading":false,
"deferRender":true,
"responsive":false,
"scrollY": 200,
"sScrollX": "100%",
"sScrollXInner": "100%",
"scrollCollapse": true,
"scroller":true,
"stateSave":true,
"searching":false,
"bLengthChange": false,
"select":{
"style": "multi"
      },
"fnDrawCallback": function (){
        // if ((userid != 1) && (userid != 60) && (userid != 79) && (userid != 22)){
        if ((Admin !== true) && (permit_users_req.indexOf(userid) == -1)){
          table_requisites_files.buttons().destroy();
    }
},
"aaSorting" : [[0, 'asc']],
"aoColumns": [
              {"className": "center_table"},
              null,
              null
],
"aoColumnDefs":[
        { "sType": 'de_date', "aTargets": 1 }
    ],
"sDom": "<'row'<'col-sm-12'B>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
{
  text:function(a){return a.i18n("Upload","Upload")},
  action: function ( e, dt, node, config ) {
    var $rows = table_requisites.$('tr.selected');
      if ($rows.length == '1'){
        $('#file_req').click();
      }
      else {
        BootstrapDialog.alert({
        title: get_lang_param("Er_title"),
        message: get_lang_param("Er_msg2"),
        type: BootstrapDialog.TYPE_WARNING,
        draggable: true
        });
      }
    }
},
{
    text:function(a){return a.i18n("Delete","Delete")},
    action: function ( e, dt, node, config ) {
      var $rows = table_requisites_files.$('tr.selected');
        if ($rows.length > '0'){
      window.dialog_requisites_files_del = new BootstrapDialog({
              title: get_lang_param("File_delete"),
              message: get_lang_param("Info_del"),
              type: BootstrapDialog.TYPE_DANGER,
              cssClass: 'del-dialog',
              closable: true,
              draggable: true,
              closeByBackdrop: false,
              closeByKeyboard: false,
              buttons:[{
                id: "requisites_file_delete",
                label: get_lang_param("Delete"),
                cssClass: "btn-danger",
              }],
            });
      dialog_requisites_files_del.open();
    }
    else {
      BootstrapDialog.alert({
      title: get_lang_param("Er_title"),
      message: get_lang_param("Er_msg2"),
      type: BootstrapDialog.TYPE_WARNING,
      draggable: true
      });
    }
  }
},
{
text: function(a){return a.i18n("Update","Update")},
action: function () {
table_requisites_files.ajax.reload();
  }
}
],
"language": {
            "url": MyHOSTNAME + "lang/lang-" + lang +".json"
}
});
var arrList_req = new Array();
  table_requisites_files.on('select', function(e, dt, type, indexes ){
       var data = table_requisites_files.row( indexes ).data();
        arrList_req.push(data[0]);
   }).on( 'deselect', function ( e, dt, type, indexes ) {
      var data = table_requisites_files.row( indexes ).data();
        arrList_req = $.grep(arrList_req, function(value){
          return value != data[0];
        })
      })
$('#file_req').on('change',function(){

    var file = this.files[0];
    var fileSize = file.size;
    var maxsize = $('input#file_size').val();
    var fileExtension = file_types;
    // var fileExtension = ['jpeg', 'jpg', 'doc', 'docx', 'xls', 'xlsx', 'pdf'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) !== -1){
    if (fileSize < maxsize){
    var form_data = new FormData();
    form_data.append('file', file);
    form_data.append('idrequisites', eq_one_id);

    $.ajax({
      url: MyHOSTNAME + "sys/uploadrequisites.php",
      type: "POST",
      dataType: 'text',
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      xhr: function() {
          waitingDialog.show(get_lang_param("Progress_file_upload"));
          var xhr = $.ajaxSettings.xhr();
          if (xhr.upload) {
              xhr.upload.addEventListener('progress', function(evt) {
                  var percent = Math.round((evt.loaded / evt.total) * 100);
                  // console.log(percent);
                  $("#progressbar").width(percent + "%");
                  $("#percent").html(percent + '%');
              }, false);
          }
          return xhr;
      },
      success: function(){
        $("#percent").html('100%');
        waitingDialog.hide();
        table_requisites_files.ajax.reload();
      }
    });
  }
  else{
    BootstrapDialog.alert({
    title: get_lang_param("Er_title"),
    message: get_lang_param("Er_msg_maxsize") + Math.round(maxsize/1024/1024) +'Mb',
    type: BootstrapDialog.TYPE_WARNING,
    draggable: true,
    callback: function(result) {
      // console.log(result);
      $('#file_req').val(null);
      }
    });
  }
}
else {
  BootstrapDialog.alert({
  title: get_lang_param("Er_title"),
  message: get_lang_param("Er_msg_type")  + '(' +file_types +')',
  type: BootstrapDialog.TYPE_WARNING,
  draggable: true,
  callback: function() {
    $('#file_req').val(null);
    }
  });
}
});

// ***** Список контрагентов *****
var table_knt = $('#table_knt').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "knt_table"
       }
},
"pading":false,
"pagingType": "full_numbers",
"deferRender":true,
"responsive":false,
"sScrollX": "100%",
"sScrollXInner": "100%",
"stateSave":true,
"searching":true,
"bLengthChange": true,
"iDisplayLength": 10,
"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
"select":{
"style": "os"
            },
fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                  if ( aData[0] == 'not_active' )
                  {
                    $(nRow).css({'background-color': '#d9534f', 'color': '#fff'});
                  }
                  // if ((userid != 1) && (userid != 63) && (userid != 22)){
                  if ((Admin !== true) && (permit_users_knt.indexOf(userid) == -1)){
                    table_knt.buttons().destroy();
              }
  },
"aaSorting" : [[2, 'asc']],
"aoColumns": [
                {"bSortable":false,"bSearchable":false,"mRender": render_active,"className": "center_table"},
                {"className": "center_table","bSearchable":false,"visible":false},
                null,
                null,
                null,
                null
              ],
"sDom": "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
  {
    text: function(a){return a.i18n("Add","Add")},
    action: function ( e, dt, node, config ) {
      window.dialog_knt_add = new BootstrapDialog({
              title: get_lang_param("Knt_add"),
              message: function(dialogRef) {
    var $message = $('<div></div>');
    var data = $.ajax({
    url: ACTIONPATH,
    type: 'POST',
    data: "mode=dialog_knt_add",
    context: {
        theDialogWeAreUsing: dialogRef
    },
    success: function(content) {
    this.theDialogWeAreUsing.setMessage(content);
    }
    });
    return $message;
    },
              nl2br: false,
              closable: true,
              draggable: true,
              closeByBackdrop: false,
              closeByKeyboard: false,
              onshown: function(){
                $("#name_knt").keyup(function(){
                if($(this).val().length > 3) {
                $('#name_knt').popover('hide');
                $('#name_knt_grp').removeClass('has-error');
                }
                else {
                $('#name_knt_grp').addClass('has-error');
                }
                });
              },
            onhidden: function(){
              table_knt.rows().deselect();
            }
          });
          dialog_knt_add.realize();
          dialog_knt_add.open();
    }
  },
  {
    text: function(a){return a.i18n("Edit","Edit")},
    action: function ( e, dt, node, config ) {
      window.dialog_knt_edit = new BootstrapDialog({
              title: get_lang_param("Knt_edit"),
              message: function(dialogRef) {
    var $message = $('<div></div>');
    var data = $.ajax({
    url: ACTIONPATH,
    type: 'POST',
    data: "mode=dialog_knt_edit" +
    '&id=' + eq_one_id,
    context: {
        theDialogWeAreUsing: dialogRef
    },
    success: function(content) {
    this.theDialogWeAreUsing.setMessage(content);
    }
    });
    return $message;
    },
              nl2br: false,
              closable: true,
              draggable: true,
              closeByBackdrop: false,
              closeByKeyboard: false,
              onshown: function(){
                $("#name_knt").keyup(function(){
                if($(this).val().length > 3) {
                $('#name_knt').popover('hide');
                $('#name_knt_grp').removeClass('has-error');
                }
                else {
                $('#name_knt_grp').addClass('has-error');
                }
                });
              },
            onhidden: function(){
              table_knt.rows().deselect();
            }
          });
          dialog_knt_edit.realize();
          dialog_knt_edit.open();
    }
  },
  {
      text:function(a){return a.i18n("Delete","Delete")},
      action: function ( e, dt, node, config ) {
        var $rows = table_knt.$('tr.selected');
          if ($rows.length == '1'){
        window.dialog_knt_del = new BootstrapDialog({
                title: get_lang_param("Knt_delete"),
                message: get_lang_param("Info_del2"),
                type: BootstrapDialog.TYPE_DANGER,
                cssClass: 'del-dialog',
                closable: true,
                draggable: true,
                closeByBackdrop: false,
                closeByKeyboard: false,
                buttons:[{
                  id: "knt_delete",
                  label: get_lang_param("Delete"),
                  cssClass: "btn-danger",
                }],
              });
        dialog_knt_del.open();
      }
      else {
        BootstrapDialog.alert({
        title: get_lang_param("Er_title"),
        message: get_lang_param("Er_msg2"),
        type: BootstrapDialog.TYPE_WARNING,
        draggable: true
        });
      }
    }
  },
    {
    text: function(a){return a.i18n("Update","Update")},
    action: function () {
    table_knt.ajax.reload();
      }
    }
  ],
"language": {
              "url": MyHOSTNAME + "lang/lang-" + lang +".json"
              }
  });
  $('#table_knt tbody').on( 'dblclick','td', function () {
    var d = $(this).attr({
      'id':'select_copy',
      'data-container':'body',
      'data-toggle':'popover',
      'data-placement':'bottom',
      'data-html': 'true',
      'data-content':get_lang_param("Copy_to_clipboard")
    });
    var ch_copy = selectText('select_copy');
    //console.log(ch_copy);
    if (ch_copy == true){
    document.execCommand("copy");
    $("#select_copy").popover('show')
    // Copy_to_clipboard_dialog.open()
    setTimeout(function(){
        $("#select_copy").popover('destroy');
        // Copy_to_clipboard_dialog.close()
        $(d).removeAttr('id data-container data-toggle data-placement data-content data-original-title title data-html');
      },800);
      }
  } );
$('body').on('click', 'button#table_knt_clear', function(event) {
                    event.preventDefault();
                    table_knt.search('').draw();
                    $("#table_knt_clear").blur();
                  });
                  if (table_knt.search() !== ''){
                  table_knt.search('').draw();
                }

table_knt.on('select', function(e, dt, type, indexes ){
    var data = table_knt.row( indexes ).data();
    eq_one_id=data[1];
    table_knt_files.ajax.reload();
})

// ***** Список файлов контрагентов *****
var table_knt_files = $('#table_knt_files').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "knt_files_table",
"id": function(){return eq_one_id;}
        }
},
"pading":false,
"deferRender":true,
"responsive":false,
"scrollY": 200,
"sScrollX": "100%",
"sScrollXInner": "100%",
"scrollCollapse": true,
"scroller":true,
"stateSave":true,
"searching":false,
"bLengthChange": false,
"select":{
"style": "multi"
        },
"fnDrawCallback": function (){
          // if ((userid != 1) && (userid != 63) && (userid != 22)){
          if ((Admin !== true) && (permit_users_knt.indexOf(userid) == -1)){
            table_knt_files.buttons().destroy();
      }
  },
"aaSorting" : [[0, 'asc']],
"aoColumns": [
                {"className": "center_table"},
                null
  ],
"aoColumnDefs":[
          { "sType": 'de_date', "aTargets": 1 }
],
"sDom": "<'row'<'col-sm-12'B>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
  {
    text:function(a){return a.i18n("Upload","Upload")},
    action: function ( e, dt, node, config ) {
      var $rows = table_knt.$('tr.selected');
        if ($rows.length == '1'){
          $('#file_knt').click();
        }
        else {
          BootstrapDialog.alert({
          title: get_lang_param("Er_title"),
          message: get_lang_param("Er_msg2"),
          type: BootstrapDialog.TYPE_WARNING,
          draggable: true
          });
        }
      }
  },
  {
      text:function(a){return a.i18n("Delete","Delete")},
      action: function ( e, dt, node, config ) {
        var $rows = table_knt_files.$('tr.selected');
          if ($rows.length > '0'){
        window.dialog_knt_files_del = new BootstrapDialog({
                title: get_lang_param("File_delete"),
                message: get_lang_param("Info_del"),
                type: BootstrapDialog.TYPE_DANGER,
                cssClass: 'del-dialog',
                closable: true,
                draggable: true,
                closeByBackdrop: false,
                closeByKeyboard: false,
                buttons:[{
                  id: "knt_file_delete",
                  label: get_lang_param("Delete"),
                  cssClass: "btn-danger",
                }],
              });
        dialog_knt_files_del.open();
      }
      else {
        BootstrapDialog.alert({
        title: get_lang_param("Er_title"),
        message: get_lang_param("Er_msg2"),
        type: BootstrapDialog.TYPE_WARNING,
        draggable: true
        });
      }
    }
  },
  {
  text: function(a){return a.i18n("Update","Update")},
  action: function () {
  table_knt_files.ajax.reload();
    }
  }
  ],
"language": {
              "url": MyHOSTNAME + "lang/lang-" + lang +".json"
  }
  });
var arrList_knt = new Array();
    table_knt_files.on('select', function(e, dt, type, indexes ){
         var data = table_knt_files.row( indexes ).data();
          arrList_knt.push(data[0]);
          // console.log(arrList_knt);
     }).on( 'deselect', function ( e, dt, type, indexes ) {
        var data = table_knt_files.row( indexes ).data();
          arrList_knt = $.grep(arrList_knt, function(value){
            return value != data[0];
          })
        })
$('#file_knt').on('change',function(){
      var file = this.files[0];
      var fileSize = file.size;
      var maxsize = $('input#file_size').val();
      var fileExtension = file_types;
      // var fileExtension = ['jpeg', 'jpg', 'doc', 'docx', 'xls', 'xlsx', 'pdf'];
      if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) !== -1){
      if (fileSize < maxsize){
      var form_data = new FormData();
      form_data.append('file', file);
      form_data.append('idcontract', eq_one_id);

      $.ajax({
        url: MyHOSTNAME + "sys/uploadcontractor.php",
        type: "POST",
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        xhr: function() {
            waitingDialog.show(get_lang_param("Progress_file_upload"));
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', function(evt) {
                    var percent = Math.round((evt.loaded / evt.total) * 100);
                    // console.log(percent);
                    $("#progressbar").width(percent + "%");
                    $("#percent").html(percent + '%');
                }, false);
            }
            return xhr;
        },
        success: function(){
          $("#percent").html('100%');
          waitingDialog.hide();
          table_knt_files.ajax.reload();
        }
      });
    }
    else{
      BootstrapDialog.alert({
      title: get_lang_param("Er_title"),
      message: get_lang_param("Er_msg_maxsize") + Math.round(maxsize/1024/1024) +'Mb',
      type: BootstrapDialog.TYPE_WARNING,
      draggable: true,
      callback: function(result) {
        // console.log(result);
        $('#file_knt').val(null);
        }
      });
    }
  }
  else {
    BootstrapDialog.alert({
    title: get_lang_param("Er_title"),
    message: get_lang_param("Er_msg_type")  + '(' + file_types +')',
    type: BootstrapDialog.TYPE_WARNING,
    draggable: true,
    callback: function() {
      $('#file_knt').val(null);
      }
    });
  }
});

// ***** Список документов *****
var table_documents = $('#table_documents').DataTable({
"aServerSide": true,
"ajax":{
"url":  ACTIONPATH,
"type": "POST",
"data":{
"mode": "documents_table",
        }
},
"pading":false,
"deferRender":true,
"responsive":false,
"scrollY": 200,
"sScrollX": "100%",
"sScrollXInner": "100%",
"scrollCollapse": true,
"scroller":true,
"stateSave":true,
"searching":false,
"bLengthChange": false,
"select":{
"style": "multi"
        },
"fnDrawCallback": function (){
          // if ((userid != 1) && (userid != 63) && (userid != 22)){
          if ((Admin !== true) && (permit_users_documents.indexOf(userid) == -1)){
            table_documents.buttons().destroy();
      }
  },
"aaSorting" : [[0, 'asc']],
"aoColumns": [
                {"className": "center_table"},
                null
  ],
"sDom": "<'row'<'col-sm-12'B>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
"buttons":[
  {
    text:function(a){return a.i18n("Upload","Upload")},
    action: function ( e, dt, node, config ) {
          $('#file_documents').click();
      }
  },
  {
      text:function(a){return a.i18n("Delete","Delete")},
      action: function ( e, dt, node, config ) {
        var $rows = table_documents.$('tr.selected');
          if ($rows.length > '0'){
        window.dialog_documents_files_del = new BootstrapDialog({
                title: get_lang_param("File_delete"),
                message: get_lang_param("Info_del"),
                type: BootstrapDialog.TYPE_DANGER,
                cssClass: 'del-dialog',
                closable: true,
                draggable: true,
                closeByBackdrop: false,
                closeByKeyboard: false,
                buttons:[{
                  id: "documents_delete",
                  label: get_lang_param("Delete"),
                  cssClass: "btn-danger",
                }],
              });
        dialog_documents_files_del.open();
      }
      else {
        BootstrapDialog.alert({
        title: get_lang_param("Er_title"),
        message: get_lang_param("Er_msg2"),
        type: BootstrapDialog.TYPE_WARNING,
        draggable: true
        });
      }
    }
  },
  {
  text: function(a){return a.i18n("Update","Update")},
  action: function () {
  table_documents.ajax.reload();
    }
  }
  ],
"language": {
              "url": MyHOSTNAME + "lang/lang-" + lang +".json"
  }
  });
var arrList_documents = new Array();
    table_documents.on('select', function(e, dt, type, indexes ){
         var data = table_documents.row( indexes ).data();
          arrList_documents.push(data[0]);
          // console.log(arrList_knt);
     }).on( 'deselect', function ( e, dt, type, indexes ) {
        var data = table_documents.row( indexes ).data();
          arrList_knt = $.grep(arrList_knt, function(value){
            return value != data[0];
          })
        })
$('#file_documents').on('change',function(){
      var file = this.files[0];
      var fileSize = file.size;
      var maxsize = $('input#file_size').val();
      var fileExtension = file_types;
      // var fileExtension = ['jpeg', 'jpg', 'doc', 'docx', 'xls', 'xlsx', 'pdf'];
      if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) !== -1){
      if (fileSize < maxsize){
      var form_data = new FormData();
      form_data.append('file', file);

      $.ajax({
        url: MyHOSTNAME + "sys/uploaddocuments.php",
        type: "POST",
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        xhr: function() {
            waitingDialog.show(get_lang_param("Progress_file_upload"));
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', function(evt) {
                    var percent = Math.round((evt.loaded / evt.total) * 100);
                    // console.log(percent);
                    $("#progressbar").width(percent + "%");
                    $("#percent").html(percent + '%');
                }, false);
            }
            return xhr;
        },
        success: function(){
          $("#percent").html('100%');
          waitingDialog.hide();
          table_documents.ajax.reload();
        }
      });
    }
    else{
      BootstrapDialog.alert({
      title: get_lang_param("Er_title"),
      message: get_lang_param("Er_msg_maxsize") + Math.round(maxsize/1024/1024) +'Mb',
      type: BootstrapDialog.TYPE_WARNING,
      draggable: true,
      callback: function(result) {
        // console.log(result);
        $('#file_documents').val(null);
        }
      });
    }
  }
  else {
    BootstrapDialog.alert({
    title: get_lang_param("Er_title"),
    message: get_lang_param("Er_msg_type")  + '(' + file_types +')',
    type: BootstrapDialog.TYPE_WARNING,
    draggable: true,
    callback: function() {
      $('#file_documents').val(null);
      }
    });
  }
});
}); //конец document ready
