<table class="table table-condensed table-striped">
    <tbody>
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
        <tr>
            <td>
                <?php
                $fieldValue = @$object->$fieldName;
                if (isset($fieldArray['select'])) {
                    foreach ($fieldArray['select'] as $value => $option) {
                        if ($fieldValue == $value) {
                            $fieldValue = $option;
                            break;
                        }
                    }
                }
                ?>

                @if (isset($object))
                {!! !empty($fieldValue) ? $fieldValue : "<font color='#ccc'>null</font>" !!}
                @else
                <div class="form-group">
                    <label for="{{ $fieldName }}">{{ ucfirst($fieldName) }}:</label>
                    <input type="{{ $fieldName }}" class="form-control">
                </div>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>