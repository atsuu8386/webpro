import { computed } from 'vue';

export default {
    name: 'StatsCard',
    props: {
        title: {
            type: String,
            required: true
        },
        value: {
            type: [String, Number],
            required: true
        },
        trend: {
            type: Number,
            default: 0
        },
        description: {
            type: String,
            default: ''
        },
        chartData: {
            type: Array,
            default: () => []
        }
    },
    setup(props) {
        const trendingColor = computed(() => {
            if (props.trend > 0) return 'green';
            if (props.trend === 0) return 'muted';
            return 'red';
        });

        const trendingIcon = computed(() => {
            if (props.trend > 0) return 'arrow-up';
            if (props.trend === 0) return 'minus';
            return 'arrow-down';
        });

        const iconPath = computed(() => {
            const icons = {
                'arrow-up': 'M3 17l6 -6l4 4l8 -8 M14 7l7 0l0 7',
                'minus': 'M5 12l14 0',
                'arrow-down': 'M12 5l0 14 M18 13l-6 6 M6 13l6 6'
            };
            return icons[trendingIcon.value];
        });

        const formattedValue = computed(() => {
            if (typeof props.value === 'number') {
                return props.value.toLocaleString();
            }
            return props.value;
        });

        return {
            trendingColor,
            trendingIcon,
            iconPath,
            formattedValue
        };
    },
    template: `
            <div>
                <div class="subheader">{{ title }}</div>
                <div class="d-flex align-items-baseline">
                    <div class="h1 mb-0 me-2">{{ formattedValue }}</div>
                    <div class="me-auto">
                        <span :class="['text-' + trendingColor, 'd-inline-flex', 'align-items-center', 'lh-1']">
                            {{ trend }}%
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="icon icon-sm ms-1"
                                 width="24"
                                 height="24"
                                 viewBox="0 0 24 24"
                                 stroke-width="2"
                                 stroke="currentColor"
                                 fill="none"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path :d="iconPath"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div v-if="description" class="text-secondary mt-2">{{ description }}</div>
            </div>
    `
};
