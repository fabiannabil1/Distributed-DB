import os

replacements = {
    '/home/bian/Documents/BDT/Laporan-Latex/main.tex': [
        (
            'aplikasi Komposin --- sebuah platform bank sampah dan \\textit{e-commerce}',
            'aplikasi Komposin, yaitu sebuah platform bank sampah dan \\textit{e-commerce}'
        )
    ],
    '/home/bian/Documents/BDT/Laporan-Latex/chapters/bab5-kesimpulan.tex': [
        (
            'berjalan dengan baik --- masing-masing Replica mendapat porsi query',
            'berjalan dengan baik, di mana masing-masing Replica mendapat porsi query'
        )
    ],
    '/home/bian/Documents/BDT/Laporan-Latex/chapters/bab1-pendahuluan.tex': [
        (
            'pengelolaan data seperti Komposin --- sebuah platform bank sampah dan\n\\textit{e-commerce} pengelolaan sampah --- beban operasi \\textit{read}',
            'pengelolaan data seperti Komposin (sebuah platform bank sampah dan\n\\textit{e-commerce} pengelolaan sampah), beban operasi \\textit{read}'
        ),
        (
            'seluruh beban query --- baik \\textit{read}\nmaupun \\textit{write} --- diproses oleh \\textit{server} yang sama.',
            'seluruh beban query, baik \\textit{read}\nmaupun \\textit{write}, diproses oleh \\textit{server} yang sama.'
        ),
        (
            '\\textbf{Pgpool-II} --- sebuah \\textit{connection pooler} dan',
            '\\textbf{Pgpool-II}, sebuah \\textit{connection pooler} dan'
        ),
        (
            'PostgreSQL Master maupun Replica --- seluruh koneksi database',
            'PostgreSQL Master maupun Replica. Seluruh koneksi database'
        )
    ],
    '/home/bian/Documents/BDT/Laporan-Latex/chapters/bab3-implementasi.tex': [
        (
            '\\subsubsection{postgresql.conf --- Master}',
            '\\subsubsection{postgresql.conf (Master)}'
        ),
        (
            '\\subsubsection{pg\\_hba.conf --- Master}',
            '\\subsubsection{pg\\_hba.conf (Master)}'
        ),
        (
            '\\subsubsection{postgresql.conf --- Replica}',
            '\\subsubsection{postgresql.conf (Replica)}'
        )
    ],
    '/home/bian/Documents/BDT/Laporan-Latex/chapters/bab4-pengujian.tex': [
        (
            'caption={Query INSERT --- Menambah Produk Baru}',
            'caption={Query INSERT: Menambah Produk Baru}'
        ),
        (
            'caption={Query UPDATE --- Mengubah Data Produk}',
            'caption={Query UPDATE: Mengubah Data Produk}'
        ),
        (
            'caption={Log PostgreSQL Master --- Query UPDATE}',
            'caption={Log PostgreSQL Master: Query UPDATE}'
        ),
        (
            'caption={Query DELETE --- Menghapus Data Produk}',
            'caption={Query DELETE: Menghapus Data Produk}'
        ),
        (
            'caption={Log PostgreSQL Master --- Query DELETE}',
            'caption={Log PostgreSQL Master: Query DELETE}'
        ),
        (
            'caption={Query SELECT --- Membaca Data Katalog, Artikel}',
            'caption={Query SELECT: Membaca Data Katalog dan Artikel}'
        )
    ],
    '/home/bian/Documents/BDT/Laporan-Latex/chapters/bab2-arsitektur.tex': [
        (
            'peran spesifik --- mulai dari \\textit{client}',
            'peran spesifik, mulai dari \\textit{client}'
        )
    ]
}

for file_path, changes in replacements.items():
    if not os.path.exists(file_path):
        print(f"Skipping non-existent file: {file_path}")
        continue
    
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content
    for target, replacement in changes:
        if target in content:
            content = content.replace(target, replacement)
            print(f"Replaced target in {os.path.basename(file_path)}")
        else:
            # Let's try matching with flexible whitespace
            normalized_target = ' '.join(target.split())
            # Search if we can find it
            found = False
            for key in replacements[file_path]:
                # Try simple replacement if exact match failed due to line endings
                pass
            print(f"Warning: Exact target not found in {os.path.basename(file_path)}")
            # Try to match manually by replacing target spaces with flexible spaces
            # Let's just do a simple fallback replace for ' --- ' or single-line versions
            # if we didn't find the multi-line targets
            single_line_target = target.replace('\n', ' ')
            single_line_replacement = replacement.replace('\n', ' ')
            if single_line_target in content:
                content = content.replace(single_line_target, single_line_replacement)
                print(f"Replaced single-line fallback in {os.path.basename(file_path)}")
    
    if content != original_content:
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Successfully updated {file_path}")
    else:
        print(f"No changes made to {file_path}")
