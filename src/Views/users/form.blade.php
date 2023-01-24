<div class="form-group">
    @if (!isset($reset))
        <div class="row">
            <div class="col-md-2 text-right mt-2">
                <label>Role</label>
            </div>
            <div class="col-md-10">
                {!! Form::select('role',$roles,null,['class'=>'form-control role','id'=>'role','placeholder'=>'','required']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 text-right mt-2">
                <label>Name</label>
            </div>
            <div class="col-md-10">
                <input type="text" name='name' {{(isset($edit)) ? 'disabled' : ''}} class="form-control name" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 text-right mt-2">
                <label>Email</label>
            </div>
            <div class="col-md-10">
                <input type="text" name='email' {{(isset($edit)) ? 'disabled' : ''}} class="form-control email"
                       required>
            </div>
        </div>
        @can('landing page assign')
            <div class="row">
                <div class="col-md-2 text-right mt-2">
                    <label>Landing Page</label>
                </div>
                <div class="col-md-10">
                    {!! Form::select('landing_page', $landing_page , null , ['class' => 'form-control landing_page']) !!}
                </div>
            </div>
        @endcan
    @endif
    @if (!isset($edit))
        <div class="row">
            <div class="col-md-2 text-right mt-2">
                <label>Password</label>
            </div>
            <div class="col-md-10">
                <input type="password" id="password" name='password' class="form-control password" required autocomplete="new-password">
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 text-right mt-2">
                <label>Confirm Password</label>
            </div>
            <div class="col-md-10">
                <input type="password" name='txtConfirmPassword'
                       class="form-control confirm-password" required  autocomplete="new-password">
            </div>
        </div>
    @endif
        <div class="row">
            <div class="col-md-2 text-right mt-2">
                <label>API User</label>
            </div>
            <div class="col-md-1">
                <input type="checkbox" name='is_api' class="form-control is_api">
            </div>
        </div>


</div>
