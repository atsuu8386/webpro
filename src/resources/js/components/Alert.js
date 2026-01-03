/**
 * Alert Component
 */
export default {
    template: `
        <div
            v-if="show"
            class="rounded-md p-4 mb-4"
            :class="alertClass"
            role="alert"
        >
            <div class="flex">
                <div class="flex-1">
                    <h4 v-if="title" class="font-semibold mb-1">{{ title }}</h4>
                    <p>{{ message }}</p>
                </div>
                <button
                    v-if="dismissible"
                    @click="close"
                    class="ml-4 text-xl leading-none hover:opacity-75"
                >
                    &times;
                </button>
            </div>
        </div>
    `,
    props: {
        type: {
            type: String,
            default: 'info',
            validator: (value) => ['success', 'danger', 'warning', 'info'].includes(value)
        },
        title: String,
        message: {
            type: String,
            required: true
        },
        dismissible: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            show: true
        };
    },
    computed: {
        alertClass() {
            const classes = {
                success: 'bg-green-100 text-green-800 border border-green-200',
                danger: 'bg-red-100 text-red-800 border border-red-200',
                warning: 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                info: 'bg-blue-100 text-blue-800 border border-blue-200'
            };
            return classes[this.type] || classes.info;
        }
    },
    methods: {
        close() {
            this.show = false;
            this.$emit('close');
        }
    }
};
