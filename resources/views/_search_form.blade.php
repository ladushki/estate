<form method="get" id="search" action="{{route('listing', ['product'=>$type])}}">
    <div class="form-group row text-left">
        <label for="town" class="col-sm-1 col-form-label">Town</label>
        <div class="col-sm-2">
            <input type="text" class="form-control" id="town" name="town" value="{!! isset($input['town'])?e($input['town']) :''!!}">
        </div>
        <label for="rooms" class="col-sm-1 col-form-label">Bedrooms</label>
        <div class="col-sm-1">
            <select name="bedrooms">
                <option value="">All</option>
                @for($i=1; $i<=14; $i++)
                    <option value="{{$i}}" {{isset($input['bedrooms']) && $input['bedrooms']==$i?'selected="selected"':''}}>{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="col-sm-1"><input type="submit" value="search" class="btn btn-outline-primary">
        </div>
    </div>
</form>
