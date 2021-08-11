/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
Website: http://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

(function($) {

    "use strict";

    $(document).ready(function() {
				
				//jQuery 'Back to Top' script
				function setModulesHeight() {
					var regexp = new RegExp("_height([0-9]+)");
					var jmmodules = jQuery(document).find('.pe-module') || [];
					if (jmmodules.length) {
						jmmodules.each(function(index,element){
							var match = regexp.exec(element.className) || [];
							if (match.length > 1) {
								var modHeight = parseInt(match[1]);
								jQuery(element).find('.pe-module-in').css('min-height', modHeight + 'px');
							}
						});
					}
				}
				setModulesHeight();
				
        // Contact Form Handling - send-email.php
        if(jQuery().validate && jQuery().ajaxSubmit) {

            var submitButton = $( '#submit-button'),
                messageContainer = $( '#pe-email-report'),
                errorContainer = $( '#pe-error-container' );

            var formOptions = {
                beforeSubmit: function() {
                    submitButton.attr('disabled','disabled');
                    messageContainer.fadeOut('fast');
                    errorContainer.fadeOut('fast');
                },
                success: function( ajax_response, statusText, xhr, $form) {
                    var response = $.parseJSON ( ajax_response );
                    submitButton.removeAttr('disabled');
                    if( response.success ) {
                        $form.resetForm();
                        messageContainer.html( response.message ).fadeIn('fast');
                    } else {
                        errorContainer.html( response.message ).fadeIn('fast');
                    }
                }
            };

            // Contact page form
            $('#pe-contact-form').validate( {
                errorLabelContainer: errorContainer,
                submitHandler: function(form) {
                    $(form).ajaxSubmit( formOptions );
                }
            });
        }

        //jQuery 'Back to Top' script
          
          // scroll body to 0px on click
          $('#pe-back-top a').click(function () {
              $('body,html').animate({
                  scrollTop: 0
              }, 800);
              return false;
          });

        // Enable html content on bootstrap tooltip

        $(function () {
          $('[data-toggle="tooltip"]').tooltip({html: true})
        })

        //jQuery Off-Canvas
        var scrollsize;

        $(function() {
            // Toggle Nav on Click
            $('.toggle-nav').click(function() {
              // Get scroll size on offcanvas open
              if(!$('body').hasClass('off-canvas')) scrollsize = $(window).scrollTop();
                // Calling a function
                toggleNav();
            });
        });

        function toggleNav() {
          var y = $(window).scrollTop();
            if ($('body').hasClass('off-canvas')) {
                // Do things on Nav Close
                $('body').removeClass('off-canvas');
                setTimeout(function() {
                  $('.sticky-bar #pe-bar-wrapp').removeAttr('style');
                  $('html').removeClass('no-scroll').removeAttr('style');
                  $(window).scrollTop(scrollsize);
                }, 300);
            } else {
            // Do things on Nav Open
            $('body').addClass('off-canvas');
            $('.sticky-bar #pe-bar-wrapp').css({'position':'absolute','top':y});
                setTimeout(function() {
              $('html').addClass('no-scroll').css('top',-y);
                }, 300);
            }
        }

        // Sticky Bar
        $(window).on("load", function () {
            var resizeTimer;

            function resizeFunction() {
            var body = $('body');
            var allpage = $('#pe-main');
              
            if(body.hasClass('sticky-bar')) {
              var bar = allpage.find('#pe-bar-wrapp');
                if (bar.length > 0) {
                  var offset = bar.outerHeight();
                  allpage.css('padding-top', (offset) + 'px');
                }
              }
            };
          resizeFunction();
          
            $(window).resize(function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(resizeFunction, 30);
            });
            
            $(window).scroll(function() {    
          var topbar = $('#pe-bar-wrapp');
          if (topbar.length > 0) {
              var scroll = $(window).scrollTop();
              if (scroll >= 20) {
                  topbar.addClass("scrolled");
                  resizeFunction();
              } else {
                  topbar.removeClass("scrolled");
                  resizeFunction();
              }
          }
          });
        });
        
        //Bootstrap modal width
        function setModalWidthandHeight(){
        		var imageWidth = $(document).find('.pe-full-image img').width();
        		$(document).find('.modal-dialog').css('width', imageWidth + 30 + 'px');
        }
        $('.pe-modal').on( 'show.bs.modal', function () {
        	setModalWidthandHeight()			
				});
				
				//Bootstrap Mainmenu
				var deviceAgent = navigator.userAgent.toLowerCase();

				var isTouchDevice = ('ontouchstart' in document.documentElement) || 
				(deviceAgent.match(/(iphone|ipod|ipad)/) ||
				deviceAgent.match(/(android)/)  || 
				deviceAgent.match(/(iemobile)/) || 
				deviceAgent.match(/iphone/i) || 
				deviceAgent.match(/ipad/i) || 
				deviceAgent.match(/ipod/i) || 
				deviceAgent.match(/blackberry/i) || 
				deviceAgent.match(/bada/i));
				
				if(isTouchDevice) {
				
				  $('ul.nav li.dropdown').on("touchstart", function (e) {
				    'use strict'; //satisfy code inspectors
				    var dropdown = $(this); //preselect the dropdown
				    if (dropdown.hasClass('open')) {
				        return true;
				    } else {
				        dropdown.addClass('open');
				        jQuery('ul.nav li.dropdown').not(this).removeClass('open');
				        e.preventDefault();
				        return false; //extra, and to make sure the function has consistent return points
				    }
				  });
				
				} else {
				
				  $('ul.nav li.dropdown').hover(function() {
				    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
				  }, function() {
				    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
				  });
				
				}
				
    });

})(jQuery);

