/**
 * Counter Component Example
 */
export default {
    template: `
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">{{ title }}</h3>
            <div class="flex items-center gap-4">
                <button
                    @click="decrement"
                    :disabled="count <= min"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-50"
                >
                    -
                </button>
                <div class="text-2xl font-bold">{{ count }}</div>
                <button
                    @click="increment"
                    :disabled="count >= max"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-50"
                >
                    +
                </button>
            </div>
        </div>
    `,
    props: {
        title: {
            type: String,
            default: 'Counter'
        },
        initialValue: {
            type: Number,
            default: 0
        },
        min: {
            type: Number,
            default: 0
        },
        max: {
            type: Number,
            default: 100
        }
    },
    data() {
        return {
            count: this.initialValue
        };
    },
    methods: {
        increment() {
            if (this.count < this.max) {
                this.count++;
                this.$emit('change', this.count);
            }
        },
        decrement() {
            if (this.count > this.min) {
                this.count--;
                this.$emit('change', this.count);
            }
        }
    }
};
