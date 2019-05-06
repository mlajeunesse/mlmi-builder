/*
* MLMI Builder — global var :)
*/
let mlmi_builder = {
	builder: undefined,
	ready: false,
	initialized: false,
};

(function($) {
	'use strict';
	
	/*
	*	MLMI Builder
	*/
	$.fn.MLMI_Builder = function() {
		let self = this;
		
		self.init = function() {
			mlmi_builder.initialized = true;
			let text_rows = self.find(".layout[data-layout=text_row]:not(.acf-clone)");
			text_rows.each(function(index, element) {
				self.register(element);
				self.columns(element)
			});
		};
		
		self.register = function(row) {
			$(row).find("div.acf-field.select-cols-number select").on("change", function() {
				$(row).find(".mlmi-builder-column-option").css("width", "5%").hide();
				setTimeout(function() {
					self.columns(row);
				}, 250);
			});
			$(row).find("div.acf-field.cols_config input[type=radio]").on("change", function() {
				setTimeout(function() {
					self.columns(row);
				}, 250);
			});
		};
		
		self.columns = function(row) {
			let cols_config = $(row).find("div.acf-field.cols_config:not(.acf-hidden) input[type=radio]:checked").val();
			switch (cols_config) {
				case '6':
				case '5': case '5-X':
				case '4': case '4-X': case 'X-4-X': {
					console.log('yep');
					$(row).find(".mlmi-builder-column[data-name=col_1]").css("width", "100%");
					$(row).find(".mlmi-builder-column-option[data-name=col_1_option]").css("width", "100%").show();
					$(row).find(".mlmi-builder-column-option[data-name=col_1_order]").css("width", "100%").show();
					break;
				}
				case '3-3':
				case '5-7':
				case '7-5': {
					$(row).find(".mlmi-builder-column[data-name=col_1]").css("width", "50%");
					$(row).find(".mlmi-builder-column[data-name=col_2]").css("width", "50%");
					$(row).find(".mlmi-builder-column-option[data-name=col_1_option]").css("width", "50%").show();
					$(row).find(".mlmi-builder-column-option[data-name=col_2_option]").css("width", "50%").show();
					$(row).find(".mlmi-builder-column-option[data-name=col_1_order]").css("width", "50%").show();
					$(row).find(".mlmi-builder-column-option[data-name=col_2_order]").css("width", "50%").show();
					break;
				}
				case '2-4':
				case '1-5': {
					$(row).find(".mlmi-builder-column[data-name=col_1]").css("width", "40%");
					$(row).find(".mlmi-builder-column[data-name=col_2]").css("width", "60%");
					$(row).find(".mlmi-builder-column-option[data-name=col_1_option]").css("width", "40%").show();
					$(row).find(".mlmi-builder-column-option[data-name=col_2_option]").css("width", "60%").show();
					$(row).find(".mlmi-builder-column-option[data-name=col_1_order]").css("width", "40%").show();
					$(row).find(".mlmi-builder-column-option[data-name=col_2_order]").css("width", "60%").show();
					break;
				}
				case '5-1':
				case '4-2':
				case 'X-3-2': {
					$(row).find(".mlmi-builder-column[data-name=col_1]").css("width", "60%");
					$(row).find(".mlmi-builder-column[data-name=col_2]").css("width", "40%");
					$(row).find(".mlmi-builder-column-option[data-name=col_1_option]").css("width", "60%").show();
					$(row).find(".mlmi-builder-column-option[data-name=col_2_option]").css("width", "40%").show();
					$(row).find(".mlmi-builder-column-option[data-name=col_1_order]").css("width", "60%").show();
					$(row).find(".mlmi-builder-column-option[data-name=col_2_order]").css("width", "40%").show();
					break;
				}
				case '2-2-2': {
					$(row).find(".mlmi-builder-column").css("width", "33.333%");
					$(row).find(".mlmi-builder-column-option").css("width", "33.333%").show();
					break;
				}
			}
			$(row).find(".one-third").css("width", "33.333%").show();
		};
		
		return function() {
			if (mlmi_builder.ready) {
				if (mlmi_builder.initialized == false) {
					self.init();
				}
			}
			acf.add_action('ready', function() {
				if (mlmi_builder.initialized == false) {
					self.init();
				}
			});
			acf.add_action('append', self.register);
			acf.add_action('append', self.columns);
			return self;
		}();
	}
	
	if (typeof acf !== 'undefined') {
		mlmi_builder.builder = $(".mlmi-builder-section").MLMI_Builder();
	}
})(jQuery);

/* Synchronize init between jQuery and ACF */
if (typeof acf !== 'undefined') {
	acf.add_action('ready', function() {
		mlmi_builder.ready = true;
		if (mlmi_builder.builder != undefined && mlmi_builder.initialized == false) {
			mlmi_builder.builder.init();
		}
	});
}
