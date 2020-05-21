<?php

return [
    'presenter' => 'Laraplus\Form\Presenters\Bootstrap4Presenter',
    'style'     => 'horizontal',
    'styles'    => [
        'horizontal' => [
            'form'           => 'form-horizontal',
            'label'          => 'col-md-3 control-label',
            'element'        => 'col-md-9',
            'no_label'       => 'col-md-12 offset-md-3 text-left',
            'required'       => ' *',
            'success-status' => true
        ],
        'vertical'   => [
            'form'           => null,
            'label'          => null,
            'element'        => null,
            'required'       => ' *',
            'success-status' => true
        ],
        'inline'     => [
            'form'           => 'form-inline',
            'label'          => null,
            'element'        => null,
            'required'       => ' *',
            'success-status' => true
        ]
    ]
];
