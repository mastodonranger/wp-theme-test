var terminus_pie = (function(){

	"use strict";

	var terminus_pie = {};

	// default settings

	terminus_pie.config = {
		thicknessBorders: 2,
		thicknessBar: 4,
		bgColor: 'black',
		fgColor: 'green',
		percentage: 0,
		icon: ''
	};

	/**
	**	Circle constructor
	**/
	terminus_pie.init = function(element, config){

		config = config || {};

		var self = this,
			value = self.h_toValue(config.percentage ? config.percentage : terminus_pie.config.percentage);

		self.ctx = element.getContext("2d");
		self.value = value;
		self.half = element.width / 2;
		self.parentElement = element;
		self.icon = config.icon || terminus_pie.config.icon;
		self.isRTL = getComputedStyle(document.body).direction === "rtl";

		var ctx = self.ctx;

		ctx.width = element.width;
		ctx.height = element.height;

		// set visual settings

		ctx.font = "30px Droid Serif";
		ctx.bgColor = config.bgColor || terminus_pie.config.bgColor;
		ctx.fgColor = config.fgColor || terminus_pie.config.fgColor;
		ctx.radius = self.half - ctx.lineWidth;
		ctx.value = value;

		ctx.thicknessBar = config.thicknessBar || terminus_pie.config.thicknessBar;
		ctx.thicknessBorders = config.thicknessBorders || terminus_pie.config.thicknessBorders;
		ctx.padding = config.thicknessBorders / 2 + 2 || terminus_pie.config.thicknessBorders / 2 + 2;

		ctx.topBorderRadius = ctx.radius - ctx.thicknessBorders;
		ctx.bottomBorderRadius = ctx.radius - ctx.thicknessBar - ctx.thicknessBorders - ctx.padding * 2;
		ctx.pieBorderRadius = ctx.radius - (ctx.thicknessBar / 2) - ctx.padding - ctx.thicknessBorders;

	}

	terminus_pie.init.prototype.startAnimate = function(){

		var self = this;

		self.value = 0;
		self.easing = 0.0095;
		self.animateInt = setTimeout(self.animate.bind(self), 4);

	}

	terminus_pie.init.prototype.render = function(){

		var self = this,
			ctx = self.ctx,
			radians = self.value * Math.PI / 180;

		ctx.clearRect(0, 0, ctx.width, ctx.height);

		if(!self.icon) self.renderPercentage(self.value);
		else self.renderIcon(self.icon);

		// foreground figures

		ctx.beginPath();
		ctx.strokeStyle = ctx.fgColor;
		ctx.arc(self.half, self.half, ctx.topBorderRadius, 0, Math.PI * 2, false);
		ctx.lineWidth = ctx.thicknessBorders;
		ctx.stroke();
		ctx.closePath();

		ctx.beginPath();
		ctx.strokeStyle = ctx.fgColor;
		ctx.arc(self.half, self.half, ctx.bottomBorderRadius, 0, Math.PI * 2, false);
		ctx.lineWidth = ctx.thicknessBorders;
		ctx.stroke();
		ctx.closePath();

		// background figure

		ctx.beginPath();
		ctx.strokeStyle = ctx.bgColor;
		ctx.arc(self.half, self.half, ctx.pieBorderRadius, 0 - 90 * Math.PI / 180, radians - 90 * Math.PI / 180);
		ctx.lineWidth = ctx.thicknessBar;
		ctx.stroke();
		ctx.closePath();

		self.value++;

	}

	terminus_pie.init.prototype.animate = function(){

		var self = this;
		
		if(self.value <= self.ctx.value){
			self.render();
			self.easing += 0.0095;
			self.animateInt = setTimeout(self.animate.bind(self), 4 * self.easing);
		}
		else{
			clearInterval(self.animateInt);
			self.value = 0;
			self.easing = 0.0095;
		}

	}

	terminus_pie.init.prototype.renderPercentage = function(percentage){

		var self = this,
			text = self.h_toPercentage(percentage) + "%",
			ctx = self.ctx,
			textWidth = ctx.measureText(text).width,
			xPos = self.isRTL ? self.half + textWidth / 2 : self.half - textWidth / 2;

		ctx.beginPath();
		ctx.fillStyle = ctx.fgColor;
		ctx.fillText(text, xPos, self.half + 10);
		ctx.closePath();

	}

	terminus_pie.init.prototype.renderIcon = function(icon){

		var self = this,
			ctx = self.ctx,
			icon,
			iconWidth,
			xPos;

		ctx.font = "42px terminus_icons";
		ctx.fillStyle = ctx.fgColor;

		icon = String.fromCharCode("0x" + icon),
		iconWidth = ctx.measureText(icon).width;
		xPos = self.isRTL ? self.half + iconWidth / 2 : self.half - iconWidth / 2;

		ctx.fillText(icon, xPos, self.half + 15);

	}

	terminus_pie.init.prototype.setNewValue = function(value){
		this.ctx.value = this.h_toValue(value);
	}

	terminus_pie.init.prototype.h_toValue = function(percentage){
		return 360 * percentage / 100;
	}

	terminus_pie.init.prototype.h_toPercentage = function(value){
		return Math.floor(value / 360 * 100);
	}

	return terminus_pie;

}());