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
