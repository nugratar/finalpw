<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;

    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }

    public function index()
    {
        $data = [
            'title' => 'DAFTAR KOMIK | NUGRATAR',
            'komik' => $this->komikModel->getKomik()
        ];
        return view('komik/index', $data);
    }


    public function detail($slug)
    {
        $data = [
            'title' => 'DETAIL KOMIK | NUGRATAR',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slug . ' tidak ditemukan.');
        }
        return view('komik/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'TAMBAH KOMIK | NUGRATAR',
            'validation' => \Config\Services::validation()
        ];
        return view('komik/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => 'Judul komik harus diisi!',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama penulis komik harus diisi'
                ]
            ],
            'ilustrator' => [
                'rules' => 'required[komik.ilustrator]',
                'errors' => [
                    'required' => 'Ilustrator komik harus diisi'
                ]
            ],
            'genre' => [
                'rules' => 'required[komik.genre]',
                'errors' => [
                    'required' => 'Genre komik harus diisi'
                ]
            ],
            'penerbit' => [
                'rules' => 'required[komik.penerbit]',
                'errors' => [
                    'required' => 'Penerbit komik harus diisi'
                ],
            ],
            'tahun_terbit' => [
                'rules' => 'required[komik.tahun_terbit]',
                'errors' => [
                    'required' => 'Tahun terbit komik harus diisi'
                ],
            ],
            'sinopsis' => [
                'rules' => 'required[komik.sinopsis]',
                'errors' => [
                    'required' => 'Sinopsis komik harus diisi'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_sized' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Pilih gambar dengan benar',
                    'mime_in' => 'Pilih dengan benar'
                ]
            ]
        ])) {
            return redirect()->to('/komik/create')->withInput();
        }
        // dd($this->request->getVar());
        // dd('berhasil');

        // ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        // dd($fileSampul);
        // cek apakah ada gambar yang diupload
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.jpg';
        } else {
            // ganti nama sampul agar random
            $namaSampul = $fileSampul->getRandomName();

            // pindahkan ke folder public/img
            $fileSampul->move('img', $namaSampul);
        }

        // ambil nama file
        // $namaSampul = $fileSampul->getName();

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'ilustrator' => $this->request->getVar('ilustrator'),
            'genre' => $this->request->getVar('genre'),
            'penerbit' => $this->request->getVar('penerbit'),
            'tahun_terbit' => $this->request->getVar('tahun_terbit'),
            'sinopsis' => $this->request->getVar('sinopsis'),
            'sampul' => $namaSampul
        ]);
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/komik');
    }

    public function delete($id)
    {
        // cari gambar berdasarkan id
        $komik = $this->komikModel->find($id);

        // cek jika gambarnya default.jpg
        if ($komik['sampul'] != 'default.jpg') {
            // hapus gambar
            unlink('img/' . $komik['sampul']);
        }

        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'UBAH DATA KOMIK | NUGRATAR',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];
        return view('komik/edit', $data);
    }

    public function update($id)
    {
        // dd($this->request->getVar());

        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => 'Judul komik harus diisi!',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'penulis' => [
                'rules' => 'required[komik.penulis]',
                'errors' => [
                    'required' => 'Nama penulis komik harus diisi'
                ]
            ],
            'ilustrator' => [
                'rules' => 'required[komik.ilustrator]',
                'errors' => [
                    'required' => 'Ilustrator komik harus diisi'
                ]
            ],
            'genre' => [
                'rules' => 'required[komik.genre]',
                'errors' => [
                    'required' => 'Genre komik harus diisi'
                ]
            ],
            'penerbit' => [
                'rules' => 'required[komik.penerbit]',
                'errors' => [
                    'required' => 'Penerbit komik harus diisi'
                ],
            ],
            'tahun_terbit' => [
                'rules' => 'required[komik.tahun_terbit]',
                'errors' => [
                    'required' => 'Penerbit komik harus diisi'
                ],
            ],
            'sinopsis' => [
                'rules' => 'required[komik.sinopsis]',
                'errors' => [
                    'required' => 'Sinopsis komik harus diisi'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_sized' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'File yang anda pilih bukan gambar',
                    'mime_in' => 'Pilih dengan benar'
                ]
            ]
        ])) {
            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        // cek apakah gambar tetap lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            $namaSampul = $fileSampul->getRandomName();
            $fileSampul->move('img', $namaSampul);
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'ilustrator' => $this->request->getVar('penulis'),
            'ilustrator' => $this->request->getVar('ilustrator'),
            'genre' => $this->request->getVar('genre'),
            'penerbit' => $this->request->getVar('penerbit'),
            'tahun_terbit' => $this->request->getVar('tahun_terbit'),
            'sinopsis' => $this->request->getVar('sinopsis'),
            'sampul' => $namaSampul
        ]);
        session()->setFlashdata('pesan', 'Data berhasil diubah!');
        return redirect()->to('/komik');
    }
}
