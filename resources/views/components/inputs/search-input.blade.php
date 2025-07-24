<div class="form-input-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <input type="text" name="{{ $name }}" class="{{ $small ? 'input-small' : 'form-input' }}" id="{{ $id }}" autocomplete="off"><hr>
    <div id="{{ $update ? 'update-' . $name : $name . '-list' }}"></div>
    <span class="error" id="{{ $update ? 'update_' . $name . '_error' : $name . '_error' }}"></span>
</div>
