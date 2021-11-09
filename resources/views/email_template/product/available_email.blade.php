@component('mail::message')
<h1>Good News {{$user['name']}} !!!</h1>
<p> The {{$product['name']}} , You’ve Been Waiting For Is Now Available For Purchase!!!
<br>
<?php 
if(isset($product['image'])){ ?>
<img src="{{ asset('/'.$product['image'])}}" style="width:200px;height:300px">
<?php
}
?>
<br>
As promised, we are here to take you to your favorite item!
</p>

<p>
@component('mail::button', ['url' => $productLink, 'color' => 'green'])
Awesome!!! Take me to the store!
@endcomponent
<br>
</p>

See you there!
<br>
Best regards, The Digible team

@endcomponent