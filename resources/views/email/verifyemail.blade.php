@component('mail::message')
    <p>تفيعل الحساب {!! $user->name !!}</p>
    @component('mail::button',['url'=>url('api/'.$user->remember_token.'/verify')])
         تفعيل الحساب
    @endcomponent
    {!! config('app.name') !!}
@endcomponent
