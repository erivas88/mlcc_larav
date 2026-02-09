// 1. CONFIGURACIÓN GLOBAL DE IDIOMA (Fuera del ready para máxima prioridad)
Highcharts.setOptions({
    lang: {
        months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        shortMonths: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        shortWeekdays: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb']
    }
});

$(document).ready(function() {
    const colorCaserones = '#0f7c91';



 function renderizarGrafico(respuesta) {
    // 1. Mapeo de series con colores dinámicos desde el API
    const seriesData = respuesta.series.map(s => ({
        name: s.name,
        data: s.data.sort((a, b) => a[0] - b[0]),
        type: 'line',
        color: s.color, // Color enviado por la Lambda (#007F2D, etc.)
        marker: {
            enabled: true,
            symbol: 'circle',
            radius: 3,
            fillColor: '#FFFFFF',
            lineWidth: 2,
            lineColor: s.color
        }
    }));

    const colorPrincipal = (respuesta.series.length > 0) ? respuesta.series[0].color : '#0f7c91';

    Highcharts.stockChart('chart-container', {
        chart: { 
            zoomType: 'x',
            style: { fontFamily: "'Poppins', sans-serif" }
        },
        
        // --- LEYENDA HABILITADA ---
     legend: {
    enabled: true,
    align: 'center',       // Mantiene la leyenda centrada horizontalmente
    verticalAlign: 'top',  // 👈 LA MUEVE A LA PARTE SUPERIOR
    layout: 'horizontal',  // Mantiene los elementos uno al lado del otro
    y: -10,                // Ajuste fino para separarla un poco del borde superior
    itemStyle: { 
        fontWeight: '400', 
        color: '#7f8c8d',  // Gris elegante
        fontSize: '10px' 
    },
    itemHoverStyle: {
        color: '#34495e'
    }
},

    xAxis: {
        type: 'datetime',
        gridLineWidth: 1,
        gridLineDashStyle: 'Dash',
        gridLineColor: '#E6E6E6',
        labels: {
            style: { 
                fontSize: '9px', // Fuente pequeña para los ejes
                color: '#95a5a6'  // Gris claro para las fechas
            }
        },
        dateTimeLabelFormats: {
            day: '%d/%m',
            week: '%d/%m',
            month: '%m/%y',
            year: '%Y'
        }
    },

    yAxis: {
        opposite: false,
        reversed: respuesta.reversed,
        gridLineDashStyle: 'Dash',
        gridLineColor: '#E6E6E6',
        title: { 
            text: respuesta.unidad,
            style: { 
                color: '#7f8c8d', 
                fontWeight: '700',
                fontSize: '11px' 
            }
        },
        labels: {
            // Aplica los decimales dinámicos del API
            format: '{value:.' + respuesta.decimales + 'f}',
            style: { 
                fontSize: '9px', // Etiquetas de valores más pequeñas
                color: '#95a5a6' 
            }
        }
    },

        tooltip: {
            shared: true,
            split: false,
            useHTML: true,
            backgroundColor: 'rgba(255, 255, 255, 0.95)',
            borderWidth: 1,
            borderColor: colorPrincipal,
            borderRadius: 8,
            shadow: true,
            // --- DECIMALES EN EL TOOLTIP ---
            valueDecimals: respuesta.decimales, // Fuerza la precisión numérica
            headerFormat: '<div style="margin-bottom: 5px; border-bottom: 1px solid #eee; padding-bottom: 3px;">' +
                          '<span style="font-size: 12px; color: #666; font-weight: bold;">{point.key}</span>' +
                          '</div>',
            // Usamos formato de punto respetando los decimales dinámicos
            pointFormat: '<div style="padding: 2px 0;">' +
                         '<span style="color:{point.color}">\u25CF</span> {series.name}: ' +
                         '<span style="font-weight: bold; color: #333;">{point.y:.' + respuesta.decimales + 'f}</span> ' + 
                         '<span style="font-size: 10px; color: #666;">' + respuesta.unidad + '</span>' +
                         '</div>',
            xDateFormat: '%A, %d de %B, %H:%M', 
        },

        plotOptions: {
            series: {
                states: {
                    hover: {
                        lineWidthPlus: 1,
                        marker: { fillColor: null }
                    }
                }
            }
        },

        rangeSelector: { enabled: false },
        navigator: { enabled: true },
        scrollbar: { enabled: true },
        credits: { enabled: false },
        series: seriesData
    });
}


    function monitorearValores() {
        const idPeriodo = $('#sel-periodo').val();
        const idParametro = $('#sel-parametro').val();
        const urlSegments = window.location.pathname.split('/');
        const idEstacion = urlSegments.pop() || urlSegments.pop();

        if (idEstacion && !isNaN(idEstacion) && idParametro && idPeriodo) {
            $('#chart-container').html(`<div class="text-center p-5"><div class="spinner-border" style="color:${colorCaserones}" role="status"></div><p class="mt-2">Procesando datos...</p></div>`);

            $.ajax({
                url: "https://7j63yn4jf9.execute-api.us-east-1.amazonaws.com/Prod/obtener-datos-grafico",
                method: "POST",
                data: { estacion: idEstacion, parametro: idParametro, periodo: idPeriodo },
                success: function(response) { renderizarGrafico(response); },
                error: function() { $('#chart-container').html('<div class="alert alert-danger">Error de comunicación con AWS.</div>'); }
            });
        }
    }

    // Inicialización de componentes
    $('.select2-pro').select2({ theme: 'bootstrap-5', width: '100%' });
    monitorearValores();
    $('#sel-periodo, #sel-parametro').on('change', monitorearValores);
});