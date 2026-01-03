<template>
    <div v-if="visible"
        class="position-absolute top-0 start-0 w-100 h-100 bg-white d-flex justify-content-center align-items-center"
        style="z-index: 10; opacity: 0.8;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</template>

<script>
export default {
    name: 'LoadingSpinner',
    props: {
        visible: {
            type: Boolean,
            default: false
        }
    }
}
</script>