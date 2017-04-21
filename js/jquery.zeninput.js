jQuery.fn.zeninput = function(options){
var options = jQuery.extend({
  error: false, // Элемент отображаемый при ошибке
    comment: false, // Элемент отображаемы при редактировании
    calculatewrapper: false, // Элемент будет отображен при расчетах
    calculate: false, // Элемент куда будет выводится результат вычисления
    oncalculate: false, // Функция вызывается если введены [+,-,*,/,(,)]
    onendcalculate: false, // Функция вызывается если удалены все [+,-,*,/,(,)]
    onready: false, // Функция вызывается при подготовке элемента
    onfocus: false, // Функция вызывается при установке фокуса
    onblur: false, // Функция вызывается при потере фокуса (в функцию передается конечный результаты ввода)
    onerror: false, // Функция вызывается при попытке ввода запрещенных символов
    onenter: false, // Функция вызывается если нажата клавиша enter (вызывается ДО onblur)
    onescape: false, // Функция вызывается если нажата клавиша escape (вызывается ДО onblur)
    oninput: false, // Функция вызывается при вводе любого символа (в функцию передается введенный символ)
    ifnul: '', // Символ вставляемый если введеные данные ошибочны или 0
    sign: false // Показывать знак минус при вводе отрицательного значения
},options);
var costToString = function(cost, fixed){
	var triadSeparator = '';
	var decSeparator = '.';
	var minus = '&minus;';
	var num = '0';
	var numd = '';
	var fractNum = 2;
	fixed = ( !fixed ) ? fixed = 2 : fixed;
	var fixedTest = '00';
	if( fixed != 2 ){
		fixedTest = '';
		for( var i = 0; i < fixed; i++ ){
			fixedTest += String('0');
		}
	}
	if( !isNaN( parseFloat(cost) ) ){
		num = parseFloat(Math.abs(cost)).toFixed(fixed).toString();
		numd = num.substr(num.indexOf('.')+1, fixed).toString();
		num = parseInt(num).toString();
		// var regEx = /(\d+)(\d{3})/;
		// while (regEx.test(num)){
		// 	num = num.replace(regEx,"$1"+triadSeparator+"$2");
		// }
		if( numd != fixedTest ){
			var lastZeros = /[0]*$/g
			num += decSeparator+numd.replace(lastZeros,'');
		}
		if( cost < 0 ) num = 'âˆ’'+num;
	}
	return num;
}
return this.each(function(){
	var nchars = new RegExp(/[\!\@\#\â„–\$\%\^\&\=\[\]\\\'\;\{\}\|\"\:\<\>\?~\`\_A-ZА-Яa-zа-я]/);
	var achars = "1234567890+-/*,. ";
	var errTimer = undefined;
	var inObj = this;
	var elemW = 68;
	var oldVal = 0;
	var newVal = 0;
	var t = { left:0, top:0 };
	var absW = jQuery(inObj).outerWidth(true) + 12;
	var absH = jQuery(inObj).outerHeight(true);
	var absT = t.top - 4;
	var absL = isNaN( t.left + parseInt(jQuery(inObj).css('marginLeft'),10) - 4 )?0:(t.left + parseInt(jQuery(inObj).css('marginLeft'),10) - 4);
	var regClean = new RegExp(' ','gi');
	var aripm = new RegExp(/[\+\-\*\/]/);
	var aripmSt = new RegExp(/^[\+\-\*\/]/);
	var toOldVal = false;
  console.log(parseInt(jQuery(inObj).css('marginLeft'),10) - 4 );
	/* Создаем не указанные элементы */
	if(!options.calculatewrapper){
		options.calculatewrapper = jQuery('<div class="calculatewrapper"></div>');
		jQuery(options.calculatewrapper).append('<div class="actWr">= </div>');
		jQuery(options.calculatewrapper).css({
			'position':'absolute',
			'left':absL+'px',
			'top':absT+'px',
			'visibility':'hidden',
			'zIndex':'0',
			'background':'#cedeea',
			'width':absW+'px',
			'padding':absH+6+'px 3px 3px 3px',
      'border-radius': '4px'
		});
		jQuery(inObj).after(options.calculatewrapper);
	}
	if(!options.calculate){
		options.calculate = jQuery('<span class="calcaction" style="font-weight:bold;"></span>');
		jQuery('.actWr' ,options.calculatewrapper).css({'padding':'3px 0px 3px 0px'}).append(options.calculate);
	}
	/* Создаем не указанные элементы */
	jQuery(this).focus(function(){
		/* Инициализация*/
		oldVal = parseFloat( String(inObj.value).replace(/ /g, '').replace(/,/g,'.'), 10 );
		( isNaN(oldVal) ) ? ( oldVal = 0 ) : oldVal;
		newVal = oldVal;
		// jQuery(inObj).css({'position':'relative', 'zIndex':2});
		t = jQuery(inObj).position();
    console.log(t);
		absT = t.top - 4;
		var mL = jQuery(inObj).css('marginLeft');
		mL = isNaN( parseInt(mL,10) )?( 0 ):( parseInt(mL,10) );
		absL = t.left + mL - 6;
		absW = jQuery(inObj).outerWidth(true) + 12;
		absH = jQuery(inObj).outerHeight(true);
		jQuery(options.calculatewrapper).css({ 'left':absL+'px','top':absT-3+'px', 'width': absW+'px', 'padding':absH+6+'px 6px 2px 6px'});
		if (options.comment) $(options.comment).css({'display': 'block'});
		/* Инициализация */
		if(options.onfocus) options.onfocus(this);
	});
	jQuery(this).blur(function(){
		if ( toOldVal ){
			newVal = oldVal;
		}
		toOldVal = false;
		if( options.comment ) jQuery(options.comment).css({'display':'none'});
		if( options.error ) jQuery(options.error).css({'display':'none'});
		jQuery(options.calculatewrapper).css({'visibility': 'hidden'});
		jQuery(inObj).css({'position':'static'});
		if( options.sign ){
			var sign = ( newVal < 0 )?( '-' ):( '' );
		}else{
			var sign = '';
		}
		newVal = Math.abs(newVal);
		if( newVal != 0 ){
			$(inObj).val( sign+costToString( newVal ) );
			if(options.onblur) options.onblur(inObj, sign+costToString( newVal ));
		}else{
			$(inObj).val( options.ifnul );
			if(options.onblur) options.onblur(inObj, options.ifnul);
		}
	});
	jQuery(this).keypress(function(e){
		var k, i;
		var tAllow = false;
		if (!e.charCode){
			k = String.fromCharCode(e.which);
			c = e.which;
		}else{
			k = String.fromCharCode(e.charCode);
			c = e.charCode;
		}
		if ( c == 37 || c == 39 ){ return true; }
		if( !e.ctrlKey ){
			var res=nchars.test(k);
			if ( res ){
				if(options.comment) jQuery(options.comment).css({'display':'none'});
				if(options.error) jQuery(options.error).css({'display':'block'});
				if(options.onerror) options.onerror(inObj);
				jQuery(inObj).addClass('error');
				clearTimeout(errTimer);
				errTimer = setTimeout(function(){
					if( options.error ) jQuery(options.error).css({'display':'none'});
					if( options.comment ) jQuery(options.comment).css({'display':'block'});
					$(inObj).removeClass('error');
				}, 3000);
				return false;
			}else{
				if ( e.keyCode == 13 ){
					if(options.onenter) setTimeout(function(){ options.onenter(inObj, newVal); }, 100);
					inObj.blur();
				}
			}
		}
	});
	jQuery(this).keyup(function(e){
		newVal = String(inObj.value).replace(/ /g, '').replace(/,/g, '.');
		if ( e.keyCode == 27 ){
			toOldVal = true;
			if(options.onescape) options.onescape(inObj, oldVal);
			inObj.blur();
			return;
		}

		var res = aripm.test(newVal);
		if(res){
			res = aripmSt.test(newVal);
			jQuery(inObj).css({'position':'relative', 'zIndex':2});
			jQuery(options.calculatewrapper).css({'visibility': 'visible'});
			if (res){
				var tStr = String( oldVal ) + String(newVal);
				try{
					newVal = parseFloat( eval( tStr ), 10 );
					newVal = isNaN( newVal )?( 0 ):( newVal );
					newVal = isFinite( newVal )?( newVal ):( 0 );
					jQuery(options.calculate).html( costToString( newVal ) );
				} catch(e) {
					newVal = 0;
					jQuery(options.calculate).html( newVal );
				}
			}else{
				var tStr = String(newVal);
				try{
					newVal = parseFloat( eval( tStr ), 10 );
					newVal = isNaN( newVal )?( 0 ):( newVal );
					newVal = isFinite( newVal )?( newVal ):( 0 );
					jQuery(options.calculate).html( costToString( newVal ) );
				} catch(e) {
					newVal = 0;
					jQuery(options.calculate).html( newVal );
				}
			}
			if( options.oncalculate ) options.oncalculate(newVal);
		}else{
			jQuery(options.calculatewrapper).css({'visibility': 'hidden'});
			jQuery(inObj).css({'position':'static'});
			if ( isNaN( parseFloat(newVal, 10) ) ){
				newVal = 0;
				jQuery(options.calculate).html( newVal );
			}else{
				jQuery(options.calculate).html( costToString( parseFloat(newVal, 10) ) );
			}
			if( options.onendcalculate ) options.onendcalculate(newVal);
		}
		if(options.oninput) options.oninput(this, e.keyCode);
	});

	if(options.onready) options.onready(this);
});
};