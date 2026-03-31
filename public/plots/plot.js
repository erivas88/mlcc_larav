
Highcharts.setOptions({
    lang: {
        months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        shortMonths: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        shortWeekdays: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
        noData: "No hay mediciones registradas para este periodo",
        decimalPoint: ',',
        thousandsSep: '.'
    },
    // Esto obliga a que CUALQUER fecha del gráfico use este formato
    time: {
        useUTC: false // Ayuda a que las fechas coincidan con tu zona horaria
    }
});

$(document).ready(function() {
    const colorCaserones = '#0f7c91';
    const API_BASE_URL = $('meta[name="api-base-url"]').attr('content');
    function renderizarGrafico(respuesta) {
        // 1. Mapeo de series con colores dinámicos desde el API
        const seriesData = respuesta.series.map(s => ({
            name: s.name,
            data: s.data.sort((a, b) => a[0] - b[0]),
            type: 'line',
            color: s.color, // Color enviado por la Lambda (#007F2D, etc.)
            lineWidth: 1,
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
                style: {
                    fontFamily: "'Poppins', sans-serif"
                }
            },
            exporting: {
                enabled: true, 
                buttons: {
                    contextButton: {
                      
                        menuItems: ['downloadPNG']
                    }
                },        
                buttons: {
                    contextButton: {
                        symbolStroke: '#7f8c8d', 
                        menuItems: ['downloadPNG']
                    }
                }
            },           
            legend: {
                enabled: true,
                align: 'center', // Mantiene la leyenda centrada horizontalmente
                verticalAlign: 'top', // 👈 LA MUEVE A LA PARTE SUPERIOR
                layout: 'horizontal', // Mantiene los elementos uno al lado del otro
                y: -10, // Ajuste fino para separarla un poco del borde superior
                itemStyle: {
                    fontWeight: '700',
                    color: '#7f8c8d', // Gris elegante
                    fontSize: '11px'
                },
                itemHoverStyle: {
                    color: '#34495e'
                },
                style: {
                    color: '#7f8c8d',
                    fontWeight: '700',
                    fontSize: '11px'
                }
            },

            xAxis: {
                type: 'datetime',
                labels: {
                    format: '{value:%e %b}', // Fuerza formato "10 Feb"
                    style: {
                        fontSize: '9px',
                        color: '#95a5a6'
                    }
                },
                gridLineWidth: 1,
                gridLineDashStyle: 'Dash',
                gridLineColor: '#E6E6E6',
                lineWidth: 1, // Esto hace visible la línea vertical del eje Y
                lineColor: '#cccccc', // Color de la línea (ajusta según tu eje X)
                gridLineWidth: 1, // Las líneas horizontales de fondo (opcional)
                labels: {
                    style: {
                        fontSize: '9px', // Fuente pequeña para los ejes
                        color: '#95a5a6' // Gris claro para las fechas
                    }
                },
                dateTimeLabelFormats: {
                    day: '%e/%b', // Ej: 10/Ene
                    month: '%b \'%y', // Ej: Ene '26
                    year: '%Y'
                }
            },

            yAxis: {
                opposite: false,
                reversed: respuesta.reversed,
                gridLineDashStyle: 'Dash',
                gridLineColor: '#E6E6E6',
                gridLineWidth: 1,

                lineWidth: 1,                 // Línea vertical eje Y
                lineColor: '#95a5a6',          // Mismo color que labels
                tickWidth: 1,
                tickColor: '#95a5a6',

                title: {
                    text: respuesta.title_axis,
                    style: {
                        fontSize: '11px',
                        fontWeight: '600',
                        color: '#95a5a6'
                    }
                },

                labels: {
                    format: '{value:.' + respuesta.decimales + 'f}',
                    style: {
                        fontSize: '9px',
                        color: '#95a5a6'
                    }
                }
        },

            tooltip: {
                shared: true,
                split: false,
                useHTML: true,
                // %A = Nombre día, %e = número día, %B = Nombre mes completo
                xDateFormat: '%A, %e de %B de %Y, %H:%M',
                headerFormat: '<div style="margin-bottom: 5px; border-bottom: 1px solid #eee; padding-bottom: 3px;">' +
                    '<span style="font-size: 12px; color: #666; font-weight: bold;">{point.key}</span>' +
                    '</div>',
                pointFormat: '<div style="padding: 2px 0;">' +
                    '<span style="color:{point.color}">\u25CF</span> {series.name}: ' +
                    '<span style="font-weight: bold; color: #333;">{point.y:.' + respuesta.decimales + 'f}</span> ' +
                    '<span style="font-size: 10px; color: #666;">' + respuesta.unidad + '</span>' +
                    '</div>',
                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                borderRadius: 8,
                borderWidth: 1,
                borderColor: colorPrincipal
            },

            plotOptions: {
                series: {
                    dataGrouping: {
                        enabled: false // Evita que Highcharts oculte etiquetas al agrupar
                    },
                    states: {
                        hover: {
                            lineWidthPlus: 1,
                            marker: {
                                fillColor: null
                            }
                        }
                    }
                }
            },

            rangeSelector: {
                enabled: false
            },
            navigator: {
                type: 'line', 
                enabled: true,
                outlineColor: '#e0e6ed',
                maskFill: 'rgba(15, 124, 145, 0.1)', // Tu colorPrincipal con mucha transparencia
                series: {
                    color: '#0f7c91',
                    lineWidth: 1,
                    fillOpacity: 0.2
                },
                yAxis: {
                    // Aquí aplicas tu lógica de límites
                    //min: respuesta.limite_min !== null ? parseFloat(respuesta.limite_min) : null,
                    //max: respuesta.limite_max !== null ? parseFloat(respuesta.limite_max) : null,            
                    // Opcional: Evita que el Navigator fuerce sus propios extremos
                    startOnTick: false,
                    endOnTick: false
                },
                xAxis: {
                    labels: {

                        // FORZAR TRADUCCIÓN AQUÍ
                        formatter: function() {
                            // Usamos el método nativo de Highcharts para formatear la fecha
                            // %b llamará a tus 'shortMonths' definidos en setOptions
                            return Highcharts.dateFormat('%e/%b', this.value);
                        }
                    }
                },
                dateTimeLabelFormats: {
                    day: '%e/%b',
                    month: '%b \'%y'
                }
            },
            scrollbar: {
                enabled: true
            },
            credits: {
                enabled: false
            },
            noData: {
                style: {
                    fontWeight: 'bold',
                    fontSize: '15px',
                    color: '#303030'
                },
                attr: {
                    // Opcional: puedes mover la posición del mensaje
                    // align: 'left'
                }
            },
            series: seriesData,
            lang: {
                noData: "No hay mediciones registradas para este periodo" // Texto personalizado
            }
        });
    }


    function monitorearValores() {
        const idPeriodo = $('#sel-periodo').val();
        const idParametro = $('#sel-parametro').val();
        const urlSegments = window.location.pathname.split('/');
        const idEstacion = urlSegments.pop() || urlSegments.pop();



        if (idEstacion && !isNaN(idEstacion) && idParametro && idPeriodo) {
            // Aplicamos el overlay con un contenedor de borde completo
            $('#chart-container').html(`
        <div class="chart-loading-wrapper">
            <div class="chart-loading-overlay">
                <div class="custom-loader"></div>
                <p class="loading-text">
                    Sincronizando registros...
                </p>
            </div>
        </div>
    `);

            // Iniciar llamada AJAX...

            $.ajax({
                url: `${API_BASE_URL}/obtener-datos-grafico`,
                method: "POST",
                data: {
                    estacion: idEstacion,
                    parametro: idParametro,
                    periodo: idPeriodo
                },
                success: function(response) {
                    renderizarGrafico(response);
                },
                error: function() {
                    $('#chart-container').html('<div class="alert alert-danger">Error de comunicación con AWS.</div>');
                }
            });
        }
    }

    // Inicialización de componentes
    $('.select2-pro').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });
    monitorearValores();
    $('#sel-periodo, #sel-parametro').on('change', monitorearValores);
});