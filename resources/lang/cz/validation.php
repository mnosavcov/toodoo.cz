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

    'accepted'             => 'Pole :attribute musí být zaškrtnuto.',
    'active_url'           => 'Pole :attribute naní platné URL.',
    'after'                => 'Pole :attribute musí být datum větší než :date.',
    'alpha'                => 'Pole :attribute smí obsahovat pouze písmena.',
    'alpha_dash'           => 'Pole :attribute smí obsahovat pouze písmena, čísla a pomlčky.',
    'alpha_num'            => 'Pole :attribute smí obsahovat pouze písmena a číslas.',
    'array'                => 'Pole :attribute musí být typu array.',
    'before'               => 'Pole :attribute musí být datum nižší než :date.',
    'between'              => [
        'numeric' => 'Pole :attribute musí být mezi :min a :max.',
        'file'    => 'Pole :attribute musí být mezi :min a :max kB.',
        'string'  => 'Pole :attribute musí být mezi :min a :max znaky.',
        'array'   => 'Pole :attribute musí být mezi :min a :max polžkami.',
    ],
    'boolean'              => 'Pole :attribute smí být true nebo false.',
    'confirmed'            => 'Kontrola pro pole :attribute nesouhlasí.',
    'date'                 => 'Pole :attribute není platné datum.',
    'date_format'          => 'Pole :attribute nemá validní formát :format.',
    'different'            => 'Pole :attribute a :other musí být rozdílné.',
    'digits'               => 'Pole :attribute musí být :digits čísel.',
    'digits_between'       => 'Pole :attribute musí mít mezi :min a :max číslicemi.',
    'distinct'             => 'Pole :attribute obsahuje duplicitní hodnoty.',
    'email'                => 'Pole :attribute musí být platná emailová adresa.',
    'exists'               => 'Vybrané pole :attribute není validní.',
    'filled'               => 'Pole :attribute je povinné.',
    'image'                => 'Pole :attribute musí být obrázek.',
    'in'                   => 'Vybrané pole :attribute je nevalidní.',
    'in_array'             => 'Pole :attribute neexistuje :other.',
    'integer'              => 'Pole :attribute musí být celé číslo.',
    'ip'                   => 'Pole :attribute musí být platná IP adresa.',
    'json'                 => 'Pole :attribute musí být validní JSON.',
    'max'                  => [
        'numeric' => 'Pole :attribute musí být menší než :max.',
        'file'    => 'Pole :attribute musí být menší než :max kB.',
        'string'  => 'Pole :attribute musí být menší než :max znaků.',
        'array'   => 'Pole :attribute musí mít více než :max položek.',
    ],
    'mimes'                => 'Pole :attribute musí být soubor typu: :values.',
    'min'                  => [
        'numeric' => 'Pole :attribute musí být větší než :min.',
        'file'    => 'Pole :attribute musí být větší než :min kB.',
        'string'  => 'Pole :attribute musí mít alespoň :min znaků.',
        'array'   => 'Pole :attribute musí mít více než :min položek.',
    ],
    'not_in'               => 'Vybrané pole :attribute není validní.',
    'numeric'              => 'Pole :attribute musí být číslo.',
    'present'              => 'Pole :attribute musí existovat.',
    'regex'                => 'Pole :attribute má neplatný formát.',
    'required'             => 'Pole :attribute je povinné.',
    'required_if'          => 'Pole :attribute je povinné když :other je :value.',
    'required_unless'      => 'Pole :attribute je povinné pokud :other má hodnotu :values.',
    'required_with'        => 'Pole :attribute je povinné když :values existuje.',
    'required_with_all'    => 'Pole :attribute je povinné když :values existuje.',
    'required_without'     => 'Pole :attribute je povinné když :values neexistuje.',
    'required_without_all' => 'Pole :attribute je povinné pokud žádná z :values neexistuje.',
    'same'                 => 'Pole :attribute a :other musí být stejné.',
    'size'                 => [
        'numeric' => 'Pole :attribute musí být :size.',
        'file'    => 'Pole :attribute musí být :size kB.',
        'string'  => 'Pole :attribute musí být :size znaků.',
        'array'   => 'Pole :attribute musí mít :size položek.',
    ],
    'string'               => 'Pole :attribute musí být řetězec.',
    'timezone'             => 'Pole :attribute musí být platná zóna.',
    'unique'               => 'Hodnota pole :attribute je již použítá.',
    'url'                  => 'Pole :attribute má nevalidní formát.',

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

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

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
        'password'=>'heslo'
    ],

];
