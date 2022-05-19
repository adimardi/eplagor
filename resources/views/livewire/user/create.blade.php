<div class="row">

    @if ($createMode)
        
    <div class="col-md-12 col-sm-12 ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Tambah Data Baru <small>Data User</small></h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />
          <form wire:submit.prevent="store" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

            @if (Auth::user()->level == 'root')
            <div class="item form-group" >
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="refferensi_bagian">Bagian <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6" wire:ignore>
                    <select wire:model="refferensi_bagian" class="form-control @error ('refferensi_bagian') is-invalid  @enderror">
                        <option value="">Pilih Bagian</option>
                        @foreach(App\reffbagian::get() as $reffbagian)
                        <option value="{{$reffbagian->id}}">{{$reffbagian->eselon_3}}</option>
                        @endforeach
                    </select>
                  @error('refferensi_bagian')
                  <span class="invalid-feedback">
                      <strong>{{$message}}</strong>
                  </span>
                  @enderror
                </div>
            </div>
            @endif

            @php

            if (Auth::user()->kantor == 'satker') {
                $reffsatkers = App\reffsatker::where('id',Auth::user()->reffsatker_id)->orderBy('kode_satker_lengkap')->get();
            }
            if (Auth::user()->kantor == 'korwil') {
                $reffsatkers = App\reffsatker::where('korwil',Auth::user()->reffsatker->korwil)->orderBy('kode_satker_lengkap')->get();
            }
            if (Auth::user()->kantor == 'banding') {
                $reffsatkers = App\reffsatker::where('tingkat_banding',Auth::user()->reffsatker->tingkat_banding)->orderBy('kode_satker_lengkap')->get();
            }
            if (Auth::user()->kantor == 'eselon_1') {
                $reffsatkers = App\reffsatker::where('kode_eselon',Auth::user()->reffsatker->kode_eselon)->orderBy('kode_satker_lengkap')->get();
            }
            if (Auth::user()->kantor == 'dirjen') {
                $reffsatkers = App\reffsatker::where('dirjen',Auth::user()->reffsatker->dirjen)->orderBy('kode_satker_lengkap')->get();
            }
            if (Auth::user()->kantor == 'pusat') {
                $reffsatkers = App\reffsatker::orderBy('kode_satker_lengkap')->get();
            }
                
            @endphp

            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="satker">Satker <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 " wire:ignore>
                    <select wire:model="satker" data-live-search="true" required="required" class="form-control @error ('satker') is-invalid  @enderror">
                        <option value="">Pilih Satker</option>
                        @foreach($reffsatkers as $satker)
                        <option value="{{$satker->id}}">{{$satker->id}} - {{$satker->nama_satker_lengkap}}</option>
                        @endforeach
                    </select>
                  @error('satker')
                  <span class="invalid-feedback">
                      <strong>{{$message}}</strong>
                  </span>
                  @enderror
                </div>
            </div>

            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama">Nama <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 ">
                <input wire:model="nama" type="text" id="nama" required="required" class="form-control @error ('nama') is-invalid  @enderror">
                @error('nama')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="username">Username <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input wire:model="username" type="text" id="username" required="required" class="form-control @error ('username') is-invalid  @enderror">
                    @error('username')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">E-Mail <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input wire:model="email" type="text" id="email" required="required" class="form-control @error ('email') is-invalid  @enderror">
                    @error('email')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="kantor">Kewenangan <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 ">
                    <select wire:model="kantor" data-live-search="true" class="form-control @error ('kantor') is-invalid  @enderror">
                        <option value="">Pilih Kewenangan</option>
                        @if (Auth::user()->level == 'root')
                        <option value="pusat">Pusat</option>
                        <option value="dirjen">Dirjen</option>
                        <option value="eselon_1">Eselon 1</option>
                        <option value="banding">Banding</option>
                        <option value="korwil">Korwil</option>
                        <option value="satker">Satker</option>
                        @else
                        <option value="satker">Satker</option>
                        @endif
                    </select>
                  @error('kantor')
                  <span class="invalid-feedback">
                      <strong>{{$message}}</strong>
                  </span>
                  @enderror
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="level">Level <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 ">
                    <select wire:model="level" data-live-search="true" class="form-control @error ('level') is-invalid  @enderror">
                        <option value="">Pilih Level</option>
                        @if (Auth::user()->level == 'root')
                        <option value="admin">admin</option>
                        <option value="user">user</option>
                        @else
                        <option value="user">user</option>
                        @endif
                    </select>
                  @error('level')
                  <span class="invalid-feedback">
                      <strong>{{$message}}</strong>
                  </span>
                  @enderror
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="nip">NIP <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input wire:model="nip" type="text" id="nip" class="form-control @error ('nip') is-invalid  @enderror">
                    @error('nip')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="jabatan">Jabatan <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 ">
                    <select wire:model="jabatan" data-live-search="true" class="form-control @error ('jabatan') is-invalid  @enderror">
                        <option value="">Pilih Jabatan</option>
                        <option value="Ketua">Ketua</option>
                        <option value="Panitera">Panitera</option>
                        <option value="Sekretaris">Sekretaris</option>
                        <option value="Operator">Operator</option>
                        <option value="Kasir">Kasir</option>
                        <option value="KPA">KPA</option>
                    </select>
                  @error('jabatan')
                  <span class="invalid-feedback">
                      <strong>{{$message}}</strong>
                  </span>
                  @enderror
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="telephone">Telephone <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input wire:model="telephone" type="text" id="telephone" class="form-control @error ('telephone') is-invalid  @enderror">
                    @error('telephone')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="password">Password <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input wire:model="pass" type="password" id="password" class="form-control @error ('pass') is-invalid  @enderror">
                    @error('pass')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="confirm_password">Confirm Password <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input wire:model="confirm_pass" type="password" id="confirm_password" class="form-control @error ('confirm_pass') is-invalid  @enderror">
                    @error('confirm_pass')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="ln_solid"></div>
            <div class="item form-group">
              <div class="col-md-6 col-sm-6 offset-md-3">
                <button wire:click="cancelData" type="reset" class="btn btn-danger">Cancel</button>
                <button class="btn btn-primary" type="reset">Reset</button>
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>

    @else
        

    <div class="col-md-12 col-sm-3 ">
        <div class="x_panel">
          <div class="x_content">
            <br />
              <div class="item form-group">
                    <button wire:click="tambahData" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah User</button>
              </div>
          </div>
        </div>
    </div>
  
    @endif



</div>