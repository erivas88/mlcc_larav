
    var rajox = L.polygon(rajo_caserones,
    {
        color: '#be0000',
        fillColor: '',
        fillOpacity: '0.0',
        radius: 100,
        weight: 3
    });
    
    
    
    var labrea1 = L.polygon(deposito_lamas,
    {
        color: '#66023C',
        fillColor: '#66023C',
        fillOpacity: 0.5,
        radius: 100,
        weight: 3
    });
    
     var lastre = L.polygon(deposito_lastre,
    {
        color: '#FFFF5C',
        fillColor: '#FFFF5C',
        fillOpacity: 0.5,
        radius: 100,
        weight: 3
    });
    
     var rramdillas = L.polygon(ramadillas,
    {
        color: '#33B503',
        fillColor: '#33B503',
        fillOpacity: 0.5,
        radius: 100,
        weight: 3
    });
    
     var relleno = L.polygon(arenas,
    {
        color: '#f77f00',
        fillColor: '#f77f00',
        fillOpacity: 0.5,
        radius: 100,
        weight: 3
    });
    
     var riverr = L.river(rio_4,
    {
        minWidth: 1, // px
        maxWidth: 2, // px
        color: "#29439c", // px
    });
    
    var riverp = L.river(rio,
    {
        minWidth: 1, // px
        maxWidth: 1,
        color: "#29439c", // px
    }).bindLabel('<span class="pop_text" style=" font-size: x-small">  Río Vizcachas de Pulido <span>');
    
    
    var riverx = L.river(rio_5,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#29439c", // px
    }).bindLabel('<span class="pop_text"; style="font-size: x-small"> Río  Pulido<span>')
    
    
    var polyline = L.polyline(frontera,
    {
        color: 'white',
        dashOffset: '0', 
        weight: 2
    });
    
    
    var labrea2 = L.river(qdalabrea,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    
    var quebrada2 = L.river(q2,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    var quebrada3 = L.river(q3,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    var quebrada4 = L.river(q4,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    var quebrada5 = L.river(q5,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    var quebrada6 = L.river(q6,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    var quebrada7 = L.river(q7,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    var quebrada8 = L.river(q8,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    var quebrada9 = L.river(q9,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    var quebrada10 = L.river(q10,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    var quebrada11 = L.river(q11,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    var quebrada12 = L.river(q12,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    var quebrada13 = L.river(q13,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    var quebrada14 = L.river(q14,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });

 
    var quebrada16 = L.river(q16,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    var quebrada18 = L.river(q18,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    var quebrada19 = L.river(q19,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    var quebrada20 = L.river(q20,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    var quebrada21 = L.river(q21,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    var quebrada22 = L.river(q22,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    var quebrada23 = L.river(q23,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    var quebrada24 = L.river(q24,
    {
        minWidth: 1, // px
        maxWidth: 1, // px
        color: "#87ceeb ", // px
    });
    
    
    
    

L.Control.MiniMap = L.Control.extend({
	options: {
		position: 'bottomright',
		condensedAttributionControl: false,
		toggleDisplay: false,
		zoomLevelOffset: -5,
		zoomLevelFixed: false,
		zoomAnimation: false,
		autoToggleDisplay: false,
		width: 150,
		height: 150,
	//	aimingRectOptions: {color: "#ff7800", weight: 1, clickable: false},
			aimingRectOptions: {color: "navy", weight: 1, clickable: false},
		shadowRectOptions: {color: "#000000", weight: 1, clickable: false, opacity:0, fillOpacity:0}
	},
	
	hideText: 'Hide MiniMap',
	
	showText: 'Show MiniMap',
	
	//layer is the map layer to be shown in the minimap
	initialize: function (layer, options) {
		L.Util.setOptions(this, options);
		//Make sure the aiming rects are non-clickable even if the user tries to set them clickable (most likely by forgetting to specify them false)
		this.options.aimingRectOptions.clickable = false;
		this.options.shadowRectOptions.clickable = false;
		this._layer = layer;
	},
	
	onAdd: function (map) {

		this._mainMap = map;

		//Creating the container and stopping events from spilling through to the main map.
		this._container = L.DomUtil.create('div', 'leaflet-control-minimap');
		this._container.style.width = this.options.width + 'px';
		this._container.style.height = this.options.height + 'px';
		L.DomEvent.disableClickPropagation(this._container);
		L.DomEvent.on(this._container, 'mousewheel', L.DomEvent.stopPropagation);


		this._miniMap = new L.Map(this._container,
		{
			attributionControl: false,
			zoomControl: false,
			zoomAnimation: this.options.zoomAnimation,
			autoToggleDisplay: this.options.autoToggleDisplay,
			touchZoom: !this.options.zoomLevelFixed,
			scrollWheelZoom: !this.options.zoomLevelFixed,
			doubleClickZoom: !this.options.zoomLevelFixed,
			boxZoom: !this.options.zoomLevelFixed,
			crs: map.options.crs
		});

		this._miniMap.addLayer(this._layer);
		
		this._miniMap.addLayer(rajox);
		this._miniMap.addLayer(labrea1);
		this._miniMap.addLayer(lastre);
		this._miniMap.addLayer(rramdillas);
		this._miniMap.addLayer(relleno);
		this._miniMap.addLayer(riverr);
		this._miniMap.addLayer(riverp);
		this._miniMap.addLayer(riverx);
		this._miniMap.addLayer(polyline);
		/**************************/

		this._miniMap.addLayer(labrea2);
		this._miniMap.addLayer(quebrada2);
		this._miniMap.addLayer(quebrada3);
		this._miniMap.addLayer(quebrada4);
		this._miniMap.addLayer(quebrada5);
		this._miniMap.addLayer(quebrada6);
			this._miniMap.addLayer(quebrada7);
				this._miniMap.addLayer(quebrada8);
					this._miniMap.addLayer(quebrada9);
						this._miniMap.addLayer(quebrada10);
							this._miniMap.addLayer(quebrada11);
								this._miniMap.addLayer(quebrada12);
									this._miniMap.addLayer(quebrada13);
									this._miniMap.addLayer(quebrada14);
									this._miniMap.addLayer(quebrada16);
									this._miniMap.addLayer(quebrada18);
									this._miniMap.addLayer(quebrada19);
									this._miniMap.addLayer(quebrada20);
									this._miniMap.addLayer(quebrada21);
									this._miniMap.addLayer(quebrada22);
									this._miniMap.addLayer(quebrada23);
									this._miniMap.addLayer(quebrada24);
		 
		
		
		
		

		//These bools are used to prevent infinite loops of the two maps notifying each other that they've moved.
		this._mainMapMoving = false;
		this._miniMapMoving = false;

		//Keep a record of this to prevent auto toggling when the user explicitly doesn't want it.
		this._userToggledDisplay = false;
		this._minimized = false;

		if (this.options.toggleDisplay) {
			this._addToggleButton();
		}

		this._miniMap.whenReady(L.Util.bind(function () {
			this._aimingRect = L.rectangle(this._mainMap.getBounds(), this.options.aimingRectOptions).addTo(this._miniMap);
			this._shadowRect = L.rectangle(this._mainMap.getBounds(), this.options.shadowRectOptions).addTo(this._miniMap);
			this._mainMap.on('moveend', this._onMainMapMoved, this);
			this._mainMap.on('move', this._onMainMapMoving, this);
			this._miniMap.on('movestart', this._onMiniMapMoveStarted, this);
			this._miniMap.on('move', this._onMiniMapMoving, this);
			this._miniMap.on('moveend', this._onMiniMapMoved, this);
		}, this));

		return this._container;
	},

	addTo: function (map) {
		L.Control.prototype.addTo.call(this, map);
		this._miniMap.setView(this._mainMap.getCenter(), this._decideZoom(true));
		this._setDisplay(this._decideMinimized());
		return this;
	},

	onRemove: function (map) {
		this._mainMap.off('moveend', this._onMainMapMoved, this);
		this._mainMap.off('move', this._onMainMapMoving, this);
		this._miniMap.off('moveend', this._onMiniMapMoved, this);

		this._miniMap.removeLayer(this._layer);
	},

	_addToggleButton: function () {
		this._toggleDisplayButton = this.options.toggleDisplay ? this._createButton(
				'', this.hideText, 'leaflet-control-minimap-toggle-display', this._container, this._toggleDisplayButtonClicked, this) : undefined;
	},

	_createButton: function (html, title, className, container, fn, context) {
		var link = L.DomUtil.create('a', className, container);
		link.innerHTML = html;
		link.href = '#';
		link.title = title;

		var stop = L.DomEvent.stopPropagation;

		L.DomEvent
			.on(link, 'click', stop)
			.on(link, 'mousedown', stop)
			.on(link, 'dblclick', stop)
			.on(link, 'click', L.DomEvent.preventDefault)
			.on(link, 'click', fn, context);

		return link;
	},

	_toggleDisplayButtonClicked: function () {
		this._userToggledDisplay = true;
		if (!this._minimized) {
			this._minimize();
			this._toggleDisplayButton.title = this.showText;
		}
		else {
			this._restore();
			this._toggleDisplayButton.title = this.hideText;
		}
	},

	_setDisplay: function (minimize) {
		if (minimize != this._minimized) {
			if (!this._minimized) {
				this._minimize();
			}
			else {
				this._restore();
			}
		}
	},

	_minimize: function () {
		// hide the minimap
		if (this.options.toggleDisplay) {
			this._container.style.width = '19px';
			this._container.style.height = '19px';
			this._toggleDisplayButton.className += ' minimized';
		}
		else {
			this._container.style.display = 'none';
		}
		this._minimized = true;
	},

	_restore: function () {
		if (this.options.toggleDisplay) {
			this._container.style.width = this.options.width + 'px';
			this._container.style.height = this.options.height + 'px';
			this._toggleDisplayButton.className = this._toggleDisplayButton.className
					.replace(/(?:^|\s)minimized(?!\S)/g, '');
		}
		else {
			this._container.style.display = 'block';
		}
		this._minimized = false;
	},

	_onMainMapMoved: function (e) {
		if (!this._miniMapMoving) {
			this._mainMapMoving = true;
			this._miniMap.setView(this._mainMap.getCenter(), this._decideZoom(true));
			this._setDisplay(this._decideMinimized());
		} else {
			this._miniMapMoving = false;
		}
		this._aimingRect.setBounds(this._mainMap.getBounds());
	},

	_onMainMapMoving: function (e) {
		this._aimingRect.setBounds(this._mainMap.getBounds());
	},

	_onMiniMapMoveStarted:function (e) {
		var lastAimingRect = this._aimingRect.getBounds();
		var sw = this._miniMap.latLngToContainerPoint(lastAimingRect.getSouthWest());
		var ne = this._miniMap.latLngToContainerPoint(lastAimingRect.getNorthEast());
		this._lastAimingRectPosition = {sw:sw,ne:ne};
	},

	_onMiniMapMoving: function (e) {
		if (!this._mainMapMoving && this._lastAimingRectPosition) {
			this._shadowRect.setBounds(new L.LatLngBounds(this._miniMap.containerPointToLatLng(this._lastAimingRectPosition.sw),this._miniMap.containerPointToLatLng(this._lastAimingRectPosition.ne)));
			this._shadowRect.setStyle({opacity:1,fillOpacity:0.3});
		}
	},

	_onMiniMapMoved: function (e) {
		if (!this._mainMapMoving) {
			this._miniMapMoving = true;
			this._mainMap.setView(this._miniMap.getCenter(), this._decideZoom(false));
			this._shadowRect.setStyle({opacity:0,fillOpacity:0});
		} else {
			this._mainMapMoving = false;
		}
	},

	_decideZoom: function (fromMaintoMini) {
		if (!this.options.zoomLevelFixed) {
			if (fromMaintoMini)
				return this._mainMap.getZoom() + this.options.zoomLevelOffset;
			else {
				var currentDiff = this._miniMap.getZoom() - this._mainMap.getZoom();
				var proposedZoom = this._miniMap.getZoom() - this.options.zoomLevelOffset;
				var toRet;
				
				if (currentDiff > this.options.zoomLevelOffset && this._mainMap.getZoom() < this._miniMap.getMinZoom() - this.options.zoomLevelOffset) {
					//This means the miniMap is zoomed out to the minimum zoom level and can't zoom any more.
					if (this._miniMap.getZoom() > this._lastMiniMapZoom) {
						//This means the user is trying to zoom in by using the minimap, zoom the main map.
						toRet = this._mainMap.getZoom() + 1;
						//Also we cheat and zoom the minimap out again to keep it visually consistent.
						this._miniMap.setZoom(this._miniMap.getZoom() -1);
					} else {
						//Either the user is trying to zoom out past the mini map's min zoom or has just panned using it, we can't tell the difference.
						//Therefore, we ignore it!
						toRet = this._mainMap.getZoom();
					}
				} else {
					//This is what happens in the majority of cases, and always if you configure the min levels + offset in a sane fashion.
					toRet = proposedZoom;
				}
				this._lastMiniMapZoom = this._miniMap.getZoom();
				return toRet;
			}
		} else {
			if (fromMaintoMini)
				return this.options.zoomLevelFixed;
			else
				return this._mainMap.getZoom();
		}
	},

	_decideMinimized: function () {
		if (this._userToggledDisplay) {
			return this._minimized;
		}

		if (this.options.autoToggleDisplay) {
			if (this._mainMap.getBounds().contains(this._miniMap.getBounds())) {
				return true;
			}
			return false;
		}

		return this._minimized;
	}
});

L.Map.mergeOptions({
	miniMapControl: false
});

L.Map.addInitHook(function () {
	if (this.options.miniMapControl) {
		this.miniMapControl = (new L.Control.MiniMap()).addTo(this);
	}
});

L.control.minimap = function (options) {
	return new L.Control.MiniMap(options);
};