<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ (isset($site->primary_logo))?$site->logo:asset('frontend/images/logo.png') }}" class="logo" alt="{{ config('app.name') }}">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
