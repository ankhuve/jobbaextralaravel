<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    "accepted"         => ":attribute måste accepteras.",
    "active_url"       => ":attribute är inte en korrekt URL.",
    "after"            => ":attribute måste vara ett datum efter :date.",
    "alpha"            => ":attribute kan bara innehålla bokstäver.",
    "alpha_dash"       => ":attribute kan bara innehålla bokstäver, siffror, och bindestreck.",
    "alpha_num"        => ":attribute kan bara innehålla bokstäver och siffror.",
    "array"            => ":attribute måste vara en array.",
    "before"           => ":attribute måste vara ett datum innan :date.",
    "between"          => [
        "numeric" => ":attribute måste vara mellan :min och :max.",
        "file"    => ":attribute måste vara mellan :min och :max kb.",
        "string"  => ":attribute måste vara mellan :min och :max tecken.",
        "array"   => ":attribute måste ha mellan :min och :max värden.",
    ],
    "confirmed"        => ":attribute måste bekräftas.",
    "date"             => ":attribute är inte ett giltigt datum.",
    "date_format"      => ":attribute måste ha formatet :format.",
    "different"        => ":attribute och :other kan inte vara samma.",
    "digits"           => ":attribute måste vara :digits siffror.",
    "digits_between"   => ":attribute måste vara mellan :min och :max siffror.",
    "email"            => ":attribute är inte en giltig e-postadress.",
    "exists"           => ":attribute existerar inte.",
    "image"            => ":attribute måste vara en bild.",
    "in"               => ":attribute är inte ett giltigt val.",
    "integer"          => ":attribute måste vara ett heltal.",
    "ip"               => ":attribute måste vara en giltig IP-adress.",
    "max"              => [
        "numeric" => ":attribute kan inte vara störra än :max.",
        "file"    => ":attribute får inte överskrida :max kb.",
        "string"  => ":attribute kan vara max :max tecken.",
        "array"   => ":attribute kan inte innehålla fler än :max värden.",
    ],
    "mimes"            => ":attribute måste vara av typen :values.",
    "min"              => [
        "numeric" => ":attribute måste vara minst :min.",
        "file"    => ":attribute måste vara minst :min kb.",
        "string"  => ":attribute måste vara minst :min tecken.",
        "array"   => ":attribute måste ha minst :min värden.",
    ],
    "not_in"           => "Det valda fältet :attribute är ogiltigt.",
    "numeric"          => ":attribute måste vara ett giltigt nummer.",
    "regex"            => ":attribute har fel format.",
    "required"         => ":attribute kan inte vara tom.",
    "required_if"      => ":attribute kan inte vara tom om :other är :value.",
    "required_with"    => ":attribute kan inte vara tom om :values är satt.",
    "required_without" => ":attribute kan inte vara tom om :values är tom.",
    "same"             => ":attribute stämmer inte överrens med :other.",
    "size"             => [
        "numeric" => ":attribute måste vara :size.",
        "file"    => ":attribute måste vara :size kb.",
        "string"  => ":attribute måste bestå utav :size tecken.",
        "array"   => ":attribute måste innehålla :size värden.",
    ],
    "unique"           => ":attribute är redan taget.",
    "url"              => ":attribute måste vara en giltig URL.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'Namn',
        'email' => 'Email',
        'message' => 'Meddelande',
        'password' => 'Lösenord',
        'width' => 'Bredd',
        'height' => 'Höjd'
    ],

];