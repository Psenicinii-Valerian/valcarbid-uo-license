    @extends('layouts.layout')

    @section('doc_scripts')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
        <script src='{{ asset('js/index-expire-time-trigger.js') }}' defer></script>
        <script src='{{ asset('js/detailed-car-expire-time-trigger.js') }}' defer></script>
        <script src='{{ asset('js/detailed-car-image-carousel.js') }}' defer></script>
        <script src='{{ asset('js/detailed-car-bid-btn-trigger.js') }}' defer></script>
        <script src='{{ asset('js/success-message-trigger.js') }}' defer></script>
    @endsection

    @section('doc_title', __('Car Detailed Info'))
    @section('doc_body')
        @if (session('success_msg'))
            <p id="success" class="bid-success-msg"><i class="fa-solid fa-check"></i> {{ session('success_msg') }}</p>
        @endif
        <h1 class="page-title">{{ __('Car Details') }}</h1>
        <form action="{{ '/listing/' . $car->id }}" class="detailed-info-form" method="POST">
            @csrf
            <div class="car-detailed">
                <div class="car-image">
                    <img src="{{ asset($images[0]) }}" alt="{{ __('Car Main Image') }}" data-images='@json(array_map('asset', $images))'>
                    <div class="arrow-btns">
                        <div class="left-arrow"><i class="fa-solid fa-angle-left"></i></div>
                        <div class="right-arrow"><i class="fa-solid fa-angle-right"></i></div>
                    </div>
                </div>
                <div class="car-detailed-info-sections">
                    <div class="car-main-info">
                        <h2>{{ strtoupper($car->make) }} {{ strtoupper($car->model) }}</h2>
                        <p>{{ $car->year }}</p>
                    </div>
                    <div class="car-secondary-info-2xl">
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('State') }}</h3>
                                <p>{{ $sellerState }}</p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('City') }}</h3>
                                <p>{{ $sellerCity }}</p>
                            </div>
                            {{-- 3 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Body') }}</h3>
                                @if ($car->body === 'suv')
                                    <p>{{ __('SUV') }}</p>
                                @else
                                    <p>{{ __(ucfirst($car->body)) }}</p>
                                @endif
                            </div>
                            {{-- 4 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Type') }}</h3>
                                <p>
                                    @if ($car->type === 'ev')
                                        {{ __('Electric Vehicle') }}
                                    @else
                                        <p>{{ __('Internal Combustion Engine') }}</p>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Mileage') }}</h3>
                                <p>@thousands($car->mileage) mi</p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('VIN') }}</h3>
                                <p>{{ $car->vin }}</p>
                            </div>
                            {{-- 3 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Cylinders') }}</h3>
                                @if (isset($car->cylinders))
                                    <p>{{ $car->cylinders }}</p>
                                @else
                                    <p>-</p>
                                @endif
                            </div>
                            {{-- 4 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Engine Power') }}</h3>
                                <p>{{ $car->engine_power }} hp</p>
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                @if (isset($car->displacement))
                                    <h3>{{ __('Displacement') }}</h3>
                                    <p>{{ $car->displacement }} l</p>
                                @else
                                    <h3>{{ __('Battery Capacity') }}</h3>
                                    <p>{{ $car->battery_capacity }} kWh</p>
                                @endif
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Transmission Type') }}</h3>
                                @if ($car->transmission === 'cvt')
                                    <p>{{ __('Continuously Variable Transmission') }}</p>
                                @else
                                    <p>{{ __(ucwords($car->transmission_type)) }}</p>
                                @endif
                            </div>
                            {{-- 3 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Drive Type') }}</h3>
                                @if ($car->drive_type === 'awd')
                                    <p>{{ __('All-Wheel Drive') }}</p>
                                @elseif($car->drive_type === 'fwd')
                                    <p>{{ __('Front-Wheel Drive') }}</p>
                                @elseif($car->drive_type === 'rwd')
                                    <p>{{ __('Rear-Wheel Drive') }}</p>
                                @else
                                    <p>{{ __('Four-Wheel Drive') }}</p>
                                @endif
                            </div>
                            {{-- 4 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Fuel Type') }}</h3>
                                <p>{{ __(ucfirst($car->fuel_type)) }}</p>
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Door count') }}</h3>
                                <p>{{ $car->door_count }}</p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Capacity') }}</h3>
                                <p>{{ $car->capacity }} {{ __('people') }}</p>
                            </div>
                            {{-- 3 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Crashes') }}</h3>
                                @if ($car->crashes == '1')
                                    <p>{{ __('Yes') }}</p>
                                @else
                                    <p>{{ __('No') }}</p>
                                @endif
                            </div>
                            {{-- 4 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Crash Description') }}</h3>
                                @if (isset($car->crash_description))
                                    <p class="crash-description-paragraph">{{ $car->crash_description }}</p>
                                @else
                                    <p>-</p>
                                @endif
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <div class="bid-price-info">
                                    <h3>{{ __('Bid Price') }}</h3>
                                    <a href="car-bid-log/{{ $car->id }}" class="circle-info-link">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                </div>
                                <p>$@thousands($listing->bid_price)</p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Buy Price') }}</h3>
                                <p>$@thousands($listing->buy_price)</p>
                            </div>
                            {{-- 3 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Current Bid Winner') }}</h3>
                                @if (isset($currentBidWinner))
                                    <p>{{ $currentBidWinner }}</p>
                                @else
                                    <p>-</p>
                                @endif
                            </div>
                            {{-- 4 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Time Left') }}</h3>
                                <p id="expires-in">
                                    {{ sprintf('%02d', $timeRemaining['days']) }}d :
                                    {{ sprintf('%02d', $timeRemaining['hours']) }}h :
                                    {{ sprintf('%02d', $timeRemaining['minutes']) }}m :
                                    {{ sprintf('%02d', $timeRemaining['seconds']) }}s
                                </p>
                            </div>
                        </div>
                    </div>
                    {{-- Content for XL, MD, LG screen --}}
                    <div class="car-secondary-info-xl">
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('State') }}</h3>
                                <p>{{ $sellerState }}</p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('City') }}</h3>
                                <p>{{ $sellerCity }}</p>
                            </div>
                            {{-- 3 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Body') }}</h3>
                                @if ($car->body === 'suv')
                                    <p>{{ __('SUV') }}</p>
                                @else
                                    <p>{{ __(ucfirst($car->body)) }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Type') }}</h3>
                                <p>
                                    @if ($car->type === 'ev')
                                        {{ __('Electric Vehicle') }}
                                    @else
                                        <p>{{ __('Internal Combustion Engine') }}</p>
                                    @endif
                                </p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Mileage') }}</h3>
                                <p>@thousands($car->mileage) mi</p>
                            </div>
                            {{-- 3 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('VIN') }}</h3>
                                <p>{{ $car->vin }}</p>
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Cylinders') }}</h3>
                                @if (isset($car->cylinders))
                                    <p>{{ $car->cylinders }}</p>
                                @else
                                    <p>-</p>
                                @endif
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Engine Power') }}</h3>
                                <p>{{ $car->engine_power }} hp</p>
                            </div>
                            {{-- 3 --}}
                            <div class="car-detailed-info">
                                @if (isset($car->displacement))
                                    <h3>{{ __('Displacement') }}</h3>
                                    <p>{{ $car->displacement }} l</p>
                                @else
                                    <h3>{{ __('Battery Capacity') }}</h3>
                                    <p>{{ $car->battery_capacity }} kWh</p>
                                @endif
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Transmission Type') }}</h3>
                                @if ($car->transmission === 'cvt')
                                    <p>{{ __('CVT') }}</p>
                                @else
                                    <p>{{ __(ucwords($car->transmission_type)) }}</p>
                                @endif
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Drive Type') }}</h3>
                                @if ($car->drive_type === 'awd')
                                    <p>{{ __('All-Wheel Drive') }}</p>
                                @elseif($car->drive_type === 'fwd')
                                    <p>{{ __('Front-Wheel Drive') }}</p>
                                @elseif($car->drive_type === 'rwd')
                                    <p>{{ __('Rear-Wheel Drive') }}</p>
                                @else
                                    <p>{{ __('Four-Wheel Drive') }}</p>
                                @endif
                            </div>
                            {{-- 3 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Fuel Type') }}</h3>
                                <p>{{ __(ucfirst($car->fuel_type)) }}</p>
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Door count') }}</h3>
                                <p>{{ $car->door_count }}</p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Capacity') }}</h3>
                                <p>{{ $car->capacity }} {{ __('people') }}</p>
                            </div>
                            {{-- 3 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Crashes') }}</h3>
                                @if ($car->crashes === '1')
                                    <p>{{ __('Yes') }}</p>
                                @else
                                    <p>{{ __('No') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Crash Description') }}</h3>
                                @if (isset($car->crash_description))
                                    <p>{{ $car->crash_description }}</p>
                                @else
                                    <p>-</p>
                                @endif
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <div class="bid-price-info">
                                    <h3>{{ __('Bid Price') }}</h3>
                                    <a href="car-bid-log/{{ $car->id }}" class="circle-info-link">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                </div>
                                <p>$@thousands($listing->bid_price)</p>
                            </div>
                            {{-- 3 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Buy Price') }}</h3>
                                <p>$@thousands($listing->buy_price)</p>
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Current Bid Winner') }}</h3>
                                @if (isset($currentBidWinner))
                                    <p>{{ $currentBidWinner }}</p>
                                @else
                                    <p>-</p>
                                @endif
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Time Left') }}</h3>
                                <p id="expires-in">
                                    {{ sprintf('%02d', $timeRemaining['days']) }}d :
                                    {{ sprintf('%02d', $timeRemaining['hours']) }}h :
                                    {{ sprintf('%02d', $timeRemaining['minutes']) }}m :
                                    {{ sprintf('%02d', $timeRemaining['seconds']) }}s
                                </p>
                            </div>
                        </div>
                    </div>
                    {{-- Content for ESM, SM screen --}}
                    <div class="car-secondary-info-esm">
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('State') }}</h3>
                                <p>{{ $sellerState }}</p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('City') }}</h3>
                                <p>{{ $sellerCity }}</p>
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Type') }}</h3>
                                <p>
                                    @if ($car->type === 'ev')
                                        {{ __('Electric Vehicle') }}
                                    @else
                                        <p>{{ __('Internal Combustion Engine') }}</p>
                                    @endif
                                </p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Mileage') }}</h3>
                                <p>@thousands($car->mileage) mi</p>
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('VIN') }}</h3>
                                <p>{{ $car->vin }}</p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Cylinders') }}</h3>
                                @if (isset($car->cylinders))
                                    <p>{{ $car->cylinders }}</p>
                                @else
                                    <p>-</p>
                                @endif
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Engine Power') }}</h3>
                                <p>{{ $car->engine_power }} hp</p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                @if (isset($car->displacement))
                                    <h3>{{ __('Displacement') }}</h3>
                                    <p>{{ $car->displacement }} l</p>
                                @else
                                    <h3>{{ __('Battery Capacity') }}</h3>
                                    <p>{{ $car->battery_capacity }} kWh</p>
                                @endif
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Transmission Type') }}</h3>
                                @if ($car->transmission === 'cvt')
                                    <p>{{ __('Continuously Variable Transmission') }}</p>
                                @else
                                    <p>{{ __(ucwords($car->transmission_type)) }}</p>
                                @endif
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Drive Type') }}</h3>
                                @if ($car->drive_type === 'awd')
                                    <p>{{ __('All-Wheel Drive') }}</p>
                                @elseif($car->drive_type === 'fwd')
                                    <p>{{ __('Front-Wheel Drive') }}</p>
                                @elseif($car->drive_type === 'rwd')
                                    <p>{{ __('Rear-Wheel Drive') }}</p>
                                @else
                                    <p>{{ __('Four-Wheel Drive') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Fuel Type') }}</h3>
                                <p>{{ __(ucfirst($car->fuel_type)) }}</p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Door count') }}</h3>
                                <p>{{ $car->door_count }}</p>
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Capacity') }}</h3>
                                <p>{{ $car->capacity }} {{ __('people') }}</p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Crashes') }}</h3>
                                @if ($car->crashes === '1')
                                    <p>{{ __('Yes') }}</p>
                                @else
                                    <p>{{ __('No') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Crash Description') }}</h3>
                                @if (isset($car->crash_description))
                                    <p>{{ $car->crash_description }}</p>
                                @else
                                    <p>-</p>
                                @endif
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <div class="bid-price-info">
                                    <h3>{{ __('Bid Price') }}</h3>
                                    <a href="car-bid-log/{{ $car->id }}" class="circle-info-link">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                </div>
                                <p>$@thousands($listing->bid_price)</p>
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Buy Price') }}</h3>
                                <p>$@thousands($listing->buy_price)</p>
                            </div>
                            {{-- 2 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Current Bid Winner') }}</h3>
                                @if (isset($currentBidWinner))
                                    <p>{{ $currentBidWinner }}</p>
                                @else
                                    <p>-</p>
                                @endif
                            </div>
                        </div>
                        <div class="car-detailed-info-section">
                            {{-- 1 --}}
                            <div class="car-detailed-info">
                                <h3>{{ __('Time Left') }}</h3>
                                <p id="expires-in">
                                    {{ sprintf('%02d', $timeRemaining['days']) }}d :
                                    {{ sprintf('%02d', $timeRemaining['hours']) }}h :
                                    {{ sprintf('%02d', $timeRemaining['minutes']) }}m :
                                    {{ sprintf('%02d', $timeRemaining['seconds']) }}s
                                </p>
                            </div>
                        </div>
                    </div>
                    @if ($userID !== $car->seller_id)
                        <div class="bid-buy-btns">
                            {{--  Bid --}}
                            <div class="bid-btns">
                                <input type="text" inputmode="numeric" name="new-bid" data-min="{{ $listing->bid_price + 1 }}"
                                    placeholder="{{ __('Enter Bid') }}" id="bid-input">
                                <button type="submit" class="bid-btn" id="bid-button" hidden>{{ __('BID') }}</button>
                                @error('new-bid')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- Buy --}}
                            <button type="submit" class="buy-btn">{{ __('BUY') }}</button>
                            <input type="hidden" name="buy-order" value="{{ $listing->buy_price }}">
                            <input type="hidden" name="car-id" value="{{ $car->id }}">
                            <input type="hidden" name="user-id" value="{{ $userID }}">
                            <input type="hidden" name="seller-id" value="{{ $seller->id }}">
                            <input type="hidden" name="listing-id" value="{{ $listing->id }}">
                        </div>
                    @else
                        <div class="listing-owner">
                            <h3>{{ __("You're the owner of this listing!") }}</h3>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    @endsection
