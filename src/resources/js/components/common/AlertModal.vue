<template>
    <div v-if="visible">
        <!-- Backdrop -->
        <div class="modal-backdrop fade show" style="z-index: 1060;"></div>

        <!-- Modal -->
        <div class="modal modal-blur fade show d-block" tabindex="-1" role="dialog" style="z-index: 1065;">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content shadow-lg">
                    <button type="button" class="btn-close" @click="hide" aria-label="Close"></button>
                    <div class="modal-status" :class="`bg-${type}`"></div>
                    <div class="modal-body text-center py-4">
                        <!-- Icon based on type -->
                        <svg v-if="type === 'danger'" xmlns="http://www.w3.org/2000/svg"
                            class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 9v2m0 4v.01" />
                            <path
                                d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.84 2.75z" />
                        </svg>
                        <svg v-else-if="type === 'success'" xmlns="http://www.w3.org/2000/svg"
                            class="icon mb-2 text-green icon-lg" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M9 12l2 2l4 -4" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-secondary icon-lg"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M12 8v4" />
                            <path d="M12 16h.01" />
                        </svg>

                        <h3>{{ title }}</h3>
                        <div class="text-secondary" style="white-space: pre-line;">{{ message }}</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn w-100" @click="hide">
                                        {{ buttonText || 'OK' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AlertModal',
    data() {
        return {
            visible: false,
            title: '',
            message: '',
            type: 'info', // info, success, danger, warning
            buttonText: ''
        }
    },
    methods: {
        show(title, message, type = 'info', buttonText = 'OK') {
            this.title = title;
            this.message = message;
            this.type = type;
            this.buttonText = buttonText;
            this.visible = true;
        },
        hide() {
            this.visible = false;
        }
    }
}
</script>