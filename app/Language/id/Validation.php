<?php

/**
 * This file contains the Indonesian language validation strings.
 */
return [
    // Core Messages
    'noRuleSets'      => 'Tidak ada aturan yang ditentukan dalam konfigurasi Validasi.',
    'ruleNotFound'    => '{0} bukan aturan yang valid.',
    'groupNotFound'   => '{0} bukan grup aturan validasi.',
    'groupNotArray'   => 'Grup aturan {0} harus berupa array.',
    'invalidTemplate' => '{0} bukan template Validasi yang valid.',

    // Rule Messages
    'alpha'                 => 'Kolom {field} hanya boleh mengandung karakter alfabet.',
    'alpha_dash'            => 'Kolom {field} hanya boleh mengandung karakter alfanumerik, garis bawah, dan tanda hubung.',
    'alpha_numeric'         => 'Kolom {field} hanya boleh mengandung karakter alfanumerik.',
    'alpha_numeric_punct'   => 'Kolom {field} hanya boleh mengandung karakter alfanumerik, spasi, dan ~ ! # $ % & * - _ + = | : .',
    'alpha_numeric_space'   => 'Kolom {field} hanya boleh mengandung karakter alfanumerik dan spasi.',
    'alpha_space'           => 'Kolom {field} hanya boleh mengandung karakter alfabet dan spasi.',
    'decimal'               => 'Kolom {field} harus mengandung angka desimal.',
    'differs'               => 'Kolom {field} harus berbeda dari kolom {param}.',
    'equals'                => 'Kolom {field} harus sama persis dengan: {param}.',
    'exact_length'          => 'Kolom {field} harus tepat {param} karakter.',
    'greater_than'          => 'Kolom {field} harus berisi angka lebih besar dari {param}.',
    'greater_than_equal_to' => 'Kolom {field} harus berisi angka lebih besar atau sama dengan {param}.',
    'hex'                   => 'Kolom {field} hanya boleh mengandung karakter heksadesimal.',
    'in_list'               => 'Kolom {field} harus salah satu dari: {param}.',
    'integer'               => 'Kolom {field} harus berisi bilangan bulat.',
    'is_natural'            => 'Kolom {field} hanya boleh berisi digit.',
    'is_natural_no_zero'    => 'Kolom {field} hanya boleh berisi digit dan harus lebih besar dari nol.',
    'is_not_unique'         => 'Kolom {field} harus berisi nilai yang sudah ada sebelumnya di database.',
    'is_unique'             => 'Kolom {field} harus berisi nilai yang unik.',
    'less_than'             => 'Kolom {field} harus berisi angka kurang dari {param}.',
    'less_than_equal_to'    => 'Kolom {field} harus berisi angka kurang dari atau sama dengan {param}.',
    'matches'               => 'Kolom {field} tidak cocok dengan kolom {param}.',
    'max_length'            => 'Kolom {field} tidak boleh melebihi {param} karakter.',
    'min_length'            => 'Kolom {field} harus minimal {param} karakter.',
    'not_equals'            => 'Kolom {field} tidak boleh: {param}.',
    'not_in_list'           => 'Kolom {field} tidak boleh salah satu dari: {param}.',
    'numeric'               => 'Kolom {field} hanya boleh berisi angka.',
    'regex_match'           => 'Kolom {field} tidak dalam format yang benar.',
    'required'              => 'Kolom {field} harus diisi.',
    'required_with'         => 'Kolom {field} harus diisi ketika {param} diisi.',
    'required_without'      => 'Kolom {field} harus diisi ketika {param} tidak diisi.',
    'string'                => 'Kolom {field} harus berupa string yang valid.',
    'timezone'              => 'Kolom {field} harus berupa zona waktu yang valid.',
    'valid_base64'          => 'Kolom {field} harus berupa string base64 yang valid.',
    'valid_email'           => 'Kolom {field} harus berisi alamat email yang valid.',
    'valid_emails'          => 'Kolom {field} harus berisi semua alamat email yang valid.',
    'valid_ip'              => 'Kolom {field} harus berisi IP yang valid.',
    'valid_url'             => 'Kolom {field} harus berisi URL yang valid.',
    'valid_url_strict'      => 'Kolom {field} harus berisi URL yang valid.',
    'valid_date'            => 'Kolom {field} harus berisi tanggal yang valid.',
    'valid_json'            => 'Kolom {field} harus berisi JSON yang valid.',

    // Credit Cards
    'valid_cc_num' => 'Kolom {field} tidak tampak sebagai nomor kartu kredit yang valid.',

    // Files
    'uploaded' => 'Kolom {field} bukan file yang valid yang diunggah.',
    'max_size' => 'Kolom {field} terlalu besar untuk file.',
    'is_image' => 'Kolom {field} bukan file gambar yang valid yang diunggah.',
    'mime_in'  => 'Kolom {field} tidak memiliki tipe mime yang valid.',
    'ext_in'   => 'Kolom {field} tidak memiliki ekstensi file yang valid.',
    'max_dims' => 'Kolom {field} bukan gambar, atau terlalu lebar atau tinggi.',
];
