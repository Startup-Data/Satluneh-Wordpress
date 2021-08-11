/**
 * PE Shortcodes
 * Version: 1.00
 * Author: pixelemu.com
 * Author URI: http://www.pixelemu.com
 */

jQuery(function($) {
	$(document).ready(function(){

		var events = false;

		function init() {

			var code = '';

			$('.pe-add-shortcode').magnificPopup({
				type: 'inline',
				removalDelay: 500,
				callbacks: {
					beforeOpen: function() {
						this.st.mainClass = 'mfp-zoom-in';
					},
					open: function() {
						$('#pe-shortcodes-modal').show();
					},
					close: function() {
						$('#pe-shortcodes-modal').hide();
					}
				},
				midClick: true
			});

			$('.pe-add-shortcode').click(function(e){
				e.preventDefault();
				var target = $(this).attr('data-target');
				var field = $(this).attr('data-field');

				$('#pe-shortcodes-modal .shortcode-use').attr('data-target', target);
				if( typeof field != "undefined" && field ) {
					$('#pe-shortcodes-modal .shortcode-use').attr('data-field', field );
				}
			});

			if( events === true ) {
				return;
			}

			events = true;

			var childrens = $('#pe-shortcodes-modal .pe-shortcodes-items [data-parent]');
			childrens.each(function() {
				var childcode = $(this).attr('data-shortcode');
				var shortcode = $(this).attr('data-parent');
				var holder = $('#pe-shortcodes-modal .pe-shortcodes-items [data-shortcode="' + shortcode + '"] .children-holder');
				if( holder.length ) {
					$(this).appendTo(holder);
					holder.addClass('limited');
					holder.parent().attr('data-child', childcode);
				}
			});

			$(document).on('click', '#pe-shortcodes-modal .pe-shortcodes-items .shortcode-toggle', function(e){
				e.preventDefault();
				var item = $(this).closest('li');

				$('#pe-shortcodes-modal .pe-shortcodes-drop').find('.active').removeClass('active');

				var newItem = item.clone();
				newItem.appendTo('#pe-shortcodes-modal .pe-shortcodes-drop');

				setID( newItem );
				toggleForm( newItem );
				dropData();
			});

			$(document).on('click', '#pe-shortcodes-modal .pe-shortcodes-drop .shortcode-toggle', function(e) {
				e.preventDefault();
				var item = $(this).closest('li');
				toggleForm( item );
			});

			$('#pe-shortcodes-modal .shortcode-save').click(function(e) {
				e.preventDefault();
				var saveBtn = $(this);
				var shortcode = saveBtn.parent().attr('data-shortcode');
				var endtag = saveBtn.parent().attr('data-endtag');
				var id = saveBtn.attr('data-id');

				var paramsList = $('#pe-shortcodes-modal .pe-shortcodes-content [data-shortcode="' + shortcode + '"]').find('li');
				var dropItem = $('#pe-shortcodes-modal .pe-shortcodes-drop [data-id="' + id + '"]');

				var data_params = new Array();
				var data_json;

				paramsList.each(function() {
					var input = $(this).find('.shortcode-input');
					var param = input.attr('data-param');
					var updated = input.val().replace(/\"/g, '');
					if( updated ) {
						data_params.push({name: param, value: updated});
					}
				});

				if( endtag == "true" ) {
					var content = saveBtn.parent('.shortcode-desc').find('.item-content').val();
					if( content ) {
						data_params.push({name: 'content', value: content});
					}
				}

				//console.log(data_params);

				data_json = JSON.stringify(data_params);
				dropItem.attr('data-params', data_json);

				var newItem = dropItem.addClass('edited').clone();
				newItem.insertAfter(dropItem).prev().remove(); //make new object

				colSize(newItem);
				dropData();

			});

			$(document).on('click', '#pe-shortcodes-modal .pe-shortcodes-drop .add', function(e) {
				e.preventDefault();

				var item = $(this).closest('li');
				var shortcode = item.attr('data-shortcode');

				var newItem = $('#pe-shortcodes-modal .pe-shortcodes-items [data-shortcode="' + shortcode + '"]').clone();
				newItem.insertAfter(item);

				setID(newItem);
				colSize(item);
				editForm(item);
				dropData();
			});

			$(document).on('click', '#pe-shortcodes-modal .pe-shortcodes-drop .clone', function(e) {
				e.preventDefault();
				var item = $(this).closest('li');
				var shortcode = item.attr('data-shortcode');
				var newItem = item.clone();
				item.removeClass('active');
				newItem.insertAfter(item).removeClass('edited');

				setID(newItem);
				colSize(item);
				editForm(item);
				dropData();

			});

			$(document).on('click', '#pe-shortcodes-modal .pe-shortcodes-drop .remove', function(e) {
				e.preventDefault();

				var item = $(this).closest('li');
				item.addClass('removed').hide();

				colSize(item);
				toggleForm(0);
				item.remove();
				dropData();
			});

			$('#pe-shortcodes-modal .shortcode-example').click(function(e) {
				e.preventDefault();
				$(this).next().slideToggle();
			});



			function setID( item ) {
				if( typeof item == "undefined" || !item ) return;

				var shortcode = item.attr('data-shortcode');
				var refItem = $('#pe-shortcodes-modal .pe-shortcodes-items [data-shortcode="' + shortcode + '"]');
				var id = refItem.attr('data-id');
				var newID = parseInt(id) + 1 + '-' + shortcode;

				item.attr('data-id', newID);
				refItem.attr('data-id', newID);

				//childs
				var subItems = item.find('.children-holder > li');
				if( subItems.length ) {
					subItems.each(function() {
						setID( $(this) );
					});
				}
			}

			function colSize( item ) {
				if( typeof item == "undefined" || !item ) return;


				var shortcode = item.attr('data-shortcode');
				if( shortcode == 'col' ) {

					var colsSaved = item.parent().find('> [data-shortcode="col"].edited').not( ".removed" );
					var currentSpan = 12;

					colsSaved.each(function() {

						var paramsSaved = JSON.parse($(this).attr('data-params'));

						if( $.isArray(paramsSaved) && typeof paramsSaved[0] != "undefined" && paramsSaved[0].name == 'size' ) {
							$(this).attr('data-span', paramsSaved[0].value);

							if( !$(this).hasClass('span') ) {
								$(this).addClass('span');
							}

						}

					});

					var colsDefault = item.parent().find('> [data-shortcode="col"]').not( ".removed, .span" );
					var countDefault = colsDefault.length;

					colsDefault.each(function() {

						var paramsDefault = JSON.parse($(this).attr('data-def'));

						if( $.isArray(paramsDefault) && typeof paramsDefault[0] != "undefined" && paramsDefault[0].name == 'size' ) {

							var newVal = Math.floor(currentSpan/parseInt(countDefault));
							if( newVal < 1 ) {
								newVal = 1;
							}
							paramsDefault[0].value = newVal;

							$(this).attr('data-span', newVal);

							$(this).attr('data-def', JSON.stringify(paramsDefault));
							$(this).removeClass('dragged').removeAttr('style').clone().insertAfter($(this)).prev().remove(); //make new object
						}

					});

				}
			}

			function editForm( item ) {
				var id = item.attr('data-id');
				var shortcode = item.attr('data-shortcode');
				var paramsForm = $('#pe-shortcodes-modal .pe-shortcodes-content [data-shortcode="' + shortcode + '"]');
				var paramsList = paramsForm.find('li');
				var saveBtn = paramsForm.find('.shortcode-save');

				var params = item.attr('data-params');
				var defParams = item.attr('data-def');

				var paramsData, paramsDefault;

				if( params ) {
					paramsData = JSON.parse(params);
				}

				if( defParams ) {
					paramsDefault = JSON.parse(defParams);
				}

				clearForm();

				paramsList.each(function() {
					var li = $(this);
					var input = li.find('.shortcode-input');
					var param = input.attr('data-param');

					$.each(paramsData, function(i) {
						if( paramsData[i].name == param ) {

							var field = li.find('[data-param="' + param + '"]');
							field.val(paramsData[i].value);
						}
					});

					$.each(paramsDefault, function(i) {
						if( paramsDefault[i].name == param ) {
							var field = li.find('[data-param="' + param + '"]');
							field.attr('placeholder', '(default: ' + paramsDefault[i].value + ')')
						}
					});

				});

				saveBtn.attr('data-id', id);

			}

			function toggleForm( item ) {

				if( typeof item == "undefined" || !item || item == 0 ) { //hide all forms
					$('#pe-shortcodes-modal .pe-shortcodes-content .shortcode-desc').hide(400);
					return;
				}

				$('#pe-shortcodes-modal .pe-shortcodes-drop').find('.active').removeClass('active');
				item.addClass('active');


				var shortcode = item.attr('data-shortcode');
				var paramsForm = $('#pe-shortcodes-modal .pe-shortcodes-content [data-shortcode="' + shortcode + '"]');

				editForm( item );

				paramsForm.show(400).siblings().hide(400);
			}

			function dropData() {
				var data = $(".pe-shortcodes-drop").pesortable("serialize").get();
				code = '';
				prepareShortcode(data[0]);
				//console.log(code);
				$('#pe-shortcodes-code').val(code);
			}

			function mergeObj(a, b) {
				var result = new Array();
				var merged = {};
				var paramsSaved = {};
				var paramsDefault = {};

				$.each(a, function(i) {
					paramsSaved[this.name] = this.value;
				 });

				$.each(b, function(i) {
					paramsDefault[this.name] = [this.value, true];
				});

				jQuery.extend( merged, paramsDefault, paramsSaved ); //merge objects

				$.each(merged, function(key, value) {
					if( $.isArray(value) && value[1] == true ) {
						result.push({ name : key, value: value[0], def: true });
					} else {
						result.push({ name : key, value: value });
					}
				});

				//console.log(result);

				return result;
			}

			function is_touch_device() {
				return 'ontouchstart' in window        // works on most browsers
						|| navigator.maxTouchPoints;       // works on IE10/11 and Surface
			};

			function prepareShortcode(data) {
				$.each(data, function(i) {
					var params_code = '';
					var content = '';
					code += '[' + data[i].shortcode;

					var paramsObj = mergeObj(data[i].params, data[i].def);

					$.each(paramsObj, function() {
						if( this.name == 'content' ) {
							content += this.value;
						} else {
							params_code += ' ' + this.name + '="' + this.value + '"';
						}
					});

					code += params_code + ']' + content;

					if( typeof data[i].children !== "undefined" && data[i].children ) {
						prepareShortcode(data[i].children[0]);
					}

					if( typeof data[i].endtag !== "undefined" && data[i].endtag == true ) {
						code += '[/' + data[i].shortcode + ']';
					}

				});

			}

			function clearForm() {
				var container = $('#pe-shortcodes-modal .item-params');
				var inputs = container.find('input');
				var textarea = container.find('textarea');
				inputs.val('');
				textarea.val('');
				inputs.prop('checked' , false);
			}

			$('#pe-shortcodes-modal .shortcode-use').click(function(e) {
				e.preventDefault();
					var target = $(this).attr('data-target');
					var data = $('#pe-shortcodes-code').val();

					if( (typeof tinyMCE != "undefined") && tinyMCE.activeEditor && !tinyMCE.activeEditor.isHidden() ) { //visual
						tinyMCE.execCommand('insertHTML',false, data);
					} else if(typeof QTags != "undefined" && QTags ) { //html
						QTags.insertContent(data);
					} else { //textarea in widget
						var field = $(this).attr('data-field');
						if( $('#widgets-right').find(field).length ) {
							var content = $('#widgets-right').find(field).first().val();
							$('#widgets-right').find(field).first().val( content + data );
						}
					}

				$.magnificPopup.close();
			});

			$('#pe-shortcodes-modal .shortcode-reset').click(function(e) {
				e.preventDefault();
				$('#pe-shortcodes-modal .pe-shortcodes-drop').find('li').remove();
				clearForm();
				toggleForm(0);
				$('#pe-shortcodes-code').val('');
			});

			$('#pe-shortcodes-modal .shortcode-copy').click(function(e) {
				e.preventDefault();
				$("#pe-shortcodes-code").select();
				document.execCommand('copy');
				$.magnificPopup.close();
			})

			$(".pe-shortcodes-drop").pesortable({
				group: 'no-drop',
				vertical: false,
				delay: 50,
				distance: 10,

				onMousedown: function ($item, _super, event) {
					if( ! is_touch_device() ) {
						event.preventDefault();
					}
					return true
				},

				afterMove: function (placeholder, container) {
					var shortcode = $('#pe-shortcodes-modal .dragged').attr('data-shortcode');
					var holder = placeholder.parent();

					if( holder.is('.children-holder.limited') ) {
						var valid = holder.parent().attr('data-child');
						if( typeof valid == "undefined" || valid !== shortcode ) {
							if( holder.find('.children-holder:not(".limited")').length ) {
								placeholder.appendTo(holder.find('.children-holder:not(".limited")').last());
							} else if( holder.closest('.children-holder:not(".limited")').length ) {
								placeholder.appendTo(holder.closest('.children-holder:not(".limited")').last());
							} else {
								placeholder.appendTo($('#pe-shortcodes-modal .pe-shortcodes-drop'));
							}
						}
					}

				},

				onDragStart: function ($item, container, _super) {
					// Duplicate items of the no drop area
					if( !container.options.drop ) {
						var refItem = $item.clone();
						refItem.insertAfter($item);
						setID($item);
					}

					_super($item, container);
				},

				onDrop: function ($item, container, _super) {

					colSize($item);
					toggleForm($item);
					dropData();

					_super($item, container);
				},
			});

			$(".pe-shortcodes-items").pesortable({
				group: 'no-drop',
				drop: false,
			});

		}

		init();
		$(document).on('widget-added widget-updated', function(){
			init();
		});
	});
});
