<div class="form-group">
    <div class="row">
        <div class="col-md-2 text-right mt-2">
            <label>Name</label>
        </div>
        <div class="col-md-10">
            <input type="text" id="txtName" name='name' class="form-control name" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 text-right mt-2">
            <label>Permissions</label>
            <br>
            <div>
                <input type="checkbox" class="select-all-permissions" onclick="toggleAllPermissions('{{$formId}}')"> Select all
            </div>
        </div>
        <div class="col-md-10">
            <div class="row">
                @foreach($permissions as $key => $permission)
                    <div class="col-sm-6">
                        <input type="checkbox" name="permissions[]" class="permissions" data-permission="{{$key}}" value="{{$key}}"> {{$permission}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

