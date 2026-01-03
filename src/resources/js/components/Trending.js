import { computed } from 'vue';

export default {
    name: 'Trending',
    props: {
        value: {
            type: Number,
            default: 25
        },
        className: {
            type: String,
            default: ''
        }
    },
    setup(props) {
        const trendingColor = computed(() => {
            if (props.value > 0) return 'green';
            if (props.value === 0) return 'muted';
            return 'red';
        });

        const trendingIcon = computed(() => {
            if (props.value > 0) return 'arrow-up';
            if (props.value === 0) return 'minus';
            return 'arrow-down';
        });

        const iconPath = computed(() => {
            const icons = {
                'arrow-up': 'M3 17l6 -6l4 4l8 -8 M14 7l7 0l0 7',
                'minus': 'M5 12l14 0',
                'arrow-down': 'M3 7l6 6l4 -4l8 8 M21 10l0 7l-7 0'
            };
            return icons[trendingIcon.value];
        });

        return {
            trendingColor,
            trendingIcon,
            iconPath
        };
    },
    template: `
        <span :class="['text-' + trendingColor, 'd-inline-flex', 'align-items-center', 'lh-1', className]">
            {{ value }}%
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
    `
};
