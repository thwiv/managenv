<tr>
    <td>
        {{ $var->name }}
    </td>
    <td>
        <input type="text" class="form-control var-value" value="{{ $var->value }}" data-name="{{ $var->name }}" data-env="{{ $var->environment_id }}" />
    </td>
    <td>
        @if($show_delete)
            <button class="btn btn-danger del-value" data-id="{{ $var->id }}" data-env="{{ $var->environment_id }}">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        @endif
    </td>
</tr>