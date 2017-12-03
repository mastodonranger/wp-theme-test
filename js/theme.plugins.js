/**
 * @preserve
 * Jribbble v2.0.4 | Thu Jun 4 01:49:29 2015 -0400
 * Copyright (c) 2015, Tyler Gaw me@tylergaw.com
 * Released under the ISC-LICENSE
 */
!function(e,t,r,s){"use strict";e.jribbble={};var n=null,o="https://api.dribbble.com/v1",i=["animated","attachments","debuts","playoffs","rebounds","teams"],u={token:"Jribbble: Missing Dribbble access token. Set one with $.jribbble.accessToken = YOUR_ACCESS_TOKEN. If you do not have an access token, you must register a new application at https://dribbble.com/account/applications/new",singular:function(e){return e.substr(0,e.length-1)},idRequired:function(e){return"Jribbble: You have to provide a "+this.singular(e)+' ID. ex: $.jribbble.%@("1234").'.replace(/%@/g,e)},subResource:function(e){return"Jribbble: You have to provide a "+this.singular(e)+' ID to get %@. ex: $.jribbble.%@("1234").%@()'.replace(/%@/g,e)},shotId:function(e){return"Jribbble: You have to provide a shot ID to get %@. ex: "+' $.jribbble.shots("1234").%@()'.replace(/%@/g,e)},commentLikes:'Jribbble: You have to provide a comment ID to get likes. ex:  $.jribbble.shots("1234").comments("456").likes()'},c=function(e,t){if(e&&"object"!=typeof e)return e;throw new Error(u.idRequired(t))},l=function(e){var t={};return e.forEach(function(e){t[e]=d.call(this,e)}.bind(this)),t},h=function(t){var r=e.param(t);return r?"?"+r:""},a=function(e){if(0!==e.length){var t=e[0],r=typeof t,s={};if("number"===r||"string"===r){var n=i.indexOf(t);n>-1?s.list=t:s.resource=t}else"object"===r&&(s=t);return s}},b=function(){var t=e.extend({},e.Deferred()),r=function(){return this.methods=[],this.response=null,this.flushed=!1,this.add=function(e){this.flushed?e(this.scope):this.methods.push(e)},this.flush=function(e){if(!this.flushed){for(this.scope=e,this.flushed=!0;this.methods[0];)this.methods.shift()(e);return e}},this};return t.queue=new r,t.url=o,t.get=function(){return n?(e.ajax({type:"GET",url:this.url,beforeSend:function(e){e.setRequestHeader("Authorization","Bearer "+n)},success:function(e){this.resolve(e)}.bind(this),error:function(e){this.reject(e)}.bind(this)}),this):(console.error(u.token),!1)},t},f=function(t){return function(r){return e.extend(this,b()),this.queue.add(function(e){e.url+="/"+t+"/"+r}),setTimeout(function(){this.queue.flush(this).get()}.bind(this)),this}},d=function(e){return function(t){return this.queue.add(function(r){r.url+="/"+e+"/"+h(t||{})}),this}};e.jribbble.shots=function(t,r){var s=a([].slice.call(arguments))||{},n=r||{},o=function(t){return function(r,s){var n=a([].slice.call(arguments))||{},o=s||{};return this.queue.add(function(r){if(!r.shotId)throw new Error(u.shotId(t));r.url+="/"+t+"/",n.resource&&(r.url+=n.resource,delete n.resource),r.url+=h(e.extend(n,o))}),this}},i=function(){return e.extend(this,b()),this.url+="/shots/",this.queue.add(function(t){s.resource&&(t.shotId=s.resource,t.url+=s.resource,delete s.resource),t.url+=h(e.extend(s,n))}),setTimeout(function(){this.queue.flush(this).get()}.bind(this)),this};return i.prototype.attachments=o("attachments"),i.prototype.buckets=o("buckets"),i.prototype.likes=o("likes"),i.prototype.projects=o("projects"),i.prototype.rebounds=o("rebounds"),i.prototype.comments=function(t,r){var s=a([].slice.call(arguments))||{},n=r||{};return this.queue.add(function(t){if(!t.shotId)throw new Error(u.shotId("comments"));t.url+="/comments/",s.resource&&(t.commentId=s.resource,t.url+=s.resource+"/",delete s.resource),t.url+=h(e.extend(s,n))}),this.likes=function(e){var t=e||{};return this.queue.add(function(e){if(!e.commentId)throw new Error(u.commentLikes);e.url+="likes/"+h(t)}),this},this},new i},e.jribbble.teams=function(e){var t="teams",r=c(e,t),s=f.call(this,t);return s.prototype=l.call(this,["members","shots"]),new s(r)},e.jribbble.users=function(e){var t="users",r=c(e,t),s=f.call(this,t);return s.prototype=l.call(this,["buckets","followers","following","likes","projects","shots","teams"]),s.prototype.isFollowing=function(e){return this.queue.add(function(t){t.url+="/following/"+e}),this},new s(r)},e.jribbble.buckets=function(e){var t="buckets",r=c(e,t),s=f.call(this,t);return s.prototype=l.call(this,["shots"]),new s(r)},e.jribbble.projects=function(e){var t="projects",r=c(e,t),s=f.call(this,t);return s.prototype=l.call(this,["shots"]),new s(r)},e.jribbble.setToken=function(e){return n=e,this}}(jQuery,window,document);

/*
 * jQuery.appear
 * https://github.com/bas2k/jquery.appear/
 * http://code.google.com/p/jquery-appear/
 * http://bas2k.ru/
 *
 * Copyright (c) 2009 Michael Hixson
 * Copyright (c) 2012-2014 Alexander Brovikov
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php)
 */(function(a){a.fn.appear=function(e,b){var d=a.extend({data:void 0,one:!0,accX:0,accY:0},b);return this.each(function(){var c=a(this);c.appeared=!1;if(e){var g=a(window),f=function(){if(c.is(":visible")){var a=g.scrollLeft(),e=g.scrollTop(),b=c.offset(),f=b.left,b=b.top,h=d.accX,k=d.accY,l=c.height(),m=g.height(),n=c.width(),p=g.width();b+l+k>=e&&b<=e+m+k&&f+n+h>=a&&f<=a+p+h?c.appeared||c.trigger("appear",d.data):c.appeared=!1}else c.appeared=!1},b=function(){c.appeared=!0;if(d.one){g.unbind("scroll",
	f);var b=a.inArray(f,a.fn.appear.checks);0<=b&&a.fn.appear.checks.splice(b,1)}e.apply(this,arguments)};if(d.one)c.one("appear",d.data,b);else c.bind("appear",d.data,b);g.scroll(f);a.fn.appear.checks.push(f);f()}else c.trigger("appear",d.data)})};a.extend(a.fn.appear,{checks:[],timeout:null,checkAll:function(){var e=a.fn.appear.checks.length;if(0<e)for(;e--;)a.fn.appear.checks[e]()},run:function(){a.fn.appear.timeout&&clearTimeout(a.fn.appear.timeout);a.fn.appear.timeout=setTimeout(a.fn.appear.checkAll,
	20)}});a.each("append prepend after before attr removeAttr addClass removeClass toggleClass remove css show hide".split(" "),function(e,b){var d=a.fn[b];d&&(a.fn[b]=function(){var b=d.apply(this,arguments);a.fn.appear.run();return b})})})(jQuery);

