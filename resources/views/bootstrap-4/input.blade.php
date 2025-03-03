@foreach($locales as $locale)
    @php
        $id = $getId($locale) ?: $getDefaultId($type, $locale);
        $label = $getLabel($locale);
        $displayFloatingLabel = $shouldDisplayFloatingLabel();
        $placeholder = $getPlaceholder($label, $locale);
        $value = $getValue($locale);
        $prepend = $getPrepend($locale);
        $append = $getAppend($locale);
        $errorMessage = $getErrorMessage($errors, $locale);
        $validationClass = $getValidationClass($errors, $locale);
        $isWired = $componentIsWired();
    @endphp
    <div @class(['d-none' => $type === 'hidden', 'form-floating' => $displayFloatingLabel, 'mb-3' => $marginBottom])>
        @if(($prepend || $append) && ! $displayFloatingLabel)
            <x-form::partials.label :id="$id" class="$type === 'file' ? 'custom-file-label' : 'form-label'" :label="$label"/>
            <div class="input-group">
        @endif
            @if(! $prepend && ! $append && ! $displayFloatingLabel && $type !== 'file')
                <x-form::partials.label :id="$id" :class="$type === 'file' ? 'custom-file-label' : 'form-label'" :label="$label"/>
            @endif
            @if($prepend && ! $displayFloatingLabel)
                <div class="input-group-prepend">
                    <x-form::partials.addon :addon="$prepend"/>
                </div>
            @endif
            @if($type === 'file')
                <div class="custom-file">
            @endif
                <input {{ $attributes->except('wire')->merge([
                    'wire:model' . $getComponentLivewireModifier() => $isWired && ! $hasComponentNativeLivewireModelBinding() ? ($locale ? $name . '.' . $locale : $name) : null,
                    'id' => $id,
                    'class' => ($type === 'file' ? 'custom-file-input' : 'form-control') . ($validationClass ? ' ' . $validationClass : null),
                    'type' => $type,
                    'name' => $isWired ? null : ($locale ? $name . '[' . $locale . ']' : $name),
                    'placeholder' => $placeholder,
                    'data-locale' => $locale,
                    'value' => $isWired ? null : ($value ?? ''),
                    'aria-describedby' => $caption ? $id . '-caption' : null,
                ]) }}/>
            @if(! $prepend && ! $append && ($displayFloatingLabel || $type === 'file'))
                <x-form::partials.label :id="$id" :class="$type === 'file' ? 'custom-file-label' : 'form-label'" :label="$label"/>
            @endif
            @if($type === 'file')
                </div>
            @endif
            @if($append && ! $displayFloatingLabel)
                <div class="input-group-append">
                    <x-form::partials.addon :addon="$append"/>
                </div>
            @endif
            <x-form::partials.caption :inputId="$id" :caption="$caption"/>
            <x-form::partials.error-message :message="$errorMessage"/>
        @if(($prepend || $append) && ! $displayFloatingLabel)
            </div>
        @endif
    </div>
@endforeach
