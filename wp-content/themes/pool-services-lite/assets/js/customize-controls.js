( function( api ) {

	// Extends our custom "pool-services-lite" section.
	api.sectionConstructor['pool-services-lite'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );