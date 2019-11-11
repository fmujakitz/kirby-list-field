<?php


Kirby::plugin('fmujakitz/list-field', [
  // plugin magic happens here
  'fields' => [
    'list-field' => [
      // the field code goes here
      'props' => [
        'value' => function($value = '') {

          if (strlen($value) == 0) return [];

          /**
           * Helpers
           */
          function isMulti($str) {
            return $str == "- >";
          }
          
          function isSingle($str) {
            return !isMulti($str) && Str::startsWith($str, "- ") ? 1 : 0;
          }
          
          /**
           * Transform stored value to regular array
           */
          $result = [];
          $list = explode("\n", $value);
          
          for ($i = 0; $i < count($list); $i++) { 
            $row = $list[$i];
            
            /**
             * Single row starts with '- '
             * trim and collect element
             */
            if (isSingle($row)) {
              $result[] = Str::trim($row, "- ");
              continue;
            }

            /**
             * Multi row is marked by '- >'
             * ignore the mark, collect empty element
             */
            if (isMulti($row)) {
              $result[] = "";
              continue;
            }
            
            /**
             * Multi row content is marked by '  '
             * trim and collect to previous element
             */
            $idx = count($result) - 1;

            $prev = $result[$idx];
            $curr = Str::trim($row, "  ");

            $result[$idx] = strlen($prev)
              ? join([$prev, $curr], " ")
              : $curr;                
          }

          /**
           * Finally, return the array
           */
          return $result;
        }
      ]
    ]
  ]
]);
