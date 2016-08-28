<?php
$mode = strtolower($mode);
?>

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
                $fieldValueActual = @$object->$fieldName;

                // === SELECT ======================================================================
                $isSelect = isset($fieldArray['select']);
                if ($isSelect) {
                    $selectOptions = $fieldArray['select'];
                    foreach ($fieldArray['select'] as $value => $option) {
                        if ($fieldValue == $value) {
                            $fieldValue = $option;
                            break;
                        }
                    }
                }
                ?>

                {{-- ########## View mode ########## --}}
                @if ($mode === 'view')
                {!! !empty($fieldValue) ? $fieldValue : "<font color='#ccc'>null</font>" !!}
                @endif

                {{-- ########## Show mode ########## --}}
                @if ($mode === 'show')
                <div class="form-group">
                    <label for="{{ $fieldName }}">{{ ucfirst($fieldName) }}:</label>
                    <div class="show-value-div">

                        {{-- Select --}}
                        @if ($isSelect)
                        @foreach ($selectOptions as $value => $option)
                        @if ($fieldValueActual === $value)
                        {!! $option !!}
                        @endif
                        @endforeach

                        {{-- Text --}}
                        @else
                        {!! $fieldValue !!}
                        @endif
                    </div>
                </div>
                @endif

                {{-- ########## Create mode ########## --}}
                @if ($mode === 'create')
                <div class="form-group">
                    <label for="{{ $fieldName }}">{{ ucfirst($fieldName) }}:</label>

                    @if ($isSelect)
                    <select name="{{ $fieldName }}" class="form-control">
                        @foreach ($selectOptions as $value => $option)
                        <option value="{{ $value }}">{!! $option !!}</option>
                        @endforeach
                    </select>
                    @else
                    <input type="text" name="{{ $fieldName }}" class="form-control">
                    @endif
                </div>
                @endif

                {{-- ########## Edit mode ############ --}}
                @if ($mode === 'edit')
                <div class="form-group">
                    <label for="{{ $fieldName }}">{{ ucfirst($fieldName) }}:</label>

                    @if ($isSelect)
                    <select name="{{ $fieldName }}" class="form-control">
                        @foreach ($selectOptions as $value => $option)
                        <option value="{{ $value }}" @if($value === $fieldValueActual) selected="selected" @endif>{!! $option !!}</option>
                        @endforeach
                    </select>
                    @else
                    <input type="text" name="{{ $fieldName }}" 
                           value="{{ $fieldValueActual }}" class="form-control">
                    @endif
                </div>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>