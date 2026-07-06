@extends('layouts.layout')

@section('doc_scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src='{{ asset('js/index-listings-styling.js') }}' defer></script>
    <script src='{{ asset('js/index-filter-car-type-trigger.js') }}' defer></script>
    <script src='{{ asset('js/index-refine-options-trigger.js') }}' defer></script>
    <script src='{{ asset('js/index-expire-time-trigger.js') }}' defer></script>
    <script src='{{ asset('js/success-message-trigger.js') }}' defer></script>
    <script src='{{ asset('js/warning-message-trigger.js') }}' defer></script>
@endsection

@section('doc_title', __('Home'))
@section('doc_body')
    @if (session('success_msg'))
        <p id="success" class="index-success-msg">
            <i class="fa-solid fa-check"></i>
            {{ session('success_msg') }}
        </p>
    @elseif (session('warning'))
        <p id="warning" class="index-warning-msg">
            <i class="fa-solid fa-xmark"></i>
            {{ session('warning') }}
        </p>
    @endif
    <div class="refine-trigger">
        <p class="refine-options">{{ __('Refine Options') }} <i class="fa fa-chevron-down"></i></p>
    </div>
    <div class="notification-bell">
        <a href="user-messages">
            @if (count($winnerMessages) > 0 || count($sellerMessages) > 0)
                <i class="fa-regular fa-bell fa-bounce fa-xl"></i>
            @else
                <i class="fa-regular fa-bell fa-xl"></i>
            @endif
        </a>
    </div>
    <form action="/" method="GET" class="search-sort-filter" id="listings_form">
        <div class="filter-search-sort">
            <!-- Filter -->
            <div class="filter" id="filterOptions">
                <div class="group-1">
                    <!-- Type Filter -->
                    <div class="filter-item type-filter">
                        <label for="type-filter">{{ __('Type:') }}</label>
                        <select name="type-filter" id="type-filter">
                            @foreach ($filters['typeFilters'] as $value => $optionLabel)
                                <option value="{{ $value }}" @if (request('type-filter') == $value) selected @endif>
                                    {{ __($optionLabel) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Year Filter -->
                    <div class="filter-item year-filter">
                        <label for="year-filter">{{ __('Year:') }}</label>
                        <select name="year-filter" id="year-filter">
                            @foreach ($filters['yearFilters'] as $value => $optionLabel)
                                <option value="{{ $value }}" @if (request('year-filter') == $value) selected @endif>
                                    {{ __($optionLabel) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="group-2">
                    <!-- Crashes Filter -->
                    <div class="filter-item crashes-filter">
                        <label for="crashes-filter">{{ __('Crashes:') }}</label>
                        <select name="crashes-filter" id="crashes-filter">
                            @foreach ($filters['crashesFilters'] as $value => $optionLabel)
                                <option value="{{ $value }}" @if (request('crashes-filter') == $value) selected @endif>
                                    {{ __($optionLabel) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Transmission Type Filter -->
                    <div class="filter-item transmission-type-filter">
                        <label for="transmission-type-filter">{{ __('Transmission Type:') }}</label>
                        <select name="transmission-type-filter" id="transmission-type-filter">
                            @foreach ($filters['transmissionTypeFilters'] as $value => $optionLabel)
                                <option value="{{ $value }}" @if (request('transmission-type-filter') == $value) selected @endif>
                                    {{ __($optionLabel) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="group-3">
                    <!-- Body Filter -->
                    <div class="filter-item body-filter">
                        <label for="body-filter">{{ __('Body:') }}</label>
                        <select name="body-filter" id="body-filter">
                            @foreach ($filters['bodyFilters'] as $value => $optionLabel)
                                <option value="{{ $value }}" @if (request('body-filter') == $value) selected @endif>
                                    {{ __($optionLabel) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Fuel Type Filter -->
                    <div class="filter-item fuel-type-filter">
                        <label for="fuel-type-filter">{{ __('Fuel Type:') }}</label>
                        <select name="fuel-type-filter" id="fuel-type-filter">
                            @foreach ($filters['fuelTypeFilters'] as $value => $optionLabel)
                                <option value="{{ $value }}" @if (request('fuel-type-filter') == $value) selected @endif>
                                    {{ __($optionLabel) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="group-4">
                    <!-- Displacement Filter -->
                    <div class="filter-item displacement-filter">
                        <label for="displacement-filter">{{ __('Displacement:') }}</label>
                        <select name="displacement-filter" id="displacement-filter">
                            @foreach ($filters['displacementFilters'] as $value => $optionLabel)
                                <option value="{{ $value }}" @if (request('displacement-filter') == $value) selected @endif>
                                    {{ __($optionLabel) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Battery Capacity Filter -->
                    <div class="filter-item battery-capacity-filter">
                        <label for="battery-capacity-filter">{{ __('Battery Capacity:') }}</label>
                        <select name="battery-capacity-filter" id="battery-capacity-filter">
                            @foreach ($filters['batteryCapacityFilters'] as $value => $optionLabel)
                                <option value="{{ $value }}" @if (request('battery-capacity-filter') == $value) selected @endif>
                                    {{ __($optionLabel) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="search-sort">
                <!-- Reset All Refines For >= XL Screens -->
                <a class="reset-xl reset" href="/">{{ __('Reset') }}</a>

                <!-- Sort -->
                <div class="sort">
                    <label for="listing-sort">{{ __('Sort by:') }}</label>
                    <select name="listing-sort" id="listing-sort">
                        @foreach ($listingSortOptions as $value => $optionLabel)
                            <option value="{{ $value }}" @if (request('listing-sort') == $value) selected @endif>
                                {{ __($optionLabel) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Search -->
                <div class="search">
                    <input type="text" id="search_input"
                        @if (!empty(request('search'))) value="{{ request('search') }}" @endif name="search"
                        placeholder="{{ __('Search...') }}">
                    <button><img src="{{ asset('site-images/loupe.png') }}" alt="{{ __('Search Image') }}"></button>
                </div>

                <!-- Reset And Refine Buttons For ESM And SM -->
                <div class="reset-refine-esm">
                    <a class="reset-esm reset" href="/">{{ __('Reset') }}</a>
                    <button class="refine-esm refine-button">{{ __('Refine') }}</button>
                </div>

                <!-- Reset For MD And XL Screens -->
                <a class="reset-md reset" href="/">{{ __('Reset') }}</a>

                <!-- Refine For MD And XL Screens -->
                <button class="refine-md refine-button">{{ __('Refine') }}</button>

                <!-- Refine FOR >= XL Screens -->
                <button class="refine-xl refine-button">{{ __('Refine') }}</button>
            </div>
        </div>
    </form>

    @if (count($carListings) > 0)
        <div class="listings">
            @foreach ($carListings as $carListing)
                <a href="{{ '/listing/' . $carListing['car']->id }}" class="listing">
                    <img src="{{ asset($carListing['imagePath']) }}" alt="{{ __('Main Car Image') }}">
                    <div class="car-info">
                        <p class="car-make-model">
                            {{ strtoupper($carListing['car']->make . ' ' . $carListing['car']->model) }}</p>
                        <p class="car-year">{{ $carListing['car']->year }}</p>
                        <div class="prices-timer">
                            <div class="prices">
                                <p>{{ __('Bid:') }} $@thousands($carListing['listing']->bid_price)</p>
                                <p class="car-buy">{{ __('Buy:') }} $@thousands($carListing['listing']->buy_price)</p>
                            </div>
                            <p id="expires-in" class="timer">
                                {{ sprintf('%02d', $carListing['remainingHours']) }} :
                                {{ sprintf('%02d', $carListing['remainingMinutes']) }} :
                                {{ sprintf('%02d', $carListing['remainingSeconds']) }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <p id="paginator">{{ $listings->appends(request()->except('page'))->links() }}</p>
    @else
        <div class="no-listings">
            <!-- HTML for when there are no car listings -->
            <p>{{ __('No car listings available with the specified parameters.') }}</p>
        </div>
    @endif
@endsection
