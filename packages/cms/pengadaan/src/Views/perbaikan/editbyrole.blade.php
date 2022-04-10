@extends('cms.layouts.default')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Create Laporan
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li>Pengadaan</li>
			<li><a href="{{ route('cms.perbaikan.view') }}">Admin</a></li>			
			<li class="active">Edit</li>
		</ol>
	</section>
		
	<section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"></h3>
          </div>
          <!-- /.box-header -->
					
			<!-- form start -->
			{!! Form::open(['route' => ['cms.perbaikan.update', 'id'=>$perbaikan->id], 'role'=>'form', 'autocomplete'=>'off']) !!}	
				<div class="box-body">
					<div class="form-group {{ ($errors->first('pemohon')) ? 'has-error' : '' }}">
						<label for="fpemohon">Pemohon</label>
						<select name="pemohon" class="form-control" id="fpemohon" readonly="true">
							<option value="">-- Pilih Pemohon --</option>
							@foreach($user as $pemohon)
								<option value="{{ $pemohon->id }}" {{ ($perbaikan->user_id==$pemohon->id) ? 'selected' : '' }}>{{ $pemohon->full_name }}</option>
							@endforeach
						</select>
						@if($errors->has('jenis_pengajuan'))										
							<span class="help-block">{{ $errors->first('jenis_pengajuan') }}</span>
						@endif
					</div>

					<div class="form-group {{ ($errors->first('jenis_pengajuan')) ? 'has-error' : '' }}">
						<label for="fjenis_pengajuan">Jenis Pengajuan</label>
						<select name="jenis_pengajuan" class="form-control" id="fjenis_pengajuan" readonly="true">
							<option value="">-- Select Jenis Pengajuan --</option>
							<option value="1" {{ ($perbaikan->jenis_pengajuan=='1') ? 'selected' : '' }}>Pengadaan</option>
							<option value="2" {{ ($perbaikan->jenis_pengajuan=='2') ? 'selected' : '' }}>Perbaikan</option>
							<option value="3" {{ ($perbaikan->jenis_pengajuan=='3') ? 'selected' : '' }}>Pergantian</option>
						</select>
						@if($errors->has('jenis_pengajuan'))										
							<span class="help-block">{{ $errors->first('jenis_pengajuan') }}</span>
						@endif
					</div>

					<div class="form-group {{ ($errors->first('tgl_pengajuan')) ? 'has-error' : '' }}">
						<label for="ftgl_pengajuan">Tanggal Pengajuan</label>
						<input type="readonly" class="form-control datepicker" id="ftgl_pengajuan" name="tgl_pengajuan" value="{{ $perbaikan->pengajuan }}" required readonly="true">
						@if($errors->has('tgl_pengajuan'))										
							<span class="help-block">{{ $errors->first('tgl_pengajuan') }}</span>
						@endif
					</div>

					<div class="form-group {{ ($errors->first('status')) ? 'has-error' : '' }}">
						<label for="fstatus">Status</label>
						<select name="status" class="form-control" id="fstatus" readonly="true">
							<option value="">-- Select Status --</option>
							<option value="0" {{ ($perbaikan->status=='0') ? 'selected' : '' }}>Inactive</option>
							<option value="1" {{ ($perbaikan->status=='1') ? 'selected' : '' }}>Active</option>
						</select>
						@if($errors->has('status'))										
							<span class="help-block">{{ $errors->first('status') }}</span>
						@endif
					</div>
					<hr>
					<div class="wrap-item-pengajuan">
						<h3 class="h3-item-pengajuan">Item Barang</h3>
						@php
							$item_key = 1;
						@endphp
						@if(isset($perbaikan->item_perbaikan))
						@foreach($perbaikan->item_perbaikan as $key => $item)
						@php
							$item_key = $item->id+1;
						@endphp
						<div class="box-body item-pengajuan" id="item-pengajuan{{ $item_key }}">
							<div class="form-group">
								<label for="fnama_barang">Nama Barang</label>
								<input type="hidden" class="form-control" id="fitem" name="item_data[]" value="{{ $item->id }}" required>
								<input type="hidden" class="form-control" id="fitem" name="perbaikan[{{ $item_key }}][item]" value="{{ $item->id }}" required>
								<input type="readonly" class="form-control" id="fnama_barang" name="perbaikan[{{ $item_key }}][nama_barang]" value="{{ $item->nama_barang }}" required readonly="true">
							</div>

							<div class="form-group">
								<label for="fspesifikasi_barang">Spesifikasi Barang</label>
								<input type="readonly" class="form-control" id="fspesifikasi_barang" name="perbaikan[{{ $item_key }}][spesifikasi_barang]" value="{{ $item->spesifikasi_barang }}" required readonly="true">
							</div>

							<div class="form-group">
								<label for="furaian_barang">Uraian Barang</label>
								<input type="readonly" class="form-control" id="furaian_barang" name="perbaikan[{{ $item_key }}][uraian_barang]" value="{{ $item->uraian_barang }}" required readonly="true">
							</div>

							<div class="form-group">
								<label for="fketerangan">Keterangan</label>
								<textarea class="form-control" placeholder="Keterangan" id="fketerangan" name="perbaikan[{{ $item_key }}][keterangan]" required readonly="true">{{ $item->keterangan }}</textarea>
							</div>
						</div>
						@endforeach
						@endif
					</div>
					<hr>
					<div class="form-group {{ ($errors->first('status')) ? 'has-error' : '' }}">
						<label for="fstatus">Status</label>
						<select name="status" class="form-control" id="fstatus" readonly="true">
							<option value="">-- Select Status --</option>
							<option value="0" {{ ($perbaikan->status=='0') ? 'selected' : '' }}>Inactive</option>
							<option value="1" {{ ($perbaikan->status=='1') ? 'selected' : '' }}>Active</option>
						</select>
						@if($errors->has('status'))										
							<span class="help-block">{{ $errors->first('status') }}</span>
						@endif
					</div>

				</div>
				<!-- /.box-body -->																		

				<div class="box-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>				
			{!! Form::close() !!}


        </div>
        <!-- /.box -->
      </div>
      <!--/.col (left) -->        
    </div>
    <!-- /.row -->
  </section>


<style>
	.item-pengajuan {
		background-color: #cfd0d1 !important;
		margin: 10px 0px 20px 20px;
	}
	.h3-item-pengajuan {
		margin-left: 20px;
	}
</style>
@endsection