//Document Text Resizer script (May 14th, 08'): By JavaScript Kit: http://www.javascriptkit.com
var documenttextsizer={

prevcontrol: '', //remember last control clicked on/ selected
existingclasses: '',

setpageclass:function(control, newclass){
  if (this.prevcontrol!='')
      this.css(this.prevcontrol, 'selectedtoggler', 'remove') //de-select previous control, by removing 'selectedtoggler' from it
  document.documentElement.className=this.existingclasses+' '+newclass //apply new class to document
  this.css(control, 'selectedtoggler', 'add') //select current control
  this.setCookie('pagesetting', newclass, 5) //remember new class added to document for 5 days
  this.prevcontrol=control
},

css:function(el, targetclass, action){
  var needle=new RegExp("(^|\\s+)"+targetclass+"($|\\s+)", "ig")
  if (action=="check")
    return needle.test(el.className)
  else if (action=="remove")
    el.className=el.className.replace(needle, "")
  else if (action=="add")
    el.className+=" "+targetclass
},

getCookie:function(Name){ 
  var re=new RegExp(Name+"=[^;]+", "i"); //construct RE to search for target name/value pair
  if (document.cookie.match(re)) //if cookie found
    return document.cookie.match(re)[0].split("=")[1] //return its value
  return null
},

setCookie:function(name, value, days){
  if (typeof days!="undefined"){ //if set persistent cookie
    var expireDate = new Date()
    var expstring=expireDate.setDate(expireDate.getDate()+days)
    document.cookie = name+"="+value+"; path=/; expires="+expireDate.toGMTString()
  }
  else //else if this is a session only cookie
    document.cookie = name+"="+value
},

setup:function(targetclass){
  this.existingclasses=document.documentElement.className //store existing CSS classes on HTML element, if any
  var persistedsetting=this.getCookie('pagesetting')
  var alllinks=document.getElementsByTagName("a")
  for (var i=0; i<alllinks.length; i++){
    if (this.css(alllinks[i], targetclass, "check")){
      if (alllinks[i].getAttribute("class")==persistedsetting) //if this control's class attribute matches persisted doc CSS class name
        this.setpageclass(alllinks[i], alllinks[i].getAttribute("class")) //apply persisted class to document
      alllinks[i].onclick=function(){
        documenttextsizer.setpageclass(this, this.getAttribute("class"))
        return false
      }
    }
  }
}

}