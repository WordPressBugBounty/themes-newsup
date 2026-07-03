( function( api ) {
	// Extends our custom "campus-lite" section.
	api.sectionConstructor['newsup-section-pro'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );

(function ($, wp) {
    'use strict';

    wp.customize.controlConstructor['newsup-info-box'] = wp.customize.Control.extend({
        ready: function () {
        }
    });

})(jQuery, wp);