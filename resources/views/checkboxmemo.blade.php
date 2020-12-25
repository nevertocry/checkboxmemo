<div class="{{$viewClass['form-group']}} {!! !$errors->has($column) ?: 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}" id="{{$id}}">

        @if($canCheckAll)
            <div class="col-sm-12">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" class="{{ $checkAllClass }}"/>&nbsp;{{ __('admin.all') }}
                    </label>
                </div>
                <hr style="margin-top: 10px;margin-bottom: 0;">
            </div>

        @endif

        @include('admin::form.error')

        @foreach($options as $option => $label)
            <div class="col-sm-4" style="padding-left: 0">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="{{$name}}[{{$option}}][id]" value="{{$option}}" class="{{$class}}" {{ (!empty($value) && in_array($option, $value)) ?'checked':'' }} {!! $attributes !!} />&nbsp;{{$label}}&nbsp;&nbsp;
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <input class="form-control" type="text" name="{{$name}}[{{$option}}][memo]" value="{{isset($memos[$option])?$memos[$option]:''}}" placeholder="{!! $placeholder !!}">
                </div>
            </div>

        @endforeach

        @include('admin::form.help-block')

    </div>
</div>
