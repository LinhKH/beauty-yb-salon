@if ($services)
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Date</label>
                <input type="date" name="date" required class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Time</label>
                @php $time_slot = time_slots();  @endphp
                <select name="time" required class="form-control">
                    @foreach ($time_slot as $time)
                        <option value="{{ $time->id }}">{{ $time->from_time . ' - ' . $time->to_time }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Service</th>
                <th>Agent</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php $g_total = 0; @endphp
            @foreach ($services as $row)
                <tr>
                    <td>{{ $row['service_name'] }}</td>
                    <td>
                        <select name="agent[]" class="form-control">
                            <option value="0">Any Agent</option>
                            @foreach ($row['agents_list'] as $a_row)
                                @php $selected = ($a_row->id == $row['agent']) ? 'selected' : ''; @endphp
                                @php $disabled = ($a_row->booked == '1') ? 'disabled' : ''; @endphp
                                <option value="{{ $a_row->id }}" {{ $selected }} {{ $disabled }}>
                                    {{ $a_row->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>{{ $siteInfo->cur_format }}{{ $row['price'] }}</td>
                    <td>
                        <input type="number" class="form-control change-service-qty" min="1" name="qty[]"
                            max="{{ $row['max_qty'] }}" value="{{ $row['qty'] }}" id="qty{{ $row['service'] }}"
                            data-id="{{ $row['service'] }}">
                        <input type="text" name="service[]" hidden value="{{ $row['service'] }}">
                        <input type="text" class="price" hidden value="{{ $row['price'] }}">
                    </td>
                    <td>{{ $siteInfo->cur_format }}<span class="service-total">{{ $row['price'] * $row['qty'] }}</span>
                    </td>
                    <td><button type="button" class="btn btn-danger remove-service"
                            data-id="{{ $row['service'] }}">X</button></td>
                    @php $g_total += ($row['price']*$row['qty']); @endphp
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Grand Total</th>
                <td>{{ $siteInfo->cur_format }}<span class="grand-total">{{ $g_total }}</span></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <div class="message"></div>
@else
    <div>
        <div class="alert alert-danger mb-2">
            No Services Found
        </div>
        <a href="{{ url('/') }}" class="btn">Select Services</a>
    </div>
@endif
