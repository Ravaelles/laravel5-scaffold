<?php
//dump($fields);
//exit;
?>
@foreach ($fields as $fieldName => $fieldArray)
<?php
//var_dump($fieldName);
//var_dump($object);
//dd($object->$fieldName);
?>
<td>
    <?php
    $fieldValue = $object->$fieldName;
    if (isset($fieldArray['select'])) {
        foreach ($fieldArray['select'] as $value => $option) {
            if ($fieldValue == $value) {
                $fieldValue = $option;
                break;
            }
        }
    }
    ?>
    {!! !empty($fieldValue) ? $fieldValue : "<font color='#ccc'>null</font>" !!}
</td>
@endforeach