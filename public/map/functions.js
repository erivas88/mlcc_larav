 // Función para etiquetas geográficas fijas (Poppins + Stroke)
    var createPremiumLabel = function(labelClass, labelText, color) {
        return L.divIcon({
            className: labelClass,
            html: `<div style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 11px; 
                               letter-spacing: 1.5px; text-transform: uppercase; white-space: nowrap; 
                               color: ${color || 'white'}; text-shadow: ${blackStroke};">
                        ${labelText}
                   </div>`,
            iconSize: [0, 0],
            iconAnchor: [0, 0]
        });
    };