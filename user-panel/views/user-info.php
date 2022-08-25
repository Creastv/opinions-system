<?php 
$user =  $user = wp_get_current_user();


$array = [
// ['Nazwa użytkownika',  $user->first_name, $user->last_name],
['Imię',  $user->first_name ],
['Nazwisko',  $user->last_name ],
['Adres e-mail',  $user->user_email ],
['Data rejestracji',  $user->user_registered ],
];

foreach ($array as list($a, $b, $c)) {
    if(!empty($b)){
     echo " $a : <strong> $b $c</strong>";
     echo " <br>";
    };
}