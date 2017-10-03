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

    // If is not special case - display custom view for this field
    if (!isset($fieldArray['view'])) {

        // === SELECT ======================================================================
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
        <?php
    } else {
        ?>
            @include($fieldArray['view'])
        <?php
    }
    ?>
</td>
@endforeach