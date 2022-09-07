<?php 
$array = [
// ['Nazwa użytkownika',  $user->first_name, $user->last_name],
    ['Imię', $current_user->first_name ],
    ['Nazwisko', $current_user->last_name ],
    ['Adres e-mail', $current_user->user_email ],
    ['Data rejestracji', $current_user->user_registered ],
];

foreach ($array as list($a, $b, $c)) {
    if(!empty($b)){
     echo " $a : <strong> $b $c</strong>";
     echo " <br>";
    };
}