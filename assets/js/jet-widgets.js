( function( $, elementor ) {

	"use strict";

	var JetWidgets = {

		init: function() {

			var widgets = {
				'jet-carousel.default' : JetWidgets.widgetCarousel,
				'jet-posts.default' : JetWidgets.widgetPosts,
				'jet-animated-box.default' : JetWidgets.widgetAnimatedBox,
				'jet-images-layout.default' : JetWidgets.widgetImagesLayout,
				'jet-testimonials.default' : JetWidgets.widgetTestimonials,
				'jet-image-comparison.default' : JetWidgets.widgetImageComparison,
				'jet-subscribe-form.default' : JetWidgets.widgetSubscribeForm,
			};

			$.each( widgets, function( widget, callback ) {
				elementor.hooks.addAction( 'frontend/element_ready/' + widget, callback );
			});
		},

		widgetCarousel: function( $scope ) {

			var $carousel = $scope.find( '.jet-carousel' );

			if ( ! $carousel.length ) {
				return;
			}

			JetWidgets.initCarousel( $carousel, $carousel.data( 'slider_options' ) );

		},

		widgetPosts: function ( $scope ) {

			var $target = $scope.find( '.jet-carousel' );

			if ( ! $target.length ) {
				return;
			}

			JetWidgets.initCarousel( $target.find( '.jet-posts' ), $target.data( 'slider_options' ) );

		},

		widgetAnimatedBox: function( $scope ) {

			JetWidgets.onAnimatedBoxSectionActivated( $scope );

			var $target      = $scope.find( '.jet-animated-box' ),
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
			var isBackSide = -1 !== [ 'section_back_content', 'section_action_button_style' ].indexOf( section );

			if ( isBackSide ) {
				$scope.find( '.jet-animated-box' ).addClass( 'flipped' );
				$scope.find( '.jet-animated-box' ).addClass( 'flipped-stop' );
			} else {
				$scope.find( '.jet-animated-box' ).removeClass( 'flipped' );
				$scope.find( '.jet-animated-box' ).removeClass( 'flipped-stop' );
			}
		},

		widgetImagesLayout: function( $scope ) {
			var $target = $scope.find( '.jet-images-layout' ),
				instance = null,
				settings = {};

			if ( ! $target.length ) {
				return;
			}

			settings = $target.data( 'settings' );
			instance = new jetImagesLayout( $target, settings );
			instance.init();
		},

		widgetSubscribeForm: function( $scope ) {
			var $target               = $scope.find( '.jet-subscribe-form' ),
				scoreId               = $scope.data( 'id' ),
				settings              = $target.data( 'settings' ),
				jetSubscribeFormAjax  = null,
				subscribeFormAjaxId   = 'jet_subscribe_form_ajax',
				$subscribeForm        = $( '.jet-subscribe-form__form', $target ),
				$input                = $( '.jet-subscribe-form__input', $target ),
				$inputData            = $input.data( 'instance-data' ),
				$submitButton         = $( '.jet-subscribe-form__submit', $target ),
				$subscribeFormMessage = $( '.jet-subscribe-form__message', $target ),
				timeout               = null,
				invalidMailMessage    = window.jetWidgets.messages.invalidMail || 'Please specify a valid email';

			jetSubscribeFormAjax = new CherryJsCore.CherryAjaxHandler({
				handlerId: subscribeFormAjaxId,

				successCallback: function( data ) {
					var successType   = data.type,
						message       = data.message || '',
						responceClass = 'jet-subscribe-form--response-' + successType;

					$submitButton.removeClass( 'loading' );

					$target.removeClass( 'jet-subscribe-form--response-error' );
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

					$target.addClass( 'jet-subscribe-form--response-error' );
					$( 'span', $subscribeFormMessage ).html( invalidMailMessage );
					$subscribeFormMessage.css( { 'visibility': 'visible' } );

					timeout = setTimeout( function() {
						$target.removeClass( 'jet-subscribe-form--response-error' );
						$subscribeFormMessage.css( { 'visibility': 'hidden' } );
						$input.removeClass( 'mail-invalid' );
					}, 20000 );
				}
			}
		},

		widgetTestimonials: function( $scope ) {
			var $target        = $scope.find( '.jet-testimonials__instance' ),
				$imagesTagList = $( '.jet-testimonials__figure', $target ),
				instance       = null,
				settings       = $target.data( 'settings' );

			if ( ! $target.length ) {
				return;
			}

			settings.adaptiveHeight = settings['adaptiveHeight'];

			JetWidgets.initCarousel( $target, settings );
		},

		widgetImageComparison: function( $scope ) {
			var $target              = $scope.find( '.jet-image-comparison__instance' ),
				instance             = null,
				imageComparisonItems = $( '.jet-image-comparison__container', $target ),
				settings             = $target.data( 'settings' ),
				elementId            = $scope.data( 'id' );

			if ( ! $target.length ) {
				return;
			}

			window.juxtapose.scanPage( '.jet-juxtapose' );

			settings.draggable = false;
			settings.infinite = false;
			//settings.adaptiveHeight = true;
			JetWidgets.initCarousel( $target, settings );
		},

		initCarousel: function( $target, options ) {

			var tabletSlides, mobileSlides, defaultOptions, slickOptions;

			if ( options.slidesToShow.tablet ) {
				tabletSlides = options.slidesToShow.tablet;
			} else {
				tabletSlides = 1 === options.slidesToShow.desktop ? 1 : 2;
			}

			if ( options.slidesToShow.mobile ) {
				mobileSlides = options.slidesToShow.mobile;
			} else {
				mobileSlides = 1;
			}

			options.slidesToShow = options.slidesToShow.desktop;

			defaultOptions = {
				customPaging: function(slider, i) {
					return $( '<span />' ).text( i + 1 );
				},
				dotsClass: 'jet-slick-dots',
				responsive: [
					{
						breakpoint: 1025,
						settings: {
							slidesToShow: tabletSlides,
						}
					},
					{
						breakpoint: 768,
						settings: {
							slidesToShow: mobileSlides,
							slidesToScroll: 1
						}
					}
				]
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
		}
	}

	/**
	 * Jet Images Layout Class
	 *
	 * @return {void}
	 */
	window.jetImagesLayout = function( $selector, settings ) {
		var self            = this,
			$instance       = $selector,
			$instanceList   = $( '.jet-images-layout__list', $instance ),
			$itemsList      = $( '.jet-images-layout__item', $instance ),
			defaultSettings = {},
			settings        = settings || {};

		/*
		 * Default Settings
		 */
		defaultSettings = {
			layoutType: 'masonry',
			columns: 3,
			columnsTablet: 2,
			columnsMobile: 1,
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
				break;
				case 'justify':
					$itemsList.each( function() {
						var $this          = $( this ),
							$imageInstance = $( '.jet-images-layout__image-instance', $this),
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

			$( '.jet-images-layout__image', $itemsList ).imagesLoaded().progress( function( instance, image ) {
				var $image      = $( image.img ),
					$parentItem = $image.closest( '.jet-images-layout__item' ),
					$loader     = $( '.jet-images-layout__image-loader', $parentItem );

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
