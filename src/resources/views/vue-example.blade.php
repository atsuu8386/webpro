@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Vue.js MPA Components Example</h1>

    <!-- Counter Component -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Counter Component</h2>
        <div id="counter-app"></div>
    </div>

    <!-- Alert Component -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Alert Component</h2>
        <div id="alert-app"></div>
    </div>

    <!-- Inline Vue Component -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Inline Component</h2>
        <div id="inline-app"></div>
    </div>
</div>
@endsection

@push('scripts')
<script type="module">
import { createApp } from 'vue';
import { Counter, Alert } from '@/components/index.js';

// Counter Example
createApp(Counter, {
    title: 'Vote Counter',
    initialValue: 5,
    min: 0,
    max: 10
}).mount('#counter-app');

// Alert Example
const AlertApp = {
    components: { Alert },
    template: `
        <div>
            <alert
                type="success"
                title="Success!"
                message="Vue.js has been successfully integrated into your Laravel MPA!"
            />
            <alert
                type="info"
                message="This is an info alert without a title"
                :dismissible="false"
            />
            <button
                @click="showAlert = !showAlert"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
            >
                Toggle Alert
            </button>
            <alert
                v-if="showAlert"
                type="warning"
                title="Warning"
                message="This alert can be toggled on and off"
            />
        </div>
    `,
    data() {
        return {
            showAlert: false
        };
    }
};
createApp(AlertApp).mount('#alert-app');

// Inline Component Example
const InlineComponent = {
    template: `
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Inline Component</h3>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Your Name:</label>
                <input
                    v-model="name"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md"
                    placeholder="Enter your name"
                >
            </div>
            <p class="text-lg">Hello, <strong>{{ name || 'Guest' }}</strong>!</p>
            <button
                @click="greet"
                class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
            >
                Greet
            </button>
        </div>
    `,
    data() {
        return {
            name: ''
        };
    },
    methods: {
        greet() {
            alert('Hello, ' + (this.name || 'Guest') + '!');
        }
    }
};
createApp(InlineComponent).mount('#inline-app');
</script>
@endpush
