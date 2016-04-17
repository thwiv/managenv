<tr>
    <td>
        {{ $var->name }}
    </td>
    <td>
        <input type="text" class="form-control var-value" value="{{ $var->value }}" data-name="{{ $var->name }}" />
    </td>
    <td>
        @if($show_delete)
            <button class="btn btn-danger del" data-id="{{ $var->id }}">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        @endif
    </td>
</tr>