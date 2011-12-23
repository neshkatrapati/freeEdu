document.onkeydown=function(e){
  var eventKey = e.keyCode || e.charCode;
  var sel = Coverflow.selected;
  if(eventKey == 39 || eventKey == 37) {
		if(eventKey == 39) sel++;
	  else if(eventKey == 37) sel--;
	  sel = sel.limit(0, Coverflow.getListLength() - 1);
	  Coverflow.select(sel);
	}
}

function enterDetect(e){
  e = e || window.event;
  var code = e.keyCode || e.which;
  if(code == 13) return true;
  else return false;
}

function CVFL$native(){
	for(var i = 0, l = arguments.length; i < l; i++)
		arguments[i].implement = function(o){
			for(var p in o)
				if(!this.prototype[p])
					this.prototype[p] = o[p];
		};
};
if(!Array.implement || !Function.implement || !Number.implement || !String.implement)	CVFL$native(Array, Function, Number, String);
Array.implement({
	contains: function(i){
		return this.indexOf(i) != -1;
	},
	indexOf: function(item){
		for(var i = 0, l = this.length; i < l; i++)
			if(this[i] == item)
				return true;
		return false;
	}
});

Function.implement({
	bind: function(o, args){
		var fn1 = this;
		var fn2 = function(){
			return fn1.apply(o, arguments || args);
		}
		return fn2;
	},
	periodical: function(t, b){
		var f1 = this;
		var f2 = function(){
			return f1.apply(b || window);
		}
		return setInterval(f2, t);
	}
});

Number.implement({
	limit: function(a, b){
		return Math.min(b, Math.max(a, this));
	}
});

String.implement({
	camelCase: function()	{
		return this.replace(/\-\w/g, function(m){
			return m.charAt(1).toUpperCase();
		});
	},
	contains: function(t, s){
		s = s || '';
		return (s + this + s).indexOf(s + t + s) != -1;
	},
	hyphenate: function(){
		return this.replace(/[A-Z]/g, function(m){
			return '-' + m.charAt(0).toLowerCase();
		});
	},
	toFloat: function(){
		return parseFloat(this);
	}
});

Number.prototype.toFloat = String.prototype.toFloat;

window.webkit = navigator.appVersion.contains('WebKit');

var CVFLClass = function(o){
	var k = function(){
		return this.init ? this.init.apply(this, arguments) : this;
	}
	k.prototype = o || {};
	CVFL$extend(k, this);
	k.prototype.setOptions = function(o){
		var m = {};
		for(var p in this.options)
			m[p] = this.options[p];
		for(var p in o)
			m[p] = o[p];
		this.options = m;
	};
	return k;
};

var CVFLEl ={
	getStyle: function(p, ps){
		var v = this.style[p.camelCase()];
		if(document.defaultView && (v == '' || ps))
			v = document.defaultView.getComputedStyle(this, ps || null).getPropertyValue(p.hyphenate());
		else if(this.currentStyle && v == '')
			v = this.currentStyle[p.camelCase()];
		if(v == 'auto' && p == 'height')
			return this.getHeight();
		if(v == NaN)
			return 0;
		return v;
	},
	htmlElement: true,
	remove: function(){
		this.parentNode.removeChild(this);
		return this.parentNode;
	},
	setStyle: function(p, v){
		this.style[p] = v;
		return this;
	},
	setStyles: function(o){
		for(var p in o)
			this.setStyle(p, o[p]);
		return this;
	}
};

function CVFL$extend(a, b){
	for(var p in b)
		a[p] = b[p];
	return a;
};

function CVFL$(el){
	if(el.htmlElement) return el;
	if(typeof el == 'string')
		el = document.getElementById(el);
	return el ? CVFL$extend(el, CVFLEl) : false;
};

