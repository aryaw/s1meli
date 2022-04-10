@extends('cms.layouts.default')

@section('content')
	<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Kerusakan
      <small>data</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li>Kerusakan</li>
      <li class="active">Kerusakan</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('cms.partials.flash')
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title"></h3>
            <div class="btn-group pull-right m-b-10">
            	<a class="btn btn-default" href="#" role="button" id="download"><i class="fa fa-download"></i></a>
              <a class="btn btn-primary" href="{{ route('cms.kerusakan.create') }}" role="button"><i class="fa fa-plus"></i> Add New</a>   
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <!-- custom datatable filter -->
            <div class="row datatable-custom-filter">
              <div class="col-sm-1">                  
                <select name="page_len" id="pageLen" class="form-control">
                  <option value="10" selected>10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                </select>
                entries
              </div>
              <div class="col-sm-2">
                <input type='text' id='startDate' placeholder='start date' class="form-control datepicker">
              </div>
              <div class="col-sm-2">
                <input type='text' id='endDate' placeholder='end date' class="form-control datepicker">
              </div>
              <div class="col-sm-2">
                <input type='text' id='searchFilter' placeholder='search name' class="form-control" autocomplete="off">
              </div>                
            </div>
            
            <div class="table-responsive">
              <table id="tableWithSearch" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Pemohon</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Wakasek</th>
                    <th>Kepsek</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>                
                </tbody>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Pemohon</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Wakasek</th>
                    <th>Kepsek</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
            </div>

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->	  

  <div class="modal fade slide-right" id="modalExport" tabindex="-1" role="dialog" aria-hidden="true">
	    <div class="modal-dialog modal-sm">
	        <div class="modal-content-wrapper">
	            <div class="modal-content">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
	                </button>
	                <div class="container-xs-height full-height">
	                    <div class="row-xs-height">
	                        <div class="modal-body col-xs-height col-middle">
	                            <h5>Select Filter Download</h5>
	                            <div class="form-group form-group-default form-group-default-select">
	                                <label>Status</label>
	                                <select name="status" class="form-control">
	                                	<option value="all">All</option>
	                                	<option value="active">ACTIVE</option>
	                                	<option value="inactive">INACTIVE</option>
	                                </select>
	                            </div>
	                            <div class="form-group form-group-default form-group-default-select required">
	                                <label>Start Date</label>
	                                <input type="text" name="start_date" class="form-control datetimepicker" autocomplete="off">
	                            </div>
	                            <div class="form-group form-group-default form-group-default-select required">
	                                <label>End Date</label>
	                                <input type="text" name="end_date" class="form-control datetimepicker" autocomplete="off">
	                            </div>
	                            <br>
	                            <button type="button" class="btn btn-success btn-block" data-dismiss="modal">Download</button>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	</div>
@endsection

@section('script')
	@parent
		<script>
      $(document).ready(function(){		  	
        
        var settings = {
          destroy: true,
          scrollCollapse: true,
          autoWidth: false,
          deferRender: true,
          iDisplayLength: 10,
          processing: true,
          serverSide: true,
          order: [[ 0, "asc" ]],
          lengthChange: false,
          searching: false,
          columns: [
            { data:'no', width: '80px', render:function(data, type, row, meta){
              var json = meta.settings.json;
              return (json.old_start + meta.row + 1);
            }},	                
            { data:'full_name', orderable:false },
            { data:'status', orderable:false },
            { data:'pengajuan'},
            { data:'approve_wakasek'},
            { data:'approve_kepsek'},
            { data:null, orderable: false, render:function(data, type, row, meta){	               		
              //var detailButton = '<a class="btn btn-primary btn-space" href="'+ ADMIN_URL + '/kerusakan/detail/' + data.id +'" role="button">Detail</a>';
              //return detailButton;
              var editButton = '<a class="btn btn-primary btn-space" href="'+ ADMIN_URL + '/kerusakan/edit/' + data.id +'" role="button">Edit</a>';
              var deleteButton = '<a class="btn btn-danger deleteDialog" href="'+ ADMIN_URL + '/kerusakan/list/delete/' + data.id +'" data-title="Laporan" role="button">Delete</a>';
              return editButton + deleteButton;
            }}
          ],
          ajax : {
            dataSrc : 'data',
            data: function(data){
              data.startDate = $('#startDate').val();
              data.endDate = $('#endDate').val();
              data.search.value = $('#searchFilter').val();
            },
            timeout: 15000,
            beforeSend: function(request){
              Pace.restart();
            },
            complete:function(){
              Pace.stop();
            },
            xhrFields : {
              withCredentials : true
            },
            crossDomain : true,
            url : ADMIN_URL + '/kerusakan/list',
            type : 'POST',
            error: function( xhr, textStatus, error)
            {
              console.log(error);
              alert('An Error Occurred');
            }
          },
          initComplete: function() {
          },
        };

		    var dataTable = $('#tableWithSearch').DataTable(settings);        
        
        //  data filter
        var filterTextTimeout;
        $('#searchFilter').keyup(function(){
          clearTimeout(filterTextTimeout);          
          filterTextTimeout = setInterval(function(){                        
            dataTable.draw();
            clearTimeout(filterTextTimeout);
          }, 700);          
        });
        $('#pageLen').change(function(){
          dataTable.page.len( $(this).val() ).draw()
        });
        $('#startDate').change(function(){          
          if($('#endDate').val()){
            dataTable.draw();
          }          
        });
        $('#endDate').change(function(){          
          if($('#startDate').val()){
            dataTable.draw();
          }          
        });


        // download
        $("#download").click(function(){
          $.ajax({
            url: ADMIN_URL + '/kerusakan/export',
            type: 'POST',
            data: { start_date:'', end_date:'' },
            dataType: 'json',
            beforeSend: function(){
               
            },
            complete: function(){               
            },
            success: function(result, status, xhr){                
                if(result.data){                    
                  var wb = XLSX.utils.book_new();
                  wb.Props = {
                    Title: "Kerusakan",
                    /* Subject: "Test",
                    Author: "Red Stapler",
                    CreatedDate: new Date(2017,12,19) */
                  };
                  
                  wb.SheetNames.push("Kerusakan Sheet");                
                  var ws = XLSX.utils.json_to_sheet(result.data);
                  wb.Sheets["Kerusakan Sheet"] = ws;
                  var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
                  function s2ab(s) {    
                    var buf = new ArrayBuffer(s.length);
                    var view = new Uint8Array(buf);
                    for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                    return buf;
                  }
                  saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), 'kerusakan.xlsx');
                }else{
                    alert('empty data')
                }
            },
            error: function(xhr, ajaxOptions, thrownError){
                var spesificError = '';
                try{
                    spesificError = xhr.responseJSON.errors[0].message;  
                }catch(e){
                    console.log("Error Exception: ", e);
                }
                alert('Terjadi Error')
                console.log('Please contact Developer. ' + thrownError + ': ' + spesificError);
            }
          });
        });
        

	    });
    </script>

@endsection