<template>
  <div>
    <button ref="triggerButton" type="button" class="d-none" data-bs-toggle="modal" data-bs-target="#tagModal"></button>

    <div class="modal fade" id="tagModal" tabindex="-1" aria-labelledby="tagModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tagModalLabel">
              {{ modalMode === 'add' ? __('add_tag') : __('edit_tag') }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body position-relative">
            <!-- Loading Overlay -->
            <LoadingSpinner :visible="isLoading" />

            <form @submit.prevent="handleSave">
              <div class="mb-3">
                <label class="form-label">{{ __('name') }}</label>
                <input v-model="localForm.name" type="text" class="form-control" :disabled="modalMode === 'view'"
                  required />
              </div>

              <div class="mb-3">
                <label class="form-label">{{ __('color') }}</label>
                <div class="input-group">
                  <input v-model="localForm.color" type="color" class="form-control form-control-color"
                    :disabled="modalMode === 'view'" required />
                  <input v-model="localForm.color" type="text" class="form-control" pattern="^#[0-9A-Fa-f]{6}$"
                    :disabled="modalMode === 'view'" placeholder="#3b82f6" />
                </div>
                <div class="mt-2">
                  <span class="badge"
                    :style="{ backgroundColor: localForm.color, color: getContrastColor(localForm.color) }">
                    {{ __('preview') }}
                  </span>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              {{ __('close') }}
            </button>
            <button v-if="modalMode !== 'view'" type="button" class="btn btn-primary" @click="handleSave">
              {{ __('save') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LoadingSpinner from '../common/LoadingSpinner.vue';

export default {
  name: 'TagModal',
  components: {
    LoadingSpinner
  },
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    mode: {
      type: String,
      default: 'add', // 'add', 'edit', 'view'
    },
    tag: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      localForm: {
        name: '',
        color: '#3b82f6',
      },
      isLoading: false,
      t: window.tagTranslations || {},
    };
  },
  watch: {
    show(newVal) {
      if (newVal) {
        this.$nextTick(() => {
          if (this.$refs.triggerButton) {
            this.$refs.triggerButton.click();
          }
        });
      } else {
        // Close modal when show becomes false
        this.$nextTick(() => {
          const modalEl = document.getElementById('tagModal');
          if (modalEl) {
            const closeButton = modalEl.querySelector('button[data-bs-dismiss="modal"]');
            if (closeButton) {
              closeButton.click();
            }
          }
        });
      }
    },
    tag(newTag) {
      if (this.mode === 'edit' && newTag && newTag.id) {
        // Fetch fresh data
        this.isLoading = true;
        axios.get(`/tags/${newTag.id}`)
          .then(res => {
            this.populateForm(res.data);
          })
          .catch(err => {
            console.error('Error fetching tag:', err);
            this.$emit('close');
            alert(this.__('error_fetching_data') || 'Error loading tag data');
          })
          .finally(() => {
            this.isLoading = false;
          });
      } else if (newTag) {
        this.populateForm(newTag);
      }
    },
    mode(newMode) {
      if (newMode === 'add') {
        this.resetForm();
      }
    },
  },
  mounted() {
    const modalEl = document.getElementById('tagModal');
    if (modalEl) {
      modalEl.addEventListener('hidden.bs.modal', () => {
        this.$emit('close');
      });
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
    populateForm(data) {
      this.localForm = {
        name: data.name || '',
        color: data.color || '#3b82f6',
      };
    },
    getContrastColor(hexColor) {
      const r = parseInt(hexColor.slice(1, 3), 16);
      const g = parseInt(hexColor.slice(3, 5), 16);
      const b = parseInt(hexColor.slice(5, 7), 16);
      const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
      return luminance > 0.5 ? '#000000' : '#ffffff';
    },
    resetForm() {
      this.localForm = {
        name: '',
        color: '#3b82f6',
      };
    },
    handleSave() {
      if (!this.localForm.name || !this.localForm.color) {
        return;
      }

      // Ensure color is in hex format
      if (!this.localForm.color.startsWith('#')) {
        this.localForm.color = '#' + this.localForm.color;
      }

      this.$emit('save', { ...this.localForm });
    },
  },
};
</script>