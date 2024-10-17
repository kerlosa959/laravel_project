{{Form::model($labour,array('route' => array('labour.update', $labour->id), 'method' => 'PUT')) }}
<div class="modal-body">

    <div class="row ">
        <div class="col-12">
            <div class="form-group">
                
                {{Form::label('department_id',__('Department'),['class'=>'form-label'])}}
                {{Form::select('department_id',$departments,null,array('class'=>'form-control select','placeholder'=>__('Select DEpartment')))}}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-label'])}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Labour Name')))}}

                {{Form::label('phone',__('Phone'),['class'=>'form-label'])}}
                {{Form::text('phone',null,array('class'=>'form-control','placeholder'=>__('Enter Labour Phone')))}}

                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
                @error('phone')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
                @error('department_id')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
