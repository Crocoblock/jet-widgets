( function( $ ) {

	'use strict';

	var JetWidgetsEditor = {

		activeSection: null,

		editedElement: null,

		init: function() {
			elementor.channels.editor.on( 'section:activated', JetWidgetsEditor.onAnimatedBoxSectionActivated );

			window.elementor.on( 'preview:loaded', function() {
				elementor.$preview[0].contentWindow.JetWidgetsEditor = JetWidgetsEditor;
			});
		},

		onAnimatedBoxSectionActivated: function( sectionName, editor ) {
			var editedElement = editor.getOption( 'editedElementView' );

			if ( 'jw-animated-box' !== editedElement.model.get( 'widgetType' ) ) {
				var prevEditedElement = window.JetWidgetsEditor.editedElement;

				if ( ! prevEditedElement ) {
					return;
				}

				if ( 'jw-animated-box' !== prevEditedElement.model.get( 'widgetType' ) ) {
					return;
				}

				prevEditedElement.$el.find( '.jw-animated-box' ).removeClass( 'flipped' );
				prevEditedElement.$el.find( '.jw-animated-box' ).addClass( 'flipped-stop' );

				window.JetWidgetsEditor.editedElement = null;
				
				return;
			}

			window.JetWidgetsEditor.editedElement = editedElement;
			window.JetWidgetsEditor.activeSection = sectionName;

			var isBackSide = -1 !== [ 'section_back_content', 'section_action_button_style' ].indexOf( sectionName );

			if ( isBackSide ) {
				editedElement.$el.find( '.jw-animated-box' ).addClass( 'flipped' );
				editedElement.$el.find( '.jw-animated-box' ).addClass( 'flipped-stop' );
			} else {
				editedElement.$el.find( '.jw-animated-box' ).removeClass( 'flipped' );
				editedElement.$el.find( '.jw-animated-box' ).addClass( 'flipped-stop' );
			}
		}
	};

	$( window ).on( 'elementor:init', JetWidgetsEditor.init );

	window.JetWidgetsEditor = JetWidgetsEditor;

}( jQuery ) );
