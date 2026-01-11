#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Build script để merge HTML partials vào index.html
"""
import os
import re
from pathlib import Path

def process_includes(html, partials_dir, included_files=None, max_depth=10, current_depth=0):
    """
    Xử lý includes đệ quy (recursive) để hỗ trợ nested includes
    """
    if included_files is None:
        included_files = []

    if current_depth >= max_depth:
        print(f'⚠ Maximum include depth ({max_depth}) reached. Stopping to prevent infinite loop.')
        return html

    include_pattern = re.compile(r'<!--\s*include:\s*([^\s]+)\s*-->')

    def replace_include(match):
        partial_path = match.group(1)
        # Remove 'partials/' prefix if present
        if partial_path.startswith('partials/'):
            partial_path = partial_path.replace('partials/', '')
        full_path = partials_dir / partial_path

        if full_path.exists():
            partial_content = full_path.read_text(encoding='utf-8')
            included_files.append(partial_path)
            print(f'✓ Included: {partial_path} (depth: {current_depth})')

            # Xử lý đệ quy: tìm và thay thế các includes bên trong partial này
            partial_content = process_includes(
                partial_content,
                partials_dir,
                included_files,
                max_depth,
                current_depth + 1
            )

            return partial_content
        else:
            print(f'⚠ Partial not found: {full_path} (looking for: {partial_path})')
            return match.group(0)

    # Tìm và thay thế tất cả includes
    html = include_pattern.sub(replace_include, html)
    return html

def build_page(template_name, output_name, partials_dir, templates_dir, output_dir):
    """Build một page từ template"""
    template_path = templates_dir / template_name
    if not template_path.exists():
        print(f'❌ Template file not found: {template_path}')
        return False

    html = template_path.read_text(encoding='utf-8')
    included_files = []

    # Xử lý includes đệ quy
    html = process_includes(html, partials_dir, included_files)

    # Ghi file output
    output_path = output_dir / output_name
    output_path.write_text(html, encoding='utf-8')

    print(f'✅ Built {output_name} successfully!')
    print(f'   Included {len(included_files)} partial(s)')
    return True

def build_html():
    """Build tất cả HTML từ template và partials"""
    base_dir = Path(__file__).parent
    partials_dir = base_dir / 'partials'
    templates_dir = base_dir / 'templates'
    output_dir = base_dir

    # Danh sách các pages cần build
    # Format: (template_file, output_file)
    pages = [
        ('index.template.html', 'index.html'),
        ('pricing.template.html', 'pricing.html'),
    ]

    print('=' * 60)
    print('Building HTML pages...')
    print('=' * 60)

    success_count = 0
    for template_name, output_name in pages:
        print(f'\n📄 Building {output_name}...')
        if build_page(template_name, output_name, partials_dir, templates_dir, output_dir):
            success_count += 1

    print('\n' + '=' * 60)
    print(f'✅ Build completed: {success_count}/{len(pages)} pages built successfully')
    print('=' * 60)
    return success_count == len(pages)

if __name__ == '__main__':
    build_html()
