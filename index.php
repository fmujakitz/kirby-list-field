<?php


Kirby::plugin('fmujakitz/list-field', [
  // plugin magic happens here
  'fields' => [
    'list-field' => [
      // the field code goes here
      'computed' => [
        'value' => function(): array {
          return Yaml::decode($this->value());
        }
      ]
    ]
  ]
]);
