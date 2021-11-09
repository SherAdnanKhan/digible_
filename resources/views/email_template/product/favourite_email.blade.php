@component('mail::message')
<h1>Hello {{$user['name']}},</h1>
<p>
{{$product['name']}} has been marked as your Favorite item and it will be available for purchase on {{$date}} onwards.
<br>
Digible platform won’t let you miss any updates about it!
<br>
You will receive an email as soon as {{$product['name']}} is available for purchase. Until then, you can always check out other items.
</p>

<p>
@component('mail::button', ['url' => $productLink, 'color' => 'green'])
Verify Other Items
@endcomponent
<br>
We can’t wait for you to start using your favorite {{$product['name']}}.
</p>

 
Have a great day!
The Digible team

@endcomponent