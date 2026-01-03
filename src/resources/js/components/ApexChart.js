import { onMounted, onBeforeUnmount, watch, ref } from 'vue';

export default {
    name: 'ApexChart',
    props: {
        chartId: {
            type: String,
            required: true
        },
        type: {
            type: String,
            default: 'bar'
        },
        height: {
            type: Number,
            default: 10
        },
        series: {
            type: Array,
            required: true
        },
        options: {
            type: Object,
            default: () => ({})
        },
        sparkline: {
            type: Boolean,
            default: false
        },
        stacked: {
            type: Boolean,
            default: false
        }
    },
    setup(props) {
        const chartElement = ref(null);
        let chart = null;

        const defaultOptions = {
            chart: {
                type: props.type,
                fontFamily: 'inherit',
                height: props.height,
                parentHeightOffset: 0,
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: false
                },
                sparkline: {
                    enabled: props.sparkline
                },
                stacked: props.stacked
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                lineCap: 'round',
                curve: 'smooth'
            },
            tooltip: {
                theme: 'dark'
            },
            grid: {
                padding: {
                    top: -20,
                    right: 0,
                    left: -4,
                    bottom: -4
                },
                strokeDashArray: 4
            },
            xaxis: {
                labels: {
                    padding: 0
                },
                tooltip: {
                    enabled: false
                },
                axisBorder: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    padding: 4
                }
            },
            legend: {
                show: false
            },
            colors: ['var(--tblr-primary)', 'var(--tblr-success)', 'var(--tblr-info)']
        };

        const initChart = async () => {
            if (!chartElement.value) return;

            // Dynamically import ApexCharts
            const ApexCharts = (await import('apexcharts')).default;

            const mergedOptions = {
                ...defaultOptions,
                ...props.options,
                chart: {
                    ...defaultOptions.chart,
                    ...(props.options.chart || {})
                }
            };

            chart = new ApexCharts(chartElement.value, {
                ...mergedOptions,
                series: props.series
            });
            chart.render();
        };

        const updateChart = () => {
            if (chart) {
                chart.updateOptions({
                    ...props.options,
                    series: props.series
                });
            }
        };

        onMounted(() => {
            initChart();
        });

        onBeforeUnmount(() => {
            if (chart) {
                chart.destroy();
            }
        });

        watch(() => props.series, updateChart, { deep: true });
        watch(() => props.options, updateChart, { deep: true });

        return {
            chartElement
        };
    },
    template: `
        <div :id="'chart-' + chartId" ref="chartElement" class="chart"></div>
    `
};
