import Trending from '../components/Trending.js';
import StatsCard from '../components/StatsCard.js';
import ApexChart from '../components/ApexChart.js';

// Lấy data từ PHP (nếu có), nếu không có thì dùng giá trị mặc định
const data = window.dashboardData || {};

// Positive trending
window.createVueApp(Trending, {
    value: data.trends?.positive ?? 7
}).mount('#trending-positive');

// Negative trending
window.createVueApp(Trending, {
    value: data.trends?.negative ?? -1
}).mount('#trending-negative');

// Active users trending
window.createVueApp(Trending, {
    value: data.trends?.activeUsers ?? -1
}).mount('#trending-active-users');

// Stats Cards
window.createVueApp(StatsCard, {
    title: 'Total Users',
    value: data.totalUsers ?? 75782,
    trend: 2,
    description: '24,635 users increased from last month'
}).mount('#stats-total-users');

window.createVueApp(StatsCard, {
    title: 'Revenue',
    value: data.revenue ?? '$128,320',
    trend: 12,
    description: '+$15,240 from last week'
}).mount('#stats-revenue');


// Active Users - Radial Bar Chart
if (document.getElementById('chart-active-users')) {
    window.createVueApp(ApexChart, {
        chartId: 'active-users',
        type: 'radialBar',
        height: 192,
        series: [data.activeUsersPercentage ?? 78],
        options: {
            chart: {
                fontFamily: 'inherit',
                sparkline: {
                    enabled: true,
                },
                animations: {
                    enabled: false,
                },
            },
            plotOptions: {
                radialBar: {
                    startAngle: -120,
                    endAngle: 120,
                    hollow: {
                        margin: 16,
                        size: '50%',
                    },
                    dataLabels: {
                        show: true,
                        value: {
                            offsetY: -8,
                            fontSize: '24px',
                        },
                    },
                },
            },
            labels: [''],
            tooltip: {
                theme: 'dark',
            },
            grid: {
                strokeDashArray: 4,
            },
            colors: ['color-mix(in srgb, transparent, var(--tblr-primary) 100%)'],
            legend: {
                show: false,
            },
        }
    }).mount('#chart-active-users');
}

// Visitors Line Chart
if (document.getElementById('chart-visitors')) {
    window.createVueApp(ApexChart, {
        chartId: 'visitors',
        type: 'line',
        height: 96,
        series: [
            {
                name: 'Visitors',
                data: data.visitorsData ?? [
                    7687, 7543, 7545, 7543, 7635, 8140, 7810, 8315, 8379, 8441, 8485, 8227, 8906, 8561, 8333, 8551, 9305, 9647, 9359, 9840, 9805, 8612, 8970,
                    8097, 8070, 9829, 10545, 10754, 10270, 9282,
                ],
            },
            {
                name: 'Visitors last month',
                data: data.visitorsLastMonthData ?? [
                    8630, 9389, 8427, 9669, 8736, 8261, 8037, 8922, 9758, 8592, 8976, 9459, 8125, 8528, 8027, 8256, 8670, 9384, 9813, 8425, 8162, 8024, 8897,
                    9284, 8972, 8776, 8121, 9476, 8281, 9065,
                ],
            },
        ],
        options: {
            chart: {
                fontFamily: 'inherit',
                sparkline: {
                    enabled: true,
                },
                animations: {
                    enabled: false,
                },
            },
            stroke: {
                width: [2, 1],
                dashArray: [0, 3],
                lineCap: 'round',
                curve: 'smooth',
            },
            tooltip: {
                theme: 'dark',
            },
            grid: {
                strokeDashArray: 4,
            },
            xaxis: {
                labels: {
                    padding: 0,
                },
                tooltip: {
                    enabled: false,
                },
                type: 'datetime',
            },
            yaxis: {
                labels: {
                    padding: 4,
                },
            },
            labels: [
                '2020-06-21',
                '2020-06-22',
                '2020-06-23',
                '2020-06-24',
                '2020-06-25',
                '2020-06-26',
                '2020-06-27',
                '2020-06-28',
                '2020-06-29',
                '2020-06-30',
                '2020-07-01',
                '2020-07-02',
                '2020-07-03',
                '2020-07-04',
                '2020-07-05',
                '2020-07-06',
                '2020-07-07',
                '2020-07-08',
                '2020-07-09',
                '2020-07-10',
                '2020-07-11',
                '2020-07-12',
                '2020-07-13',
                '2020-07-14',
                '2020-07-15',
                '2020-07-16',
                '2020-07-17',
                '2020-07-18',
                '2020-07-19',
                '2020-07-20',
            ],
            colors: ['color-mix(in srgb, transparent, var(--tblr-primary) 100%)', 'color-mix(in srgb, transparent, var(--tblr-gray-400) 100%)'],
            legend: {
                show: false,
            },
        }
    }).mount('#chart-visitors');
}
