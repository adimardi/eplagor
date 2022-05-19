<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\users;
use App\reffsatker;
use Auth;
use Session;
use RealRashid\SweetAlert\Facades\Alert;

class Create extends Component
{
    public $refferensi_bagian, $satker, $nama, $username, $email, $password, $gambar, $nip, $telephone, $kantor, $level, $jabatan, $pass, $confirm_pass;
    public $createMode = false;


    public function render()
    {
        return view('livewire.user.create');
    }

    private function resetInputFields()
    {
        $this->refferensi_bagian = null;
        $this->satker = null;
        $this->nama = null;
        $this->username = null;
        $this->email = null;
        $this->password = null;
        $this->gambar = null;
        $this->nip = null;
        $this->telp = null;
        $this->kantor = null;
        $this->level = null;
        $this->jabatan = null;
        $this->pass = null;
        $this->confirm_pass = null;
    }

    public function store()
    {
        $this->validate([
            'satker' => 'required',
            'nama' => 'required',
            'username' => 'required|max:20|alpha_num|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'kantor' => 'required',
            'level' => 'required',
            'pass' => 'required|min:6|alpha_num|same:confirm_pass',
            'confirm_pass' => 'required|min:6|alpha_num|same:pass',
        ]);

        $users = users::create([
            'reffbagian_id' => $this->refferensi_bagian,
            'reffsatker_id' => $this->satker,
            'name' => $this->nama,
            'username' => $this->username,
            'email' => $this->email,
            'nip' => $this->nip,
            'telephone' => $this->telephone,
            'kantor' => $this->kantor,
            'level' => $this->level,
            'jabatan' => $this->jabatan,
            'password' => bcrypt($this->pass),
        ]);

        Alert::success('Success Title', 'Success Message');
        $this->resetInputFields();
        $this->createMode = false;
        $this->emit('usersStored');

    }

    public function tambahData()
    {
        $this->createMode = true;
    }

    public function cancelData()
    {
        $this->resetInputFields();
        $this->createMode = false;
    }


}