/*!
 * jQuery Mousewheel 3.1.13
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license
 * http://jquery.org/license
 */(function(c){"function"===typeof define&&define.amd?define(["jquery.appear"],c):"object"===typeof exports?module.exports=c:c(jQuery)})(function(c){function l(a){var b=a||window.event,k=r.call(arguments,1),f=0,e=0,d=0,g=0,l=0,n=0;a=c.event.fix(b);a.type="mousewheel";"detail"in b&&(d=-1*b.detail);"wheelDelta"in b&&(d=b.wheelDelta);"wheelDeltaY"in b&&(d=b.wheelDeltaY);"wheelDeltaX"in b&&(e=-1*b.wheelDeltaX);"axis"in b&&b.axis===b.HORIZONTAL_AXIS&&(e=-1*d,d=0);f=0===d?e:d;"deltaY"in b&&(f=d=-1*b.deltaY);"deltaX"in
b&&(e=b.deltaX,0===d&&(f=-1*e));if(0!==d||0!==e){1===b.deltaMode?(g=c.data(this,"mousewheel-line-height"),f*=g,d*=g,e*=g):2===b.deltaMode&&(g=c.data(this,"mousewheel-page-height"),f*=g,d*=g,e*=g);g=Math.max(Math.abs(d),Math.abs(e));if(!h||g<h)h=g,m.settings.adjustOldDeltas&&"mousewheel"===b.type&&0===g%120&&(h/=40);m.settings.adjustOldDeltas&&"mousewheel"===b.type&&0===g%120&&(f/=40,e/=40,d/=40);f=Math[1<=f?"floor":"ceil"](f/h);e=Math[1<=e?"floor":"ceil"](e/h);d=Math[1<=d?"floor":"ceil"](d/h);m.settings.normalizeOffset&&
this.getBoundingClientRect&&(b=this.getBoundingClientRect(),l=a.clientX-b.left,n=a.clientY-b.top);a.deltaX=e;a.deltaY=d;a.deltaFactor=h;a.offsetX=l;a.offsetY=n;a.deltaMode=0;k.unshift(a,f,e,d);p&&clearTimeout(p);p=setTimeout(t,200);return(c.event.dispatch||c.event.handle).apply(this,k)}}function t(){h=null}var n=["wheel","mousewheel","DOMMouseScroll","MozMousePixelScroll"],k="onwheel"in document||9<=document.documentMode?["wheel"]:["mousewheel","DomMouseScroll","MozMousePixelScroll"],r=Array.prototype.slice,
	p,h;if(c.event.fixHooks)for(var q=n.length;q;)c.event.fixHooks[n[--q]]=c.event.mouseHooks;var m=c.event.special.mousewheel={version:"3.1.12",setup:function(){if(this.addEventListener)for(var a=k.length;a;)this.addEventListener(k[--a],l,!1);else this.onmousewheel=l;c.data(this,"mousewheel-line-height",m.getLineHeight(this));c.data(this,"mousewheel-page-height",m.getPageHeight(this))},teardown:function(){if(this.removeEventListener)for(var a=k.length;a;)this.removeEventListener(k[--a],l,!1);else this.onmousewheel=
	null;c.removeData(this,"mousewheel-line-height");c.removeData(this,"mousewheel-page-height")},getLineHeight:function(a){a=c(a);var b=a["offsetParent"in c.fn?"offsetParent":"parent"]();b.length||(b=c("body"));return parseInt(b.css("fontSize"),10)||parseInt(a.css("fontSize"),10)||16},getPageHeight:function(a){return c(a).height()},settings:{adjustOldDeltas:!0,normalizeOffset:!0}};c.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",
	a)}})});

/** Abstract base class for collection plugins v1.0.1.
 Written by Keith Wood (kbwood{at}iinet.com.au) December 2013.
 Licensed under the MIT (http://keith-wood.name/licence.html) license. */
(function(){var j=false;window.JQClass=function(){};JQClass.classes={};JQClass.extend=function extender(f){var g=this.prototype;j=true;var h=new this();j=false;for(var i in f){h[i]=typeof f[i]=='function'&&typeof g[i]=='function'?(function(d,e){return function(){var b=this._super;this._super=function(a){return g[d].apply(this,a||[])};var c=e.apply(this,arguments);this._super=b;return c}})(i,f[i]):f[i]}function JQClass(){if(!j&&this._init){this._init.apply(this,arguments)}}JQClass.prototype=h;JQClass.prototype.constructor=JQClass;JQClass.extend=extender;return JQClass}})();(function($){JQClass.classes.JQPlugin=JQClass.extend({name:'plugin',defaultOptions:{},regionalOptions:{},_getters:[],_getMarker:function(){return'is-'+this.name},_init:function(){$.extend(this.defaultOptions,(this.regionalOptions&&this.regionalOptions[''])||{});var c=camelCase(this.name);$[c]=this;$.fn[c]=function(a){var b=Array.prototype.slice.call(arguments,1);if($[c]._isNotChained(a,b)){return $[c][a].apply($[c],[this[0]].concat(b))}return this.each(function(){if(typeof a==='string'){if(a[0]==='_'||!$[c][a]){throw'Unknown method: '+a;}$[c][a].apply($[c],[this].concat(b))}else{$[c]._attach(this,a)}})}},setDefaults:function(a){$.extend(this.defaultOptions,a||{})},_isNotChained:function(a,b){if(a==='option'&&(b.length===0||(b.length===1&&typeof b[0]==='string'))){return true}return $.inArray(a,this._getters)>-1},_attach:function(a,b){a=$(a);if(a.hasClass(this._getMarker())){return}a.addClass(this._getMarker());b=$.extend({},this.defaultOptions,this._getMetadata(a),b||{});var c=$.extend({name:this.name,elem:a,options:b},this._instSettings(a,b));a.data(this.name,c);this._postAttach(a,c);this.option(a,b)},_instSettings:function(a,b){return{}},_postAttach:function(a,b){},_getMetadata:function(d){try{var f=d.data(this.name.toLowerCase())||'';f=f.replace(/'/g,'"');f=f.replace(/([a-zA-Z0-9]+):/g,function(a,b,i){var c=f.substring(0,i).match(/"/g);return(!c||c.length%2===0?'"'+b+'":':b+':')});f=$.parseJSON('{'+f+'}');for(var g in f){var h=f[g];if(typeof h==='string'&&h.match(/^new Date\((.*)\)$/)){f[g]=eval(h)}}return f}catch(e){return{}}},_getInst:function(a){return $(a).data(this.name)||{}},option:function(a,b,c){a=$(a);var d=a.data(this.name);if(!b||(typeof b==='string'&&c==null)){var e=(d||{}).options;return(e&&b?e[b]:e)}if(!a.hasClass(this._getMarker())){return}var e=b||{};if(typeof b==='string'){e={};e[b]=c}this._optionsChanged(a,d,e);$.extend(d.options,e)},_optionsChanged:function(a,b,c){},destroy:function(a){a=$(a);if(!a.hasClass(this._getMarker())){return}this._preDestroy(a,this._getInst(a));a.removeData(this.name).removeClass(this._getMarker())},_preDestroy:function(a,b){}});function camelCase(c){return c.replace(/-([a-z])/g,function(a,b){return b.toUpperCase()})}$.JQPlugin={createPlugin:function(a,b){if(typeof a==='object'){b=a;a='JQPlugin'}a=camelCase(a);var c=camelCase(b.name);JQClass.classes[c]=JQClass.classes[a].extend(b);new JQClass.classes[c]()}}})(jQuery);


