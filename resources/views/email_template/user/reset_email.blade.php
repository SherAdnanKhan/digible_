@component('mail::message')
<h1>Hi {{$user['name']}},</h1>
<p>There was a request to change your password!
If you did not make this request, then please ignore this email.
</p>

 
<p>Otherwise, please click this link to change your password:
@component('mail::button', ['url' => $passwordResetUrl])
Reset Email
@endcomponent</p>
 
Best regards,<br>
the Digible team

@endcomponent