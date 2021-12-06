@component('mail::message')
<h1>Hi {{$user['name']}},</h1>
<p>There was a request to change your password! <br>
If you did not make this request, then please ignore this email.
</p>

 
<p>Otherwise, please click this link to change your password:
@component('mail::button', ['url' => $passwordResetUrl, 'color' => 'green'])
Reset Password
@endcomponent</p>
 
Best regards, the Digible team

@endcomponent