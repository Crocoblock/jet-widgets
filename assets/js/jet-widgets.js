( function( $, elementor ) {

	"use strict";

	var JetWidgets = {

		init: function() {

			var widgets = {
				'jw-carousel.default' : JetWidgets.widgetCarousel,
				'jw-posts.default' : JetWidgets.widgetPosts,
				'jw-animated-box.default' : JetWidgets.widgetAnimatedBox,
				'jw-images-layout.default' : JetWidgets.widgetImagesLayout,
				'jw-testimonials.default' : JetWidgets.widgetTestimonials,
				'jw-image-comparison.default' : JetWidgets.widgetImageComparison,
				'jw-subscribe-form.default' : JetWidgets.widgetSubscribeForm
			};

			$.each( widgets, function( widget, callback ) {
				elementor.hooks.addAction( 'frontend/element_ready/' + widget, callback );
			});
		},

		widgetCarousel: function( $scope ) {

			var $carousel = $scope.find( '.jw-carousel' );

			if ( ! $carousel.length ) {
				return;
			}

			JetWidgets.initCarousel( $carousel, $carousel.data( 'slider_options' ) );

		},

		widgetPosts: function ( $scope ) {

			var $target = $scope.find( '.jw-carousel' );

			if ( ! $target.length ) {
				return;
			}

			JetWidgets.initCarousel( $target.find( '.jw-posts' ), $target.data( 'slider_options' ) );

		},

		widgetAnimatedBox: function( $scope ) {

			JetWidgets.onAnimatedBoxSectionActivated( $scope );

			var $target      = $scope.find( '.jw-animated-box' ),
				toogleEvents = 'mouseenter mouseleave',
				scrollOffset = $( window ).scrollTop();

			if ( ! $target.length ) {
				return;
			}

			if ( 'ontouchend' in window || 'ontouchstart' in window ) {
				$target.on( 'touchstart', function( event ) {
					scrollOffset = $( window ).scrollTop();
				} );

				$target.on( 'touchend', function( event ) {

					if ( scrollOffset !== $( window ).scrollTop() ) {
						return false;
					}

					if ( ! $( this ).hasClass( 'flipped-stop' ) ) {
						$( this ).toggleClass( 'flipped' );
					}
				} );

			} else {
				$target.on( toogleEvents, function( event ) {
					if ( ! $( this ).hasClass( 'flipped-stop' ) ) {
						$( this ).toggleClass( 'flipped' );
					}
				} );
			}
		},

		onAnimatedBoxSectionActivated: function( $scope ) {
			if ( ! window.elementor ) {
				return;
			}

			if ( ! window.JetWidgetsEditor ) {
				return;
			}

			if ( ! window.JetWidgetsEditor.activeSection ) {
				return;
			}

			var section = window.JetWidgetsEditor.activeSection;
			var isBackSide = -1 !== [ 'section_action_button_style' ].indexOf( section );

			if ( isBackSide ) {
				$scope.find( '.jw-animated-box' ).addClass( 'flipped' );
				$scope.find( '.jw-animated-box' ).addClass( 'flipped-stop' );
			} else {
				$scope.find( '.jw-animated-box' ).removeClass( 'flipped' );
				$scope.find( '.jw-animated-box' ).removeClass( 'flipped-stop' );
			}
		},

		widgetImagesLayout: function( $scope ) {
			var $target = $scope.find( '.jw-images-layout' ),
				instance = null,
				settings = {};

			if ( ! $target.length ) {
				return;
			}

			settings = $target.data( 'settings' );
			instance = new jwImagesLayout( $target, settings );
			instance.init();
		},

		widgetSubscribeForm: function( $scope ) {
			var $target               = $scope.find( '.jw-subscribe-form' ),
				scoreId               = $scope.data( 'id' ),
				settings              = $target.data( 'settings' ),
				jetSubscribeFormAjax  = null,
				subscribeFormAjaxId   = 'jw_subscribe_form_ajax',
				$subscribeForm        = $( '.jw-subscribe-form__form', $target ),
				$input                = $( '.jw-subscribe-form__input', $target ),
				$inputData            = $input.data( 'instance-data' ),
				$submitButton         = $( '.jw-subscribe-form__submit', $target ),
				$subscribeFormMessage = $( '.jw-subscribe-form__message', $target ),
				timeout               = null,
				invalidMailMessage    = window.jetWidgets.messages.invalidMail || 'Please specify a valid email';

			jetSubscribeFormAjax = new CherryJsCore.CherryAjaxHandler({
				handlerId: subscribeFormAjaxId,

				successCallback: function( data ) {
					var successType   = data.type,
						message       = data.message || '',
						responceClass = 'jw-subscribe-form--response-' + successType;

					$submitButton.removeClass( 'loading' );

					$target.removeClass( 'jw-subscribe-form--response-error' );
					$target.addClass( responceClass );

					$( 'span', $subscribeFormMessage ).html( message );
					$subscribeFormMessage.css( { 'visibility': 'visible' } );

					timeout = setTimeout( function() {
						$subscribeFormMessage.css( { 'visibility': 'hidden' } );
						$target.removeClass( responceClass );
					}, 20000 );

					if ( settings['redirect'] ) {
						window.location.href = settings['redirect_url'];
					}

					$( window ).trigger( {
						type: 'jet-widgets/subscribe',
						elementId: scoreId,
						successType: successType,
						inputData: $inputData
					} );
				}
			});

			$input.on( 'focus', function() {
				$input.removeClass( 'mail-invalid' );
			} );

			$( document ).keydown( function( event ) {

				if ( 13 === event.keyCode && $input.is( ':focus' ) ) {
					subscribeHandle();

					return false;
				}
			} );

			$submitButton.on( 'click', function() {
				subscribeHandle();

				return false;
			} );

			function subscribeHandle() {
				var inputValue = $input.val();

				if ( JetWidgetsTools.validateEmail( inputValue ) ) {
					jetSubscribeFormAjax.sendData(
						{
							'mail': inputValue,
							'data': $inputData
						}
					);
					$submitButton.addClass( 'loading' );
				} else {
					$input.addClass( 'mail-invalid' );

					$target.addClass( 'jw-subscribe-form--response-error' );
					$( 'span', $subscribeFormMessage ).html( invalidMailMessage );
					$subscribeFormMessage.css( { 'visibility': 'visible' } );

					timeout = setTimeout( function() {
						$target.removeClass( 'jw-subscribe-form--response-error' );
						$subscribeFormMessage.css( { 'visibility': 'hidden' } );
						$input.removeClass( 'mail-invalid' );
					}, 20000 );
				}
			}
		},

		widgetTestimonials: function( $scope ) {
			var $target        = $scope.find( '.jw-testimonials__instance' ),
				$imagesTagList = $( '.jw-testimonials__figure', $target ),
				instance       = null,
				settings       = $target.data( 'settings' );

			if ( ! $target.length ) {
				return;
			}

			settings.adaptiveHeight = settings['adaptiveHeight'];

			JetWidgets.initCarousel( $target, settings );
		},

		widgetImageComparison: function( $scope ) {
			var $target              = $scope.find( '.jw-image-comparison__instance' ),
				instance             = null,
				imageComparisonItems = $( '.jw-image-comparison__container', $target ),
				settings             = $target.data( 'settings' ),
				elementId            = $scope.data( 'id' );

			if ( ! $target.length ) {
				return;
			}

			settings.draggable = false;

			$target.on( 'init', function( event, slick ){
				window.juxtapose.scanPage( '.jw-juxtapose' );
			} );

			JetWidgets.initCarousel( $target, settings );
		},

		initCarousel: function( $target, options ) {

			var	defaultOptions,
				slickOptions,
				responsive        = [],
				eTarget           = $target.closest( '.elementor-widget' ),
				breakpoints       = JetWidgetsTools.getElementorElementSettings( eTarget ),
				activeBreakpoints = elementor.config.responsive.activeBreakpoints,
				prevDeviceValue,
				slidesCount,
				dotsEnable = options.dots;

			if ( $target.hasClass( 'jw-posts' ) && $target.parent().hasClass( 'jw-carousel' ) ) {
				function renameKeys( obj, newKeys ) {
					const keyValues = Object.keys( obj ).map( key => {
						const newKey = newKeys[key] || key;
						return { [newKey]: obj[key] };
					} );
					return Object.assign( {}, ...keyValues );
				}

				var newBreakpointsKeys = {
					columns: "slides_to_show",
					columns_widescreen: "slides_to_show_widescreen",
					columns_laptop: "slides_to_show_laptop",
					columns_tablet_extra: "slides_to_show_tablet_extra",
					columns_tablet: "slides_to_show_tablet",
					columns_mobile_extra: "slides_to_show_mobile_extra",
					columns_mobile: "slides_to_show_mobile"
				};

				breakpoints = renameKeys( breakpoints, newBreakpointsKeys );
			}

			options.slidesToShow = +breakpoints.slides_to_show;

			Object.keys( activeBreakpoints ).forEach( function( breakpointName ) {
				if ( 'widescreen' === breakpointName ) {
					return options.slidesToShow = breakpoints.slides_to_show_widescreen ? +breakpoints.slides_to_show_widescreen : +breakpoints.slides_to_show;
				}
			} );

			slidesCount = $( '> div', $target ).length;

			if ( options.slidesToShow >= slidesCount ) {
				options.dots = false;
			}

			prevDeviceValue = options.slidesToShow;

			Object.keys( activeBreakpoints ).reverse().forEach( function( breakpointName ) {

				var breakpointSetting = {
					breakpoint: null,
					settings: {}
				}

				breakpointSetting.breakpoint = 'widescreen' != breakpointName ? activeBreakpoints[breakpointName].value : activeBreakpoints[breakpointName].value - 1;

				if ( 'widescreen' === breakpointName ) {
					breakpointSetting.settings.slidesToShow = +breakpoints['slides_to_show'];
				} else {
					breakpointSetting.settings.slidesToShow = breakpoints['slides_to_show_' + breakpointName] ? +breakpoints['slides_to_show_' + breakpointName] : prevDeviceValue;
				}

				$target.on( 'init reInit', function(event, slick, currentSlide, nextSlide ){
					if ( breakpointSetting.settings.slidesToShow >= slick.slideCount ) {
						breakpointSetting.settings.dots = false;
					} else {
						if ( dotsEnable ) {
							breakpointSetting.settings.dots = true;
						}
					}
				} );

				prevDeviceValue = breakpointSetting.settings.slidesToShow;

				responsive.push( breakpointSetting );
			} );

			options.responsive = responsive;

			defaultOptions = {
				customPaging: function(slider, i) {
					return $( '<span />' ).text( i + 1 );
				},
				dotsClass: 'jw-slick-dots',
			};

			slickOptions = $.extend( {}, defaultOptions, options );

			$target.slick( slickOptions );
		},
	};

	$( window ).on( 'elementor/frontend/init', JetWidgets.init );

	var JetWidgetsTools = {
		debounce: function( threshold, callback ) {
			var timeout;

			return function debounced( $event ) {
				function delayed() {
					callback.call( this, $event );
					timeout = null;
				}

				if ( timeout ) {
					clearTimeout( timeout );
				}

				timeout = setTimeout( delayed, threshold );
			};
		},

		getObjectNextKey: function( object, key ) {
			var keys      = Object.keys( object ),
				idIndex   = keys.indexOf( key ),
				nextIndex = idIndex += 1;

			if( nextIndex >= keys.length ) {
				//we're at the end, there is no next
				return false;
			}

			var nextKey = keys[ nextIndex ];

			return nextKey;
		},

		getObjectPrevKey: function( object, key ) {
			var keys      = Object.keys( object ),
				idIndex   = keys.indexOf( key ),
				prevIndex = idIndex -= 1;

			if ( 0 > idIndex ) {
				//we're at the end, there is no next
				return false;
			}

			var prevKey = keys[ prevIndex ];

			return prevKey;
		},

		getObjectFirstKey: function( object ) {
			return Object.keys( object )[0];
		},

		getObjectLastKey: function( object ) {
			return Object.keys( object )[ Object.keys( object ).length - 1 ];
		},

		validateEmail: function( email ) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

			return re.test( email );
		},

		getElementorElementSettings: function( $scope ) {

			if ( window.elementorFrontend && window.elementorFrontend.isEditMode() ) {
				return JetWidgetsTools.getEditorElementSettings( $scope );
			}

			return $scope.data( 'settings' ) || {};
		},

		getEditorElementSettings: function( $scope ) {
			var modelCID = $scope.data( 'model-cid' ),
				elementData;

			if ( ! modelCID ) {
				return {};
			}

			if ( ! elementor.hasOwnProperty( 'config' ) ) {
				return {};
			}

			if ( ! elementor.config.hasOwnProperty( 'elements' ) ) {
				return {};
			}

			if ( ! elementor.config.elements.hasOwnProperty( 'data' ) ) {
				return {};
			}

			elementData = elementor.config.elements.data[ modelCID ];

			if ( ! elementData ) {
				return {};
			}

			return elementData.toJSON();
		}
	}

	/**
	 * Jet Images Layout Class
	 *
	 * @return {void}
	 */
	window.jwImagesLayout = function( $selector, settings ) {
		var self            = this,
			$instance       = $selector,
			$instanceList   = $( '.jw-images-layout__list', $instance ),
			$itemsList      = $( '.jw-images-layout__item', $instance ),
			defaultSettings = {},
			settings        = settings || {};

		/*
		 * Default Settings
		 */
		defaultSettings = {
			layoutType: 'masonry',
			justifyHeight: 300
		}

		/**
		 * Checking options, settings and options merging
		 */
		$.extend( defaultSettings, settings );

		/**
		 * Layout build
		 */
		self.layoutBuild = function() {
			switch ( settings['layoutType'] ) {
				case 'masonry':
					salvattore.init();

					$(window).on( 'resize orientationchange', function() {
						salvattore.rescanMediaQueries();
					} );
				break;
				case 'justify':
					$itemsList.each( function() {
						var $this          = $( this ),
							$imageInstance = $( '.jw-images-layout__image-instance', $this),
							imageWidth     = $imageInstance.data( 'width' ),
							imageHeight    = $imageInstance.data( 'height' ),
							imageRatio     = +imageWidth / +imageHeight,
							flexValue      = imageRatio * 100,
							newWidth       = +settings['justifyHeight'] * imageRatio,
							newHeight      = 'auto';

						$this.css( {
							'flex-grow': flexValue,
							'flex-basis': newWidth
						} );
					} );
				break;
			}

			$( '.jw-images-layout__image', $itemsList ).imagesLoaded().progress( function( instance, image ) {
				var $image      = $( image.img ),
					$parentItem = $image.closest( '.jw-images-layout__item' ),
					$loader     = $( '.jw-images-layout__image-loader', $parentItem );

				$parentItem.addClass( 'image-loaded' );

				$loader.fadeTo( 500, 0, function() {
					$( this ).remove();
				} );

			});
		}

		/**
		 * Init
		 */
		self.init = function() {
			self.layoutBuild();
		}
	}

}( jQuery, window.elementorFrontend ) );
