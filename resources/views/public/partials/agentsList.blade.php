{{-- <ul>
@if ($agents)
        <li>
            <input type="radio" value="0" name="agent" checked id="agent0"><label for="agent0">Any Agent</label>
        </li>
        @foreach ($agents as $agent)
        <li>
            <input type="radio" value="{{$agent->id}}" name="agent" id="agent{{$agent->id}}"><label for="agent{{$agent->id}}">{{$agent->name}}</label>
            {{-- @if ($agent->avail_space >= $agent->appointment_count) 
            <small>Booked</small>
            @endif --}}
{{-- </li>     --}}
{{-- @endforeach --}}
{{-- @else --}}
{{-- <li>No Agents Found</li>         --}}
{{-- @endif 
</ul> --}}
<ul>
    @if ($agents)
        @php $avail = 0; @endphp
        @foreach ($agents as $agent)
            <li>
                <input type="radio" name="agent" @if ($agent->booked == '1') disabled @endif
                    value="{{ $agent->id }}" id="agent{{ $agent->id }}">
                <label for="agent{{ $agent->id }}">
                    <img src="{{ asset('public/agents/' . $agent->agent_image) }}" alt="">
                    <span>{{ $agent->name }}</span>
                </label>
            </li>
            @if ($agent->booked == '0')
                @php $avail++; @endphp
            @endif
        @endforeach
        @if ($avail > 0)
            <li>
                <input type="radio" name="agent" value="0" checked id="agent0">
                <label for="agent0">
                    <img src="{{ asset('public/agents/default.png') }}" alt="">
                    <span>Any Agent</span>
                </label>
            </li>
        @endif
    @endif
</ul>
