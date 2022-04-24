@extends('cms.layouts.default')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Edit Nota Laporan
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li>Penerimaan</li>
			<li><a href="{{ route('cms.penerimaan.view') }}">Admin</a></li>			
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
			{!! Form::open(['route' => ['cms.penerimaan.updatenota', 'id'=>$penerimaan->id], 'role'=>'form', 'autocomplete'=>'off', 'enctype'=>'multipart/form-data']) !!}	
				<div class="box-body">
					<div class="form-group {{ ($errors->first('pemohon')) ? 'has-error' : '' }}">
						<label for="fpemohon">Pemohon</label>
						<input type="text" class="form-control" id="ftgl_penerimaan" name="tgl_penerimaan" value="{{ $penerimaan->user->full_name }}" readonly>
						@if($errors->has('pemohon'))										
							<span class="help-block">{{ $errors->first('pemohon') }}</span>
						@endif
					</div>

					<div class="form-group {{ ($errors->first('nomor_laporan')) ? 'has-error' : '' }}">
						<label for="fnomor_laporan">No. Laporan</label>
						<input type="text" class="form-control" id="fnomor_laporan" name="nomor_laporan" value="{{ $penerimaan->nomor_laporan }}" readonly>
					</div>

					<div class="form-group {{ ($errors->first('actor')) ? 'has-error' : '' }}">
						<label for="factor">Penerima Barang</label>
						<input type="text" class="form-control" id="factor" name="actor" value="{{ $penerimaan->actor }}" readonly>
					</div>

					<div class="form-group {{ ($errors->first('tgl_penerimaan')) ? 'has-error' : '' }}">
						<label for="ftgl_penerimaan">Tanggal Penerimaan</label>
						<input type="text" class="form-control" id="ftgl_penerimaan" name="tgl_penerimaan" value="{{ $penerimaan->tgl_penerimaan }}" readonly>
					</div>

					<div class="form-group {{ ($errors->first('nota')) ? 'has-error' : '' }}">
						<label for="fnota">Nota</label>
						<input type="file" class="form-control" id="fnota" name="nota" value="{{ old('nota') }}" >
						@if($errors->has('nota'))										
							<span class="help-block">{{ $errors->first('nota') }}</span>
						@endif
                        @if(in_array(Storage::mimeType($penerimaan->nota), ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/jpg', 'image/tiff']))
                            <img src="{{ Storage::url($penerimaan->nota) }}" width="400px" height="auto" style="margin-top: 20px;"/>
                        @elseif(in_array(Storage::mimeType($penerimaan->nota), ['application/pdf']))
                            <a href="{{ Storage::url($penerimaan->nota) }}" target="_blank"/>
						@endif

					</div>

					<div class="form-group {{ ($errors->first('status')) ? 'has-error' : '' }}">
						<label for="fstatus">Status</label>
                        <input type="text" class="form-control" id="fstatus" name="status" value="{{ ($penerimaan->status=='0') ? 'Inactive' : 'Active' }}" readonly>                        
					</div>
					<hr>
					<div class="wrap-item-pengajuan">
						<h3 class="h3-item-pengajuan">Item Barang</h3>
						@php
							$item_key = 1;
						@endphp
						@if(isset($penerimaan->item_pengadaan))
						@foreach($penerimaan->item_pengadaan as $key => $item)
						@php
							$item_key = $item->id+1;
						@endphp
						<div class="box-body item-pengajuan" id="item-pengajuan{{ $item_key }}">
							<div class="form-group">
								<label for="fnama_barang">Nama Barang</label>
								<input type="hidden" class="form-control" id="fitem" name="item_data[]" value="{{ $item->id }}" >
								<input type="hidden" class="form-control" id="fitem" name="penerimaan[{{ $item_key }}][item]" value="{{ $item->id }}" >
								<input type="text" class="form-control" id="fnama_barang" name="penerimaan[{{ $item_key }}][nama_barang]" value="{{ $item->nama_barang }}" readonly>
							</div>

							<div class="form-group">
								<label for="fspesifikasi_barang">Spesifikasi Barang</label>
								<textarea class="form-control" placeholder="Spesifikasi Barang" id="fketerangan" name="penerimaan[{{ $item_key }}][spesifikasi_barang]" readonly>{{ $item->spesifikasi_barang }}</textarea>
							</div>

							<div class="form-group">
								<label for="furaian_barang">Uraian Barang</label>
								<input type="text" class="form-control" id="furaian_barang" name="penerimaan[{{ $item_key }}][uraian_barang]" value="{{ $item->uraian_barang }}" readonly>
							</div>

							<div class="form-group">
								<label for="furaian_barang">Qty</label>
								<input type="text" class="form-control" id="fqty" name="penerimaan[{{ $item_key }}][qty]" value="{{ $item->qty }}" readonly>
							</div>

							<div class="form-group">
								<label for="fketerangan">Keterangan</label>
								<textarea class="form-control" placeholder="Keterangan" id="fketerangan" name="penerimaan[{{ $item_key }}][keterangan]"  readonly>{{ $item->keterangan }}</textarea>
							</div>
						</div>
						@endforeach
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