@extends('cms.layouts.default')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Create Barang
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li>Barang</li>
			<li><a href="{{ route('cms.barang.view') }}">Admin</a></li>			
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
					{!! Form::open(['route' => 'cms.barang.store', 'role'=>'form', 'autocomplete'=>'off']) !!}	
						<div class="box-body">
							<div class="form-group {{ ($errors->first('kode_barang')) ? 'has-error' : '' }}">
								<label for="fkode_barang">Kode barang</label>
								<textarea class="form-control" placeholder="No. Laporan" id="fkode_barang" name="kode_barang" required>{{ old('kode_barang') }}</textarea>
								@if($errors->has('kode_barang'))										
									<span class="help-block">{{ $errors->first('kode_barang') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('nama')) ? 'has-error' : '' }}">
								<label for="fnama">Nama barang</label>
								<textarea class="form-control" placeholder="No. Laporan" id="fnama" name="nama" required>{{ old('nama') }}</textarea>
								@if($errors->has('nama'))										
									<span class="help-block">{{ $errors->first('nama') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('kategory')) ? 'has-error' : '' }}">
								<label for="fkategory">Kategori barang</label>
								<textarea class="form-control" placeholder="No. Laporan" id="fkategory" name="kategory" required>{{ old('kategory') }}</textarea>
								@if($errors->has('kategory'))										
									<span class="help-block">{{ $errors->first('kategory') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('merk')) ? 'has-error' : '' }}">
								<label for="fmerk">Merk barang</label>
								<textarea class="form-control" placeholder="No. Laporan" id="fmerk" name="merk" required>{{ old('merk') }}</textarea>
								@if($errors->has('merk'))										
									<span class="help-block">{{ $errors->first('merk') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('bahan')) ? 'has-error' : '' }}">
								<label for="fbahan">Bahan barang</label>
								<textarea class="form-control" placeholder="No. Laporan" id="fbahan" name="bahan" required>{{ old('bahan') }}</textarea>
								@if($errors->has('bahan'))										
									<span class="help-block">{{ $errors->first('bahan') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('spesifikasi')) ? 'has-error' : '' }}">
								<label for="fspesifikasi">Spesifikasi barang</label>
								<textarea class="form-control" placeholder="No. Laporan" id="fspesifikasi" name="spesifikasi" required>{{ old('spesifikasi') }}</textarea>
								@if($errors->has('spesifikasi'))										
									<span class="help-block">{{ $errors->first('spesifikasi') }}</span>
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
@endsection

@section('script')
  @parent  
  <script>
    $(document).ready(function(){
      	
    });
  </script>
@endsection