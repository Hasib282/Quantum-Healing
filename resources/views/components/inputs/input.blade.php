<div class="form-input-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <input type="text" name="{{ $name }}" class="{{ $small ? 'input-small' : 'form-input' }}" id="{{ $id }}">
    <span class="error" id="{{ $update ? 'update_' . $name . '_error' : $name . '_error' }}"></span>
</div>