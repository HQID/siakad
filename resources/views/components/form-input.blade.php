@props(['name', 'label', 'type' => 'text', 'value' => '', 'required' => false, 'placeholder' => '', 'options' => []])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }} @if($required) <span class="text-danger">*</span> @endif</label>
    
    @if($type === 'textarea')
        <textarea 
            name="{{ $name }}" 
            id="{{ $name }}" 
            class="form-control @error($name) is-invalid @enderror" 
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes }}
        >{{ old($name, $value) }}</textarea>
    @elseif($type === 'select')
        <select 
            name="{{ $name }}" 
            id="{{ $name }}" 
            class="form-select @error($name) is-invalid @enderror"
            {{ $required ? 'required' : '' }}
            {{ $attributes }}
        >
            <option value="">Select {{ $label }}</option>
            @foreach($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
    @elseif($type === 'checkbox')
        <div class="form-check">
            <input 
                type="checkbox" 
                name="{{ $name }}" 
                id="{{ $name }}" 
                class="form-check-input @error($name) is-invalid @enderror" 
                value="1"
                {{ old($name, $value) ? 'checked' : '' }}
                {{ $attributes }}
            >
            <label class="form-check-label" for="{{ $name }}">{{ $placeholder }}</label>
        </div>
    @elseif($type === 'radio')
        @foreach($options as $optionValue => $optionLabel)
            <div class="form-check">
                <input 
                    type="radio" 
                    name="{{ $name }}" 
                    id="{{ $name }}_{{ $optionValue }}" 
                    class="form-check-input @error($name) is-invalid @enderror" 
                    value="{{ $optionValue }}"
                    {{ old($name, $value) == $optionValue ? 'checked' : '' }}
                    {{ $required ? 'required' : '' }}
                    {{ $attributes }}
                >
                <label class="form-check-label" for="{{ $name }}_{{ $optionValue }}">{{ $optionLabel }}</label>
            </div>
        @endforeach
    @else
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            class="form-control @error($name) is-invalid @enderror" 
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes }}
        >
    @endif
    
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>