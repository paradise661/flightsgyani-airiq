{{--{{ dd($rules) }}--}}
@foreach($rules as $rule)
{{--    {{ dd($rule) }}--}}
{{ $rule['pax'] }}
@foreach($rule['rule'] as $r)
{{ $r['title'] }}
{{ $r['text'] }}
@endforeach

@endforeach