/* http://keith-wood.name/countdown.html
 Countdown for jQuery v2.0.2.
 Written by Keith Wood (kbwood{at}iinet.com.au) January 2008.
 Available under the MIT (http://keith-wood.name/licence.html) license.
 Please attribute the author if you use it. */
(function($){var w='countdown';var Y=0;var O=1;var W=2;var D=3;var H=4;var M=5;var S=6;$.JQPlugin.createPlugin({name:w,defaultOptions:{until:null,since:null,timezone:null,serverSync:null,format:'dHMS',layout:'',compact:false,padZeroes:false,significant:0,description:'',expiryUrl:'',expiryText:'',alwaysExpire:false,onExpiry:null,onTick:null,tickInterval:1},regionalOptions:{'':{labels:['Years','Months','Weeks','Days','Hours','Minutes','Seconds'],labels1:['Year','Month','Week','Day','Hour','Minute','Second'],compactLabels:['y','m','w','d'],whichLabels:null,digits:['0','1','2','3','4','5','6','7','8','9'],timeSeparator:':',isRTL:false}},_getters:['getTimes'],_rtlClass:w+'-rtl',_sectionClass:w+'-section',_amountClass:w+'-amount',_periodClass:w+'-period',_rowClass:w+'-row',_holdingClass:w+'-holding',_showClass:w+'-show',_descrClass:w+'-descr',_timerElems:[],_init:function(){var c=this;this._super();this._serverSyncs=[];var d=(typeof Date.now=='function'?Date.now:function(){return new Date().getTime()});var e=(window.performance&&typeof window.performance.now=='function');function timerCallBack(a){var b=(a<1e12?(e?(performance.now()+performance.timing.navigationStart):d()):a||d());if(b-g>=1000){c._updateElems();g=b}f(timerCallBack)}var f=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||null;var g=0;if(!f||$.noRequestAnimationFrame){$.noRequestAnimationFrame=null;setInterval(function(){c._updateElems()},980)}else{g=window.animationStartTime||window.webkitAnimationStartTime||window.mozAnimationStartTime||window.oAnimationStartTime||window.msAnimationStartTime||d();f(timerCallBack)}},UTCDate:function(a,b,c,e,f,g,h,i){if(typeof b=='object'&&b.constructor==Date){i=b.getMilliseconds();h=b.getSeconds();g=b.getMinutes();f=b.getHours();e=b.getDate();c=b.getMonth();b=b.getFullYear()}var d=new Date();d.setUTCFullYear(b);d.setUTCDate(1);d.setUTCMonth(c||0);d.setUTCDate(e||1);d.setUTCHours(f||0);d.setUTCMinutes((g||0)-(Math.abs(a)<30?a*60:a));d.setUTCSeconds(h||0);d.setUTCMilliseconds(i||0);return d},periodsToSeconds:function(a){return a[0]*31557600+a[1]*2629800+a[2]*604800+a[3]*86400+a[4]*3600+a[5]*60+a[6]},resync:function(){var d=this;$('.'+this._getMarker()).each(function(){var a=$.data(this,d.name);if(a.options.serverSync){var b=null;for(var i=0;i<d._serverSyncs.length;i++){if(d._serverSyncs[i][0]==a.options.serverSync){b=d._serverSyncs[i];break}}if(b[2]==null){var c=($.isFunction(a.options.serverSync)?a.options.serverSync.apply(this,[]):null);b[2]=(c?new Date().getTime()-c.getTime():0)-b[1]}if(a._since){a._since.setMilliseconds(a._since.getMilliseconds()+b[2])}a._until.setMilliseconds(a._until.getMilliseconds()+b[2])}});for(var i=0;i<d._serverSyncs.length;i++){if(d._serverSyncs[i][2]!=null){d._serverSyncs[i][1]+=d._serverSyncs[i][2];delete d._serverSyncs[i][2]}}},_instSettings:function(a,b){return{_periods:[0,0,0,0,0,0,0]}},_addElem:function(a){if(!this._hasElem(a)){this._timerElems.push(a)}},_hasElem:function(a){return($.inArray(a,this._timerElems)>-1)},_removeElem:function(b){this._timerElems=$.map(this._timerElems,function(a){return(a==b?null:a)})},_updateElems:function(){for(var i=this._timerElems.length-1;i>=0;i--){this._updateCountdown(this._timerElems[i])}},_optionsChanged:function(a,b,c){if(c.layout){c.layout=c.layout.replace(/&lt;/g,'<').replace(/&gt;/g,'>')}this._resetExtraLabels(b.options,c);var d=(b.options.timezone!=c.timezone);$.extend(b.options,c);this._adjustSettings(a,b,c.until!=null||c.since!=null||d);var e=new Date();if((b._since&&b._since<e)||(b._until&&b._until>e)){this._addElem(a[0])}this._updateCountdown(a,b)},_updateCountdown:function(a,b){a=a.jquery?a:$(a);b=b||this._getInst(a);if(!b){return}a.html(this._generateHTML(b)).toggleClass(this._rtlClass,b.options.isRTL);if($.isFunction(b.options.onTick)){var c=b._hold!='lap'?b._periods:this._calculatePeriods(b,b._show,b.options.significant,new Date());if(b.options.tickInterval==1||this.periodsToSeconds(c)%b.options.tickInterval==0){b.options.onTick.apply(a[0],[c])}}var d=b._hold!='pause'&&(b._since?b._now.getTime()<b._since.getTime():b._now.getTime()>=b._until.getTime());if(d&&!b._expiring){b._expiring=true;if(this._hasElem(a[0])||b.options.alwaysExpire){this._removeElem(a[0]);if($.isFunction(b.options.onExpiry)){b.options.onExpiry.apply(a[0],[])}if(b.options.expiryText){var e=b.options.layout;b.options.layout=b.options.expiryText;this._updateCountdown(a[0],b);b.options.layout=e}if(b.options.expiryUrl){window.location=b.options.expiryUrl}}b._expiring=false}else if(b._hold=='pause'){this._removeElem(a[0])}},_resetExtraLabels:function(a,b){for(var n in b){if(n.match(/[Ll]abels[02-9]|compactLabels1/)){a[n]=b[n]}}for(var n in a){if(n.match(/[Ll]abels[02-9]|compactLabels1/)&&typeof b[n]==='undefined'){a[n]=null}}},_adjustSettings:function(a,b,c){var d=null;for(var i=0;i<this._serverSyncs.length;i++){if(this._serverSyncs[i][0]==b.options.serverSync){d=this._serverSyncs[i][1];break}}if(d!=null){var e=(b.options.serverSync?d:0);var f=new Date()}else{var g=($.isFunction(b.options.serverSync)?b.options.serverSync.apply(a[0],[]):null);var f=new Date();var e=(g?f.getTime()-g.getTime():0);this._serverSyncs.push([b.options.serverSync,e])}var h=b.options.timezone;h=(h==null?-f.getTimezoneOffset():h);if(c||(!c&&b._until==null&&b._since==null)){b._since=b.options.since;if(b._since!=null){b._since=this.UTCDate(h,this._determineTime(b._since,null));if(b._since&&e){b._since.setMilliseconds(b._since.getMilliseconds()+e)}}b._until=this.UTCDate(h,this._determineTime(b.options.until,f));if(e){b._until.setMilliseconds(b._until.getMilliseconds()+e)}}b._show=this._determineShow(b)},_preDestroy:function(a,b){this._removeElem(a[0]);a.empty()},pause:function(a){this._hold(a,'pause')},lap:function(a){this._hold(a,'lap')},resume:function(a){this._hold(a,null)},toggle:function(a){var b=$.data(a,this.name)||{};this[!b._hold?'pause':'resume'](a)},toggleLap:function(a){var b=$.data(a,this.name)||{};this[!b._hold?'lap':'resume'](a)},_hold:function(a,b){var c=$.data(a,this.name);if(c){if(c._hold=='pause'&&!b){c._periods=c._savePeriods;var d=(c._since?'-':'+');c[c._since?'_since':'_until']=this._determineTime(d+c._periods[0]+'y'+d+c._periods[1]+'o'+d+c._periods[2]+'w'+d+c._periods[3]+'d'+d+c._periods[4]+'h'+d+c._periods[5]+'m'+d+c._periods[6]+'s');this._addElem(a)}c._hold=b;c._savePeriods=(b=='pause'?c._periods:null);$.data(a,this.name,c);this._updateCountdown(a,c)}},getTimes:function(a){var b=$.data(a,this.name);return(!b?null:(b._hold=='pause'?b._savePeriods:(!b._hold?b._periods:this._calculatePeriods(b,b._show,b.options.significant,new Date()))))},_determineTime:function(k,l){var m=this;var n=function(a){var b=new Date();b.setTime(b.getTime()+a*1000);return b};var o=function(a){a=a.toLowerCase();var b=new Date();var c=b.getFullYear();var d=b.getMonth();var e=b.getDate();var f=b.getHours();var g=b.getMinutes();var h=b.getSeconds();var i=/([+-]?[0-9]+)\s*(s|m|h|d|w|o|y)?/g;var j=i.exec(a);while(j){switch(j[2]||'s'){case's':h+=parseInt(j[1],10);break;case'm':g+=parseInt(j[1],10);break;case'h':f+=parseInt(j[1],10);break;case'd':e+=parseInt(j[1],10);break;case'w':e+=parseInt(j[1],10)*7;break;case'o':d+=parseInt(j[1],10);e=Math.min(e,m._getDaysInMonth(c,d));break;case'y':c+=parseInt(j[1],10);e=Math.min(e,m._getDaysInMonth(c,d));break}j=i.exec(a)}return new Date(c,d,e,f,g,h,0)};var p=(k==null?l:(typeof k=='string'?o(k):(typeof k=='number'?n(k):k)));if(p)p.setMilliseconds(0);return p},_getDaysInMonth:function(a,b){return 32-new Date(a,b,32).getDate()},_normalLabels:function(a){return a},_generateHTML:function(c){var d=this;c._periods=(c._hold?c._periods:this._calculatePeriods(c,c._show,c.options.significant,new Date()));var e=false;var f=0;var g=c.options.significant;var h=$.extend({},c._show);for(var i=Y;i<=S;i++){e|=(c._show[i]=='?'&&c._periods[i]>0);h[i]=(c._show[i]=='?'&&!e?null:c._show[i]);f+=(h[i]?1:0);g-=(c._periods[i]>0?1:0)}var j=[false,false,false,false,false,false,false];for(var i=S;i>=Y;i--){if(c._show[i]){if(c._periods[i]){j[i]=true}else{j[i]=g>0;g--}}}var k=(c.options.compact?c.options.compactLabels:c.options.labels);var l=c.options.whichLabels||this._normalLabels;var m=function(a){var b=c.options['compactLabels'+l(c._periods[a])];return(h[a]?d._translateDigits(c,c._periods[a])+(b?b[a]:k[a])+' ':'')};var n=(c.options.padZeroes?2:1);var o=function(a){var b=c.options['labels'+l(c._periods[a])];return((!c.options.significant&&h[a])||(c.options.significant&&j[a])?'<span class="'+d._sectionClass+'">'+'<span class="'+d._amountClass+'">'+d._minDigits(c,c._periods[a],n)+'</span>'+'<span class="'+d._periodClass+'">'+(b?b[a]:k[a])+'</span></span>':'')};return(c.options.layout?this._buildLayout(c,h,c.options.layout,c.options.compact,c.options.significant,j):((c.options.compact?'<span class="'+this._rowClass+' '+this._amountClass+(c._hold?' '+this._holdingClass:'')+'">'+m(Y)+m(O)+m(W)+m(D)+(h[H]?this._minDigits(c,c._periods[H],2):'')+(h[M]?(h[H]?c.options.timeSeparator:'')+this._minDigits(c,c._periods[M],2):'')+(h[S]?(h[H]||h[M]?c.options.timeSeparator:'')+this._minDigits(c,c._periods[S],2):''):'<span class="'+this._rowClass+' '+this._showClass+(c.options.significant||f)+(c._hold?' '+this._holdingClass:'')+'">'+o(Y)+o(O)+o(W)+o(D)+o(H)+o(M)+o(S))+'</span>'+(c.options.description?'<span class="'+this._rowClass+' '+this._descrClass+'">'+c.options.description+'</span>':'')))},_buildLayout:function(c,d,e,f,g,h){var j=c.options[f?'compactLabels':'labels'];var k=c.options.whichLabels||this._normalLabels;var l=function(a){return(c.options[(f?'compactLabels':'labels')+k(c._periods[a])]||j)[a]};var m=function(a,b){return c.options.digits[Math.floor(a/b)%10]};var o={desc:c.options.description,sep:c.options.timeSeparator,yl:l(Y),yn:this._minDigits(c,c._periods[Y],1),ynn:this._minDigits(c,c._periods[Y],2),ynnn:this._minDigits(c,c._periods[Y],3),y1:m(c._periods[Y],1),y10:m(c._periods[Y],10),y100:m(c._periods[Y],100),y1000:m(c._periods[Y],1000),ol:l(O),on:this._minDigits(c,c._periods[O],1),onn:this._minDigits(c,c._periods[O],2),onnn:this._minDigits(c,c._periods[O],3),o1:m(c._periods[O],1),o10:m(c._periods[O],10),o100:m(c._periods[O],100),o1000:m(c._periods[O],1000),wl:l(W),wn:this._minDigits(c,c._periods[W],1),wnn:this._minDigits(c,c._periods[W],2),wnnn:this._minDigits(c,c._periods[W],3),w1:m(c._periods[W],1),w10:m(c._periods[W],10),w100:m(c._periods[W],100),w1000:m(c._periods[W],1000),dl:l(D),dn:this._minDigits(c,c._periods[D],1),dnn:this._minDigits(c,c._periods[D],2),dnnn:this._minDigits(c,c._periods[D],3),d1:m(c._periods[D],1),d10:m(c._periods[D],10),d100:m(c._periods[D],100),d1000:m(c._periods[D],1000),hl:l(H),hn:this._minDigits(c,c._periods[H],1),hnn:this._minDigits(c,c._periods[H],2),hnnn:this._minDigits(c,c._periods[H],3),h1:m(c._periods[H],1),h10:m(c._periods[H],10),h100:m(c._periods[H],100),h1000:m(c._periods[H],1000),ml:l(M),mn:this._minDigits(c,c._periods[M],1),mnn:this._minDigits(c,c._periods[M],2),mnnn:this._minDigits(c,c._periods[M],3),m1:m(c._periods[M],1),m10:m(c._periods[M],10),m100:m(c._periods[M],100),m1000:m(c._periods[M],1000),sl:l(S),sn:this._minDigits(c,c._periods[S],1),snn:this._minDigits(c,c._periods[S],2),snnn:this._minDigits(c,c._periods[S],3),s1:m(c._periods[S],1),s10:m(c._periods[S],10),s100:m(c._periods[S],100),s1000:m(c._periods[S],1000)};var p=e;for(var i=Y;i<=S;i++){var q='yowdhms'.charAt(i);var r=new RegExp('\\{'+q+'<\\}([\\s\\S]*)\\{'+q+'>\\}','g');p=p.replace(r,((!g&&d[i])||(g&&h[i])?'$1':''))}$.each(o,function(n,v){var a=new RegExp('\\{'+n+'\\}','g');p=p.replace(a,v)});return p},_minDigits:function(a,b,c){b=''+b;if(b.length>=c){return this._translateDigits(a,b)}b='0000000000'+b;return this._translateDigits(a,b.substr(b.length-c))},_translateDigits:function(b,c){return(''+c).replace(/[0-9]/g,function(a){return b.options.digits[a]})},_determineShow:function(a){var b=a.options.format;var c=[];c[Y]=(b.match('y')?'?':(b.match('Y')?'!':null));c[O]=(b.match('o')?'?':(b.match('O')?'!':null));c[W]=(b.match('w')?'?':(b.match('W')?'!':null));c[D]=(b.match('d')?'?':(b.match('D')?'!':null));c[H]=(b.match('h')?'?':(b.match('H')?'!':null));c[M]=(b.match('m')?'?':(b.match('M')?'!':null));c[S]=(b.match('s')?'?':(b.match('S')?'!':null));return c},_calculatePeriods:function(c,d,e,f){c._now=f;c._now.setMilliseconds(0);var g=new Date(c._now.getTime());if(c._since){if(f.getTime()<c._since.getTime()){c._now=f=g}else{f=c._since}}else{g.setTime(c._until.getTime());if(f.getTime()>c._until.getTime()){c._now=f=g}}var h=[0,0,0,0,0,0,0];if(d[Y]||d[O]){var i=this._getDaysInMonth(f.getFullYear(),f.getMonth());var j=this._getDaysInMonth(g.getFullYear(),g.getMonth());var k=(g.getDate()==f.getDate()||(g.getDate()>=Math.min(i,j)&&f.getDate()>=Math.min(i,j)));var l=function(a){return(a.getHours()*60+a.getMinutes())*60+a.getSeconds()};var m=Math.max(0,(g.getFullYear()-f.getFullYear())*12+g.getMonth()-f.getMonth()+((g.getDate()<f.getDate()&&!k)||(k&&l(g)<l(f))?-1:0));h[Y]=(d[Y]?Math.floor(m/12):0);h[O]=(d[O]?m-h[Y]*12:0);f=new Date(f.getTime());var n=(f.getDate()==i);var o=this._getDaysInMonth(f.getFullYear()+h[Y],f.getMonth()+h[O]);if(f.getDate()>o){f.setDate(o)}f.setFullYear(f.getFullYear()+h[Y]);f.setMonth(f.getMonth()+h[O]);if(n){f.setDate(o)}}var p=Math.floor((g.getTime()-f.getTime())/1000);var q=function(a,b){h[a]=(d[a]?Math.floor(p/b):0);p-=h[a]*b};q(W,604800);q(D,86400);q(H,3600);q(M,60);q(S,1);if(p>0&&!c._since){var r=[1,12,4.3482,7,24,60,60];var s=S;var t=1;for(var u=S;u>=Y;u--){if(d[u]){if(h[s]>=t){h[s]=0;p=1}if(p>0){h[u]++;p=0;s=u;t=1}}t*=r[u]}}if(e){for(var u=Y;u<=S;u++){if(e&&h[u]){e--}else if(!e){h[u]=0}}}return h}})})(jQuery);

