!function(){function t(e){var o=i[e],n="exports";return"object"==typeof o?o:(o[n]||(o[n]={},o[n]=o.call(o[n],t,o[n],o)||o[n]),o[n])}function e(t,e){i[t]=e}var i={};e("jquery",function(){return jQuery}),e("popup",function(t){function e(){this.destroyed=!1,this.__popup=i("<div />").css({display:"none",position:"absolute",outline:0}).attr("tabindex","-1").html(this.innerHTML).appendTo("body"),this.__backdrop=this.__mask=i("<div />").css({opacity:.7,background:"#000"}),this.node=this.__popup[0],this.backdrop=this.__backdrop[0],o++}var i=t("jquery"),o=0,n=!("minWidth"in i("html")[0].style),s=!n;return i.extend(e.prototype,{node:null,backdrop:null,fixed:!1,destroyed:!0,open:!1,returnValue:"",autofocus:!0,align:"bottom left",innerHTML:"",className:"ui-popup",show:function(t){if(this.destroyed)return this;var o=this.__popup,r=this.__backdrop;if(this.__activeElement=this.__getActive(),this.open=!0,this.follow=t||this.follow,!this.__ready){if(o.addClass(this.className).attr("role",this.modal?"alertdialog":"dialog").css("position",this.fixed?"fixed":"absolute"),n||i(window).on("resize",i.proxy(this.reset,this)),this.modal){var a={position:"fixed",left:0,top:0,width:"100%",height:"100%",overflow:"hidden",userSelect:"none",zIndex:this.zIndex||e.zIndex};o.addClass(this.className+"-modal"),s||i.extend(a,{position:"absolute",width:i(window).width()+"px",height:i(document).height()+"px"}),r.css(a).attr({tabindex:"0"}).on("focus",i.proxy(this.focus,this)),this.__mask=r.clone(!0).attr("style","").insertAfter(o),r.addClass(this.className+"-backdrop").insertBefore(o),this.__ready=!0}o.html()||o.html(this.innerHTML)}return o.addClass(this.className+"-show").show(),r.show(),this.reset().focus(),this.__dispatchEvent("show"),this},showModal:function(){return this.modal=!0,this.show.apply(this,arguments)},close:function(t){return!this.destroyed&&this.open&&(void 0!==t&&(this.returnValue=t),this.__popup.hide().removeClass(this.className+"-show"),this.__backdrop.hide(),this.open=!1,this.blur(),this.__dispatchEvent("close")),this},remove:function(){if(this.destroyed)return this;this.__dispatchEvent("beforeremove"),e.current===this&&(e.current=null),this.__popup.remove(),this.__backdrop.remove(),this.__mask.remove(),n||i(window).off("resize",this.reset),this.__dispatchEvent("remove");for(var t in this)delete this[t];return this},reset:function(){var t=this.follow;return t?this.__follow(t):this.__center(),this.__dispatchEvent("reset"),this},focus:function(){var t=this.node,o=this.__popup,n=e.current,s=this.zIndex=e.zIndex++;if(n&&n!==this&&n.blur(!1),!i.contains(t,this.__getActive())){var r=o.find("[autofocus]")[0];!this._autofocus&&r?this._autofocus=!0:r=t,this.__focus(r)}return o.css("zIndex",s),e.current=this,o.addClass(this.className+"-focus"),this.__dispatchEvent("focus"),this},blur:function(){var t=this.__activeElement,e=arguments[0];return e!==!1&&this.__focus(t),this._autofocus=!1,this.__popup.removeClass(this.className+"-focus"),this.__dispatchEvent("blur"),this},addEventListener:function(t,e){return this.__getEventListener(t).push(e),this},removeEventListener:function(t,e){for(var i=this.__getEventListener(t),o=0;o<i.length;o++)e===i[o]&&i.splice(o--,1);return this},__getEventListener:function(t){var e=this.__listener;return e||(e=this.__listener={}),e[t]||(e[t]=[]),e[t]},__dispatchEvent:function(t){var e=this.__getEventListener(t);this["on"+t]&&this["on"+t]();for(var i=0;i<e.length;i++)e[i].call(this)},__focus:function(t){try{this.autofocus&&!/^iframe$/i.test(t.nodeName)&&t.focus()}catch(e){}},__getActive:function(){try{var t=document.activeElement,e=t.contentDocument,i=e&&e.activeElement||t;return i}catch(o){}},__center:function(){var t=this.__popup,e=i(window),o=i(document),n=this.fixed,s=n?0:o.scrollLeft(),r=n?0:o.scrollTop(),a=e.width(),c=e.height(),l=t.width(),h=t.height(),d=(a-l)/2+s,u=382*(c-h)/1e3+r,f=t[0].style;f.left=Math.max(parseInt(d),s)+"px",f.top=Math.max(parseInt(u),r)+"px"},__follow:function(t){var e=t.parentNode&&i(t),o=this.__popup;if(this.__followSkin&&o.removeClass(this.__followSkin),e){var n=e.offset();if(n.left*n.top<0)return this.__center()}var s=this,r=this.fixed,a=i(window),c=i(document),l=a.width(),h=a.height(),d=c.scrollLeft(),u=c.scrollTop(),f=o.width(),p=o.height(),v=e?e.outerWidth():0,_=e?e.outerHeight():0,g=this.__offset(t),m=g.left,b=g.top,y=r?m-d:m,w=r?b-u:b,k=r?0:d,x=r?0:u,E=k+l-f,L=x+h-p,C={},N=this.align.split(" "),$=this.className+"-",T={top:"bottom",bottom:"top",left:"right",right:"left"},I={top:"top",bottom:"top",left:"left",right:"left"},z=[{top:w-p,bottom:w+_,left:y-f,right:y+v},{top:w,bottom:w-p+_,left:y,right:y-f+v}],M={left:y+v/2-f/2,top:w+_/2-p/2},j={left:[k,E],top:[x,L]};i.each(N,function(t,e){z[t][e]>j[I[e]][1]&&(e=N[t]=T[e]),z[t][e]<j[I[e]][0]&&(N[t]=T[e])}),N[1]||(I[N[1]]="left"===I[N[0]]?"top":"left",z[1][N[1]]=M[I[N[1]]]),$+=N.join("-")+" "+this.className+"-follow",s.__followSkin=$,e&&o.addClass($),C[I[N[0]]]=parseInt(z[0][N[0]]),C[I[N[1]]]=parseInt(z[1][N[1]]),o.css(C)},__offset:function(t){var e=t.parentNode,o=e?i(t).offset():{left:t.pageX,top:t.pageY};t=e?t:t.target;var n=t.ownerDocument,s=n.defaultView||n.parentWindow;if(s==window)return o;var r=s.frameElement,a=i(n),c=a.scrollLeft(),l=a.scrollTop(),h=i(r).offset(),d=h.left,u=h.top;return{left:o.left+d-c,top:o.top+u-l}}}),e.zIndex=1024,e.current=null,e}),e("dialog-config",{backdropBackground:"#000",backdropOpacity:.7,content:'<span class="ui-dialog-loading">Loading..</span>',title:"",statusbar:"",button:null,ok:null,cancel:null,okValue:"ok",cancelValue:"cancel",cancelDisplay:!0,width:"",height:"",padding:"",skin:"",quickClose:!1,cssUri:"../css/ui-dialog.css",innerHTML:'<div i="dialog" class="ui-dialog"><div class="ui-dialog-arrow-a"></div><div class="ui-dialog-arrow-b"></div><table class="ui-dialog-grid"><tr><td i="header" class="ui-dialog-header"><button i="close" class="ui-dialog-close">&#215;</button><div i="title" class="ui-dialog-title"></div></td></tr><tr><td i="body" class="ui-dialog-body"><div i="content" class="ui-dialog-content"></div></td></tr><tr><td i="footer" class="ui-dialog-footer"><div i="statusbar" class="ui-dialog-statusbar"></div><div i="button" class="ui-dialog-button"></div></td></tr></table></div>'}),e("dialog",function(t){var e=t("jquery"),i=t("popup"),o=t("dialog-config"),n=o.cssUri;if(n){var s=t[t.toUrl?"toUrl":"resolve"];s&&(n=s(n),n='<link rel="stylesheet" href="'+n+'" />',e("base")[0]?e("base").before(n):e("head").append(n))}var r=0,a=new Date-0,c=!("minWidth"in e("html")[0].style),l="createTouch"in document&&!("onmousemove"in document)||/(iPhone|iPad|iPod)/i.test(navigator.userAgent),h=!c&&!l,d=function(t,i,o){var n=t=t||{};("string"==typeof t||1===t.nodeType)&&(t={content:t,fixed:!l}),t=e.extend(!0,{},d.defaults,t),t.original=n;var s=t.id=t.id||a+r,c=d.get(s);return c?c.focus():(h||(t.fixed=!1),t.quickClose&&(t.modal=!0,t.backdropOpacity=0),e.isArray(t.button)||(t.button=[]),void 0!==i&&(t.ok=i),t.ok&&t.button.push({id:"ok",value:t.okValue,callback:t.ok,autofocus:!0}),void 0!==o&&(t.cancel=o),t.cancel&&t.button.push({id:"cancel",value:t.cancelValue,callback:t.cancel,display:t.cancelDisplay}),d.list[s]=new d.create(t))},u=function(){};u.prototype=i.prototype;var f=d.prototype=new u;return d.create=function(t){var o=this;e.extend(this,new i);var n=(t.original,e(this.node).html(t.innerHTML)),s=e(this.backdrop);return this.options=t,this._popup=n,e.each(t,function(t,e){"function"==typeof o[t]?o[t](e):o[t]=e}),t.zIndex&&(i.zIndex=t.zIndex),n.attr({"aria-labelledby":this._$("title").attr("id","title:"+this.id).attr("id"),"aria-describedby":this._$("content").attr("id","content:"+this.id).attr("id")}),this._$("close").css("display",this.cancel===!1?"none":"").attr("title",this.cancelValue).on("click",function(t){o._trigger("cancel"),t.preventDefault()}),this._$("dialog").addClass(this.skin),this._$("body").css("padding",this.padding),t.quickClose&&s.on("onmousedown"in document?"mousedown":"click",function(){return o._trigger("cancel"),!1}),this.addEventListener("show",function(){s.css({opacity:0,background:t.backdropBackground}).animate({opacity:t.backdropOpacity},150)}),this._esc=function(t){var e=t.target,n=e.nodeName,s=/^input|textarea$/i,r=i.current===o,a=t.keyCode;!r||s.test(n)&&"button"!==e.type||27===a&&o._trigger("cancel")},e(document).on("keydown",this._esc),this.addEventListener("remove",function(){e(document).off("keydown",this._esc),delete d.list[this.id]}),r++,d.oncreate(this),this},d.create.prototype=f,e.extend(f,{content:function(t){var i=this._$("content");return"object"==typeof t?(t=e(t),i.empty("").append(t.show()),this.addEventListener("beforeremove",function(){e("body").append(t.hide())})):i.html(t),this.reset()},title:function(t){return this._$("title").text(t),this._$("header")[t?"show":"hide"](),this},width:function(t){return this._$("content").css("width",t),this.reset()},height:function(t){return this._$("content").css("height",t),this.reset()},button:function(t){t=t||[];var i=this,o="",n=0;return this.callbacks={},"string"==typeof t?(o=t,n++):e.each(t,function(t,s){var r=s.id=s.id||s.value,a="";i.callbacks[r]=s.callback,s.display===!1?a=' style="display:none"':n++,o+='<button type="button" i-id="'+r+'"'+a+(s.disabled?" disabled":"")+(s.autofocus?' autofocus class="ui-dialog-autofocus"':"")+">"+s.value+"</button>",i._$("button").on("click","[i-id="+r+"]",function(t){var o=e(this);o.attr("disabled")||i._trigger(r),t.preventDefault()})}),this._$("button").html(o),this._$("footer")[n?"show":"hide"](),this},statusbar:function(t){return this._$("statusbar").html(t)[t?"show":"hide"](),this},_$:function(t){return this._popup.find("[i="+t+"]")},_trigger:function(t){var e=this.callbacks[t];return"function"!=typeof e||e.call(this)!==!1?this.close().remove():this}}),d.oncreate=e.noop,d.getCurrent=function(){return i.current},d.get=function(t){return void 0===t?d.list:d.list[t]},d.list={},d.defaults=o,d}),e("drag",function(t){var e=t("jquery"),i=e(window),o=e(document),n="createTouch"in document,s=document.documentElement,r=!("minWidth"in s.style),a=!r&&"onlosecapture"in s,c="setCapture"in s,l={start:n?"touchstart":"mousedown",over:n?"touchmove":"mousemove",end:n?"touchend":"mouseup"},h=n?function(t){return t.touches||(t=t.originalEvent.touches.item(0)),t}:function(t){return t},d=function(){this.start=e.proxy(this.start,this),this.over=e.proxy(this.over,this),this.end=e.proxy(this.end,this),this.onstart=this.onover=this.onend=e.noop};return d.types=l,d.prototype={start:function(t){return t=this.startFix(t),o.on(l.over,this.over).on(l.end,this.end),this.onstart(t),!1},over:function(t){return t=this.overFix(t),this.onover(t),!1},end:function(t){return t=this.endFix(t),o.off(l.over,this.over).off(l.end,this.end),this.onend(t),!1},startFix:function(t){return t=h(t),this.target=e(t.target),this.selectstart=function(){return!1},o.on("selectstart",this.selectstart).on("dblclick",this.end),a?this.target.on("losecapture",this.end):i.on("blur",this.end),c&&this.target[0].setCapture(),t},overFix:function(t){return t=h(t)},endFix:function(t){return t=h(t),o.off("selectstart",this.selectstart).off("dblclick",this.end),a?this.target.off("losecapture",this.end):i.off("blur",this.end),c&&this.target[0].releaseCapture(),t}},d.create=function(t,n){var s,r,a,c,l=e(t),h=new d,u=d.types.start,f=function(){},p=t.className.replace(/^\s|\s.*/g,"")+"-drag-start",v={onstart:f,onover:f,onend:f,off:function(){l.off(u,h.start)}};return h.onstart=function(e){var n="fixed"===l.css("position"),h=o.scrollLeft(),d=o.scrollTop(),u=l.width(),f=l.height();s=0,r=0,a=n?i.width()-u+s:o.width()-u,c=n?i.height()-f+r:o.height()-f;var _=l.offset(),g=this.startLeft=n?_.left-h:_.left,m=this.startTop=n?_.top-d:_.top;this.clientX=e.clientX,this.clientY=e.clientY,l.addClass(p),v.onstart.call(t,e,g,m)},h.onover=function(e){var i=e.clientX-this.clientX+this.startLeft,o=e.clientY-this.clientY+this.startTop,n=l[0].style;i=Math.max(s,Math.min(a,i)),o=Math.max(r,Math.min(c,o)),n.left=i+"px",n.top=o+"px",v.onover.call(t,e,i,o)},h.onend=function(e){var i=l.position(),o=i.left,n=i.top;l.removeClass(p),v.onend.call(t,e,o,n)},h.off=function(){l.off(u,h.start)},n?h.start(n):l.on(u,h.start),v},d}),e("dialog-plus",function(t){var e=t("jquery"),i=t("dialog"),o=t("drag");return i.oncreate=function(t){var i,n=t.options,s=n.original,r=n.url,a=n.oniframeload;if(r&&(this.padding=n.padding=0,i=e("<iframe />"),i.attr({src:r,name:t.id,width:"100%",height:"100%",allowtransparency:"yes",frameborder:"no",scrolling:"no"}).on("load",function(){var e;try{e=i[0].contentWindow.frameElement}catch(o){}e&&(n.width||t.width(i.contents().width()),n.height||t.height(i.contents().height())),a&&a.call(t)}),t.addEventListener("beforeremove",function(){i.attr("src","about:blank").remove()},!1),t.content(i[0]),t.iframeNode=i[0]),!(s instanceof Object))for(var c=function(){t.close().remove()},l=0;l<frames.length;l++)try{if(s instanceof frames[l].Object){e(frames[l]).one("unload",c);break}}catch(h){}e(t.node).on(o.types.start,"[i=title]",function(e){t.follow||(t.focus(),o.create(t.node,e))})},i.get=function(t){if(t&&t.frameElement){var e,o=t.frameElement,n=i.list;for(var s in n)if(e=n[s],e.node.getElementsByTagName("iframe")[0]===o)return e}else if(t)return i.list[t]},i}),window.dialog=t("dialog-plus")}();