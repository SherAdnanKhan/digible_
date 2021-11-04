@component('mail::message')
<h1>Hello {{$user['name']}},</h1>
<p>
Are you ready to gain access to all of the assets we prepared for Digible Clients?
<br>
We need a little more information to complete your registration, including a confirmation of your email address. 
</p>

<p>
Click below to confirm your email address:
@component('mail::button', ['url' => $url, 'color' => 'green'])
Verify Email
@endcomponent
<br>
This link will verify your email address, and then you will officially be a part of the Digible community.
</p>

 
See you there!

Best regards, the Digible team

@endcomponent