@component('mail::message')
# Introduction

Login: {{ $client['email'] }}<br>
Senha: {{ $client['pass'] }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