(function ($) {

	$.fn.extend({

		terminus_lightbox : function (options) {

			if (!$.fancybox) return;

			var defaults = {
					groups			:	['.page_wrap'],
					linkElements	:   'a.fancybox, a.fancybox_media, .overlay-type-image, a[rel^="lightbox"], a[rel^="prettyPhoto"], a[href$=jpg], a[href$=png], a[href$=gif], a[href$=jpeg], a[href*=".jpg?"], a[href*=".png?"], a[href*=".jpeg?"]',
					videoElements	: 	'a[href$=".mov"], a[href*="maps.google.com"], a[href*="vimeo.com"] , a[href*="youtube.com/watch"] , a[href*="screenr.com"], a[href*="iframe=true"]',
					exclude			:	'[class*="share-"]'
				},
				o = $.extend({}, defaults, options),
				fbHelpers = {
					thumbs: {
						width: 80,
						height: 80
					},
					buttons: {},
					media: {}
				},
				fbDefault = {
					openEffect: 'elastic',
					closeEffect: 'elastic',
					openSpeed: 300,
					closeSpeed: 300,
					padding: 20,
					margin: 50,
					helpers: $.extend($.fancybox.defaults.helpers, fbHelpers),
					wrapCSS: 'j_fancybox',
					beforeShow: function () {
						var className = '';
						if (this.title) {
							this.title += '<br />';
							this.title += '<div class="fancybox-share-buttons">';
						}  else {
							this.title += '<div class="fancybox-share-buttons only">';
						}
						this.title += '<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-url="' + this.href + '">Tweet</a> ';
						this.title += '<iframe src="//www.facebook.com/plugins/like.php?href=http://fancyapps.com/fancybox/demo/1_b.jpg&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:23px;" allowtransparency="true"></iframe>';
						this.title += '</div>';
					}
				};

			$.fancybox.defaults = $.extend($.fancybox.defaults, fbDefault);
			$.fancybox.defaults.helpers.title = {
				type: 'inside'
			}

			return this.each(function () {
				for (var i = 0; i < o.groups.length; i++) {
					$(o.groups[i]).each(function () {
						var elements = $(o.linkElements, this);
						elements.not(o.exclude).addClass('lightbox-added').fancybox();
					});
				}
			});

		},

		terminus_hover_effect: function () {

			var elements = $('a img', this)
				.not('.advertise-image, .vc_single_image-img, .size-large, [aria-describedby], .wp-post-image, .dokan-store-img')
				.parents('a')
				.not('.t-tab-link, .woobanner, .banner-button, .elzoom, .products a, .fancybox_item, .product_thumb, .banner, table a');

			elements.each(function () {

				var link = $(this),
					current = link.find('img:first'),
					url		 	= link.attr('href'),
					spanClass	= "",
					overlay 	= link.find('.curtain-overlay');

				if ( url ) {
					if ( url.match(/(jpg|gif|jpeg|png|tif)/) ) spanClass = "overlay-type-image";
					if (!url.match(/(jpg|gif|jpeg|png|\.tif|\.mov|\.swf|vimeo\.com|youtube\.com)/) ) spanClass = "overlay-type-link";
				}

				if ( !overlay.length ) {
					overlay = $("<div class='curtain-overlay " + spanClass + "'></div>").appendTo(link);
				}

				if ( !link.hasClass('lightbox-added') ) {
					link.addClass('lightbox-added');
				}

				if ( current.hasClass('alignnone') ) link.addClass('alignnone');
				if ( current.hasClass('alignleft') ) link.addClass('alignleft');
				if ( current.hasClass('alignright') ) link.addClass('alignright');
				if ( current.hasClass('aligncenter') ) link.wrap('<span class="aligncenter" />').addClass('aligncenter');

			});

		},

		/**
		 **	Emulates select form element
		 **	@return jQuery
		 **/
		terminus_custom_select : function(){

			// focus out

			$(document).on('click.selectFocusOut', function(event){

				if(!$(event.target).closest('.custom_select').length){
					$('.custom_select').add('.options_list').add('.active_option').removeClass('opened');
				}

			});

			// reset

			$('input[type="reset"], button[type="reset"]').on('click.resetCustomSelect', function(){

				var $this = $(this),
					selects = $this.closest('form').find('.custom_select');

				selects.each(function(){

					var $this = $(this),
						selected = $this.children('option[selected]'),
						defaultText = $this.data('default-text'),
						active = $this.children('.active_option');

					if(defaultText) active.text(defaultText);
					else if(selected.val()) active.text(selected.val());
					else active.text($this.children('option').eq(0).val());


				});

			});

			// template

			var template = "<div class='active_option'></div><ul class='options_list'></ul>",
				len = $(this).length;

			return this.each(function(i){

				var $this = $(this);

				if (!$this.children('ul.options_list').length) {
					$this.prepend(template);
				}

				var active = $this.children('.active_option'),
					list = $this.children('.options_list'),
					select = $this.children('select').hide(),
					options = select.children('option'),
					selected = select.children('option[selected]'),
					defaultText = $this.data('default-text');

				active.on('click', function(e) {
					e.preventDefault();
					$this.toggleClass('opened');
				});

				if(defaultText) active.text(defaultText);
				else if(selected.val()) active.text(selected.val());
				else active.text(options.eq(0).val());

				options.each(function() {

					var $this = $(this),
						template = $('<li></li>', {
						text : $this.val(),
						'data-option-value': $this.val()
					});

					list.append(template);

				});

				list.on("click", "li", function() {

					var $current = $(this),
						v = $current.text();

					active.text(v);
					select.val(v);

					$this.removeClass("opened");

				});

			});

		},

		/**
		 **	Call function after window resize and delay
		 **	@param fn - function that will be called
		 **	@param delay - Delay, after which function will be called
		 **	@param namepsace - namespace for event
		 **/
		terminus_after_resize : function(fn, delay, namespace){

			var ns = namespace || "";

			return this.each(function(){

				$(this).on('resize' + ns, function(){

					setTimeout(function(){
						fn();
					}, delay);

				});

			});

		},

		/**
		 **	@return jQuery
		 **/
		terminus_tabs : function(options){

			return this.each(function(){

				var $container = $(this),

					tabs = {

						init : function(){

							$container.addClass('initialized');

							this.nav = $container.children('.tabs_nav').length ? $container.children('.tabs_nav') : $container.children('.ts_nav');
							this.subContainer = $container.children('.tab_containers_wrap').length ? $container.children('.tab_containers_wrap') : $container.children('.ts_containers_wrap');
							this.tab = this.subContainer.children('.tab_container').length ? this.subContainer.children('.tab_container') : this.subContainer.children('.ts_container');

							if ($('.tabs_nav_link').length) {
								$('.tabs_nav_link', this.subContainer).appendTo(this.nav);
							}

							this.startState();

							var self = this;

							$(window).terminus_after_resize(function(){
								self.responsive.bind(self)();
							}, 300);

							this.nav.on('click', 'a:not(.all)', { tabs : this }, this.openSubContainer);

							$.terminus_core.components.servicesCarousel();
						},

						startState : function(){

							var i = this.nav.find('.active').parent().index();

							if(i < 0){
								i = 0;
								this.nav.children().eq(i).children().addClass('active');
							}

							var active = this.tab.eq(i);

							active.siblings().addClass('invisible');

							this.showTab(active);

						},

						openSubContainer : function(event){

							var tabs = event.data.tabs,
								tab = $($(this).attr('href'));

							$(this).addClass('active').parent().siblings().children().removeClass('active');

							tabs.showTab(tab);

							event.preventDefault();

						},

						showTab : function(element){

							var height = element.outerHeight();

							element.removeClass('invisible').siblings().addClass('invisible');

							this.subContainer.css('height', height);

						},

						responsive : function(){

							var height = this.tab.not('.invisible').outerHeight();
							this.subContainer.css('height', height);

						}

					}

				tabs.init();

			});

		},

		terminus_parallax: function (xpos, speedFactor, outerHeight) {

			var $this = $(this);
			var getHeight;
			var firstTop;
			var paddingTop = 0;
			var $window = $(window);
			var windowHeight = $window.height();

			$window.resize(function () {
				windowHeight = $window.height();
			});

			//get the starting position of each element to have parallax applied to it
			$this.each(function(){
				firstTop = $this.offset().top;
			});

			if (outerHeight) {
				getHeight = function(jqo) {
					return jqo.outerHeight(true);
				};
			} else {
				getHeight = function(jqo) {
					return jqo.height();
				};
			}

			// setup defaults if arguments aren't specified
			if (arguments.length < 1 || xpos === null) xpos = "50%";
			if (arguments.length < 2 || speedFactor === null) speedFactor = 0.1;
			if (arguments.length < 3 || outerHeight === null) outerHeight = true;

			// function to be called whenever the window is scrolled or resized
			function update(){
				var pos = $window.scrollTop();

				$this.each(function(){
					var $element = $(this);
					var top = $element.offset().top;
					var height = getHeight($element);

					// Check if totally above or totally below viewport
					if (top + height < pos || top > pos + windowHeight) {
						return;
					}

					$this.css('backgroundPosition', xpos + " " + Math.round((firstTop - pos) * speedFactor) + "px");
				});
			}

			$window.bind('scroll', update).resize(update);
			update();

		}

	});

})(jQuery);

