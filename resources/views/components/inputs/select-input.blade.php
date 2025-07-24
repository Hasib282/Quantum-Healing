<div class="form-input-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $id }}" class="{{ $small ? 'input-small' : 'form-input' }}">
        @if($options)
            <option value="">Select {{ $label }}</option>
            @foreach($options as $key => $text)
                <option value="{{ $key }}" {{ old($name) == $key || (isset($selected) && $selected == $key) ? 'selected' : '' }}>
                    {{ $text }}
                </option>
            @endforeach
        @endif
    </select>
    <span class="error" id="{{ $update ? 'update_' . $name . '_error' : $name . '_error' }}"></span>
</div>