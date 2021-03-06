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
			<li>Penerimaan</li>
			<li><a href="{{ route('cms.penerimaan.view') }}">Admin</a></li>			
			<li class="active">Create</li>
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
					{!! Form::open(['route' => 'cms.penerimaan.store', 'role'=>'form', 'autocomplete'=>'off', 'enctype'=>'multipart/form-data']) !!}	
						<div class="box-body">
							<div class="form-group {{ ($errors->first('pemohon')) ? 'has-error' : '' }}">
								<label for="fpemohon">Pemohon</label>
								<select name="pemohon" class="form-control" id="fpemohon">
									<option value="">-- Pilih Pemohon --</option>
									@foreach($user as $pemohon)
										<option value="{{ $pemohon->id }}" {{ (old('pemohon')==$pemohon->id) ? 'selected' : '' }}>{{ $pemohon->full_name }}</option>
									@endforeach
								</select>
								@if($errors->has('pemohon'))										
									<span class="help-block">{{ $errors->first('pemohon') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('nomor_laporan')) ? 'has-error' : '' }}">
								<label for="fnomor_laporan">No. Laporan</label>
								<select name="nomor_laporan" class="form-control" id="fnomor_laporan">
									<option value="">-- Pilih Laporan --</option>
									@foreach($no_laporan as $nmer)
										@if($nmer->nomor_laporan)
										<option value="{{ $nmer->nomor_laporan }}" {{ (old('nomor_laporan')==$nmer->nomor_laporan) ? 'selected' : '' }}>{{ $nmer->nomor_laporan }}</option>
										@endif
									@endforeach
								</select>
								@if($errors->has('nomor_laporan'))										
									<span class="help-block">{{ $errors->first('nomor_laporan') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('actor')) ? 'has-error' : '' }}">
								<label for="factor">Penerima Barang</label>
								<textarea class="form-control" placeholder="Penerima Barang" id="factor" name="actor" required></textarea>
								@if($errors->has('actor'))										
									<span class="help-block">{{ $errors->first('actor') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('tgl_penerimaan')) ? 'has-error' : '' }}">
								<label for="ftgl_penerimaan">Tanggal Penerimaan</label>
								<input type="text" class="form-control datepicker" id="ftgl_penerimaan" name="tgl_penerimaan" value="{{ old('tgl_penerimaan') }}" required>
								@if($errors->has('tgl_penerimaan'))										
									<span class="help-block">{{ $errors->first('tgl_penerimaan') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('nota')) ? 'has-error' : '' }}">
								<label for="fnota">Nota</label>
								<input type="file" class="form-control" id="fnota" name="nota" value="{{ old('nota') }}" >
								@if($errors->has('nota'))										
									<span class="help-block">{{ $errors->first('nota') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('status')) ? 'has-error' : '' }}">
								<label for="fstatus">Status</label>
								<select name="status" class="form-control" id="fstatus">
									<option value="">-- Select Status --</option>
									<option value="0" {{ (old('status')=='0') ? 'selected' : '' }}>Inactive</option>
									<option value="1" {{ (old('status')=='1') ? 'selected' : '' }}>Active</option>
								</select>
								@if($errors->has('status'))										
									<span class="help-block">{{ $errors->first('status') }}</span>
								@endif
							</div>
							<hr>
							<div class="wrap-item-pengajuan">
								<h3 class="h3-item-pengajuan">Item Barang</h3>
								<div class="box-body item-pengajuan" id="item-pengajuan1">
									<div class="form-group">
										<label for="fnama_barang">Nama Barang</label>
										@if($barangs)
										<select class="form-control" id="fstatus" name="penerimaan[1][id_barang]">
											<option value="">-- Pilih Barang --</option>
											@foreach($barangs as $barang)
											<option value="{{ $barang->id }}" {{ (old('status')==$barang->id) ? 'selected' : '' }}>{{ $barang->kode_barang }} &nbsp;&nbsp;---&nbsp;&nbsp; {{ $barang->nama }}</option>
											@endforeach
										</select>
										@endif
									</div>

									<div class="form-group">
										<label for="furaian_barang">Qty</label>
										<input type="text" class="form-control" id="fqty" name="penerimaan[1][qty]" value="">
									</div>

									<?php /*
									<div class="form-group">
										<label for="fspesifikasi_barang">Spesifikasi Barang</label>
										<textarea class="form-control" placeholder="Spesifikasi Barang" id="fspesifikasi_barang" name="penerimaan[1][spesifikasi_barang]"></textarea>
									</div>

									<div class="form-group">
										<label for="furaian_barang">Uraian Barang</label>
										<input type="text" class="form-control" id="furaian_barang" name="penerimaan[1][uraian_barang]" value="">
									</div>

									<div class="form-group">
										<label for="furaian_barang">Satuan</label>
										<input type="text" class="form-control" id="fsatuan" name="penerimaan[1][satuan]" value="">
									</div>
									*/ ?>

									<div class="form-group">
										<label for="fketerangan">Keterangan</label>
										<textarea class="form-control" placeholder="Keterangan" id="fketerangan" name="penerimaan[1][keterangan]"></textarea>
									</div>

									<div class="form-group">
									<a href="javascript:void(0);" class="btn btn-danger">Hapus Item</a>
									</div>
								</div>							
							</div>
							<div class="box-footer">
								<button type="button" class="btn btn-success add-item" data-item="1">Tambah Item</button>
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

