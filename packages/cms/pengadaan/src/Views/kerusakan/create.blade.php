@extends('cms.layouts.default')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Create Laporan Kerusakan
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li>Kerusakan</li>
			<li><a href="{{ route('cms.kerusakan.view') }}">Admin</a></li>			
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
					{!! Form::open(['route' => 'cms.kerusakan.store', 'role'=>'form', 'autocomplete'=>'off']) !!}	
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
								<textarea class="form-control" placeholder="No. Laporan" id="fnomor_laporan" name="nomor_laporan" required>{{ old('nomor_laporan') }}</textarea>
								@if($errors->has('nomor_laporan'))										
									<span class="help-block">{{ $errors->first('nomor_laporan') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('tgl_pengajuan')) ? 'has-error' : '' }}">
								<label for="ftgl_pengajuan">Tanggal Pengajuan</label>
								<input type="text" class="form-control datepicker" id="ftgl_pengajuan" name="tgl_pengajuan" value="{{ old('tgl_pengajuan') }}" required>
								@if($errors->has('tgl_pengajuan'))										
									<span class="help-block">{{ $errors->first('tgl_pengajuan') }}</span>
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
										<input type="text" class="form-control" id="fnama_barang" name="kerusakan[1][nama_barang]" value="" required>
									</div>

									<div class="form-group">
										<label for="fspesifikasi_barang">Spesifikasi Barang</label>
										<textarea class="form-control" placeholder="Spesifikasi Barang" id="fspesifikasi_barang" name="kerusakan[1][spesifikasi_barang]" required></textarea>
									</div>

									<div class="form-group">
										<label for="furaian_barang">Uraian Barang</label>
										<input type="text" class="form-control" id="furaian_barang" name="kerusakan[1][uraian_barang]" value="">
									</div>
									
									<div class="form-group">
										<label for="furaian_barang">Qty</label>
										<input type="text" class="form-control" id="fqty" name="kerusakan[1][qty]" value="">
									</div>
									
									<div class="form-group">
										<label for="furaian_barang">Satuan</label>
										<input type="text" class="form-control" id="fsatuan" name="kerusakan[1][satuan]" value="">
									</div>

									<div class="form-group">
										<label for="fketerangan">Keterangan</label>
										<textarea class="form-control" placeholder="Keterangan" id="fketerangan" name="kerusakan[1][keterangan]"></textarea>
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

		  	_html = '<div class="box-body item-pengajuan" id="item-pengajuan'+_new_item_row+'">'+
				'<div class="form-group">'+
					'<label for="fnama_barang">Nama Barang</label>'+
					'<input type="text" class="form-control" id="fnama_barang" name="kerusakan['+_new_item_row+'][nama_barang]" value="" required>'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="fspesifikasi_barang">Spesifikasi Barang</label>'+
					// '<input type="text" class="form-control" id="fspesifikasi_barang" name="kerusakan['+_new_item_row+'][spesifikasi_barang]" value="">'+
					'<textarea class="form-control" placeholder="Spesifikasi Barang" id="fspesifikasi_barang" name="kerusakan['+_new_item_row+'][spesifikasi_barang]"></textarea>'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="furaian_barang">Uraian Barang</label>'+
					'<input type="text" class="form-control" id="furaian_barang" name="kerusakan['+_new_item_row+'][uraian_barang]" value="">'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="furaian_barang">Qty</label>'+
					'<input type="text" class="form-control" id="fqty" name="kerusakan['+_new_item_row+'][qty]" value="">'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="furaian_barang">Satuan</label>'+
					'<input type="text" class="form-control" id="fsatuan" name="kerusakan['+_new_item_row+'][satuan]" value="">'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="fketerangan">Keterangan</label>'+
					'<textarea class="form-control" placeholder="Keterangan" id="fketerangan" name="kerusakan['+_new_item_row+'][keterangan]"></textarea>'+
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