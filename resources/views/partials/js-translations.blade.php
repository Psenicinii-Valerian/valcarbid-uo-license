{{-- Exposes the translation strings needed by client-side JS to the current locale. --}}
@php
    $jsTranslations = [
        'Not Any' => __('Not Any'),
        'Any' => __('Any'),
        'Electricity' => __('Electricity'),
        '3 Cylinders' => __('3 Cylinders'),
        '4 Cylinders' => __('4 Cylinders'),
        '6 Cylinders' => __('6 Cylinders'),
        '8 Cylinders' => __('8 Cylinders'),
        '12 Cylinders' => __('12 Cylinders'),
        'Gasoline' => __('Gasoline'),
        'Diesel' => __('Diesel'),
        'Ethanol' => __('Ethanol'),
        'Hybrid' => __('Hybrid'),
        'Automatic' => __('Automatic'),
        'Manual' => __('Manual'),
        'CVT' => __('CVT'),
        'Select Make' => __('Select Make'),
        'Select Model' => __('Select Model'),
        'Select Year' => __('Select Year'),
        'Refine Options' => __('Refine Options'),
        'Choose your car images' => __('Choose your car images'),
        "Choose your car's main image" => __("Choose your car's main image"),
        'Main image selected!' => __('Main image selected!'),
        'Successfully added' => __('Successfully added'),
        'image!' => __('image!'),
        'images!' => __('images!'),
    ];
@endphp

<script type="application/json" id="app-i18n-data">@json($jsTranslations)</script>
<script>
    window.i18n = JSON.parse(document.getElementById('app-i18n-data').textContent);

    // Tiny translation helper for client-side strings. Falls back to the key (English).
    window.__ = function (key) {
        return (window.i18n && window.i18n[key]) || key;
    };
</script>
