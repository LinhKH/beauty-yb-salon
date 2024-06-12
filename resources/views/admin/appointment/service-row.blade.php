<tr>
    <td>
        <select name="service[]" class="form-control serviceSelect" id="sRow{{$id}}" required>
            <option value="" selected disabled>Select Service</option>
            @foreach($services as $service)
                <option value="{{$service->id}}">{{$service->title}}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="number" name="qty[]" class="form-control serviceQty" id="sQty{{$id}}" value="1" min="1" required>
    </td>
    <td>
        <span class="serviceTotal"></span>
        <input type="text" hidden class="servicePrice">
    </td>
    <td></td>
</tr>