/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 *
 * Open source under the BSD License.
 *
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this list of
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list
 * of conditions and the following disclaimer in the documentation and/or other materials
 * provided with the distribution.
 *
 * Neither the name of the author nor the names of contributors may be used to endorse
 * or promote products derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
 * OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
	{
		def: 'easeOutQuad',
		swing: function (x, t, b, c, d) {
			//alert(jQuery.easing.default);
			return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
		},
		easeInQuad: function (x, t, b, c, d) {
			return c*(t/=d)*t + b;
		},
		easeOutQuad: function (x, t, b, c, d) {
			return -c *(t/=d)*(t-2) + b;
		},
		easeInOutQuad: function (x, t, b, c, d) {
			if ((t/=d/2) < 1) return c/2*t*t + b;
			return -c/2 * ((--t)*(t-2) - 1) + b;
		},
		easeInCubic: function (x, t, b, c, d) {
			return c*(t/=d)*t*t + b;
		},
		easeOutCubic: function (x, t, b, c, d) {
			return c*((t=t/d-1)*t*t + 1) + b;
		},
		easeInOutCubic: function (x, t, b, c, d) {
			if ((t/=d/2) < 1) return c/2*t*t*t + b;
			return c/2*((t-=2)*t*t + 2) + b;
		},
		easeInQuart: function (x, t, b, c, d) {
			return c*(t/=d)*t*t*t + b;
		},
		easeOutQuart: function (x, t, b, c, d) {
			return -c * ((t=t/d-1)*t*t*t - 1) + b;
		},
		easeInOutQuart: function (x, t, b, c, d) {
			if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
			return -c/2 * ((t-=2)*t*t*t - 2) + b;
		},
		easeInQuint: function (x, t, b, c, d) {
			return c*(t/=d)*t*t*t*t + b;
		},
		easeOutQuint: function (x, t, b, c, d) {
			return c*((t=t/d-1)*t*t*t*t + 1) + b;
		},
		easeInOutQuint: function (x, t, b, c, d) {
			if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
			return c/2*((t-=2)*t*t*t*t + 2) + b;
		},
		easeInSine: function (x, t, b, c, d) {
			return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
		},
		easeOutSine: function (x, t, b, c, d) {
			return c * Math.sin(t/d * (Math.PI/2)) + b;
		},
		easeInOutSine: function (x, t, b, c, d) {
			return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
		},
		easeInExpo: function (x, t, b, c, d) {
			return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
		},
		easeOutExpo: function (x, t, b, c, d) {
			return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
		},
		easeInOutExpo: function (x, t, b, c, d) {
			if (t==0) return b;
			if (t==d) return b+c;
			if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
			return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
		},
		easeInCirc: function (x, t, b, c, d) {
			return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
		},
		easeOutCirc: function (x, t, b, c, d) {
			return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
		},
		easeInOutCirc: function (x, t, b, c, d) {
			if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
			return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
		},
		easeInElastic: function (x, t, b, c, d) {
			var s=1.70158;var p=0;var a=c;
			if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
			if (a < Math.abs(c)) { a=c; var s=p/4; }
			else var s = p/(2*Math.PI) * Math.asin (c/a);
			return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		},
		easeOutElastic: function (x, t, b, c, d) {
			var s=1.70158;var p=0;var a=c;
			if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
			if (a < Math.abs(c)) { a=c; var s=p/4; }
			else var s = p/(2*Math.PI) * Math.asin (c/a);
			return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
		},
		easeInOutElastic: function (x, t, b, c, d) {
			var s=1.70158;var p=0;var a=c;
			if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
			if (a < Math.abs(c)) { a=c; var s=p/4; }
			else var s = p/(2*Math.PI) * Math.asin (c/a);
			if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
			return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
		},
		easeInBack: function (x, t, b, c, d, s) {
			if (s == undefined) s = 1.70158;
			return c*(t/=d)*t*((s+1)*t - s) + b;
		},
		easeOutBack: function (x, t, b, c, d, s) {
			if (s == undefined) s = 1.70158;
			return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
		},
		easeInOutBack: function (x, t, b, c, d, s) {
			if (s == undefined) s = 1.70158;
			if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
			return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
		},
		easeInBounce: function (x, t, b, c, d) {
			return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
		},
		easeOutBounce: function (x, t, b, c, d) {
			if ((t/=d) < (1/2.75)) {
				return c*(7.5625*t*t) + b;
			} else if (t < (2/2.75)) {
				return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
			} else if (t < (2.5/2.75)) {
				return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
			} else {
				return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
			}
		},
		easeInOutBounce: function (x, t, b, c, d) {
			if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
			return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
		}
	});

