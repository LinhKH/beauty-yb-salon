<label for="">Client Name : {{$appointment->name}}</label>
<input type="text" name="app_id" hidden value="{{$appointment->id}}">
<div class="form-group">
    <label for="">Status</label>
    <select name="status" class="form-control">
        <option value="0" @if($appointment->service_status == '0') selected @endif>Pending</option>
        <option value="1" @if($appointment->service_status == '1') selected @endif>In Progress</option>
        <option value="2" @if($appointment->service_status == '2') selected @endif>Completed</option>
    </select>
</div>