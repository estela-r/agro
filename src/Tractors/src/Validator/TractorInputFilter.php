<?php
declare(strict_types=1);

namespace Tractors\Validator;


use Zend\Filter\StringTrim;
use Zend\Filter\ToFloat;
use Zend\InputFilter\InputFilter;
use Zend\Validator\GreaterThan;
use Zend\Validator\StringLength;

class TractorInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class]
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => ['min' => 3],
                ]
            ]
        ]);
    }
}