/******************************************/
var Anim = new CVFLClass({
	options:{
		duration: 300,
		overflow: true,
		onComplete: function(){},
		transition: function(i){
			return (i <= 0.5) ? Math.pow((2 * i), 4) / 2 : (2 - Math.pow((2 * (1 - i)), 4)) / 2;
		}
	},
	init: function(el, o){
		this.el = CVFL$(el);
		this.setOptions(o);
		return this;
	},
	start: function(o){
		this.stop();
		this.now = {}; this.from = {}; this.to = {};
		for(var p in o){
			var from = o[p][0], to = o[p][1];
			if(!to && to != 0) to = from, from = parseFloat(this.el.getStyle(p));
			this.from[p] = from; this.to[p] = to;
		}
		if(this.options.overflow)	this.el.style.overflow = 'hidden';
		this.startTime = new Date().getTime();
		this.timer = this.step.periodical(1000/60, this);
		return this;
	},
	calc: function(){
		for(var p in this.from){
			var d = this.options.transition(this.d);
			this.now[p] = (this.to[p] - this.from[p]) * d + this.from[p];
		}
	},
	set: function(){
		for(var p in this.now){
			var unit = (['opacity', 'zindex'].contains(p.toLowerCase())) ? '' : 'px';
			if(p.contains('color'))	this.now[p] = parseInt(this.now[p]);
			if(p == 'opacity' && window.ie)	this.el.style['filter'] = 'alpha(opacity='+ parseInt(this.now[p] * 100) +')';
			this.el.style[p] = this.now[p] + unit;
		}
	},

	step: function(){
		var time = new Date().getTime();
		if(time < this.startTime + this.options.duration){
			this.d = (time - this.startTime) / this.options.duration;
			this.calc(); this.set();
		}else{
			this.stop();
			this.now = this.to;
			this.set();
			this.options.onComplete.call(this, this.el);
		}
	},
	stop: function(){
		clearInterval(this.timer);
	}
});

if(typeof TILT == 'undefined') TILT = true;

var isChrome=navigator.userAgent.toLowerCase().indexOf('chrome') > -1;

