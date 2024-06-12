<div class="modal fade" id="singleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="appointmentForm" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Book Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12 mb-3">
                            <label class="form-label">Services</label>
                            <select class="form-control" id="serviceSelect" name="service" required>
                                <option value="" selected disabled>Select Service</option>
                                @php $services = all_services(); @endphp
                                @foreach ($services as $types)
                                    <option value="{{ $types->id }}">{{ $types->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('service'))
                                <div class="alert alert-danger">{{ $errors->first('service') }}</div>
                            @endif
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Persons</label>
                            <input type="number" class="form-control" id="personSelect" name="person" min="1"
                                max="" value="1">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" id="dateSelect" name="date"
                                min="{{ date('Y-m-d') }}" placeholder="Please Enter Date" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Time</label>
                            <select class="form-control" name="time" id="timeSelect" required>
                                <option value="" selected disabled>Select The Time Slot</option>
                                @php $time = time_slots(); @endphp
                                @foreach ($time as $types)
                                    <option value="{{ $types->id }}">{{ $types->from_time }} - {{ $types->to_time }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('time'))
                                <div class="alert alert-danger">{{ $errors->first('time') }}</div>
                            @endif
                        </div>
                        <div class="agentsList service-agents-radio"></div>
                    </div>
                    <div class="message"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save to My Services</button>
                </div>
            </form>
        </div>
    </div>
</div>
