<div class="form-group row{{ $errors->has('level') ? ' has-error' : '' }}">
    <label for="filter_peradilan" class="col-md-2 control-label">Filter Berdasarkan Peradilan</label>
    <div class="col-md-6 col-sm-6">
      <select class="selectpicker" data-size="5" data-width="100%" data-live-search="true" name="filter_peradilan" id="filter_peradilan">
        <option  data-tokens="ketchup mustard" readonly="readonly"  value="">Pilih Peradilan</option>
        @foreach (App\reffsatker::get()->unique('dirjen')->sortBy('dirjen') as $reffsatker)
            <option readonly="readonly" value="{{$reffsatker->dirjen}}">{{$reffsatker->dirjen}}</option>
        @endforeach
      </select>
    </div>
</div>
<div class="form-group row{{ $errors->has('level') ? ' has-error' : '' }}">
    <label for="filter_eselon" class="col-md-2 control-label">Filter Berdasarkan DIPA</label>
    <div class="col-md-6 col-sm-6">
      <select class="selectpicker" data-size="5" data-width="100%" data-live-search="true" name="filter_eselon" id="filter_eselon">
        <option readonly="readonly" value="">Pilih DIPA</option>
        @foreach (App\reffsatker::get()->unique('kode_eselon')->sortBy('kode_eselon') as $reffsatker)
            <option readonly="readonly" value="{{$reffsatker->kode_eselon}}">{{$reffsatker->kode_eselon}} {{$reffsatker->nama_eselon}}</option>
        @endforeach
      </select>
    </div>
</div>
<div class="form-group row{{ $errors->has('level') ? ' has-error' : '' }}">
    <label for="filter_wilayah" class="col-md-2 control-label">Filter Berdasarkan Wilayah</label>
    <div class="col-md-6 col-sm-6">
      <select class="selectpicker" data-size="5" data-width="100%" data-live-search="true" name="filter_wilayah" id="filter_wilayah">
        <option  readonly="readonly" value="">Pilih Wilayah</option>
        @foreach (App\reffsatker::get()->unique('kode_wilayah')->sortBy('kode_wilayah') as $reffsatker)
            <option readonly="readonly" value="{{$reffsatker->kode_wilayah}}">{{$reffsatker->kode_wilayah}} {{$reffsatker->provinsi}}</option>
        @endforeach
      </select>
    </div>
</div>
