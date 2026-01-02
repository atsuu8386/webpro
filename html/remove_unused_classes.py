#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Script để loại bỏ các class không được sử dụng trong CSS/JS
"""
import re
import os

# Đọc danh sách class cần loại bỏ
unused_classes = set()
if os.path.exists('unused_classes_final.txt'):
    with open('unused_classes_final.txt', 'r', encoding='utf-8') as f:
        unused_classes = set(line.strip() for line in f if line.strip())

print(f"Sẽ loại bỏ {len(unused_classes)} class không được sử dụng")

# Xử lý từng file HTML trong partials
html_files = []
for root, dirs, files in os.walk('partials'):
    for file in files:
        if file.endswith('.html'):
            html_files.append(os.path.join(root, file))
html_files.append('templates/index.template.html')

total_removed = 0
files_modified = []

for html_file in html_files:
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()

    original_content = content

    # Tìm và loại bỏ các class
    def remove_unused_classes(match):
        class_attr = match.group(1)
        classes = class_attr.split()

        # Loại bỏ các class không sử dụng
        new_classes = [cls for cls in classes if cls not in unused_classes]

        if len(new_classes) != len(classes):
            removed = len(classes) - len(new_classes)
            if new_classes:
                return f'class="{" ".join(new_classes)}"'
            else:
                # Nếu không còn class nào, loại bỏ cả attribute
                return ''
        return match.group(0)

    # Pattern để tìm class attribute
    pattern = r'class=["\']([^"\']+)["\']'
    content = re.sub(pattern, remove_unused_classes, content)

    if content != original_content:
        # Đếm số class đã loại bỏ
        removed_count = 0
        for match in re.finditer(r'class=["\']([^"\']+)["\']', original_content):
            classes = match.group(1).split()
            removed_in_this = sum(1 for cls in classes if cls in unused_classes)
            removed_count += removed_in_this

        with open(html_file, 'w', encoding='utf-8') as f:
            f.write(content)

        files_modified.append((html_file, removed_count))
        total_removed += removed_count

print(f"\n✅ Đã xử lý {len(html_files)} file")
if files_modified:
    print(f"✅ Đã sửa {len(files_modified)} file:")
    for file, count in files_modified:
        print(f"  - {file}: Loại bỏ {count} class")
    print(f"\n✅ Tổng cộng đã loại bỏ {total_removed} class")
else:
    print("ℹ Không có file nào cần sửa")
