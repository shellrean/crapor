<?php

$config['config/sekolah'] = [
  [
    'field'   => 'nama',
    'label'   => 'Nama sekolah',
    'rules'   => 'required|trim'
  ],
  [
    'field'   => 'nss',
    'label'   => 'NSS',
    'rules'   => 'required'
  ],
  [
    'field'   => 'npsn',
    'label'   => 'NPSN',
    'rules'   => 'required'
  ],
  [
    'field'   => 'telp',
    'label'   => 'No telp',
    'rules'   => 'required'
  ],
  [
    'field'   => 'faks',
    'label'   => 'No faks',
    'rules'   => 'required'
  ],
  [
    'field'   => 'kecamatan',
    'label'   => 'Kecamatan',
    'rules'   => 'required'
  ],
  [
    'field'   => 'kota',
    'label'   => 'Kabupaten/kota',
    'rules'   => 'required'
  ],
  [
    'field'   => 'provinsi',
    'label'   => 'Provinsi',
    'rules'   => 'required'
  ],
  [
    'field'   => 'website',
    'label'   => 'Website',
    'rules'   => 'required'
  ],
  [
    'field'   => 'email',
    'label'   => 'Email',
    'rules'   => 'required'
  ]
];

$config['mapel'] = [
  [
    'field'   => 'id_mapel',
    'label'   => 'Kode mapel',
    'rules'   => 'required'
  ],
  [
    'field'   => 'nama_mapel',
    'label'   => 'Nama mapel',
    'rules'   => 'required'
  ]
];

$config['auth'] = [
  [
    'field'   => 'username',
    'label'   => 'Username',
    'rules'   => 'required|trim',
  ],
  [
    'field'   => 'password',
    'label'   => 'Password',
    'rules'   => 'required|trim'
  ]
];

$config['kelas/create'] = [
  [
    'field'   => 'name',
    'label'   => 'Name',
    'rules'   => 'required|trim'
  ],
  [
    'field'   => 'wali_kelas',
    'label'   => 'Wali kelas',
    'rules'   => 'required|is_unique[kelas.guru_id]|trim',
    'message' => 'Teacher is already taken'
  ],
  [
    'field'   => 'jurusan',
    'label'   => 'Jurusan',
    'rules'   => 'required|trim'
  ],
  [
    'field'   => 'tingkat',
    'label'   => 'Tingkat',
    'rules'   => 'required|in_list[10,11,12]|trim',
  ]
];

$config['kelas/edit'] = [
  [
    'field'   => 'name',
    'label'   => 'Name',
    'rules'   => 'required|trim'
  ],
  [
    'field'   => 'wali_kelas',
    'label'   => 'Wali kelas',
    'rules'   => 'required|trim'
  ],
  [
    'field'   => 'jurusan',
    'label'   => 'Jurusan',
    'rules'   => 'required|trim'
  ],
  [
    'field'   => 'tingkat',
    'label'   => 'Tingkat',
    'rules'   => 'required|in_list[10,11,12]|trim',
  ]
];