/*
 * Copyright (C) 2009 Joel Sutherland
 * Licenced under the MIT license
 * http://www.newmediacampaigns.com/page/jquery-flickr-plugin
 *
 * Available tags for templates:
 * title, link, date_taken, description, published, author, author_id, tags, image*
 */
(function($){$.fn.jflickrfeed=function(settings,callback){settings=$.extend(true,{flickrbase:'http://api.flickr.com/services/feeds/',feedapi:'photos_public.gne',limit:20,qstrings:{lang:'en-us',format:'json',jsoncallback:'?'},cleanDescription:true,useTemplate:true,itemTemplate:'',itemCallback:function(){}},settings);var url=settings.flickrbase+settings.feedapi+'?';var first=true;for(var key in settings.qstrings){if(!first)
	url+='&';url+=key+'='+settings.qstrings[key];first=false;}
	return $(this).each(function(){var $container=$(this);var container=this;$.getJSON(url,function(data){$.each(data.items,function(i,item){if(i<settings.limit){if(settings.cleanDescription){var regex=/<p>(.*?)<\/p>/g;var input=item.description;if(regex.test(input)){item.description=input.match(regex)[2]
		if(item.description!=undefined)
			item.description=item.description.replace('<p>','').replace('</p>','');}}
		item['image_s']=item.media.m.replace('_m','_s');item['image_t']=item.media.m.replace('_m','_t');item['image_m']=item.media.m.replace('_m','_m');item['image']=item.media.m.replace('_m','');item['image_b']=item.media.m.replace('_m','_b');delete item.media;if(settings.useTemplate){var template=settings.itemTemplate;for(var key in item){var rgx=new RegExp('{{'+key+'}}','g');template=template.replace(rgx,item[key]);}
			$container.append(template)}
		settings.itemCallback.call(container,item);}});if($.isFunction(callback)){callback.call(container,data);}});});}})(jQuery);




