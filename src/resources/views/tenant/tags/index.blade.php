@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        {{ __('tag.tags') }}
                    </h2>
                    <div class="text-secondary mt-1">
                        {{ __('tag.manage_tags') }}
                    </div>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button type="button" class="btn btn-primary d-none d-sm-inline-block" id="btn-add-tag">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                            {{ __('tag.add_tag') }}
                        </button>
                        <button type="button" class="btn btn-primary d-sm-none btn-icon" id="btn-add-tag-mobile">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('tag.tag_list') }}</h3>
                        </div>
                        <div id="tags-app"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@php
    $translations = [
        'tags' => __('tag.tags'),
        'tag_list' => __('tag.tag_list'),
        'add_tag' => __('tag.add_tag'),
        'edit_tag' => __('tag.edit_tag'),
        'name' => __('tag.name'),
        'color' => __('tag.color'),
        'preview' => __('tag.preview'),
        'add' => __('tag.add'),
        'edit' => __('tag.edit'),
        'delete' => __('tag.delete'),
        'save' => __('tag.save'),
        'cancel' => __('tag.cancel'),
        'close' => __('tag.close'),
        'no' => __('tag.no'),
        'actions' => __('tag.actions'),
        'search' => __('tag.search'),
        'search_placeholder' => __('tag.search_placeholder'),
        'show' => __('tag.show'),
        'entries' => __('tag.entries'),
        'showing' => __('tag.showing'),
        'to' => __('tag.to'),
        'of' => __('tag.of'),
        'prev' => __('tag.prev'),
        'next' => __('tag.next'),
        'no_tags_found' => __('tag.no_tags_found'),
        'delete_confirm' => __('tag.delete_confirm'),
        'save_error' => __('tag.save_error'),
        'update_error' => __('tag.update_error'),
        'delete_error' => __('tag.delete_error'),
        'fetch_error' => __('tag.fetch_error'),
    ];
@endphp
<script>
    // Pass translations to Vue components
    window.tagTranslations = @json($translations);
</script>
@vite('resources/js/pages/tags.js')
@endpush
