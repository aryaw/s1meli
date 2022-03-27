@extends('cms.layouts.default')

@section('content')
		<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Settings
        <small>page</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>        
        <li class="active">Settings</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('cms.partials.flash')
      <div class="row">
        <div class="col-xs-12">                    
          {!! Form::open(['route' => 'cms.setting.update', 'autocomplete'=>'off', 'method'=>'PUT', 'enctype' => 'multipart/form-data']) !!}
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              @foreach( $groups as $index=>$group )
              <li class="{{ ($index==0) ? 'active' : '' }}"><a href="#tab_{{ $index }}" data-toggle="tab">{{ $group->group }}</a></li>
              @endforeach

              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>            
            <div class="tab-content">              
              @foreach( $groups as $index2=>$group2 )
              <div class="tab-pane {{ ($index2==0) ? 'active' : '' }}" id="tab_{{ $index2 }}">
                @if( isset($settings[$group2->group]) )
                  @foreach( $settings[$group2->group] as $setting )                  
                  <div class="row">                    

                    <div class="col-md-12">
                      <div class="form-group">
                        <label>{{ $setting->name }}</label>  <code>{{ $setting->key }}</code>
                        <div class="box-tools pull-right">                          
                          <a href="{{ route('cms.setting.delete',['id'=>$setting->id]) }}" class="text-muted deleteDialog" data-title="{{ $setting->key }}"><i class="fa fa-trash"></i></a>
                        </div>

                        @if($setting->type=='text')
                        <input type="text" name="settings[{{ $setting->id }}]" class="form-control" placeholder="" value="{{ (old('settings.'.$setting->id)) ? old('settings.'.$setting->id) : $setting->value }}">
                        @elseif($setting->type=='textarea')                      
                        <textarea class="form-control" name="settings[{{ $setting->id }}]" rows="3" placeholder="">{{ (old('settings.'.$setting->id)) ? old('settings.'.$setting->id) : $setting->value }}</textarea>
                        @elseif($setting->type=='wysiwyg')
                        <textarea class="form-control summernote" name="settings[{{ $setting->id }}]" cols="30" rows="10" placeholder="">{{ (old('settings.'.$setting->id)) ? old('settings.'.$setting->id) : $setting->value }}</textarea>
                        @elseif($setting->type=='image')
                        <input class="form-control" type="file" name="settings[{{ $setting->id }}]" accept="image/*" onchange="previewImage(this, '#image_{{ $setting->id }}')">
                        @endif                        

                        @if($errors->has('settings.'.$setting->id))
                          <span class="help-block">{{ $errors->first('settings.'.$setting->id) }}</span>
                        @endif

                        @if($setting->type =='image' && $setting->value)                      
                        <div style="margin-top: 5px">                          
                          <img src="{{ Storage::url($setting->value) }}" alt="setting" height="50" id="image_{{ $setting->id }}">
                        </div>                        
                        @endif  

                      </div>
                    </div>

                  </div>
                  @endforeach
                  <div class="box-footer">                    
                    <button type="submit" class="btn btn-info pull-right">Save Settings {{ setting('ok') }}</button>
                  </div>
                @endif
              </div>
              @endforeach              
            </div>            
            <!-- /.tab-content -->
          </div>
          {!! Form::close() !!}
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">New Setting</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
            {!! Form::open(['route' => 'cms.setting.store', 'class'=>'form-group', 'autocomplete'=>'off']) !!}
              <div class="box-body">
                <div class="col-md-3">
                  <div class="form-group {{ ($errors->first('name')) ? 'has-error' : '' }}">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Setting name" value="{{ old('name') }}" required>
                    @if($errors->has('name'))                   
                      <span class="help-block">{{ $errors->first('name') }}</span>
                    @endif
                  </div>                    
                </div>
                <div class="col-md-3">
                  <div class="form-group {{ ($errors->first('key')) ? 'has-error' : '' }}">
                    <label for="key">Key</label>
                    <input type="text" class="form-control" name="key" placeholder="Setting key" value="{{ old('key') }}" required onkeypress="slugFormat(event)">
                    @if($errors->has('key'))                   
                      <span class="help-block">{{ $errors->first('key') }}</span>
                    @endif
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group {{ ($errors->first('type')) ? 'has-error' : '' }}">
                    <label for="type">Type</label>
                    <select name="type" class="form-control" required>
                      <option value="">Choose Type</option>
                      @foreach($setting_types as $type)
                      <option value="{{ $type['value'] }}" {{ (old('type')==$type['value']) ? 'selected' : '' }}>{{ $type['name'] }}</option>
                      @endforeach
                    </select>
                    @if($errors->has('type'))                   
                      <span class="help-block">{{ $errors->first('type') }}</span>
                    @endif
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group {{ ($errors->first('group')) ? 'has-error' : '' }}">
                    <label for="group">Group</label>
                    <select name="group" class="form-control" required>
                      <option value="">Choose Group</option>
                      @foreach($groups as $group3)
                      <option value="{{ $group3->group }}" {{ (old('group')==$group3->group) ? 'selected' : '' }}>{{ $group3->group }}</option>
                      @endforeach
                    </select>
                    @if($errors->has('group'))                   
                      <span class="help-block">{{ $errors->first('group') }}</span>
                    @endif
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Add New Setting</button>
              </div>
              <!-- /.box-footer -->
            {!! Form::close() !!}
          </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
@endsection

@section('script')
  @parent  
  <script>
    $(document).ready(function(){
      $('.summernote').summernote(summernoteOptions);
    });
  </script>
@endsection