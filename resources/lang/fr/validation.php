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

    'accepted' => 'Le :attribute doit être accepté.',
    'active_url' => ':attribute n\'est pas une URL valide.',
    'after' => ':attribute doit être une date après :date.',
    'after_or_equal' => ':attribute doit être en même temps ou après :date.',
    'alpha' => ':attribute ne doit contenir que des lettres.',
    'alpha_dash' => ':attribute ne doit contenir que des lettres, des chiffres, des "-" et des "_".',
    'alpha_num' => ':attribute ne doit contenir que des lettres et des chiffres.',
    'array' => ':attribute doit être une liste.',
    'before' => ':attribute doit être une date avant :date.',
    'before_or_equal' => ':attribute doit être une date avant ou égal à :date.',
    'between' => [
        'numeric' => ':attribute doit être entre :min et :max.',
        'file' => ':attribute doit être entre :min et :max ko.',
        'string' => ':attribute doit contenir entre :min et :max caractères.',
        'array' => ':attribute doit avoir entre :min et :max objets.',
    ],
    'boolean' => ':attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation de :attribute ne correspond pas.',
    'date' => ':attribute n\'est pas une date valide.',
    'date_equals' => ':attribute doit être une date égal à :date.',
    'date_format' => ':attribute ne correspond pas au format :format.',
    'different' => ':attribute et :other doivent être différents.',
    'digits' => ':attribute doit avoir :digits chiffres.',
    'digits_between' => ':attribute doit avoir entre :min et :max chiffres.',
    'dimensions' => ':attribute a des dimensions invalides.',
    'distinct' => ':attribute existe déjà.',
    'email' => ':attribute doit être une email valide.',
    'ends_with' => ':attribute doit se terminer: :values.',
    'exists' => ':attribute n\'existe pas.',
    'file' => ':attribute doit être un fichier.',
    'filled' => ':attribute ne doit pas être vide.',
    'gt' => [
        'numeric' => ':attribute doit être supérieur à :value.',
        'file' => ':attribute doit faire plus de :value ko.',
        'string' => ':attribute doit contenir plus de :value caractères.',
        'array' => ':attribute doit avoir plus de :value objets.',
    ],
    'gte' => [
        'numeric' => ':attribute doit être supérieur ou égal à :value.',
        'file' => ':attribute doit faire au moins :value ko.',
        'string' => ':attribute doit contenir au moins :value caractères.',
        'array' => ':attribute doit avoir au moins :value objets.',
    ],
    'image' => ':attribute doit être une image.',
    'in' => ':attribute n\'est pas valide.',
    'in_array' => ':attribute n\'existe pas dans :other.',
    'integer' => ':attribute doit être un nombre entier.',
    'ip' => ':attribute doit être une IP valide.',
    'ipv4' => ':attribute doit être une adresse IPv4 valide.',
    'ipv6' => ':attribute doit être une adresse IPv6 valide.',
    'json' => ':attribute doit être une JSON valide.',
    'lt' => [
        'numeric' => ':attribute doit être inférieur à :value.',
        'file' => ':attribute ne doit pas faire plus de :value ko.',
        'string' => ':attribute doit faire moins de :value caractères.',
        'array' => ':attribute doit avoir moins de :value objets.',
    ],
    'lte' => [
        'numeric' => ':attribute doit être inférieur ou égal à :value.',
        'file' => ':attribute ne peut pas faire plus de :value ko.',
        'string' => ':attribute ne peut pas avoir plus de :value caractères.',
        'array' => ':attribute ne peut pas avoir plus de :value objets.',
    ],
    'max' => [
        'numeric' => ':attribute ne peut pas être supérieur à :max.',
        'file' => ':attribute ne doit pas faire plus de :max ko.',
        'string' => ':attribute ne doit pas avoir plus de :max caractères.',
        'array' => ':attribute ne doit pas avoir plus de :max objets.',
    ],
    'mimes' => ':attribute doit être un fichier de type: :values.',
    'mimetypes' => ':attribute doit être un fichier de type: :values.',
    'min' => [
        'numeric' => ':attribute doit être au moins égal à :min.',
        'file' => ':attribute doit faire au moins :min ko.',
        'string' => ':attribute doit avoir au moins :min caractères.',
        'array' => ':attribute doit avoir au moins :min objets.',
    ],
    'not_in' => ':attribute est invalide.',
    'not_regex' => 'Le format de :attribute est invalide.',
    'numeric' => ':attribute doit être un nombre.',
    'password' => 'Le mot de passe est incorrect.',
    'present' => ':attribute doit être présent.',
    'regex' => 'Le format de :attribute est invalide.',
    'required' => ':attribute est requis.',
    'required_if' => ':attribute est requis quand :other est :value.',
    'required_unless' => ':attribute est requis uniquement si :other fait parti de :values.',
    'required_with' => ':attribute est requis lorsque :values est présent.',
    'required_with_all' => ':attribute est requis lorsque :values sont présents.',
    'required_without' => ':attribute est requis lorsque :values n\'est pas présent.',
    'required_without_all' => ':attribute est requis lorsque :values ne sont pas présents.',
    'same' => ':attribute et :other doivent être identiques.',
    'size' => [
        'numeric' => ':attribute doit être égal à :size.',
        'file' => ':attribute doit faire :size ko.',
        'string' => ':attribute doit contenir :size caractères.',
        'array' => ':attribute doit contenir :size objets.',
    ],
    'starts_with' => ':attribute doit commencer par: :values.',
    'string' => ':attribute doit être une chaine de caractères.',
    'timezone' => ':attribute doit être une zone valide.',
    'unique' => ':attribute est déjà pris.',
    'uploaded' => 'Impossible d\'uploader :attribute.',
    'url' => 'Le format de :attribute est invalide.',
    'uuid' => ':attribute doit être un UUID valide.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
