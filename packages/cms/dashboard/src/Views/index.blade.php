@extends('cms.layouts.default')

@section('title', '- Dashboard')

@section('content')

		<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       <div class="row">
        <div class="col-lg-12 col-xs-12">
          <h1>Selamat Datang</h1>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h2>{{ $pending_kepsek }}</h2>

              <p>Inventaris menunggu persetujuan Kepala Sekolah</p>
            </div>
            <a href="{{ route('cms.pengadaan.list') }}" class="small-box-footer">Periksa <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h2>{{ $pending_wakasek }}</h2>

              <p>Inventaris menunggu persetujuan Wakil Kepala Sekolah</p>
            </div>
            <a href="{{ route('cms.pengadaan.list') }}" class="small-box-footer">Periksa <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>

      <div class="row">
        <section class="col-lg-6 connectedSortable">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Pengadaan Barang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list">
                @if(isset($barangPengadaan))
                  @foreach($barangPengadaan as $pengadaan)
                  <li>
                    <span class="text">{{ $pengadaan->nama_barang }}</span>
                    <small class="label label-primary"> {{ $pengadaan->qty }}</small>
                  </li>
                  @endforeach
                @endif
              </ul>
            </div>
          </div>
        </section>
        <section class="col-lg-6 connectedSortable">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Penerimaan Barang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list">
                @if(isset($barangPenerimaan))
                  @foreach($barangPenerimaan as $penerimaan)
                  <li>
                    <span class="text">{{ $penerimaan->nama_barang }}</span>
                    <small class="label label-success"> {{ $penerimaan->qty }}</small>
                  </li>
                  @endforeach
                @endif
              </ul>
            </div>
          </div>
        </section>
      </div>
      <div class="row">
        <section class="col-lg-6 connectedSortable">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Perbaikan Barang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list">
                @if(isset($barangKerusakan))
                  @foreach($barangPerbaikan as $perbaiakn)
                  <li>
                    <span class="text">{{ $perbaiakn->nama_barang }}</span>
                    <small class="label label-warning"> {{ $perbaiakn->qty }}</small>
                  </li>
                  @endforeach
                @endif
              </ul>
            </div>
          </div>
        </section>
        <section class="col-lg-6 connectedSortable">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Kerusakan Barang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list">
                @if(isset($barangKerusakan))
                  @foreach($barangKerusakan as $kerusakan)
                  <li>
                    <span class="text">{{ $kerusakan->nama_barang }}</span>
                    <small class="label label-warning"> {{ $kerusakan->qty }}</small>
                  </li>
                  @endforeach
                @endif
              </ul>
            </div>
          </div>
        </section>
      </div>

    </section>
    <!-- /.content -->

@endsection

@section('script')
  @parent
@endsection