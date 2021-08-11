(function ($) {
		"use strict";

		redux                                                   = redux || {};
		redux.field_objects                                     = redux.field_objects || {};
		redux.field_objects.demo_content_import                 = redux.field_objects.demo_content_import || {};

		var ajaxDone                                            = false;
		var arr                                                 = null;

		redux.field_objects.demo_content_import.init = function( selector ) {
				if ( !selector ) {
						selector = $( document ).find( ".redux-group-tab:visible" ).find( '.redux-container-demo_content_import:visible' );
				}

				$( selector ).each(
						function() {
								var el = $( this );
								var parent = el;

								if ( !el.hasClass( 'redux-field-container' ) ) {
										parent = el.parents( '.redux-field-container:first' );
								}

								if ( parent.is( ":hidden" ) ) { // Skip hidden fields
										return;
								}

								if ( parent.hasClass( 'redux-field-init' ) ) {
										parent.removeClass( 'redux-field-init' );
								} else {
										return;
								}

								redux.field_objects.demo_content_import.vars(el);
								redux.field_objects.demo_content_import.modInit(el);
						}
				);
		};

		redux.field_objects.demo_content_import.vars = function(el) {

			redux.field_objects.demo_content_import.startTime       = '';
			redux.field_objects.demo_content_import.errorI          = false;
			redux.field_objects.demo_content_import.warning         = false;
			redux.field_objects.demo_content_import.loopLength      = null;
			redux.field_objects.demo_content_import.loopCount       = 0;
			redux.field_objects.demo_content_import.min_data        = '';
			redux.field_objects.demo_content_import.upload_url      = '';
			redux.field_objects.demo_content_import.site_url        = '';
			redux.field_objects.demo_content_import.nonce           = '';
			redux.field_objects.demo_content_import.timeout_warn    = '';
			redux.field_objects.demo_content_import.timeout_seconds = '';
			redux.field_objects.demo_content_import.logStatus       = 'delete';

			ajaxDone                                                = false;

			arr = el.find('.importer-holder').data('import-array');
			arr     = decodeURIComponent(arr);
			arr     = JSON.parse(arr);
			redux.field_objects.demo_content_import.demoConfig = arr;

			redux.field_objects.demo_content_import.demo = el.find('.importer-holder').data('demo');
			redux.field_objects.demo_content_import.dataDir = el.find('.importer-holder').data('dir');

		}

		redux.field_objects.demo_content_import.reset = function(el) {
			//hide messages
			el.find('.importer-result-success').fadeOut( "slow" );
			el.find('.importer-result-fail').fadeOut( "slow" );
			el.find('.importer-result-warning').fadeOut( "slow" );

			//remove previous imported
			el.find('.importer-holder .pe-bar').remove();
		}

		redux.field_objects.demo_content_import.modInit = function(el) {

				//select data
				el.find('.import_content .checkbox').each(function() {
					if( $(this).is(':checked') ) {
						$(this).addClass('checked');
					}
				});

				el.find('.import_content .checkbox').on('click', function(e) {

					if( $(this).hasClass('checked') ) {
						//uncheck
						$(this).prop('checked', false);
						$(this).removeAttr('checked');
						$(this).removeClass('checked');
					} else {
						//check
						$(this).prop('checked', true);
						$(this).attr('checked', 'checked');
						$(this).addClass('checked');
					}

					if( el.find('.import_content .checkbox.checked').length > 0 ) {
						$(".button_data_import").attr('disabled', false);
					} else {
						$(".button_data_import").attr('disabled', true);
					}

				});

				//default version
				el.find('.import_version .demo_version').on('click', function(e) {
					e.preventDefault();
					$(this).siblings().removeClass('checked');
					$(this).addClass('checked');

					if( $(this).data('demo') && $(this).data('dir') ) {
						var $demo = $(this).data('demo');
						var $dir = $(this).data('dir');
						redux.field_objects.demo_content_import.demo = $demo;
						redux.field_objects.demo_content_import.dataDir = $dir;
						el.find('.importer-holder').attr('data-demo', $demo);
						el.find('.importer-holder').attr('data-dir', $dir);
					}

				});

				//show logs
				$('.button_data_log').on('click', function() {
						redux.field_objects.demo_content_import.openLog(el);
				});

				//demo import
				$('.button_data_import').on('click', function() {

						redux.field_objects.demo_content_import.reset(el);

						// Button is disabled, so don't do anything!
						if ($(".button_data_import").attr('disabled') === 'disabled') {
								return;
						}

						//if ( !confirm( 'Have you read the tips below? If you are ready please click OK.' ) ) {
						//		return false;
						//}

						// Disable button
						$(".button_data_import").attr('disabled', true);

						// update import array
						var newArr = new Array();
						el.find('.import_content .checkbox.checked').each(function() {
							var item = $(this).data('content');
							item     = decodeURIComponent(item);
							item     = JSON.parse(item);
							newArr.push( item );
						});

						arr = newArr;

						redux.field_objects.demo_content_import.demoConfig = arr;
						var demo_config = arr;

						redux.field_objects.demo_content_import.loopLength      = demo_config.length;

						redux.field_objects.demo_content_import.min_data        = el.find('.importer-holder').data('min-data');
						redux.field_objects.demo_content_import.upload_url      = el.find('.importer-holder').data('source-upload-url');
						redux.field_objects.demo_content_import.site_url        = el.find('.importer-holder').data('source-site');
						redux.field_objects.demo_content_import.nonce           = el.find('.importer-holder').data('nonce');
						redux.field_objects.demo_content_import.timeout_warn    = Boolean(el.find('.importer-holder').data('timeout-warn'));
						redux.field_objects.demo_content_import.timeout_seconds = el.find('.importer-holder').data('timeout-seconds');

						redux.field_objects.demo_content_import.demoImport(el);
				});
		};

		redux.field_objects.demo_content_import.openLog = function(el) {
				var nonce = $('.modalbg').data('nonce');

				$.ajax({
						url: wp_ajax.url,
						type: 'POST',
						data: {
								action: 'get_import_log',
								nonce:  nonce
						},
						beforeSend: function () {

						},
						success: function(data) {
								$('.log-area').val(data);
						}
				});
		}

		redux.field_objects.demo_content_import.startTimer = function(el) {
				$.ajax({
						url: wp_ajax.url,
						type: 'POST',
						data: {
								action: 'poll_counter'
						},
						beforeSend: function () {

						},
						success: function(data) {
								if (ajaxDone == false) {
										setTimeout(redux.field_objects.demo_content_import.startTimer(el), 500);
								}

								if (data['data'].loop != redux.field_objects.demo_content_import.loopCount ) {
										return;
								}

								redux.field_objects.demo_content_import.progressBar(el, data);
						}
				});
		};

		redux.field_objects.demo_content_import.demoImport = function(el) {
				var loop_count  = redux.field_objects.demo_content_import.loopCount;
				var demo_config = redux.field_objects.demo_content_import.demoConfig;
				var doImport    = demo_config[loop_count].class_check;

				doImport = (doImport) ? 'yes' : 'no';

				var didMenus    = Boolean(el.find('.importer-holder').data('did-menus'));
				var didRev      = Boolean(el.find('.importer-holder').data('did-rev'));

				var log_delete  = redux.field_objects.demo_content_import.logStatus;

				if (demo_config[loop_count].importer === 'content' && didMenus === true) {
						if ( !confirm( 'It appears the demo menus have already been imported.  Importing them again will cause duplicates.  Click OK to continue, or click Cancel to skip the menu import.' ) ) {
								doImport = 'dupe';
						}
				}

				if (demo_config[loop_count].importer === 'revslider' && didRev === true) {
						if ( !confirm( 'Revolution sliders have already been imported. Click OK to continue ( duplicates will be created ), or click Cancel to skip the Revolution slider import.' ) ) {
								doImport = 'dupe';
						}
				}

				$(".button_data_log").attr('disabled', true);

				$.ajax({
						type: 'POST',
						url: wp_ajax.url,
						dataType: "JSON",
						data: {
								action:     'demo_installer',
								ajax_nonce: wp_ajax.nonce,
								importer:   demo_config[loop_count].importer,
								type:       demo_config[loop_count].type,
								xml:        demo_config[loop_count].xml,
								process:    doImport,
								demo:       redux.field_objects.demo_content_import.demo,
								data_dir:   redux.field_objects.demo_content_import.dataDir,
								upload_url: redux.field_objects.demo_content_import.upload_url,
								site_url:   redux.field_objects.demo_content_import.site_url,
								nonce:      redux.field_objects.demo_content_import.nonce,
								loop:       loop_count,
								log:        log_delete,
								min_data:   redux.field_objects.demo_content_import.min_data
						},
						beforeSend: function () {
								ajaxDone = false;
								redux.field_objects.demo_content_import.startTime = new Date().getTime();
								redux.field_objects.demo_content_import.appendBar(el);
								redux.field_objects.demo_content_import.startTimer(el);
						},
						success: function (data) {
								ajaxDone = true;
								redux.field_objects.demo_content_import.progressBar(el, data);
								redux.field_objects.demo_content_import.autoLoop(el);
						},
						error: function (jqXHR, textStatus, errorThrown) {
								console.log(jqXHR);
								console.log(textStatus);
								console.log(errorThrown);

								ajaxDone = true;

								redux.field_objects.demo_content_import.errorI = true;
								el.find('.importer-holder .import-' + loop_count + ' span').text('Sorry, an error occurred!');
								el.find('.importer-holder .import-' + loop_count + ' .progress-importer').css({"-webkit-transform": "translateX(100%)"})
										.css({"-o-transform": "translateX(100%)"})
										.css({"-ms-transform": "translateX(100%)"})
										.css({"transform": "translateX(100%)"})
										.addClass('error');
								redux.field_objects.demo_content_import.autoLoop(el);
						},
						complete: function (jqXHR, textStatus) {

						}
				});

				if (log_delete == 'delete') {
						redux.field_objects.demo_content_import.logStatus = 'deleted';
				}

		};

		redux.field_objects.demo_content_import.autoLoop = function(el) {
				el.find('.importer-holder .import-' + redux.field_objects.demo_content_import.loopCount + ' span').removeClass('loading-animation');

				redux.field_objects.demo_content_import.loopCount++;

				if (redux.field_objects.demo_content_import.loopCount < redux.field_objects.demo_content_import.loopLength) {
						redux.field_objects.demo_content_import.demoImport(el);
				} else {
						$(".button_data_log").attr('disabled', false);

						if (redux.field_objects.demo_content_import.errorI === false) { //success

								el.find('.importer-result-success').fadeIn( "slow" );
								redux.field_objects.demo_content_import.vars(el); //reset
								$(".button_data_import").attr('disabled', false);

						} else if (redux.field_objects.demo_content_import.errorI === true) { //error
								el.find('.importer-result-fail').fadeIn( "slow" );
						}

						if (redux.field_objects.demo_content_import.warning === true) { //warning
								el.find('.importer-result-warning').fadeIn( "slow" );
						}
				}
		};

		redux.field_objects.demo_content_import.appendBar = function(el) {
				var loop_count  = redux.field_objects.demo_content_import.loopCount;
				var demo_config = redux.field_objects.demo_content_import.demoConfig;

				var bar_dom = $('<div class="pe-bar import-' + loop_count + '">' +
						'<div class="pe-bar-inner">' +
						'<div class="progress-importer"></div>' +
						'</div>' +
						'<span>Loading ' + demo_config[loop_count].type + '</span>' +
						'</div>');

				el.find('.importer-holder').append(bar_dom);
				el.find('.importer-holder .import-' + loop_count).css('opacity', 1);
				el.find('.importer-holder .import-' + loop_count + ' span').addClass('loading-animation');
		};

		redux.field_objects.demo_content_import.progressBar = function(el, data) {
				var loop_count  = redux.field_objects.demo_content_import.loopCount;
				var demo_config = redux.field_objects.demo_content_import.demoConfig;
				var seconds     = redux.field_objects.demo_content_import.timeout_seconds;
				var isWarn      = redux.field_objects.demo_content_import.timeout_warn;

				if (demo_config[loop_count] === undefined) {
						return;
				}

				if (typeof data == 'undefined' || !data) {
						data            = {};
						data['success'] = true;
						data['data']    = {'tt_post': 1, 'add_post': 1, 'message': 'correctly imported but an error occured!', 'error': true, 'steps': false};
				}

				var ttpost      = (typeof data['data'].tt_post != 'undefined') ? data['data'].tt_post : '1';
				var addpost     = (typeof data['data'].add_post != 'undefined' || typeof data['data'].add_post == 0) ? data['data'].add_post : '1';
				var messages    = (typeof data['data'].message != 'undefined') ? data['data'].message : '';
				var errors      = (typeof data['data'].error != 'undefined') ? data['data'].error : '';
				var steps       = (typeof data['data'].steps != 'undefined') ? data['data'].steps : false;
				var progress    = ttpost / addpost * 100;
				var endTime     = (new Date().getTime() - redux.field_objects.demo_content_import.startTime) / 1000;

				if (endTime >= seconds && addpost != 0 && messages == false || errors == true) {
						redux.field_objects.demo_content_import.warning = true;

						if (messages === 'skip' || isWarn === false) {
								redux.field_objects.demo_content_import.warning = false;
						}

						if (isWarn === true) {
								el.find('.importer-holder .import-' + loop_count + ' span').css({"color": "#e74c3c"});
						}
				}

				if (addpost != 0 && messages == false) {
						progress = addpost / ttpost * 100;
						el.find('.importer-holder .import-' + loop_count + ' span').text(addpost + '/' + ttpost + ' ' + demo_config[loop_count].type + ' loaded');
				} else if (addpost == 0 && messages == false  && steps == false) {
						progress = 100;
						el.find('.importer-holder .import-' + loop_count + ' span').text('All ' + demo_config[loop_count].type + ' already exist!');
				} else if (messages != false) {
						progress = 100;

						if (messages === 'skip') {
								messages = 'import skipped.  The required plugin is either not installed, or installed but not activated.';
						} else if(messages === 'dupe') {
								messages = 'import skipped to avoid duplicate entries.';
						}

						el.find('.importer-holder .import-' + loop_count + ' span').text(demo_config[loop_count].type + ' ' + messages);
						el.find('.importer-holder .import-' + loop_count + ' .progress-importer').addClass('message-error');
				}

				el.find('.importer-holder .import-' + loop_count + ' .progress-importer')
						.css({"-webkit-transform": "translateX(" + progress + "%)"})
						.css({"-o-transform": "translateX(" + progress + "%)"})
						.css({"-ms-transform": "translateX(" + progress + "%)"})
						.css({"transform": "translateX(" + progress + "%)"});
		};
})(jQuery);
