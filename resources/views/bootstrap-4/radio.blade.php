@php
    $validationClass = $getValidationClass($errors);
    $errorMessage = $getErrorMessage($errors);
    $captionId = $getId() ?: $getDefaultId('radio');
    $isWired = $componentIsWired();
@endphp
<div @class(['mb-3' => $marginBottom, $validationClass => $validationClass])>
    <div>
        <x:form::partials.label class="form-label" :label="$getLabel()"/>
    </div>
    @foreach($group as $groupValue => $groupLabel)
        @php
            $radioId = $getId(suffix: $groupValue) ?: $getDefaultId(prefix: 'radio', suffix: $groupValue);
            $checked = $getGroupModeCheckedStatus($groupValue);
        @endphp
        <div @class(['form-check', 'form-check-inline' => $inline])>
            <input {{ $attributes->merge([
                'wire:model' . $getComponentLivewireModifier() => $isWired && ! $hasComponentNativeLivewireModelBinding() ? $name : null,
                'id' => $radioId,
                'class' => 'form-check-input',
                'name' => $isWired ? null : $name,
                'value' => $groupValue,
                'checked' => $isWired ? null : $checked,
                'aria-describedby' => $caption ? $captionId . '-caption' : null,
            ]) }} type="radio">
            <x:form::partials.label :id="$radioId" class="form-check-label" :label="$groupLabel"/>
        </div>
    @endforeach
    <x:form::partials.caption :inputId="$captionId" :caption="$caption"/>
    <x:form::partials.error-message class="d-block" :message="$errorMessage"/>
</div>
