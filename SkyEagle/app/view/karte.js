Ext.define("SkyEagle.view.karte",{
	extend: "Ext.Panel",
	xtype: "karte",
	requires: ['Ext.ux.LeafletMap'],
	
	
    config: {
		title: "Karte",
		iconCls: "maps",
		layout: "fit",
                		items: [
							{
							// Ext.ux.LeafletMap Component
							xtype: 'leafletmap',
							id: 'leafletmap',
							useCurrentLocation: false,
							autoMapCenter: false,
                        	enableOwnPositionMarker: false,
							mapOptions: {
								zoom: 15
									}
							}
							]
            		},

});
