import { createApp } from 'vue';
import '@/bootstrap'; // Ensure bootstrap.js is loaded first for CSRF token
import TagList from '@/components/tag/TagList.vue';

const app = createApp(TagList);
app.mount('#tags-app');

export default app;