var Coverflow ={
	dbOffset:15,
	alreadyInit:false,
	touchingList:false,
	load: 9000,
	scrollable: true,
	containerWidth: 537.68,//0
	list: [],
	options:{
		bgColor: '#272727', //272727',
		middleSpace: 10,
		createLabel: function(item){
			return item.label;
		},
		onSelectCenter: function(){},
		refill: function(start){}		
	},
	selected: 3, // N° de l'image affichée (0 première, 3=aspect centré
	check: function(){
		this.load--;
		if(this.load == 0){
			this.container.className = '';
			this.containerWidth = this.widthOffset*2 + this.options.middleSpace + 200;
			this.setup();
			this.wrapperAnim.options.onComplete = function(){};
			if (!this.alreadyInit) {
				this.wrapperAnim.start({opacity: [1]});
				this.alreadyInit = true;
			}
			this.scrollable = true;
		}
	},
	init: function(list, o){
		this.scrollable = false;
		this.list = list || this.list;
		o = o || {};
		for(var p in o)	this.options[p] = o[p];

		this.container = CVFL$('__cvfl-coverflow');
		this.container.className = 'loading';
		this.wrapper = CVFL$('__cvfl-coverflow-wrapper');
		this.wrapperAnim = new Anim(this.wrapper);
		this.label = CVFL$('__cvfl-coverflow-label');
		this.labelAnim = new Anim(this.label);
		if (!this.alreadyInit) {
			this.label.style.opacity = 0;
			this.wrapper.style.opacity = 0;
			
		}
		this.wrapper.innerHTML = '';
		

		this.load = this.getListLength();
		for(var i = 0; i < this.getListLength(); i++){
			var img = new Image();
			img.onload = function(){
				Coverflow.check();
				Coverflow.widthOffset = img.width * Coverflow.wr;
				Coverflow.imageWidth = img.width;
			};
			img.src = this.getListElement(i).src;
		}
		
	},

	hr: 0.62, wr: 0.64, mt: 12, mh: 50,
	widthOffset: 163.84, // Hack: default value=0 but sometimes FF is long to calculate the correct value

	setup: function(list){
		var sel = this.selected;

		var element = document.getElementById("smallerPreview");
	        element.innerHTML = "<img src='" + this.list[sel].src + "'></img>";

		var start = (sel >= 3) ? sel - 3 : 0;
		var end = (sel >= 3) ? start + 7 : sel + 4;
		if(end > this.getListLength()) end = this.getListLength();
		for(var i = start; i < end; i++){
			var img = new Image(); img.src = this.getListElement(i).src;
			img.id = '__cvfl-img-'+ i;
			img.onclick = function(){
				return Coverflow.select.apply(Coverflow, arguments);
			};
			this.wrapper.appendChild(img);

			var j = Math.abs(sel - i);
			var lOffset, zIndex;
			var hr = this.hr, wr = this.wr;
			if(i < sel){
				lOffset = (150 - (j * 50));
				zIndex = 500 - (j * 50);
				this.tilt(img, 'l', hr, wr, lOffset, zIndex);
			}	else if(i == sel)	{
				lOffset = (this.widthOffset*2 - this.imageWidth + this.options.middleSpace) / 2 + 100;
				zIndex = 500;
				this.tilt(img, 'n', 1, 1, lOffset, zIndex);
			}	else{
				lOffset = (this.containerWidth - 100 - this.widthOffset) + (50 * (j - 1));
				zIndex = 500 - (j * 50);
				this.tilt(img, 'r', hr, wr, lOffset, zIndex);
			}
		}
		CVFL$('__cvfl-img-'+ this.selected).style.cursor = 'pointer';
		this.showLabel(this.selected);
	},

	working: false,
	chainDuration: 300,
	chains: [],
	select: function(n){
		if (Lightbox.alreadyDisplaying) {
			Lightbox.close();
			return;
		}
		
		if(this.working) return;
		this.clearTimers();
		if(typeof n != 'number'){
			var id = n.target.id;
			var sel = parseInt(id.match(/__cvfl-img-(\d+)/)[1]);
		}	else var sel = n;
		sel = sel.limit(0, this.getListLength() - 1);
		if(this.selected == sel){
			if(typeof n != 'number')
				this.options.onSelectCenter.call(Coverflow, this.getListElement(sel), '__cvfl-img-'+ sel);
			return;
		}

		var element = document.getElementById("smallerPreview");
	        element.innerHTML = "<img src='" + this.list[sel].src + "'></img>";
			

		var old = parseInt(this.selected);
		if(Math.abs(old - sel) > 1){
			this.clearChains();
			this.startChain(sel, old);
			return;
		}
		this.selected = sel;
		CVFL$('__cvfl-img-'+ old).style.cursor = '';
		if(sel != old) this.labelAnim.start({opacity: [0]});
		if(sel < old){
			this.working = true;
			//move out the images on the right, then delete the right most one
			var end = old + 4;
			if(end > this.getListLength()) end = this.getListLength();
			for(var i = old + 1; i < end; i++) this.shiftOut(i, 'r', old, sel, end);
			var start = sel - 3;
			if(start < 0)	start = 0;
			var lOffset = (this.containerWidth - 100 - this.widthOffset - 50) + ((old - sel) * 50);
			var zIndex = 500 - ((old - sel) * 50);
			var dur = this.chainDuration / 2;
			this.tiltAway(old, 'r', lOffset, zIndex, dur);
			var fn = function(){
				Coverflow.center.apply(Coverflow, [sel, 'l', 1]);
				for(var i = start; i < sel; i++) Coverflow.shiftIn(i, 'l', old, sel);
			}
			setTimeout(fn, dur / 2);
		}	else if(old < sel) {
			this.working = true;
			//move out the images on the left, then delete the left most one
			var end = old - 3; //3
			if(end < 0)	end = 0;
			for(var i = end; i < old; i++) this.shiftOut(i, 'l', old, sel, end);
			var start = sel + 4; //4
			if(start > this.getListLength()) start = this.getListLength();
			var lOffset = 150 - ((sel - old) * 50);
			var
			zIndex = 500 - ((sel - old) * 50);
			var dur = this.chainDuration / 2;
			this.tiltAway(old, 'l', lOffset, zIndex, dur);
			var fn = function(){
				Coverflow.center.apply(Coverflow, [sel, 'r', 1]);
				for(var i = sel + 1; i < start; i++) Coverflow.shiftIn(i, 'r', old, sel);
			}
			setTimeout(fn, dur / 2);
			var getNext = function() {
				Coverflow.options.refill(Coverflow.dbOffset);
				Coverflow.dbOffset+=30;
			}
			if (parseInt(this.selected) > this.getListLength()-6) {
					setTimeout(getNext, 0);
			}
		}
	},

	clearChains: function(){
		clearInterval(this.chainTimer);
		this.chains = [];
	},
	addCover: function(elt){
		while (this.touchingList){};
		this.touchingList=true;
		this.list[this.list.length]=elt;	
		this.touchingList=false;
	},
	getListElement: function(index){
		while (this.touchingList){};
		return this.list[index];
	},
	getListLength: function() {
		while (this.touchingList){};
		return this.list.length;
	},
	startChain: function(sel, old){
		var d = Math.abs(old - sel);
		var n = old;
		if(old < sel){
			for(var i = old + 1; i <= sel; i++)	this.chains.push(i);
		}	else {
			for(var i = old - 1; i >= sel; i--)	this.chains.push(i);
		}

		var fn = function(){
			return Coverflow.nextFrame.apply(Coverflow);
		};
		this.chainDuration = 600 / d;
		this.chainTimer = setInterval(fn, 1000/40);
	},

	nextFrame: function(){
		var dur = this.chainDuration;
		if(this.chains.length > 0){
			if(!this.working){
				var sel = this.chains.shift();
				this.select(sel, dur);
			}
		}	else {
			this.clearChains();
			this.chainDuration = 600;
		}
	},

	showLabel: function(sel){
		this.label.innerHTML = this.options.createLabel.call(this, this.getListElement(this.selected));
		this.labelAnim.start({opacity: [1]});
	},

	timers: [],

	clearTimers: function(){
		for(var i = 0; i < this.timers.length; i++) (this.timers[i].stop) ? this.timers[i].stop() : clearInterval(this.timers[i]);
		this.timers = [];

	},

	center: function(n, dir, len, l, move){
		var finalLeft = (this.widthOffset*2 - this.imageWidth + this.options.middleSpace) / 2 + 100, finalZ = 500;
		var id = '__cvfl-img-'+ n, el = CVFL$(id);
		el.style.zIndex = finalZ;
		var hr = [this.hr, 1], wr = [this.wr, 1], mt = [this.mt, 0], mh = [this.mh, 0];
		var left = parseInt(el.getStyle('left'));
		var z = parseInt(el.getStyle('zIndex'));
		var startTime, duration = this.chainDuration / len, timer;
		if(move) duration /= 2;
		var complete = false;
		var setupCanvas = function(hr_now, wr_now, lOffset, zIndex, mt_now, mh_now, tiltOverride)	{
			var el = CVFL$(id);
			var img = new Image();
			img.src = el.src;
			img.id = el.id;
			img.onclick = el.onclick;
			el.parentNode.replaceChild(img, el);
			var tilt = tiltOverride || dir;
			Coverflow.tilt(img, tilt, hr_now, wr_now, lOffset, finalZ, mt_now, mh_now);
		};
		var step = function(){
			var time = new Date().getTime();
			if(time < startTime + duration){
				var x = transition((time - startTime) / duration);
				var hr_now = (hr[1] - hr[0]) * x + hr[0];
				var wr_now = (wr[1] - wr[0]) * x + wr[0];
				var mt_now = (mt[1] - mt[0]) * x + mt[0];
				var mh_now = (mh[1] - mh[0]) * x + mh[0];
				var lOffset = (finalLeft - left) * x + left;
				var zIndex = (finalZ - z) * x + z;
				setupCanvas(hr_now, wr_now, lOffset, zIndex, mt_now, mh_now);
			}	else {
				clearInterval(timer);
				setupCanvas(hr[1], wr[1], finalLeft, finalZ, mt[1], mh[1], 'n');
				Coverflow.showLabel(n);
				Coverflow.working = false;
				CVFL$('__cvfl-img-'+ Coverflow.selected).style.cursor = 'pointer';
			}
		};
		startTime = new Date().getTime();
		timer = setInterval(step, 1000 / 40);
		this.timers.push(timer);
	},

	tiltAway: function(n, dir, finalLeft, finalZ, duration)	{
		var id = '__cvfl-img-'+ n, el = CVFL$(id);
		finalZ += 100;
		el.style.zIndex = finalZ;
		var hr = [1, this.hr], wr = [1, this.wr], mt = [0, this.mt], mh = [0, this.mh];
		var left = parseInt(el.getStyle('left'));
		var z = parseInt(el.getStyle('zIndex'));
		var startTime, duration = duration || this.chainDuration, timer;
		var setupCanvas = function(hr_now, wr_now, lOffset, zIndex, mt_now, mh_now){
			var el = CVFL$(id);
			var img = new Image();
			img.src = el.src;
			img.id = el.id;
			img.onclick = el.onclick;
			el.parentNode.replaceChild(img, el);
			Coverflow.tilt(img, dir, hr_now, wr_now, lOffset, finalZ, mt_now, mh_now);
		};
		var step = function(){
			var time = new Date().getTime();
			if(time < startTime + duration){
				var x = transition((time - startTime) / duration);
				var hr_now = (hr[1] - hr[0]) * x + hr[0];
				var wr_now = (wr[1] - wr[0]) * x + wr[0];
				var mt_now = (mt[1] - mt[0]) * x + mt[0];
				var mh_now = (mh[1] - mh[0]) * x + mh[0];
				var lOffset = Math.ceil((finalLeft - left) * x + left);
				var zIndex = Math.ceil((finalZ - z) * x + z);
				setupCanvas(hr_now, wr_now, lOffset, zIndex, mt_now, mh_now);
			}	else {
				finalZ -= 100;
				clearInterval(timer);
				setupCanvas(hr[1], wr[1], finalLeft, finalZ, mt[1], mh[1]);
			}
		};
		startTime = new Date().getTime();
		timer = setInterval(step, 1000 / 40);
		this.timers.push(timer);
	},

	shiftOut: function(i, dir, old, sel, edge){
		var d = Math.abs(old - sel);
		var el = CVFL$('__cvfl-img-'+ i);
		var l = parseInt(el.getStyle('left'));
		l = (dir == 'r') ? (l + 50 * d) : (l - 50 * d);
		var z = parseInt(el.getStyle('zIndex')) - (50 * d);
		el.setStyle('zIndex', z);
		var o = {left: [l]};
		var fn = function(){};
		if(i < sel - 3 || i > sel + 3){
			o.opacity = [1, 0];
			fn = function(el){
				el.remove();
			};
		}
		this.timers.push(new Anim(el, {onComplete: fn, duration: this.chainDuration}).start(o));
	},

	shiftIn: function(i, dir, old, sel){
		if(i < old - 3 || i > old + 3){
			var img = new Image(); img.src = this.getListElement(i).src;
			img.id = '__cvfl-img-'+ i;
			img.onclick = function(){
				return Coverflow.select.apply(Coverflow, arguments);
			};
			(dir == 'l') ? this.wrapper.insertBefore(img, this.wrapper.firstChild) : this.wrapper.appendChild(img);
			var j = (dir == 'l') ? old - 3 - i : i - old - 3;
			var left = (dir == 'l') ? (0 - 50 * j) : ((this.containerWidth - this.widthOffset) + 50 * j);
			Coverflow.tilt(img, dir, this.hr, this.wr, left, (350 - 50 * j));
			try {
				CVFL$('__cvfl-img-'+ i).style.opacity = 0;
			} catch (e) {}
		}
		var d = Math.abs(old - sel);
		var el = CVFL$('__cvfl-img-'+ i);
		var l = parseInt(el.getStyle('left'));
		l = (dir == 'l') ? (l + 50 * d) : (l - 50  * d);
		var z = parseInt(el.getStyle('zIndex')) + (50 * d);
		el.setStyle('zIndex', z);
		this.timers.push(new Anim(el, {duration: this.chainDuration}).start({left: [l], opacity: [1]}));
	},

	tilt: function(image, tilt, hratio, wratio, lOffset, zIndex, tOffset, hOffset){
		var prnt = image.parentNode;
		var canvas = document.createElement('canvas'), res;
		if(canvas.getContext)	{
			var ih = image.height, iw = image.width;
			var ref_h = Math.floor(ih / 2);
			if(tilt != 'n'){
				canvas.style.top = Math.ceil(tOffset || this.mt) +'px';
				hOffset = hOffset || this.mh;
				hOffset = Math.ceil(hOffset);
				ref_h -= hOffset/2;
				ih -= hOffset/2;
				if(!TILT)	iw = this.imageWidth*wratio;
			}
			var h = ih + ref_h, w = iw;
			canvas.id = image.id;
			canvas.style.width = w +'px'; canvas.width = w;
			canvas.style.height = h +'px'; canvas.height = h;
			canvas.style.left = lOffset +'px';
			canvas.style.zIndex = zIndex;
			canvas.onclick = image.onclick;
			canvas.src = image.src;

			var ctx = canvas.getContext('2d');
			prnt.replaceChild(canvas, image);

			ctx.clearRect(0, 0, canvas.width, canvas.height);
			ctx.globalCompositeOperation = 'source-over';
			ctx.fillStyle = 'rgba(0, 0, 0, 0)';
			ctx.fillRect(0, 0, canvas.width, canvas.height);
			ctx.save();


			try{
				ctx.translate(0, canvas.height);
				ctx.scale(1, -1);
				if (!isChrome) ctx.drawImage(image, 0, -(canvas.height - ref_h - ref_h), canvas.width, canvas.height - ref_h);
				ctx.restore();
			}catch(e){
				//console.log(i, 0, 0, arg.width, arg.height); 
				 this.clearTimers(); this.init(); this.working = false; return; }

			ctx.globalCompositeOperation = 'destination-out';
			var grad = ctx.createLinearGradient(0, h - ref_h, 0, h);
			grad.addColorStop(1, 'rgba(0, 0, 0, 1)'); //0,0,0
			grad.addColorStop(0, 'rgba(0, 0, 0, 0.8)');//0,0,0
			ctx.fillStyle = grad;
			ctx.fillRect(0, h - ref_h, w, ref_h);

			if(this.options.bgColor != ''){
				ctx.globalCompositeOperation = 'destination-over';
				ctx.fillStyle = this.options.bgColor;
				ctx.fillRect(0, canvas.height - ref_h, canvas.width, ref_h);
			}

			ctx.globalCompositeOperation = 'source-over';
			ctx.drawImage(image, 0, 0, iw, ih);
			ctx.save();

			if(TILT && tilt != 'n'){
				res = document.createElement('canvas');
				if(res.getContext){
					var o =	{
						position: 'fixed', left: '-9999px', top: '0px',
						height: canvas.height +'px', width: canvas.width +'px'
					};
					for(var p in o)
						res.style[p] = o[p];
					res.height = canvas.height; res.width = canvas.width;
				}

				if(res.getContext){
					ctx = res.getContext('2d');
					ctx.globalCompositeOperation = 'source-over';
					ctx.clearRect(0, 0, res.width, res.height);

					var width = 5, l = Math.ceil(w/width);
					for(var i = 0; i < l; i++){
						var crap = (res.height - (res.height * hratio)) / 2;
						var dest_x = i * width, dest_y = 0;
						var src_y = crap * (i / l);
						var src_x = dest_x;
						if(tilt == 'r')	{
							src_y = Math.ceil(crap * ((l - i - 1) / l));
						}
						var dest_h = res.height - src_y * 2;
						try {
						ctx.drawImage(canvas, dest_x, dest_y, width, res.height, src_x, src_y, width, dest_h);
						}  catch (e) {}
					}

					ctx.save();

					if(canvas.getContext)	{
						var tw = parseInt(canvas.width * wratio);
						canvas.width = tw; canvas.style.width = tw +'px';
						ctx = canvas.getContext('2d');
						ctx.clearRect(0, 0, canvas.width, canvas.height);
						ctx.globalCompositeOperation = 'source-over';
						this.removeExcess(tilt, ctx, 0, 0, canvas.width, canvas.height, hratio, ref_h);
						ctx.clip();
						ctx.drawImage(res, 0, 0, canvas.width, canvas.height);
						ctx.save();
					}
				}
			}

			ctx.save();
		}
		return canvas;
	},

	removeExcess: function(dir, ctx, x, y, w, h, hr){
		var crap = (h - (h * hr)) / 2;
		ctx.beginPath();
		if(dir == 'l'){ctx.moveTo(x, y); ctx.lineTo(w, y + crap); ctx.lineTo(w, y + h - crap); ctx.lineTo(x, y + h);}
		else {ctx.moveTo(x, y + crap); ctx.lineTo(x + w, y); ctx.lineTo(x + w, y + h); ctx.lineTo(x, y + h - crap);}
		ctx.closePath();
	},

	wheel: function(e){
		if(this.load != 0 || !this.scrollable) return;
		if(e.preventDefault) e.preventDefault();
		e.returnValue = false;
		if(e.wheelDelta) delta = e.wheelDelta / 120;
		else if(e.detail)	delta = -e.detail / 3;
		if(delta)	{
			var sel = this.selected;
			if(delta < 0)	sel++;
			else sel--;
			sel = sel.limit(0, this.getListLength() - 1);
			this.select(sel);
		}
	}
};