@section('script')
  @parent  
  <script>
    $(document).ready(function(){
      	$('body').on('click', '.add-item', function(evt) {
		  	_item_row = parseInt($('.add-item').attr('data-item'));
		  	_new_item_row = _item_row + 1;
			  _html = '';

		  	_html += '<div class="box-body item-pengajuan" id="item-pengajuan'+_new_item_row+'">'+
				'<div class="form-group">'+
					'<label for="fnama_barang">Nama Barang</label>'+
				_html += '<select class="form-control" id="fstatus" name="penerimaan['+_new_item_row+'][id_barang]">'+
					'<option value="">-- Pilih Barang --</option>';
					@if($barangs)
					@foreach($barangs as $barang)
				_html += '<option value="{{ $barang->id }}">{{ $barang->kode_barang }} &nbsp;&nbsp;---&nbsp;&nbsp; {{ $barang->nama }}</option>';
					@endforeach
					@endif
				_html +=  '</select>'+
				'</div>'+
				// '<div class="form-group">'+
				// 	'<label for="fspesifikasi_barang">Spesifikasi Barang</label>'+
				// 	// '<input type="text" class="form-control" id="fspesifikasi_barang" name="penerimaan['+_new_item_row+'][spesifikasi_barang]" value="">'+
				// 	'<textarea class="form-control" placeholder="Spesifikasi Barang" id="fspesifikasi_barang" name="penerimaan['+_new_item_row+'][spesifikasi_barang]"></textarea>'+
				// '</div>'+
				// '<div class="form-group">'+
				// 	'<label for="furaian_barang">Uraian Barang</label>'+
				// 	'<input type="text" class="form-control" id="furaian_barang" name="penerimaan['+_new_item_row+'][uraian_barang]" value="">'+
				// '</div>'+
				'<div class="form-group">'+
					'<label for="furaian_barang">Qty</label>'+
					'<input type="text" class="form-control" id="fqty" name="penerimaan['+_new_item_row+'][qty]" value="">'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="fketerangan">Keterangan</label>'+
					'<textarea class="form-control" placeholder="Keterangan" id="fketerangan" name="penerimaan['+_new_item_row+'][keterangan]"></textarea>'+
				'</div>'+
				'<div class="form-group">'+
				'<a href="javascript:void(0);" class="btn btn-danger remove-item" data-item="'+_new_item_row+'">Hapus Item</a>'+
				'</div>'+
			'</div>';
			console.log(_html);
			// $('#item-pengajuan'+_item_row).after(_html);
			$('.wrap-item-pengajuan').append(_html);
			$(this).attr('data-item', _new_item_row);
	  	});

		$('body').on('click', '.remove-item', function(evt) {
			_item_row = parseInt($(this).data('item'));
			$('#item-pengajuan'+_item_row).remove();
	  	});
    });
  </script>
@endsection