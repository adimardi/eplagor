<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

use App\pagu;
use App\anggaran;
use App\AnggaranDakung;
use App\reffbagian;
use App\reffsatker;
use App\reff_bas;
use App\Users;

use Carbon\Carbon;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

use Cache;
use Session;
use Auth;
use DB;

use App\Traits\filter;


class AkunController extends Controller
{
    use filter;

    protected $session;
    private $title = 'Rekap Akun';

    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->config = [
            'title'     => $this->title,
            'pageTitle' => $this->title,
        ];
    }

    public function index()
    {
        $config = $this->config;
        return view('pagu.akun.index', compact('config'));
    }

    public function rincian($akun)
    {
        $this->config = [
            'title'     => 'Rincian Akun',
            'pageTitle' => 'Rincian Akun',
        ];

        $data ['config'] = $this->config;
        $data['akun'] = Crypt::decrypt($akun);

        return view('pagu.akun.rincian', $data);
    }

    public function show($id)
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }

    public function uploads(Request $request)
    {

    }

}
