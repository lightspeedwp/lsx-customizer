/*
 * lsx-customizer-colour-admin.js
 */

(function(api) {
	var css_template = wp.template("lsx-color-scheme"),
		skip_update_css = false;

	api.controlConstructor.select = api.Control.extend({
		ready: function() {
			if ("color_scheme" === this.id) {
				this.setting.bind("change", function(_value) {
					skip_update_css = true;

					var _colors = color_scheme[_value].colors;

					_.each(_colors, function(_color, _setting) {
						if ("function" === typeof api(_setting)) {
							api(_setting).set(_color);
							api.control(_setting)
								.container.find(".color-picker-hex")
								.data("data-default-color", _color)
								.wpColorPicker("defaultColor", _color);
						}
					});

					skip_update_css = false;
					update_css();
				});
			}
		}
	});

	// Generate the CSS for the current Colour Scheme.
	function update_css() {
		if (skip_update_css) {
			return;
		}

		var __scheme = api("color_scheme")(),
			__css,
			__colors = color_scheme[__scheme].colors;

		// Merge in color scheme overrides.
		_.each(color_scheme_keys, function(__setting) {
			if ("function" === typeof api(__setting)) {
				__colors[__setting] = api(__setting)();
			}
		});

		__css = css_template(__colors);
		api.previewer.send("update-color-scheme-css", __css);
	}

	// Update the CSS whenever a color setting is changed.
	_.each(color_scheme_keys, function(__setting) {
		api(__setting, function(__setting) {
			__setting.bind(update_css);
		});
	});
})(wp.customize);
