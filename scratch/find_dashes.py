import os
import re

latex_dir = '/home/bian/Documents/BDT/Laporan-Latex'

for root, dirs, files in os.walk(latex_dir):
    for file in files:
        if file.endswith('.tex'):
            path = os.path.join(root, file)
            with open(path, 'r', encoding='utf-8') as f:
                content = f.read()
            lines = content.split('\n')
            for i, line in enumerate(lines, 1):
                if '---' in line:
                    print(f"{file}:{i}: {line}")
