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
			<li>Kerusakan</li>
			<li><a href="{{ route('cms.kerusakan.view') }}">Admin</a></li>			
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
			{!! Form::open(['route' => ['cms.kerusakan.updatebyrole', 'id'=>$kerusakan->id], 'role'=>'form', 'autocomplete'=>'off']) !!}	
				<div class="box-body">
					<div class="form-group {{ ($errors->first('pemohon')) ? 'has-error' : '' }}">
						<label for="fpemohon">Pemohon</label>
						<input type="text" class="form-control" id="fnama_barang" name="" value="{{ $kerusakan->user->full_name }}" readonly>
					</div>

					<div class="form-group {{ ($errors->first('nomor_laporan')) ? 'has-error' : '' }}">
						<label for="fnomor_laporan">No. Laporan</label>
						<textarea class="form-control" placeholder="No. Laporan" id="fnomor_laporan" name="" readonly>{{ $kerusakan->nomor_laporan }}</textarea>
					</div>

					<div class="form-group {{ ($errors->first('tgl_pengajuan')) ? 'has-error' : '' }}">
						<label for="ftgl_pengajuan">Tanggal Pengajuan</label>
						<input type="text" class="form-control datepicker" id="ftgl_pengajuan" name="" value="{{ $kerusakan->pengajuan }}" readonly>
					</div>

					<div class="form-group {{ ($errors->first('status')) ? 'has-error' : '' }}">
						<label for="fstatus">Status</label>
						<select class="form-control" id="fstatus" readonly>
							<option value="">-- Select Status --</option>
							<option value="0" {{ ($kerusakan->status=='0') ? 'selected' : '' }}>Inactive</option>
							<option value="1" {{ ($kerusakan->status=='1') ? 'selected' : '' }}>Active</option>
						</select>
					</div>
					<hr>
					<div class="wrap-item-pengajuan">
						<h3 class="h3-item-pengajuan">Item Barang</h3>
						@php
							$item_key = 1;
						@endphp
						@if(isset($kerusakan->item_kerusakan))
						@foreach($kerusakan->item_kerusakan as $key => $item)
						@php
							$item_key = $item->id+1;
						@endphp
						<div class="box-body item-pengajuan" id="item-pengajuan{{ $item_key }}">
							<div class="form-group">
								<label for="fnama_barang">Nama Barang</label>
								<input type="hidden" class="form-control" id="fitem" readonly>
								<input type="hidden" class="form-control" id="fitem" value="{{ $item->id }}" readonly>
								<input type="text" class="form-control" id="fnama_barang" value="{{ $item->nama_barang }}" readonly>
							</div>

							<div class="form-group">
								<label for="fspesifikasi_barang">Spesifikasi Barang</label>
								<textarea class="form-control" placeholder="Spesifikasi Barang" id="fketerangan" readonly>{{ $item->spesifikasi_barang }}</textarea>
							</div>

							<div class="form-group">
								<label for="furaian_barang">Qty</label>
								<input type="text" class="form-control" id="fqty" value="{{ $item->qty }}" readonly>
							</div>

							<div class="form-group">
								<label for="furaian_barang">Satuan</label>
								<input type="text" class="form-control" id="fsatuan" value="{{ $item->satuan }}" readonly>
							</div>

							<div class="form-group">
								<label for="fketerangan">Keterangan</label>
								<textarea class="form-control" placeholder="Keterangan" id="fketerangan" readonly>{{ $item->keterangan }}</textarea>
							</div>
						</div>
						@endforeach
						@endif
					</div>

				</div>
				<!-- /.box-body -->																		
				@if($btn == 'kepsek')
				<input type="hidden" class="form-control" id="fapproval-kepsek" name="approval" value="1">
				<div class="box-footer">
					<button type="submit" class="btn btn-primary">Approve Kepala Sekolah</button>
				</div>
				@endif

				@if($btn == 'wakasek')
				<input type="hidden" class="form-control" id="fapproval-wakasek" name="approval" value="1">
				<div class="box-footer">
					<button type="submit" class="btn btn-primary">Approve Wakil Kepala Sekolah</button>
				</div>
				@endif
								
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