<template>
  <div>
    <div class="card-body border-bottom py-3">
      <div class="d-flex">
        <div class="text-secondary">
          {{ __('show') }}
          <div class="mx-2 d-inline-block">
            <select v-model.number="perPage" @change="fetchTags" class="form-select form-select-sm">
              <option v-for="n in perPageOptions" :key="n" :value="n">{{ n }}</option>
            </select>
          </div>
          {{ __('entries') }}
        </div>
        <div class="ms-auto text-secondary">
          {{ __('search') }}:
          <div class="ms-2 d-inline-block">
            <input
              v-model="search"
              @input="fetchTags"
              type="text"
              class="form-control form-control-sm"
              :placeholder="__('search_placeholder')"
            />
          </div>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap datatable">
        <thead>
          <tr>
            <th class="w-1">{{ __('no') }}</th>
            <th>{{ __('name') }}</th>
            <th>{{ __('color') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(tag, idx) in tags.data" :key="tag.id">
            <td><span class="text-secondary">{{ (tags.current_page - 1) * tags.per_page + idx + 1 }}</span></td>
            <td><a href="#" class="text-reset">{{ tag.name }}</a></td>
            <td>
              <span class="badge" :style="{ backgroundColor: tag.color, color: getContrastColor(tag.color) }">
                {{ tag.name }}
              </span>
            </td>
            <td class="text-end">
              <div class="btn-list justify-content-end">
                <button @click="openEdit(tag)" type="button" class="btn btn-sm btn-ghost-warning">
                  {{ __('edit') }}
                </button>
                <button @click="confirmDelete(tag)" type="button" class="btn btn-sm btn-ghost-danger">
                  {{ __('delete') }}
                </button>
              </div>
            </td>
          </tr>
          <tr v-if="!tags.data || tags.data.length === 0">
            <td colspan="4" class="text-center text-secondary py-4">
              {{ __('no_tags_found') }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card-footer d-flex align-items-center">
      <p class="m-0 text-secondary">
        {{ __('showing') }}
        <span>{{ tags.data.length > 0 ? (tags.current_page - 1) * tags.per_page + 1 : 0 }}</span>
        {{ __('to') }}
        <span>{{ tags.data.length > 0 ? (tags.current_page - 1) * tags.per_page + tags.data.length : 0 }}</span>
        {{ __('of') }}
        <span>{{ tags.total || 0 }}</span>
        {{ __('entries') }}
      </p>
      <ul class="pagination m-0 ms-auto">
        <li class="page-item" :class="{ disabled: !tags.prev_page_url }">
          <a class="page-link" href="#" @click.prevent="prevPage" :tabindex="!tags.prev_page_url ? '-1' : null" :aria-disabled="!tags.prev_page_url">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
            {{ __('prev') }}
          </a>
        </li>
        <li class="page-item" :class="{ active: tags.current_page === n }" v-for="n in getPageNumbers()" :key="n">
          <a class="page-link" href="#" @click.prevent="fetchTags(n)">{{ n }}</a>
        </li>
        <li class="page-item" :class="{ disabled: !tags.next_page_url }">
          <a class="page-link" href="#" @click.prevent="nextPage" :tabindex="!tags.next_page_url ? '-1' : null" :aria-disabled="!tags.next_page_url">
            {{ __('next') }}
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
          </a>
        </li>
      </ul>
    </div>

    <TagModal
      :show="showModal"
      :mode="modalMode"
      :tag="selectedTag"
      @close="handleModalClose"
      @save="handleModalSave"
    />
  </div>
</template>

<script>
// Use window.axios which has CSRF token configured (bootstrap.js sets this up)
const axios = window.axios;
import TagModal from './TagModal.vue';

export default {
  name: 'TagList',
  components: {
    TagModal,
  },
  data() {
    return {
      tags: {
        data: [],
        current_page: 1,
        per_page: 10,
        total: 0,
        prev_page_url: null,
        next_page_url: null,
      },
      search: '',
      perPage: 50,
      perPageOptions: [10, 20, 50, 100],
      showModal: false,
      modalMode: 'add', // 'add' or 'edit'
      selectedTag: null,
      t: window.tagTranslations || {},
    };
  },
  mounted() {
    this.fetchTags();

    // Listen for add button click
    const addBtn = document.getElementById('btn-add-tag');
    const addBtnMobile = document.getElementById('btn-add-tag-mobile');
    if (addBtn) {
      addBtn.addEventListener('click', () => this.openAdd());
    }
    if (addBtnMobile) {
      addBtnMobile.addEventListener('click', () => this.openAdd());
    }
  },
  methods: {
    __(key, defaultValue = '') {
      const keys = key.split('.');
      let value = this.t;
      for (const k of keys) {
        value = value?.[k];
        if (value === undefined) break;
      }
      return value !== undefined ? value : (defaultValue || key);
    },
    getContrastColor(hexColor) {
      // Convert hex to RGB
      const r = parseInt(hexColor.slice(1, 3), 16);
      const g = parseInt(hexColor.slice(3, 5), 16);
      const b = parseInt(hexColor.slice(5, 7), 16);

      // Calculate luminance
      const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;

      // Return black or white based on luminance
      return luminance > 0.5 ? '#000000' : '#ffffff';
    },
    async fetchTags(page = 1) {
      try {
        const params = {
          page,
          per_page: this.perPage,
        };
        if (this.search) {
          params.search = this.search;
        }

        const response = await axios.get('/tags', { params });
        this.tags = response.data;
      } catch (err) {
        console.error('Error fetching tags:', err);
        alert(this.__('fetch_error'));
      }
    },
    getPageNumbers() {
      const current = this.tags.current_page;
      const last = this.tags.last_page || 1;
      const pages = [];

      if (last <= 7) {
        for (let i = 1; i <= last; i++) {
          pages.push(i);
        }
      } else {
        if (current <= 3) {
          for (let i = 1; i <= 5; i++) {
            pages.push(i);
          }
          pages.push('...');
          pages.push(last);
        } else if (current >= last - 2) {
          pages.push(1);
          pages.push('...');
          for (let i = last - 4; i <= last; i++) {
            pages.push(i);
          }
        } else {
          pages.push(1);
          pages.push('...');
          for (let i = current - 1; i <= current + 1; i++) {
            pages.push(i);
          }
          pages.push('...');
          pages.push(last);
        }
      }

      return pages;
    },
    prevPage() {
      if (this.tags.prev_page_url) {
        this.fetchTags(this.tags.current_page - 1);
      }
    },
    nextPage() {
      if (this.tags.next_page_url) {
        this.fetchTags(this.tags.current_page + 1);
      }
    },
    openAdd() {
      this.modalMode = 'add';
      this.selectedTag = null;
      this.showModal = true;
    },
    openEdit(tag) {
      this.modalMode = 'edit';
      this.selectedTag = { ...tag };
      this.showModal = true;
    },
    handleModalClose() {
      this.showModal = false;
      this.selectedTag = null;
    },
    async handleModalSave(tagData) {
      try {
        if (this.modalMode === 'add') {
          await axios.post('/tags', tagData);
        } else {
          await axios.put(`/tags/${this.selectedTag.id}`, tagData);
        }
        this.closeModal();
        this.fetchTags(this.tags.current_page);
      } catch (err) {
        const errorMsg = err.response?.data?.message || err.response?.data?.error || err.message;
        alert(errorMsg || this.__('save_error'));
      }
    },
    closeModal() {
      // Close modal by clicking the close button
      this.$nextTick(() => {
        const modalEl = document.getElementById('tagModal');
        if (modalEl) {
          const closeButton = modalEl.querySelector('button[data-bs-dismiss="modal"]');
          if (closeButton) {
            closeButton.click();
          } else {
            // Fallback: set showModal to false
            this.showModal = false;
            this.selectedTag = null;
          }
        } else {
          this.showModal = false;
          this.selectedTag = null;
        }
      });
    },
    async confirmDelete(tag) {
      if (!confirm(this.__('delete_confirm', `Bạn có chắc chắn muốn xóa tag "${tag.name}"?`))) {
        return;
      }

      try {
        await axios.delete(`/tags/${tag.id}`);
        this.fetchTags(this.tags.current_page);
      } catch (err) {
        const errorMsg = err.response?.data?.message || err.response?.data?.error || err.message;
        alert(errorMsg || this.__('delete_error'));
      }
    },
  },
};
</script>
