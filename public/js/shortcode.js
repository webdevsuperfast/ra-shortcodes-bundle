(function($){
	if($('.rasb-countdown').length > 0) {
		$('.rasb-countdown').each(function(index){
			var instance = $(this).data('instance');
			countdownInstance(instance);
		});
		function countdownInstance(instance) {
			var obj = window['countdown'+instance];

			var id = obj.id,
				year = obj.year,
				month = obj.month,
				day = obj.day,
				hour = obj.hour,
				minute = obj.minute;
			$('#'+id).countdown( year+'/'+month+'/'+day+ ' ' +hour+':'+minute+':00', function(event) {
				var $this = $(this).html(event.strftime(
					''
					+ '<span><span>%D</span> </br>day%!D</span> '
					+ '<span><span>%H</span> </br>hour%!H</span> '
					+ '<span><span>%M</span> </br>minute%!M</span> '
					+ '<span><span>%S</span> </br>second%!S</span>'
				));
			});
			// console.log(year+'/'+month+'/'+day);
		}
	}
	//* Button Shortcode
	if($('.rasb_button').length > 0) {
		$('.rasb_button').each(function(index){
			var instance = $(this).data('instance');
			btnInstance(instance);
		});
	}

	function btnInstance(instance) {
		var obj = window['btn'+instance];

		var borderWidth = obj.borderWidth,
			padding = obj.padding,
			marginBottom = obj.marginBottom,
			borderRadius = obj.borderRadius,
			width = obj.width,
			hover = obj.hover,
			colorHover = obj.colorHover,
			borderColor = obj.borderColor,
			color = obj.color,
			backgroundColor = obj.backgroundColor,
			fontSize = obj.fontSize,
			tabletSize = obj.tabletSize;

		vein.inject(['#btn-'+instance+''], {
			'font-size' : ''+fontSize+'',
			'border-width' : ''+borderWidth+'',
			'padding' : ''+padding+'',
			'margin-bottom' : ''+marginBottom+'',
			'border-radius' : ''+borderRadius+'',
			'width' : ''+width+'',
			'color' : ''+color+'',
			'border-color' : ''+borderColor+'',
			'background-color' : ''+backgroundColor+''
		});

		// On Hover
		vein.inject(['#btn-'+instance+':hover'], {
			'background-color' : ''+hover+'',
			'border-color' : ''+hover+'',
			'color' : ''+colorHover+''
		});

		// Ghost Button
		vein.inject(['#btn-'+instance+'.btn.btn-ghost'], {
			'background-color' : 'transparent',
			'color' : ''+backgroundColor+''
		});

		vein.inject(['#btn-'+instance+'.btn.btn-ghost:hover'], {
			'border-color' : ''+hover+'',
			'background-color' : ''+hover+'',
			'color' : ''+colorHover+''
		});

		vein.inject([{
			'@media (max-width: 991px)': ['#btn-'+instance+'']
		}], {
			'font-size': ''+tabletSize+' !important'
		});

		vein.inject([{
			'@media (max-width: 767px)': ['#btn-'+instance+'']
		}], {
			'width': '100% !important'
		});
	}

	//* Text Shortcode
	if($('.rasb_text').length > 0) {
		$('.rasb_text').each(function(index){
			var instance = $(this).data('instance');
			textInstance(instance);
		});
	}

	function textInstance(instance) {
		var text = window['text' + instance];

		var fontSize = text.fontSize,
			lineHeight = text.lineHeight,
			marginBottom = text.marginBottom,
			letterSpacing = text.letterSpacing,
			color = text.color,
			textAlign = text.textAlign,
			tabletSize = text.tabletSize;

		vein.inject(['#rasb_text-'+instance+''], {
			'font-size' : ''+fontSize+'',
			'line-height' : ''+lineHeight+'',
			'letter-spacing' : ''+letterSpacing+'',
			'color' : ''+color+'',
			'margin-bottom' : ''+marginBottom+'',
			'text-align' : ''+textAlign+''
		});

		vein.inject([{
			'@media only screen  and (max-width: 991px)': ['#text-'+instance+'']
		}], {
			'font-size': ''+tabletSize+' !important'
		});
	}
})(jQuery);
