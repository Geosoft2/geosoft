Ext.define("SkyEagle.view.diagramm",{
	requires: [
				'Ext.field.DatePicker',
				'Ext.field.Select'
				],
	extend: "Ext.Panel",
	xtype: "diagramm",
	
	config: {
		title: "Diagramm",
		iconCls: "char",
		
		items: [
				{
					xtype: "toolbar",
					title: "SkyEagle",
					items: [
						{
						xtype: "button",
						text: "Karte"
						}
					]
				},
				{
					xtype: "panel",
					padding: 10,
					items: [
						{
							xtype: 'datepickerfield',
							destroyPickerOnHide: true,
							name: "data",
							label: "von",
							value: new Date(),
							picker: {
								yearFrom: 1990
							}
						},
						{
							xtype: 'datepickerfield',
							destroyPickerOnHide: true,
							name: "data",
							label: "bis",
							value: new Date(),
							picker: {
								yearFrom: 1990
							}
						},
						{
							xtype: "selectfield",
							name: "Wert",
							label: "Wert",
							options: [
								{
									text: "O2",
									value: "O2"
								},
								{
									text: "O3",
									value: "O3"
								},
								{
									text: "O4",
									value: "O4"
								},
								{
									text: "O5",
									value: "O5"
								}
								]
						},
						{
							xtype: "togglefield",
							name: "toggle",
							label: "Diagramm/Tabelle"
						},
						{
							xtype: "button",
							ui: "confirm", 
							text: "Anzeigen"
						}							
						]
				}
			]
	}
});