/**************************************************************************
 *------------------------ COMINGSOON COUNTER 1.1 ------------------------
 * ========================================================================
 * Copyright 2014 Bruno Milgiaretti http://www.sisteminterattivi.org
 * Licensed under MIT http://opensource.org/licenses/MIT
 * ========================================================================
 Usage:
 Constructor:
 $(selector).mbComingsoon(expiryDate Date or String) Expiry date of counter
 $(selector).mbComingsoon(options plain Object) options: {
																expiryDate: Date,   //Expiry Date required
																interval: Number,   //Update interval in milliseconds (default = 1000))
                                                                localization: {
                                                                    days: "days",           //Localize labels of counter
                                                                    hours: "hours",
                                                                    minutes: "minutes",
                                                                    seconds: "seconds"
                                                                }
																callBack: Function  //Function executed on expiry or if espired
															}
 Methds:
 .mbComingSoon('start') // start counter
 .mbComingSoon('stop') // stop counter
 .mbComingSoon(options) // change options

 Note: Max time that the counter can display is 999 days 23h 59' 59". If time is greater hours, minutes and seconds will be displayed
 correctly, but days will be 999 until decrease under this quota.
 */

(function ($) {
	// Class Definition
	var MbComingsoon;
	MbComingsoon = function (date, element, localization, speed, callBack, gmt, showText) {
		this.$el = $(element);
		this.gmt = gmt;
		this.showText = showText;
		this.end = date;
		this.active = false;
		this.interval = 1000;
		this.speed = speed;
		if (jQuery.isFunction(callBack))
			this.callBack = callBack;
		else
			this.callBack = null;
		this.localization = {days: "days", hours: "hours", minutes: "minutes", seconds: "seconds"};
		$.extend(this.localization, this.localization, localization);

	}

	MbComingsoon.prototype = {
		// Returns an object containing counter data
		getCounterNumbers: function () {
			var result = {
					days   : {
						tens    : 0,
						units   : 0,
						hundreds: 0
					},
					hours  : {
						tens : 0,
						units: 0
					},
					minutes: {
						tens : 0,
						units: 0
					},
					seconds: {
						tens : 0,
						units: 0
					}
				}, millday = 1000 * 60 * 60 * 24,
				millhour = 1000 * 60 * 60,
				millminutes = 1000 * 60,
				millseconds = 1000,
				rest = 0
				;

			var now = new Date();
			var time_gmt = now.getTimezoneOffset() / 60 + this.gmt;
			var diff = this.end.getTime() - now.getTime() - (time_gmt * 60 * 60000);
			// CountDown expired !!
			if (diff <= 0)
				return result;

			// Max number of days is 99 (i will expand in future versions)
			var days = Math.min(Math.floor(diff / millday), 999);
			rest = diff % millday;

			result.days.hundreds = Math.floor(days / 100);
			var dayrest = days % 100;
			result.days.tens = Math.floor(dayrest / 10);
			result.days.units = dayrest % 10;

			var hours = Math.floor(rest / millhour);
			rest = rest % millhour;
			result.hours.tens = Math.floor(hours / 10);
			result.hours.units = hours % 10;

			var minutes = Math.floor(rest / millminutes);
			rest = rest % millminutes;
			result.minutes.tens = Math.floor(minutes / 10);
			result.minutes.units = minutes % 10;

			var seconds = Math.floor(rest / 1000);
			result.seconds.tens = Math.floor(seconds / 10);
			result.seconds.units = seconds % 10;
			return result;
		},
		// If changed update a part (day, hours, minutes, seconds) of counter
		updatePart       : function (part) {
			var cn = this.getCounterNumbers();
			var $part = $('.' + part, this.$el);
			if (part == 'days') {
				this.setDayHundreds(cn.days.hundreds > 0);
				if ($part.find('.number.hundreds.show').html() != cn[part].hundreds) {
					var $n1 = $('.n1.hundreds', $part);
					var $n2 = $('.n2.hundreds', $part);
					this.scrollNumber($n1, $n2, cn[part].hundreds);
				}
			}
			if ($part.find('.number.tens.show').html() != cn[part].tens) {
				var $n1 = $('.n1.tens', $part);
				var $n2 = $('.n2.tens', $part);
				this.scrollNumber($n1, $n2, cn[part].tens);

			}
			if ($part.find('.number.units.show').html() != cn[part].units) {
				var $n1 = $('.n1.units', $part);
				var $n2 = $('.n2.units', $part);
				this.scrollNumber($n1, $n2, cn[part].units);
			}
			// Only forn day part update hundreds
		},
		// True if countdown is expired
		timeOut          : function () {
			var now = new Date()
			var time_gmt = now.getTimezoneOffset() / 60 + this.gmt;
			var diff = this.end.getTime() - now.getTime() - (time_gmt * 60 * 60000);
			if (diff <= 0)
				return true;
			return false;
		},
		setDayHundreds   : function (action) {
			if (action)
				$('.counter.days', this.$el).addClass('with-hundreds');
			else
				$('.counter.days', this.$el).removeClass('with-hundreds');
		},
		// Update entire counter
		updateCounter    : function () {
			this.updatePart('days');
			this.updatePart('hours');
			this.updatePart('minutes');
			this.updatePart('seconds');
			if (this.timeOut()) {
				this.active = false;
				if (this.callBack)
					this.callBack(this);
			}
		},
		localize         : function (localization) {
			if ($.isPlainObject(localization))
				$.extend(this.localization, this.localization, localization);
			$('.days', this.$el).siblings('.counter-caption').text(this.localization.days);
			$('.hours', this.$el).siblings('.counter-caption').text(this.localization.hours);
			$('.minutes', this.$el).siblings('.counter-caption').text(this.localization.minutes);
			$('.seconds', this.$el).siblings('.counter-caption').text(this.localization.seconds);
		},
		// Start automatic update (interval in milliseconds)
		start            : function (interval) {
			if (interval)
				this.interval = interval;
			var i = this.interval;
			this.active = true;
			var me = this;
			setTimeout(function () {
				me.updateCounter();
				if (me.active)
					me.start();
			}, i);
		},
		// Stop automatic update
		stop             : function () {
			this.active = false;
		},
		// Animation of a single
		scrollNumber     : function ($n1, $n2, value) {
			if ($n1.hasClass('show')) {
				$n2.removeClass('hidden-down')
					.css('top', '-100%')
					.text(value)
					.stop()
					.animate({ top: 0 }, this.speed, function () {
						$n2.addClass('show');
					});
				$n1.stop().animate({ top: "100%" }, this.speed, function () {
					$n1.removeClass('show')
						.addClass('hidden-down');
				});
			} else {
				$n1.removeClass('hidden-down')
					.css('top', '-100%')
					.text(value)
					.stop()
					.animate({ top: 0 }, this.speed, function () {
						$n1.addClass('show');
					});
				$n2.stop().animate({ top: "100%" }, this.speed, function () {
					$n2.removeClass('show')
						.addClass('hidden-down');
				});
			}
		}
	}

	// jQuery plugin
	jQuery.fn.mbComingsoon = function (opt) {
		var defaults = {
			interval    : 1000,
			callBack    : null,
			localization: { days: "Days", hours: "Hours", minutes: "Minutes", seconds: "Seconds" },
			speed       : 500,
			gmt         : 0,
			showText    : 1
		}

		var options = {};

		var content = '   <div class="counter-group" id="myCounter">' +
			'       <div class="counter-block">' +
			'           <div class="counter days">' +
			'               <div class="number show n1 hundreds">0</div>' +
			'               <div class="number show n1 tens">0</div>' +
			'               <div class="number show n1 units">0</div>' +
			'               <div class="number hidden-up n2 hundreds">0</div>' +
			'               <div class="number hidden-up n2 tens">0</div>' +
			'               <div class="number hidden-up n2 units">0</div>' +
			'           </div>' +
			'           <div class="counter-caption">Days</div>' +
			'       </div>' +
			'       <div class="counter-block">' +
			'           <div class="counter hours">' +
			'               <div class="number show n1 tens">0</div>' +
			'               <div class="number show n1 units">0</div>' +
			'               <div class="number hidden-up n2 tens">0</div>' +
			'               <div class="number hidden-up n2 units">0</div>' +
			'           </div>' +
			'           <div class="counter-caption">Hours</div>' +
			'       </div>' +
			'       <div class="counter-block">' +
			'           <div class="counter minutes">' +
			'               <div class="number show n1 tens">0</div>' +
			'               <div class="number show n1 units">0</div>' +
			'               <div class="number hidden-up n2 tens">0</div>' +
			'               <div class="number hidden-up n2 units">0</div>' +
			'           </div>' +
			'           <div class="counter-caption">Minutes</div>' +
			'       </div>' +
			'       <div class="counter-block">' +
			'           <div class="counter seconds">' +
			'               <div class="number show n1 tens">0</div>' +
			'               <div class="number show n1 units">0</div>' +
			'               <div class="number hidden-up n2 tens">0</div>' +
			'               <div class="number hidden-up n2 units">0</div>' +
			'           </div>' +
			'           <div class="counter-caption">Seconds</div>' +
			'       </div>' +
			'   </div>';

		return this.each(function () {
			var $this = $(this);
			var data = $this.data('mbComingsoon');

			if (!data) {
				if (opt instanceof Date)
					options.expiryDate = opt;
				else if ($.isPlainObject(opt))
					$.extend(options, defaults, opt);
				else if (typeof opt == "string")
					options.expiryDate = new Date(opt);
				if (!options.expiryDate)
					throw new Error('Expiry date is required!');

				data = new MbComingsoon(options.expiryDate, $this, options.localization, options.speed, options.callBack, options.gmt, options.showText);

				if (options.showText) {
					$this.html(content);
				}
				data.localize();
				data.start();
			} else if (opt == 'start') {
				data.start();
			} else if (opt == 'stop') {
				data.stop();
			} else if ($.isPlainObject(opt)) {
				if (opt.expiryDate instanceof Date)
					data.end = opt.expiryDate;
				if ($.isNumeric(opt.interval))
					data.interval = opt.interval;
				if ($.isNumeric(opt.gmt))
					data.gmt = opt.gmt;
				if ($.isNumeric(opt.showText))
					data.showText = opt.showText;
				if ($.isFunction(opt.callBack))
					data.callBack = opt.callBack;
				if ($.isPlainObject(opt.localization))
					this.localize(opt.localization);
			}
		})
	}

})(jQuery);