function transition(i){
	return (i <= 0.5) ? Math.pow((2 * i), 4) / 2 : (2 - Math.pow((2 * (1 - i)), 4)) / 2;
};

function CVFLLeftRight(e){
	var sel = Coverflow.selected;
	if(e.keyCode == 39)	sel++;
	else if(e.keyCode == 37) sel--;
	sel = sel.limit(0, Coverflow.getListLength() - 1);
	Coverflow.select(sel);
}

if (window.addEventListener) CVFL$('__cvfl-coverflow').addEventListener('DOMMouseScroll', Coverflow.wheel.bind(Coverflow), false);
CVFL$('__cvfl-coverflow').onmousewheel = Coverflow.wheel.bind(Coverflow);


CVFLEl.getCoords = function(){
	var el = this;
	var pos = {x: 0, y: 0, w: this.offsetWidth, h: this.offsetHeight};
	while(el && el != document.body){
		pos.x += el.offsetLeft, pos.y += el.offsetTop;
		el = el.offsetParent;
	}
	return pos;
};

var Lightbox ={
	alreadyDisplaying:false,
	show: function(src, imgId){
		if (this.alreadyDisplaying) {
			Lightbox.close();
			return;
		}
		this.alreadyDisplaying=true;
		var overlay = document.createElement('div');
		overlay.id = '__lb-ol';
		overlay.style.opacity = 0;
		overlay.style.zIndex = 0;		
		overlay.style.top=document.getElementById("__cvfl-coverflow").offsetTop+"px";
		
		overlay.style.left=(document.getElementById("__cvfl-coverflow").offsetLeft+30)+"px";
		document.getElementById("__cvfl-coverflow-holder").appendChild(overlay);

		var trail = CVFL$(imgId);
		var pos = trail.getCoords();
		var img = new Image();
		img.src = src;
		img.id = '__lb-im';
		var finalW = img.width;
		var finalH = img.height;
		var finalT = '-250px';
		finalL = 100 + 'px';
	
		img.style.opacity = 0.5;
		img.style.top = '0px';
		img.style.left = '130px';
		img.style.zIndex = 0;
		document.getElementById("__lb-ol").appendChild(img);
		overlay.onclick = img.onclick = Lightbox.close;
		new Anim(document.getElementById("__cvfl-coverflow")).start({opacity: [0]});
		new Anim(overlay).start({opacity: [1]});
		new Anim(img).start({
			opacity: [1], width: [finalW], height: [finalH],
			top: [finalT], left: [finalL]
		});
	},

	close: function(){
		var el = CVFL$('__lb-ol');
		new Anim(el, {duration: 300, onComplete: function(el){ el.remove(); }}).start({opacity: [0]});
		el = CVFL$('__lb-im');
		new Anim(el, {duration: 300, onComplete: function(el){ el.remove(); }}).start({opacity: [0]});
		new Anim(document.getElementById("__cvfl-coverflow")).start({opacity: [1]});
		Lightbox.alreadyDisplaying=false;
	}
};
