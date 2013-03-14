Ext.define('SkyEagle.view.Main', {
    extend: 'Ext.tab.Panel',
    xtype: 'Main',
    requires: [
        'Ext.TitleBar',
        'Ext.Video',
        'Ext.ux.LeafletMap'
    ],
    config: {
        tabBarPosition: 'bottom',

        items: [
        		{
            		xtype:"karte"
            	},
            	{
            		xtype: "diagramm"
            	},
            	{
            		xtype: "impressum"
            	} 
                ]
            }
});
